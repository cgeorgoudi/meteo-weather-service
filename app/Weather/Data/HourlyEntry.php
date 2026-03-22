<?php

namespace App\Weather\Data;

use Carbon\Carbon;

class HourlyEntry
{
    public function __construct(
        public readonly Carbon $datetime,
        public readonly ?float $temperature,
        public readonly ?float $precipitation,
    ) {}
}
