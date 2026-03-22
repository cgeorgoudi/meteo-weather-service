<?php

namespace App\Weather\Data;

class WeatherData
{
    /**
     * @param DailyEntry[]  $daily
     * @param HourlyEntry[] $hourly
     */
    public function __construct(
        public readonly array $daily,
        public readonly array $hourly,
    ) {}
}
