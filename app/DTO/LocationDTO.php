<?php

namespace App\DTO;

class LocationDTO
{
    public function __construct(
        protected string  $city,
        protected string  $state,
        protected ?string $country = 'USA',
    )
    {
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }
}
