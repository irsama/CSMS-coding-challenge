<?php

namespace App\Models;

class Invoice
{

    public ?ChargingDetailRecord $chargingDetailRecord = null;
    public ?ChargingRate $chargingRate = null;
    private ?float $overall = 0;
    private ?float $energy = 0;
    private ?float $time = 0;
    private ?float $transaction = 0;

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function calculate(){
        if($this->chargingRate && $this->chargingDetailRecord){
            $this->calculateIfChargingIsValid();
        }
    }
    public function calculateIfChargingIsValid(){
        if($this->chargingRate->isValid() && $this->chargingDetailRecord->isValid()) {
            $this->calculatePrice();
        }
    }
    private function calculatePrice()
    {
        $this->energy = $this->chargingDetailRecord->getValue() * $this->chargingRate->rate;
        $this->time =$this->chargingDetailRecord->getDuration() * $this->chargingRate->time;
        $this->transaction = $this->chargingRate->transaction;
        $this->overall = $this->energy + $this->time + $this->transaction;
    }
}
