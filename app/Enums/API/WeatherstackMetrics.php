<?php

namespace App\Enums\API;

enum WeatherstackMetrics: string
{
    case Metric = 'm';
    case Scientific = 's';
    case Fahrenheit = 'f';
}
