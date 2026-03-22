<?php

namespace App\Weather\Providers;

use App\Models\Location;
use App\Weather\Contracts\WeatherProviderInterface;
use App\Weather\Data\DailyEntry;
use App\Weather\Data\HourlyEntry;
use App\Weather\Data\WeatherData;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WeatherApiProvider implements WeatherProviderInterface
{
    private const BASE_URL = 'https://api.weatherapi.com/v1/forecast.json';

    public function __construct(
        private readonly Client $client,
        private readonly string $apiKey,
    ) {}

    public function getName(): string
    {
        return 'WeatherAPI.com';
    }

    public function fetch(Location $location, int $days): WeatherData
    {
        $response = $this->client->get(self::BASE_URL, [
            'query' => [
                'key'  => $this->apiKey,
                'q'    => "{$location->latitude},{$location->longitude}",
                'days' => min($days, 14),
                'aqi'  => 'no',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return new WeatherData(
            daily:  $this->parseDaily($data['forecast']['forecastday'] ?? []),
            hourly: $this->parseHourly($data['forecast']['forecastday'] ?? []),
        );
    }

    private function parseDaily(array $forecastDays): array
    {
        $entries = [];

        foreach ($forecastDays as $day) {
            $entries[] = new DailyEntry(
                date:             Carbon::parse($day['date']),
                tempMin:          $day['day']['mintemp_c'] ?? null,
                tempMax:          $day['day']['maxtemp_c'] ?? null,
                precipitationSum: $day['day']['totalprecip_mm'] ?? null,
            );
        }

        return $entries;
    }

    private function parseHourly(array $forecastDays): array
    {
        $entries = [];

        foreach ($forecastDays as $day) {
            foreach ($day['hour'] ?? [] as $hour) {
                $entries[] = new HourlyEntry(
                    datetime:      Carbon::parse($hour['time']),
                    temperature:   $hour['temp_c'] ?? null,
                    precipitation: $hour['precip_mm'] ?? null,
                );
            }
        }

        return $entries;
    }
}
