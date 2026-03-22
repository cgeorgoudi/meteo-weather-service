<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HourlyForecast extends Model
{
    protected $fillable = [
        'location_id',
        'weather_provider_id',
        'forecast_datetime',
        'temperature',
        'precipitation',
        'fetched_at',
    ];

    protected $casts = [
        'forecast_datetime' => 'datetime',
        'fetched_at' => 'datetime',
        'temperature' => 'decimal:2',
        'precipitation' => 'decimal:2',
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
