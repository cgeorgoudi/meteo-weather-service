<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeatherProvider extends Model
{
    protected $fillable = ['name', 'class', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function dailyForecasts(): HasMany
    {
        return $this->hasMany(DailyForecast::class);
    }

    public function hourlyForecasts(): HasMany
    {
        return $this->hasMany(HourlyForecast::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
