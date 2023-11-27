<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\LocationDTO;
use App\Http\Controllers\Controller;
use App\Services\API\Weather\WeatherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller
{
    public function __construct(protected WeatherService $weatherService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required|string',
            'state' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $city = $request->input('city');
        $state = $request->input('state');

        $locationDTO = new LocationDTO($city, $state);

        return response()->json($this->weatherService->fetchWeather($locationDTO));
    }
}
