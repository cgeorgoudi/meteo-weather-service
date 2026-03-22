<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Weather API Key (weatherapi.com)
    |--------------------------------------------------------------------------
    */
    'weatherapi_key' => env('WEATHER_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Registered Providers
    |--------------------------------------------------------------------------
    | Add new provider classes here to extend data sources.
    */
    'providers' => [
        \App\Weather\Providers\OpenMeteoProvider::class,
        \App\Weather\Providers\WeatherApiProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Forecast days to fetch
    |--------------------------------------------------------------------------
    */
    'forecast_days' => 7,
];
