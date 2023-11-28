<?php

namespace Tests\Unit\Mappers\API\AirQuality;

use App\Enums\API\AirQualityIndexes;
use App\Mappers\API\AirQuality\AQIBasicsMapper;
use Exception;
use PHPUnit\Framework\TestCase;

class AQIBasicsMapperTest extends TestCase
{
    protected AQIBasicsMapper $aqiBasicsMapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->aqiBasicsMapper = new AQIBasicsMapper();
    }

    /**
     * @dataProvider pollutionIndexProvider
     */
    public function testGetHRDescriptionFromIndex(int $index, string $expectedDescription): void
    {
        $result = $this->aqiBasicsMapper->getHRTitleFromIndex($index);
        $this->assertEquals($expectedDescription, $result);
    }

    /**
     * @throws Exception
     */
    public static function pollutionIndexProvider(): array
    {
        return [
            'good_index' => [
                random_int(0, AirQualityIndexes::Good->value), AirQualityIndexes::Good->title()
            ],
            'moderate_index' => [
                random_int(AirQualityIndexes::Good->value + 1, AirQualityIndexes::Moderate->value),
                AirQualityIndexes::Moderate->title()
            ],
            'ufsg_index' => [
                random_int(AirQualityIndexes::Moderate->value + 1, AirQualityIndexes::UFSG->value),
                AirQualityIndexes::UFSG->title()
            ],
            'unhealthy_index' => [
                random_int(AirQualityIndexes::UFSG->value + 1, AirQualityIndexes::Unhealthy->value),
                AirQualityIndexes::Unhealthy->title()
            ],
            'very_unhealthy_index' => [
                random_int(AirQualityIndexes::Unhealthy->value + 1, AirQualityIndexes::VeryUnhealthy->value),
                AirQualityIndexes::VeryUnhealthy->title()
            ],
            'hazardous_index' => [
                random_int(AirQualityIndexes::VeryUnhealthy->value + 1, AirQualityIndexes::Hazardous->value),
                AirQualityIndexes::Hazardous->title()
            ],
            'unknown_index' => [random_int(AirQualityIndexes::VeryUnhealthy->value + 1, 999), 'Unknown Index'],
        ];
    }
}
