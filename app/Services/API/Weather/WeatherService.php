<?php

namespace App\Services\API\Weather;

use Illuminate\Support\Facades\Request;

class WeatherService
{
    public function __construct(protected WeatherInterface $weatherService)
    {
    }

    public function fetchWeather(): array
    {
        return $this->weatherService->fetchWeather();
    }
}
