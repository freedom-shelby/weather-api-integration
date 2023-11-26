<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseWeather;

class Weather extends BaseWeather
{
    public function getWeather(): string
    {
        return response()->json([
            //
        ]);
    }
}
