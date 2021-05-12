<?php

namespace Printful\Service;

use CacheInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Printful\Entity\AddressInfo;
use Printful\Entity\Country;
use Printful\Entity\ItemInfo;
use Printful\Entity\ShippingInfo;
use Printful\Entity\ShippingRequest;

class PrintfulService
{
    private const RATES_API_URL = 'https://api.printful.com/shipping/rates';
    private const COUNTRIES_API_URL = 'https://api.printful.com/countries';
    private const COUNTRIES_CACHE_KEY = 'countries_cache';
    private const SHIPPING_OPTIONS_CACHE_KEY = 'shipping_options_cache';
    private const API_CREDENTIALS = '77qn9aax-qrrm-idki:lnh0-fm2nhmp0yca7';

    private CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    private function getGuzzleClient(): Client
    {
        return new Client([
            'headers' => [
                'Authorization' => ['Basic ' . base64_encode(self::API_CREDENTIALS)],
            ],
        ]);
    }

    /**
     * @param string $address
     * @param array $items
     * @return ShippingInfo[]
     * @throws Exception
     */
    public function availableShippingOptions(string $address, array $items): array
    {
        $request = json_encode($this->createRequest($address, $items));

        return $this->getShippingOptions($request);
    }

    protected function createRequest(string $address, array $items): ShippingRequest
    {
        $explodedAddress = array_map('trim', explode(',', $address));

        $request = new ShippingRequest(
            new AddressInfo(
                $explodedAddress[0],
                $explodedAddress[1],
                "US",
                $this->getStateCodeFromName($explodedAddress[2]),
                $explodedAddress[3]
            ),
        );

        foreach ($items as $variantId => $quantity) {
            $request->addItem(
                new ItemInfo(
                    $variantId,
                    null,
                    null,
                    $quantity
                )
            );
        }

        return $request;
    }

    protected function getStateCodeFromName(string $stateName): ?string
    {
        $countries = $this->getCountries();

        foreach ($countries as $country) {
            if ($country->getCode() !== 'US') {
                continue;
            }

            foreach ($country->getStates() as $state) {
                if ($state->getName() !== $stateName) {
                    continue;
                }

                return $state->getCode();
            }
        }

        return null;
    }

    /**
     * @return Country[]
     * @throws Exception
     */
    protected function getCountries(): array
    {
        $cachedCountries = $this->cache->get(self::COUNTRIES_CACHE_KEY);
        $countries = [];

        if ($cachedCountries === null) {
            $cachedCountries = $this->cache->set(
                self::COUNTRIES_CACHE_KEY,
                $this->getCountriesFromApi(),
                300
            );
        }

        foreach (json_decode($cachedCountries)->result as $resultCountry) {
            $country = new Country($resultCountry);
            $countries[] = $country;
        }

        return $countries;
    }

    /**
     * @return string
     * @throws Exception
     */
    private function getCountriesFromApi(): string
    {
        try {
            $client = $this->getGuzzleClient();
            $response = $client->request('GET', self::COUNTRIES_API_URL);
            $countries = json_decode($response->getBody());

            if ($countries->code !== 200) {
                throw new Exception($countries->result);
            }

            return json_encode($countries);
        } catch (GuzzleException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @param string $request
     * @return ShippingInfo[]
     * @throws Exception
     */
    protected function getShippingOptions(string $request): array
    {
        $cacheKey = self::SHIPPING_OPTIONS_CACHE_KEY . md5($request);
        $cachedShippingOptions = $this->cache->get($cacheKey);
        $shippingOptions = [];

        if ($cachedShippingOptions === null) {
            $cachedShippingOptions = $this->cache->set(
                $cacheKey,
                $this->getShippingOptionsFromApi($request),
                300
            );
        }

        foreach (json_decode($cachedShippingOptions)->result as $resultShippingOption) {
            $shippingOptions[] = new ShippingInfo($resultShippingOption);
        }

        return $shippingOptions;
    }

    /**
     * @param string $request
     * @return string
     * @throws Exception
     */
    private function getShippingOptionsFromApi(string $request): string
    {
        try {
            $client = $this->getGuzzleClient();
            $response = $client->request('POST', self::RATES_API_URL, ['body' => $request]);
            $shippingOptions = json_decode($response->getBody());

            if ($shippingOptions->code !== 200) {
                throw new Exception($shippingOptions->result);
            }

            return json_encode($shippingOptions);
        } catch (GuzzleException $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}