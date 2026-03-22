<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hourly_forecasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            $table->foreignId('weather_provider_id')->constrained()->cascadeOnDelete();
            $table->timestamp('forecast_datetime');
            $table->decimal('temperature', 5, 2)->nullable()->comment('Celsius');
            $table->decimal('precipitation', 7, 2)->nullable()->comment('mm');
            $table->timestamp('fetched_at');
            $table->timestamps();

            $table->unique(['location_id', 'weather_provider_id', 'forecast_datetime'], 'hourly_uidx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hourly_forecasts');
    }
};
