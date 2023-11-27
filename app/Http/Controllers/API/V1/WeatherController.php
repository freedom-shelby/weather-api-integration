<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\API\Weather\WeatherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class WeatherController extends Controller
{
    public function index(Request $request, WeatherService $weatherService): JsonResponse
    {
        return response()->json($weatherService->fetchWeather());
    }
}
