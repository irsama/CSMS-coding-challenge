<?php

namespace App\Models;

class ChargingRate
{
    public float $rate;
    public float $time;
    public float $transaction;
    public function isValid(): bool
    {
        return true;
    }
}
