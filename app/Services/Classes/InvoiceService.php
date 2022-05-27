<?php

namespace App\Services\Classes;

use App\Http\Requests\Invoice\InvoiceCalculateRequest;
use App\Models\ChargingDetailRecord;
use App\Models\ChargingRate;
use App\Models\Invoice;
use App\Services\Interfaces\IInvoiceService;

class InvoiceService implements IInvoiceService
{

    /**
     * @param array $data
     * @return array|null
     */
    public function calculate(array $data): ?array
    {
        $invoice = new Invoice();
        if(count($data) !== 0) {
            $rateData = $data['rate'];
            $cdrData = $data['cdr'];
            $chargingDetailRecord = new ChargingDetailRecord($cdrData);
            $chargingRate = new ChargingRate($rateData);

            $invoice->chargingDetailRecord = $chargingDetailRecord;
            $invoice->chargingRate = $chargingRate;

            $invoice->calculate();
        }

        return([
            'overall'=>$invoice->overall,
            'components'=>[
                'energy'=>$invoice->energy,
                'time'=>$invoice->time,
                'transaction'=>$invoice->transaction,
            ]
        ]);
    }
}
