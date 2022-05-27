<?php

namespace App\Services\Interfaces;

use App\Http\Requests\Invoice\InvoiceCalculateRequest;

interface IInvoiceService
{
    /**
     * @param array $data
     * @return array|null
     */
    public function calculate(array $data): ?array;
}
