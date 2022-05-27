<?php

namespace App\Services\Interfaces;

use App\Http\Requests\Invoice\InvoiceCalculateRequest;

interface IInvoiceService
{
    /**
     * @param InvoiceCalculateRequest $request
     * @return array|null
     */
    public function calculate(InvoiceCalculateRequest $request): ?array;
}
