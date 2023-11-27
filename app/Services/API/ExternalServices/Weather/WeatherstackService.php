<?php

namespace App\Services\API\ExternalServices\Weather;

use App\DTO\LocationDTO;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class WeatherstackService
{
    /**
     * Base Url for current weather
     */
    protected const BASE_URL = 'http://api.weatherstack.com/current';

    /**
     * Set default metric unit to Fahrenheit
     */
    protected const DEFAULT_METRIC = 'f';

    public function __construct(protected Client $httpClient)
    {
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getCurrentWeather(LocationDTO $locationDTO)
    {
        $response = $this->httpClient->get(static::BASE_URL, [
            'query' => [
                'access_key' => env('WEATHERSTACK_API_KEY'),
                'units' => static::DEFAULT_METRIC,
                'query' => $locationDTO->getCity() . ", " . $locationDTO->getState(),
            ]
        ]);

        return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }
}
