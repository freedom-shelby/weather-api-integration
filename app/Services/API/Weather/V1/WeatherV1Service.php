<?php

namespace App\Services\API\Weather\V1;

use App\DTO\LocationDTO;
use App\Services\API\ExternalServices\AirQuality\IQAirService;
use App\Services\API\ExternalServices\Weather\WeatherstackService;
use App\Services\API\Weather\WeatherInterface;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class WeatherV1Service implements WeatherInterface
{
    public function __construct(
        protected WeatherstackService $weatherstackService,
        protected IQAirService        $iQAirService
    )
    {
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function fetchWeather(LocationDTO $locationDTO): array
    {
        $weatherData = $this->weatherstackService->getCurrentWeather($locationDTO);
        $airQualityData = $this->iQAirService->getAirQuality($locationDTO);

        return [
            // todo:: send response
        ];
    }
}
