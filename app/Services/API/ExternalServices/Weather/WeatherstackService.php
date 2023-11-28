<?php

namespace App\Services\API\ExternalServices\Weather;

use App\DTO\LocationDTO;
use App\Enums\API\WeatherstackMetrics;
use App\Enums\API\WeatherstackPaths;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class WeatherstackService
{
    /**
     * The API Base URL
     */
    protected const BASE_URL = 'http://api.weatherstack.com/';

    /**
     * Set default metric unit to Fahrenheit
     */
    protected const DEFAULT_METRIC = WeatherstackMetrics::Fahrenheit;

    public function __construct(protected Client $httpClient)
    {
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getCurrentWeather(LocationDTO $locationDTO)
    {
        $response = $this->httpClient->get(static::BASE_URL . WeatherstackPaths::Current->value, [
            'query' => [
                'access_key' => env('WEATHERSTACK_API_KEY'),
                'units' => static::DEFAULT_METRIC->value,
                'query' => $locationDTO->getCity() . ", " . $locationDTO->getState(),
            ]
        ]);

        return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function getWeatherDescriptionAsString(array $descriptions): string
    {
        return implode(', ', $descriptions);
    }
}
