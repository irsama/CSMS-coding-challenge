<?php

namespace App\Models;


class ChargingDetailRecord
{
    public int $meterStart;
    public \DateTime $timestampStart;
    public int $meterStop;
    public \DateTime $timestampStop;
    public function getValue(): int
    {
        return $this->meterStop - $this->meterStart;
    }
    public function getDuration(){
        $interval = $this->timestampStop->diff($this->timestampStart);
        $hours   = $interval->format('%h');
        $minutes = $interval->format('%i');
        $second = $interval->format('%s');
       return (intval($hours) * 60) + intval($minutes) + (intval($second) / 60);
    }
    public function isValid(): bool
    {
        if($this->meterStart>=$this->meterStop){
            return false;
        }
        if($this->timestampStart>=$this->timestampStop){
            return false;
        }
        return true;
    }
}
