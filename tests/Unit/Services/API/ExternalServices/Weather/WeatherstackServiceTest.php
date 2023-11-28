<?php

namespace Tests\Unit\Services\API\ExternalServices\Weather;

use App\DTO\LocationDTO;
use App\Enums\API\WeatherstackMetrics;
use App\Enums\API\WeatherstackPaths;
use App\Services\API\ExternalServices\Weather\WeatherstackService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use JsonException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class WeatherstackServiceTest extends TestCase
{
    protected WeatherstackService $weatherstackService;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create a mocked instance of GuzzleHttp\Client
        $mockedHttpClient = $this->createMock(Client::class);

        // Initialize the WeatherstackService instance with the mocked Client
        $this->weatherstackService = new WeatherstackService($mockedHttpClient);
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function testGetCurrentWeather(): void
    {
        $expectedApiResponse = [
            'current' => [
                'temperature' => 68,
                'weather_descriptions' => ['Partly', 'Cloudy'],
            ],
        ];

        $mockResponse = new Response(200, [], json_encode($expectedApiResponse, JSON_THROW_ON_ERROR));

        $locationDTO = new LocationDTO('New York', 'NY');

        $reflection = new ReflectionClass(WeatherstackService::class);
        $property = $reflection->getProperty('httpClient');

        // Configure the mocked HttpClient's behavior for the get method
        $httpClientMock = $this->createMock(Client::class);
        $property->setValue($this->weatherstackService, $httpClientMock); // Set the mocked client

        $httpClientMock
            ->expects($this->once())
            ->method('get')
            ->with(
                WeatherstackService::BASE_URL . WeatherstackPaths::Current->value,
                [
                    'query' => [
                        'access_key' => null,
                        'units' => WeatherstackMetrics::Fahrenheit->value,
                        'query' => $locationDTO->getCity() . ", " . $locationDTO->getState(),
                    ],
                ]
            )
            ->willReturn($mockResponse);

        try {
            $result = $this->weatherstackService->getCurrentWeather($locationDTO);

            $this->assertEquals($expectedApiResponse, $result);
        } catch (JsonException) {
            $this->fail('JSON decoding error occurred');
        } catch (GuzzleException) {
            $this->fail('Failed HTTP request');
        }
    }

    /**
     * @dataProvider weatherDescriptionProvider
     */
    public function testGetWeatherDescriptionAsString(array $weatherDescriptions, string $expectedString): void
    {
        $result = $this->weatherstackService->getWeatherDescriptionAsString($weatherDescriptions);
        $this->assertEquals($expectedString, $result);
    }

    public static function weatherDescriptionProvider(): array
    {
        return [
            'single_description' => [['Partly cloudy'], 'Partly cloudy'],
            'multiple_descriptions' => [['Partly', 'Cloudy'], 'Partly, Cloudy'],
            'empty_descriptions' => [[], ''],
        ];
    }
}
