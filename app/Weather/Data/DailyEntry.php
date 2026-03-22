<?php

namespace App\Weather\Data;

use Carbon\Carbon;

class DailyEntry
{
    public function __construct(
        public readonly Carbon $date,
        public readonly ?float $tempMin,
        public readonly ?float $tempMax,
        public readonly ?float $precipitationSum,
    ) {}
}
