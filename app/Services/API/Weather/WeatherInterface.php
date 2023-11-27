<?php

namespace App\Services\API\Weather;

use App\DTO\LocationDTO;

interface WeatherInterface
{
    public function fetchWeather(LocationDTO $locationDTO);
}
