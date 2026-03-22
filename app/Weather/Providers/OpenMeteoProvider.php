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

class OpenMeteoProvider implements WeatherProviderInterface
{
    private const BASE_URL = 'https://api.open-meteo.com/v1/forecast';

    public function __construct(private readonly Client $client) {}

    public function getName(): string
    {
        return 'Open-Meteo';
    }

    public function fetch(Location $location, int $days): WeatherData
    {
        $response = $this->client->get(self::BASE_URL, [
            'query' => [
                'latitude'           => $location->latitude,
                'longitude'          => $location->longitude,
                'hourly'             => 'temperature_2m,precipitation',
                'daily'              => 'temperature_2m_min,temperature_2m_max,precipitation_sum',
                'timezone'           => $location->timezone,
                'forecast_days'      => $days,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return new WeatherData(
            daily:  $this->parseDaily($data['daily'] ?? []),
            hourly: $this->parseHourly($data['hourly'] ?? []),
        );
    }

    private function parseDaily(array $raw): array
    {
        $entries = [];
        $dates   = $raw['time'] ?? [];

        foreach ($dates as $i => $date) {
            $entries[] = new DailyEntry(
                date:             Carbon::parse($date),
                tempMin:          $raw['temperature_2m_min'][$i] ?? null,
                tempMax:          $raw['temperature_2m_max'][$i] ?? null,
                precipitationSum: $raw['precipitation_sum'][$i] ?? null,
            );
        }

        return $entries;
    }

    private function parseHourly(array $raw): array
    {
        $entries   = [];
        $datetimes = $raw['time'] ?? [];

        foreach ($datetimes as $i => $dt) {
            $entries[] = new HourlyEntry(
                datetime:      Carbon::parse($dt),
                temperature:   $raw['temperature_2m'][$i] ?? null,
                precipitation: $raw['precipitation'][$i] ?? null,
            );
        }

        return $entries;
    }
}
