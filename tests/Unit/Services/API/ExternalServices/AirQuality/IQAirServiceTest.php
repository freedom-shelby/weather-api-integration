<?php

namespace Tests\Unit\Services\API\ExternalServices\AirQuality;

use App\DTO\LocationDTO;
use App\Services\API\ExternalServices\AirQuality\IQAirService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use JsonException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class IQAirServiceTest extends TestCase
{
    protected IQAirService $iqAirService;
    protected Client $mockedHttpClient;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create a mocked instance of GuzzleHttp\Client
        $this->mockedHttpClient = $this->createMock(Client::class);

        // Initialize the IQAirService instance with the mocked Client
        $this->iqAirService = new IQAirService($this->mockedHttpClient);
    }

    /**
     * @throws Exception
     */
    public function testGetAirQuality(): void
    {
        $expectedApiResponse = [
            'status' => 'success',
            'data' => [
                'city' => 'Los Angeles',
                'state' => 'California',
                'country' => 'USA',
            ],
        ];

        $mockResponse = new Response(200, [], json_encode($expectedApiResponse));

        $locationDTO = new LocationDTO('Los Angeles', 'California');

        $reflection = new ReflectionClass(IQAirService::class);
        $property = $reflection->getProperty('httpClient');
        $property->setValue($this->iqAirService, $this->mockedHttpClient); // Set the mocked client

        $this->mockedHttpClient
            ->expects($this->once())
            ->method('get')
            ->with(
                IQAirService::BASE_URL,
                [
                    'query' => [
                        'key' => null,
                        'city' => $locationDTO->getCity(),
                        'state' => $locationDTO->getState(),
                        'country' => $locationDTO->getCountry(),
                    ],
                ]
            )
            ->willReturn($mockResponse);

        try {
            $result = $this->iqAirService->getAirQuality($locationDTO);
            $this->assertEquals($expectedApiResponse, $result);
        } catch (JsonException) {
            $this->fail('JSON decoding error occurred');
        } catch (GuzzleException) {
            $this->fail('Failed HTTP request');
        }
    }
}
