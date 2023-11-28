<?php

namespace Tests\Unit\Services\API\Weather\V1;

use App\DTO\LocationDTO;
use App\Enums\API\AirQualityIndexes;
use App\Enums\API\WeatherstackMetrics;
use App\Enums\API\WeatherstackPaths;
use App\Mappers\API\AirQuality\AQIBasicsMapper;
use App\Services\API\ExternalServices\AirQuality\IQAirService;
use App\Services\API\ExternalServices\Weather\WeatherstackService;
use App\Services\API\Weather\V1\WeatherV1Service;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class WeatherV1ServiceTest extends TestCase
{
    protected WeatherstackService $mockWeatherstackService;
    protected IQAirService $mockIQAirService;
    protected AQIBasicsMapper $mockAQIBasicsMapper;
    protected WeatherV1Service $weatherV1Service;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Mock dependencies: WeatherstackService, IQAirService, AQIBasicsMapper
        $this->mockWeatherstackService = $this->createMock(WeatherstackService::class);
        $this->mockIQAirService = $this->createMock(IQAirService::class);
        $this->mockAQIBasicsMapper = $this->createMock(AQIBasicsMapper::class);

        // Initialize the WeatherV1Service instance with the mocked dependencies
        $this->weatherV1Service = new WeatherV1Service(
            $this->mockWeatherstackService,
            $this->mockIQAirService,
            $this->mockAQIBasicsMapper
        );
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testFetchWeather(): void
    {
        $locationDTO = new LocationDTO('Los Angeles', 'California');
        $humidityPercent = 70;
        $temperature = 68;
        $weatherDescription1 = 'Partly';
        $weatherDescription2 = 'Cloudy';
        $weatherDescriptionText = $weatherDescription1 . ', ' . $weatherDescription2;

        // Mock WeatherstackService response
        $mockWeatherData = [
            WeatherstackPaths::Current->value => [
                'temperature' => $temperature,
                'weather_descriptions' => [$weatherDescription1, $weatherDescription2],
                'humidity' => $humidityPercent,
            ],
            'request' => ['unit' => WeatherstackMetrics::Fahrenheit->value],
        ];

        // Mock IQAirService response
        $mockAirQualityData = [
            'data' => [
                'current' => [
                    'pollution' => ['aqius' => 50],
                ],
            ],
        ];

        $this->mockAQIBasicsMapper->expects($this->once())
            ->method('getHRTitleFromIndex')
            ->with($mockAirQualityData['data']['current']['pollution']['aqius'])
            ->willReturn(AirQualityIndexes::Good->title());

        $this->mockWeatherstackService->expects($this->once())
            ->method('getCurrentWeather')
            ->with($locationDTO)
            ->willReturn($mockWeatherData);

        $this->mockWeatherstackService
            ->method('getWeatherDescriptionAsString')
            ->willReturn($weatherDescriptionText);

        $this->mockIQAirService->expects($this->once())
            ->method('getAirQuality')
            ->with($locationDTO)
            ->willReturn($mockAirQualityData);

        $expectedResult = [
            'query' => [
                'city' => $locationDTO->getCity(),
                'state' => $locationDTO->getState(),
            ],
            'temperature' => $temperature,
            'temperature_unit' => WeatherstackMetrics::Fahrenheit->value,
            'weather_description' => $weatherDescriptionText,
            'humidity_percent' => $humidityPercent,
            'air_quality_description' => AirQualityIndexes::Good->title(),
        ];

        $result = $this->weatherV1Service->fetchWeather($locationDTO);
        $this->assertEquals($expectedResult, $result);
    }
}
