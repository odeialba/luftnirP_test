<?php

namespace Printful\Entity;

class ShippingRequest
{
    public AddressInfo $recipient;
    /** @var ItemInfo[] $items */
    public array $items;
    public ?string $currency;
    public ?string $locale;

    /**
     * @param AddressInfo $recipient
     * @param ItemInfo[] $items
     * @param string|null $currency
     * @param string|null $locale
     */
    public function __construct(
        AddressInfo $recipient,
        array $items = [],
        ?string $currency = null,
        ?string $locale = null
    ) {
        $this->setRecipient($recipient);
        $this->setItems($items);
        $this->setCurrency($currency);
        $this->setLocale($locale);
    }

    public function getRecipient(): AddressInfo
    {
        return $this->recipient;
    }

    public function setRecipient(AddressInfo $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @return ItemInfo[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param ItemInfo[] $items
     * @return self
     */
    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function addItem(ItemInfo $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }
}