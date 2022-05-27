<?php

namespace App\Models;

class ChargingRate
{
    public float $energy;
    public float $time;
    public float $transaction;

    function __construct($data=null) {
        if(is_array($data)){
            $this->energy = $data['energy'];
            $this->time = $data['time'];
            $this->transaction = $data['transaction'];
        }
    }
    public function isValid(): bool
    {
        return true;
    }
}
