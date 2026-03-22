<?php

namespace App\Providers;

use App\Weather\Providers\OpenMeteoProvider;
use App\Weather\Providers\WeatherApiProvider;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OpenMeteoProvider::class, function () {
            return new OpenMeteoProvider(new Client());
        });

        $this->app->bind(WeatherApiProvider::class, function () {
            return new WeatherApiProvider(
                new Client(),
                config('weather.weatherapi_key', ''),
            );
        });
    }

    public function boot(): void {}
}
