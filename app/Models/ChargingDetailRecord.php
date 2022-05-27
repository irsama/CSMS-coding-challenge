<?php

namespace App\Models;


class ChargingDetailRecord
{
    public int $meterStart;
    public \DateTime $timestampStart;
    public int $meterStop;
    public \DateTime $timestampStop;

    function __construct($data=null) {
        if(is_array($data)){
            $this->meterStart = $data['meterStart'];
            $this->timestampStart = new \DateTime($data['timestampStart']);
            $this->meterStop = $data['meterStop'];
            $this->timestampStop = new \DateTime($data['timestampStop']);
        }
    }
    public function getValueInkWh()
    {
        return ($this->meterStop - $this->meterStart)/1000;
    }
    public function getDurationInHour(){
        $interval = $this->timestampStop->diff($this->timestampStart);
        $hours   = $interval->format('%h');
        $minutes = $interval->format('%i');
        $second = $interval->format('%s');
       return ((intval($hours) * 60) + intval($minutes) + (intval($second) / 60))/60;
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
