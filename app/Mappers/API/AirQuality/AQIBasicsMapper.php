<?php

namespace App\Mappers\API\AirQuality;

use App\Enums\API\AirQualityIndexes;

class AQIBasicsMapper
{
    /**
     * Get Human-Readable Levels of Concern from pollution index
     */
    public function getHRDescriptionFromIndex(int $index): string
    {
        return match (true) {
            $index <= AirQualityIndexes::Good->value => AirQualityIndexes::Good->title(),
            $index <= AirQualityIndexes::Moderate->value => AirQualityIndexes::Moderate->title(),
            $index <= AirQualityIndexes::UFSG->value => AirQualityIndexes::UFSG->title(),
            $index <= AirQualityIndexes::Unhealthy->value => AirQualityIndexes::Unhealthy->title(),
            $index <= AirQualityIndexes::VeryUnhealthy->value => AirQualityIndexes::VeryUnhealthy->title(),
            $index <= AirQualityIndexes::Hazardous->value => AirQualityIndexes::Hazardous->title(),
            default => 'Unknown Index'
        };
    }
}
