<?php

namespace Printful\Entity;

class AddressInfo
{
    public string $address1;
    public string $city;
    public string $country_code;
    public ?string $state_code;
    public ?string $zip;
    public ?string $phone;

    public function __construct(
        string $address1,
        string $city,
        string $countryCode,
        ?string $stateCode = null,
        ?string $zip = null,
        ?string $phone = null
    ) {
        $this->setAddress1($address1);
        $this->setCity($city);
        $this->setCountryCode($countryCode);
        $this->setStateCode($stateCode);
        $this->setZip($zip);
        $this->setPhone($phone);
    }

    public function getAddress1(): string
    {
        return $this->address1;
    }

    public function setAddress1(string $address1): self
    {
        $this->address1 = $address1;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountryCode(): string
    {
        return $this->country_code;
    }

    public function setCountryCode(string $country_code): self
    {
        $this->country_code = $country_code;

        return $this;
    }

    public function getStateCode(): ?string
    {
        return $this->state_code;
    }

    public function setStateCode(?string $state_code): self
    {
        $this->state_code = $state_code;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}