<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller
{
    public function __construct(
        private ApiService $apiService
    ) {}

    public function getForecast(Request $request): JsonResponse
    {
        // $validator = Validator::make($request->all(), [
        //     'latitude' => ['required', 'numeric', 'between:-90,90'],
        //     'longitude' => ['required', 'numeric', 'between:-180,180'],
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }
        try {
            return response()->json($this->apiService->get('forecast', [
                // 'latitude' => $request->latitude,
                // 'longitude' => $request->longitude,
                'latitude' => 35.22,
                'longitude' => -80.85,
                'wind_speed_unit' => 'mph',
                'temperature_unit' => 'fahrenheit',
                'precipitation_unit' => 'inch',
                'hourly' => 'temperature_2m',
                'current' => ['temperature_2m','relative_humidity_2m','weather_code','wind_speed_10m']
            ]));
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Weather service error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
