<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = ['name', 'latitude', 'longitude', 'timezone', 'is_active'];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
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
