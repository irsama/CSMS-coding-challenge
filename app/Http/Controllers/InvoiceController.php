<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\InvoiceCalculateRequest;
use App\Services\Classes\InvoiceService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(title="Invoice", version="0.1")
 */
class InvoiceController extends Controller
{
    /**
     * Add a new pet to the store.
     *
     * @OA\Post(
     *     path="/rate",
     *     tags={"rate"},
     *     operationId="addRate",
     *     summary="Calculate given rate to the corresponding CDR",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="overall", type="number"),
     *              @OA\Property(property="rate", type="object",
     *                  @OA\Property(property="energy", type="number"),
     *                  @OA\Property(property="time", type="number"),
     *                  @OA\Property(property="transaction", type="number"),
     *              ),
     *          ),
     *     ),
     *     @OA\RequestBody(
     *          description="rate and CDR for calculating parice",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="cdr", type="object",
     *                  @OA\Property(property="meterStart", type="number"),
     *                  @OA\Property(property="timestampStart", type="string timestamp according to ISO 8601"),
     *                  @OA\Property(property="meterStop", type="number"),
     *                  @OA\Property(property="timestamp", type="string timestamp according to ISO 8601"),
     *              ),
     *              @OA\Property(property="rate", type="object",
     *                  @OA\Property(property="energy", type="number"),
     *                  @OA\Property(property="time", type="number"),
     *                  @OA\Property(property="transaction", type="number"),
     *              ),
     *          ),
     *         required=true,
     *     )
     *)
     */
    public function rate(InvoiceCalculateRequest $request): JsonResponse
    {
        $data = [];
        if(!$request->validator->fails()){
            $data = $request->all();
        }
        $invoiceService = new InvoiceService();
        return response()->json($invoiceService->calculate($data),200);
    }
}
