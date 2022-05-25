<?php

namespace App\Models;


class ChargingDetailRecord
{
    public int $meterStart;
    public \DateTime $timestampStart;
    public int $meterStop;
    public \DateTime $timestampStop;
}
