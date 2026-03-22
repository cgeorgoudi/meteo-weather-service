<?php

namespace App\Console\Commands;

use App\Weather\WeatherFetcher;
use Illuminate\Console\Command;

class FetchWeatherCommand extends Command
{
    protected $signature   = 'weather:fetch';
    protected $description = 'Fetch weather forecast data from all active providers for all active locations';

    public function handle(WeatherFetcher $fetcher): int
    {
        $this->info('Starting weather data fetch...');

        $fetcher->fetchAll();

        $this->info('Weather data fetch completed.');

        return self::SUCCESS;
    }
}
