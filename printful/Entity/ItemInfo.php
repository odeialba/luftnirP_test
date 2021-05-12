<?php

namespace Printful\Entity;

class ItemInfo
{
    public ?string $variant_id;
    public ?string $external_variant_id;
    public ?string $warehouse_product_variant_id;
    public int $quantity;
    public ?string $value;

    public function __construct(
        ?string $variantId,
        ?string $externalVariantId,
        ?string $warehouseProductVariantId,
        int $quantity,
        ?string $value = null
    ) {
        $this->setVariantId($variantId);
        $this->setExternalVariantId($externalVariantId);
        $this->setWarehouseProductVariantId($warehouseProductVariantId);
        $this->setQuantity($quantity);
        $this->setValue($value);
    }

    public function getVariantId(): ?string
    {
        return $this->variant_id;
    }

    public function setVariantId(?string $variantId): self
    {
        $this->variant_id = $variantId;

        return $this;
    }

    public function getExternalVariantId(): ?string
    {
        return $this->external_variant_id;
    }

    public function setExternalVariantId(?string $externalVariantId): self
    {
        $this->external_variant_id = $externalVariantId;

        return $this;
    }

    public function getWarehouseProductVariantId(): ?string
    {
        return $this->warehouse_product_variant_id;
    }

    public function setWarehouseProductVariantId(?string $warehouseProductVariantId): self
    {
        $this->warehouse_product_variant_id = $warehouseProductVariantId;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}