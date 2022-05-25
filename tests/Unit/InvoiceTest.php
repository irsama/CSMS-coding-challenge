<?php

namespace Tests\Unit;

use App\Models\ChargingDetailRecord;
use App\Models\ChargingRate;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use WithFaker;

    private function createChargingDetailRecord(): ChargingDetailRecord{
        $chargingDetailRecord = new ChargingDetailRecord();
        $chargingDetailRecord->meterStart = intval($this->faker->numerify('#######'));
        $chargingDetailRecord->meterStop = $chargingDetailRecord->meterStart + intval($this->faker->numerify('#####'));
        $chargingDetailRecord->timestampStart = new \DateTime($this->faker->iso8601());
        $chargingDetailRecord->timestampStop = $chargingDetailRecord->timestampStart->add(new \DateInterval('PT' . rand(60,135) . 'M'));
        return $chargingDetailRecord;
    }

    private function createChargingRate(): ChargingRate{
        $chargingRate = new ChargingRate();
        $chargingRate->rate = rand(0.2,0.9);
        $chargingRate->time = rand(2,4);
        $chargingRate->transaction = rand(1,1.5);
        return $chargingRate;
    }
    /**
     * A unit test that assert invoice price components.
     *
     * @return void
     */
    public function test_invoice_calculate_price()
    {
        $chargingDetailRecord = $this->createChargingDetailRecord();
        $chargingRate = $this->createChargingRate();

        $invoice = new Invoice();
        $invoice->chargingDetailRecord = $chargingDetailRecord;
        $invoice->chargingRate = $chargingRate;

        $invoice->calculate();
        $this->assertIsFloat($invoice->overall);
        $this->assertIsFloat($invoice->energy);
        $this->assertIsFloat($invoice->time);
        $this->assertIsFloat($invoice->transaction);
    }
    /**
     * A unit test that assert invoice overall be equal with other components.
     *
     * @return void
     */
    public function test_invoice_calculate_overall()
    {
        $chargingDetailRecord = $this->createChargingDetailRecord();
        $chargingRate = $this->createChargingRate();

        $invoice = new Invoice();
        $invoice->chargingDetailRecord = $chargingDetailRecord;
        $invoice->chargingRate = $chargingRate;
        $invoice->calculate();
        $this->assertEquals($invoice->overall,($invoice->eneregy+$invoice->time+$invoice->transaction));
    }

    /**
     * A unit test that assert invoice components be zero in mismatch situation.
     *
     * @return void
     */
    public function test_invoice_return_zero_without_charging_detail_record()
    {
        $chargingRate = $this->createChargingRate();

        $invoice = new Invoice();
        $invoice->chargingRate = $chargingRate;
        $invoice->calculate();
        $this->assertEquals($invoice->energy,0);
        $this->assertEquals($invoice->time,0);
        $this->assertEquals($invoice->transaction,0);
        $this->assertEquals($invoice->overall,0);
    }

    /**
     * A unit test that assert invoice components be zero in mismatch situation.
     *
     * @return void
     */
    public function test_invoice_return_zero_without_charging_rate()
    {
        $chargingDetailRecord = $this->createChargingDetailRecord();

        $invoice = new Invoice();
        $invoice->chargingDetailRecord = $chargingDetailRecord;
        $invoice->calculate();
        $this->assertEquals($invoice->energy,0);
        $this->assertEquals($invoice->time,0);
        $this->assertEquals($invoice->transaction,0);
        $this->assertEquals($invoice->overall,0);
    }

    /**
     * A unit test that assert invoice components be zero in mismatch situation.
     *
     * @return void
     */
    public function test_invoice_return_zero_when_meter_start_equal_meter_stop()
    {
        $chargingDetailRecord = $this->createChargingDetailRecord();
        $chargingDetailRecord->meterStop = $chargingDetailRecord->meterStart;
        $chargingRate = $this->createChargingRate();

        $invoice = new Invoice();
        $invoice->chargingDetailRecord = $chargingDetailRecord;
        $invoice->chargingRate = $chargingRate;
        $invoice->calculate();
        $this->assertEquals($invoice->energy,0);
        $this->assertEquals($invoice->time,0);
        $this->assertEquals($invoice->transaction,0);
        $this->assertEquals($invoice->overall,0);
    }

    /**
     * A unit test that assert invoice components be zero in mismatch situation.
     *
     * @return void
     */
    public function test_invoice_return_zero_when_meter_start_less_than_meter_stop()
    {
        $chargingDetailRecord = $this->createChargingDetailRecord();
        $chargingRate = $this->createChargingRate();
        $chargingDetailRecord->meterStop = $chargingDetailRecord->meterStart-1;

        $invoice = new Invoice();
        $invoice->chargingDetailRecord = $chargingDetailRecord;
        $invoice->chargingRate = $chargingRate;
        $invoice->calculate();
        $this->assertEquals($invoice->energy,0);
        $this->assertEquals($invoice->time,0);
        $this->assertEquals($invoice->transaction,0);
        $this->assertEquals($invoice->overall,0);
    }

    /**
     * A unit test that assert invoice components be zero in mismatch situation.
     *
     * @return void
     */
    public function test_invoice_return_zero_when_timestamp_start_equal_timestamp_stop()
    {
        $chargingDetailRecord = $this->createChargingDetailRecord();
        $chargingRate = $this->createChargingRate();
        $chargingDetailRecord->timestampStop = $chargingDetailRecord->timestampStart;

        $invoice = new Invoice();
        $invoice->chargingDetailRecord = $chargingDetailRecord;
        $invoice->chargingRate = $chargingRate;
        $invoice->calculate();
        $this->assertEquals($invoice->energy,0);
        $this->assertEquals($invoice->time,0);
        $this->assertEquals($invoice->transaction,0);
        $this->assertEquals($invoice->overall,0);
    }

    /**
     * A unit test that assert invoice components be zero in mismatch situation.
     *
     * @return void
     */
    public function test_invoice_return_zero_when_timestamp_start_less_than_timestamp_stop()
    {
        $chargingDetailRecord = $this->createChargingDetailRecord();
        $chargingRate = $this->createChargingRate();
        $time = new \DateTime($chargingDetailRecord->timestampStop);
        $chargingDetailRecord->timestampStart = $time->add(new \DateInterval('PT' . rand(60,135) . 'M'));

        $invoice = new Invoice();
        $invoice->chargingDetailRecord = $chargingDetailRecord;
        $invoice->chargingRate = $chargingRate;
        $invoice->calculate();
        $this->assertEquals($invoice->energy,0);
        $this->assertEquals($invoice->time,0);
        $this->assertEquals($invoice->transaction,0);
        $this->assertEquals($invoice->overall,0);
    }
}
