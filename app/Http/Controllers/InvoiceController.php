<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\InvoiceCalculateRequest;
use App\Services\Classes\InvoiceService;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
    /**
     * @param InvoiceCalculateRequest $request
     * @return JsonResponse
     */
    public function rate(InvoiceCalculateRequest $request): JsonResponse
    {
        $invoiceService = new InvoiceService();
        return response()->json($invoiceService->calculate($request));
    }
}
