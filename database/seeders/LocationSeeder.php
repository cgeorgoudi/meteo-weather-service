<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        Location::firstOrCreate(
            ['name' => env('DEFAULT_LOCATION_NAME', 'Athens')],
            [
                'latitude'  => env('DEFAULT_LOCATION_LAT', 37.9838),
                'longitude' => env('DEFAULT_LOCATION_LON', 23.7275),
                'timezone'  => env('DEFAULT_LOCATION_TIMEZONE', 'Europe/Athens'),
                'is_active' => true,
            ]
        );
    }
}
