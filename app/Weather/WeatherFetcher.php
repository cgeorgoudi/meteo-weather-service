<?php

namespace App\Weather;

use App\Models\DailyForecast;
use App\Models\HourlyForecast;
use App\Models\Location;
use App\Models\WeatherProvider;
use App\Weather\Contracts\WeatherProviderInterface;
use Illuminate\Support\Facades\Log;

class WeatherFetcher
{
    public function fetchAll(): void
    {
        $locations = Location::active()->get();
        $providers = WeatherProvider::active()->get();

        foreach ($locations as $location) {
            foreach ($providers as $providerModel) {
                $this->fetchForLocationAndProvider($location, $providerModel);
            }
        }
    }

    private function fetchForLocationAndProvider(Location $location, WeatherProvider $providerModel): void
    {
        try {
            /** @var WeatherProviderInterface $provider */
            $provider = app($providerModel->class);
            $days     = config('weather.forecast_days', 7);

            Log::info("Fetching weather for [{$location->name}] from [{$provider->getName()}]");

            $data      = $provider->fetch($location, $days);
            $fetchedAt = now();

            foreach ($data->daily as $entry) {
                DailyForecast::updateOrCreate(
                    [
                        'location_id'         => $location->id,
                        'weather_provider_id' => $providerModel->id,
                        'forecast_date'       => $entry->date->toDateString(),
                    ],
                    [
                        'temp_min'          => $entry->tempMin,
                        'temp_max'          => $entry->tempMax,
                        'precipitation_sum' => $entry->precipitationSum,
                        'fetched_at'        => $fetchedAt,
                    ]
                );
            }

            foreach ($data->hourly as $entry) {
                HourlyForecast::updateOrCreate(
                    [
                        'location_id'         => $location->id,
                        'weather_provider_id' => $providerModel->id,
                        'forecast_datetime'   => $entry->datetime,
                    ],
                    [
                        'temperature'   => $entry->temperature,
                        'precipitation' => $entry->precipitation,
                        'fetched_at'    => $fetchedAt,
                    ]
                );
            }

            Log::info("Successfully stored forecast for [{$location->name}] from [{$provider->getName()}]");
        } catch (\Throwable $e) {
            Log::error("Failed to fetch weather for [{$location->name}] from [{$providerModel->name}]: {$e->getMessage()}");
        }
    }
}
