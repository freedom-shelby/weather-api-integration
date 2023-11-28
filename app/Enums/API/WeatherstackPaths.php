<?php

namespace App\Enums\API;

enum WeatherstackPaths: string
{
    case Current = 'current';
    case Historical = 'historical';
    case Forecast = 'forecast';
}
