<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyForecast extends Model
{
    protected $fillable = [
        'location_id',
        'weather_provider_id',
        'forecast_date',
        'temp_min',
        'temp_max',
        'precipitation_sum',
        'fetched_at',
    ];

    protected $casts = [
        'forecast_date' => 'date',
        'fetched_at' => 'datetime',
        'temp_min' => 'decimal:2',
        'temp_max' => 'decimal:2',
        'precipitation_sum' => 'decimal:2',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function weatherProvider(): BelongsTo
    {
        return $this->belongsTo(WeatherProvider::class);
    }
}
