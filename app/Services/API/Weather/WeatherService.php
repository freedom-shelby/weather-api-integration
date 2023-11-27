<?php

namespace App\Services\API\Weather;

class WeatherService
{
    public function __construct(protected WeatherInterface $weatherService)
    {
    }

    public function getWeather(): array
    {
        return $this->weatherService->getWeather();
    }
}
