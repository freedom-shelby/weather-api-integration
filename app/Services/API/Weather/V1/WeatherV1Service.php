<?php

namespace App\Services\API\Weather\V1;

use App\DTO\LocationDTO;
use App\Enums\API\WeatherstackPaths;
use App\Mappers\API\AirQuality\AQIBasicsMapper;
use App\Services\API\ExternalServices\AirQuality\IQAirService;
use App\Services\API\ExternalServices\Weather\WeatherstackService;
use App\Services\API\Weather\WeatherInterface;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class WeatherV1Service implements WeatherInterface
{
    public function __construct(
        protected WeatherstackService $weatherstackService,
        protected IQAirService        $iQAirService,
        protected AQIBasicsMapper     $aQIBasicsMapper
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
            'query' => [
                'city' => $locationDTO->getCity(),
                'state' => $locationDTO->getState(),
            ],
            "temperature" => $weatherData[WeatherstackPaths::Current->value]['temperature'],
            "temperature_unit" => $weatherData['request']['unit'],
            "weather_description" => $this->weatherstackService->getWeatherDescriptionAsString(
                $weatherData[WeatherstackPaths::Current->value]['weather_descriptions']
            ),
            "humidity_percent" => $weatherData[WeatherstackPaths::Current->value]['humidity'],
            "air_quality_description" => $this->aQIBasicsMapper->getHRTitleFromIndex(
                $airQualityData['data']['current']['pollution']['aqius']
            )
        ];
    }
}
