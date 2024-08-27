<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/weather', function() {
    $apiKey = config('services.weatherbit.key');
    $lat = request('lat');
    $lng = request('lng');
    $response = Http::get('http://api.weatherbit.io/v2.0/forecast/daily', [
        'lat' => $lat,
        'lon' => $lng,
        'key' => $apiKey,
        'units' => 'ca', // Metric units
    ]);

    if ($response->successful()) {
        return $response->json();
    } else {
        return response()->json(['error' => 'Unable to fetch weather data'], $response->status());
    }
});

