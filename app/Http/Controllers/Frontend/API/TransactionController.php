<?php

namespace App\Http\Controllers\Frontend\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CalculateTotalBalanceRequest;
use App\Http\Requests\Frontend\TransactionListRequest;
use App\Http\Requests\Frontend\TransactionSaveOrUpdateRequest;
use App\Services\Frontend\API\TransactionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{

    /**
     * @param TransactionService $transactionService
     */
    public function __construct(private readonly TransactionService $transactionService)
    {
    }


    public function list(TransactionListRequest $request)
    {
        try {
            $transaction = $this->transactionService->getTransactions($request);
            return $this->successResponse(data: $transaction);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse("Serverdə xəta baş verdi!");
        }
    }

    /**
     * @param TransactionSaveOrUpdateRequest $request
     * @return JsonResponse
     */
    public function store(TransactionSaveOrUpdateRequest $request): JsonResponse
    {
        try {
            $transaction = $this->transactionService->createTransaction($request);
            return $this->successResponse("Tranzaksiya uğurla əlavə edildi!", $transaction);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse("Tranzaksiya əlavə edilə bilmədi");
        }
    }

    /**
     * @param CalculateTotalBalanceRequest $request
     * @return JsonResponse
     */
    public function calculateTotalBalance(CalculateTotalBalanceRequest $request): JsonResponse
    {
        try {
            $transactions = $this->transactionService->calculateTotalBalance($request);
            return $this->successResponse(data: $transactions);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse("Serverdə xəta baş verdi!");
        }
    }
}
