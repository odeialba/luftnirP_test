<?php

namespace Printful\Entity;

class ShippingInfo
{
    private string $id;
    private string $name;
    private string $rate;
    private string $currency;
    private ?int $minDeliveryDays = null;
    private ?int $maxDeliveryDays = null;

    public function __construct(object $shippingOption) {
        $this->setId($shippingOption->id);
        $this->setName($shippingOption->name);
        $this->setRate($shippingOption->rate);
        $this->setCurrency($shippingOption->currency);
        $this->setMinDeliveryDays($shippingOption->minDeliveryDays);
        $this->setMaxDeliveryDays($shippingOption->maxDeliveryDays);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRate(): string
    {
        return $this->rate;
    }

    public function setRate(string $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getMinDeliveryDays(): ?int
    {
        return $this->minDeliveryDays;
    }

    public function setMinDeliveryDays(?int $minDeliveryDays): self
    {
        $this->minDeliveryDays = $minDeliveryDays;

        return $this;
    }

    public function getMaxDeliveryDays(): ?int
    {
        return $this->maxDeliveryDays;
    }

    public function setMaxDeliveryDays(?int $maxDeliveryDays): self
    {
        $this->maxDeliveryDays = $maxDeliveryDays;

        return $this;
    }
}