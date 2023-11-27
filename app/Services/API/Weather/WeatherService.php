<?php

namespace App\Services\API\Weather;

use App\DTO\LocationDTO;

class WeatherService
{
    public function __construct(protected WeatherInterface $weatherService)
    {
    }

    public function fetchWeather(LocationDTO $locationDTO): array
    {
        return $this->weatherService->fetchWeather($locationDTO);
    }
}
