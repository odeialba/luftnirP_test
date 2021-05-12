<?php

namespace Printful\Entity;

class State
{
    private string $code;
    private string $name;

    public function __construct(object $state)
    {
        $this->setCode($state->code);
        $this->setName($state->name);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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
}