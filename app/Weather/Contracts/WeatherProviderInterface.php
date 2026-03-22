<?php

namespace App\Weather\Contracts;

use App\Models\Location;
use App\Weather\Data\WeatherData;

interface WeatherProviderInterface
{
    /**
     * Human-readable name of the provider.
     */
    public function getName(): string;

    /**
     * Fetch forecast data for the given location.
     */
    public function fetch(Location $location, int $days): WeatherData;
}
