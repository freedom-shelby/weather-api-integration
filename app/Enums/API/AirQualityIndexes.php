<?php

namespace App\Enums\API;

enum AirQualityIndexes: int
{
    case Good = 50;
    case Moderate = 100;
    case UFSG = 150; // Unhealthy for Sensitive Groups
    case Unhealthy = 200;
    case VeryUnhealthy = 250;
    case Hazardous = 300;

    public function title(): string
    {
        return match ($this) {
            self::Good => 'Good',
            self::Moderate => 'Moderate',
            self::UFSG => 'Unhealthy for Sensitive Groups',
            self::Unhealthy => 'Unhealthy',
            self::VeryUnhealthy => 'Very Unhealthy',
            self::Hazardous => 'Hazardous',
        };
    }
}
