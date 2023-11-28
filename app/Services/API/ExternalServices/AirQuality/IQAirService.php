<?php

namespace App\Services\API\ExternalServices\AirQuality;

use App\DTO\LocationDTO;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class IQAirService
{
    /**
     * The API Base URL
     */
    public const BASE_URL = 'https://api.airvisual.com/v2/city';

    public function __construct(protected Client $httpClient)
    {
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getAirQuality(LocationDTO $locationDTO)
    {
        $response = $this->httpClient->get(static::BASE_URL, [
            'query' => [
                'key' => env('IQAIR_API_KEY'),
                'city' => $locationDTO->getCity(),
                'state' => $locationDTO->getState(),
                'country' => $locationDTO->getCountry(),
            ]
        ]);

        return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }
}
