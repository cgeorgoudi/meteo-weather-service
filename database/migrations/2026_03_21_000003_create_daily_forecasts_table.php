<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_forecasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            $table->foreignId('weather_provider_id')->constrained()->cascadeOnDelete();
            $table->date('forecast_date');
            $table->decimal('temp_min', 5, 2)->nullable();
            $table->decimal('temp_max', 5, 2)->nullable();
            $table->decimal('precipitation_sum', 7, 2)->nullable()->comment('mm');
            $table->timestamp('fetched_at');
            $table->timestamps();

            $table->unique(['location_id', 'weather_provider_id', 'forecast_date'], 'daily_forecasts_uidx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_forecasts');
    }
};
