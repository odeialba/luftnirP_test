<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Printful\Entity\AddressInfo;
use Printful\Entity\Country;
use Printful\Entity\ItemInfo;
use Printful\Entity\ShippingRequest;
use Printful\Service\CacheService;
use Printful\Service\PrintfulService;

class CreateRequestTest extends TestCase
{
    public function provider(): array
    {
        return [
            [
                'address' => '11025 Westlake Dr, Charlotte, North Carolina, 28273',
                'items' => [7679 => 2],
                'return' => new ShippingRequest(
                    new AddressInfo(
                        '11025 Westlake Dr',
                        'Charlotte',
                        "US",
                        'NC',
                        '28273'
                    ),
                    [
                        new ItemInfo('7679', null, null, 2)
                    ]
                )
            ]
        ];
    }

    public static function callMethod($obj, $name, array $args) {
        // Necessary to test protected methods
        $class = new ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }

    /**
     * @dataProvider provider
     * @param string $address
     * @param array $items
     * @param ShippingRequest $request
     */
    public function testCreateRequest(
        string $address,
        array $items,
        ShippingRequest $request
    ): void
    {
        $printfulService = $this->getMockBuilder(PrintfulService::class)
            ->setConstructorArgs([new CacheService()])
            ->disableOriginalConstructor()
            ->setMethods(['getCountries'])
            ->getMock();

        $cachedCountries = file_get_contents(__DIR__ . "/Fixtures/countries");

        $countries = [];
        foreach (json_decode($cachedCountries)->result as $resultCountry) {
            $country = new Country($resultCountry);
            $countries[] = $country;
        }

        $printfulService->expects(self::once())
            ->method('getCountries')
            ->willReturn($countries);

        $requested = self::callMethod(
            $printfulService,
            'createRequest',
            [$address, $items]
        );

        self::assertEquals($request, $requested);
    }
}
