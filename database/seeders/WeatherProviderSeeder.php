<?php

namespace Database\Seeders;

use App\Models\WeatherProvider;
use Illuminate\Database\Seeder;

class WeatherProviderSeeder extends Seeder
{
    public function run(): void
    {
        $providers = config('weather.providers', []);

        foreach ($providers as $class) {
            $name = class_basename($class);
            // Derive readable name from class
            $name = str_replace('Provider', '', $name);
            $name = preg_replace('/([A-Z])/', ' $1', $name);
            $name = trim($name);

            WeatherProvider::firstOrCreate(
                ['class' => $class],
                ['name' => $name, 'is_active' => true]
            );
        }
    }
}
