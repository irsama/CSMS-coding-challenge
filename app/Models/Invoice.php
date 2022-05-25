<?php

namespace App\Models;

class Invoice
{

    public ?ChargingDetailRecord $chargingDetailRecord = null;
    public ?ChargingRate $chargingRate = null;
    private ?float $overall = null;
    private ?float $energy = null;
    private ?float $time = null;
    private ?float $transaction = null;

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function calculate()
    {
    }
}
