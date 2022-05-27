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
     * @param InvoiceCalculateRequest $request
     * @return array|null
     */
    public function calculate(InvoiceCalculateRequest $request): ?array
    {
        $invoice = new Invoice();
        if (!$request->validator->fails()) {
            $rateData = $request->get('rate');
            $cdrData = $request->get('cdr');
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
