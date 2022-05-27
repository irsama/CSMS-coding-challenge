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
        $this->energy = number_format(
            round(
                $this->chargingDetailRecord->getValueInkWh() * $this->chargingRate->energy,3
            ),
            3,'.','');
        $this->time =number_format(
            round(
                $this->chargingDetailRecord->getDurationInHour() * $this->chargingRate->time,3
            ),
            3,'.','');
        $this->transaction = number_format(
            round(
                $this->chargingRate->transaction,3
            ),
            3,'.','');
        $this->overall = number_format(
            round(
                $this->energy + $this->time + $this->transaction,2
            ),
            2,'.','');
    }
}
