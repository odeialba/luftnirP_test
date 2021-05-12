<?php

namespace Printful\Entity;

class Country
{
    private string $code;
    private string $name;
    /** @var State[] $states */
    private array $states = [];

    public function __construct(object $country)
    {
        $this->setCode($country->code);
        $this->setName($country->name);

        if ($country->states) {
            foreach ($country->states as $resultState) {
                $this->addState(new State($resultState));
            }
        }
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

    /**
     * @return State[]
     */
    public function getStates(): array
    {
        return $this->states;
    }

    /**
     * @param State[] $states
     * @return Country
     */
    public function setStates(array $states): self
    {
        $this->states = $states;

        return $this;
    }

    public function addState(State $state): self
    {
        $this->states[] = $state;

        return $this;
    }
}