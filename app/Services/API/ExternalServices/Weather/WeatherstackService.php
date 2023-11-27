<?php

namespace App\Services\API\ExternalServices\Weather;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class WeatherstackService
{
    const API_URL = 'https://api.weatherstack.com/current';

    public function __construct(protected Client $httpClient)
    {
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getCurrentTemperature($location)
    {
        $response = $this->httpClient->get(static::API_URL, [
            'query' => [
                'access_key' => env('WEATHERSTACK_API_KEY'),
                'query' => $location,
            ]
        ]);

        return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }
}
