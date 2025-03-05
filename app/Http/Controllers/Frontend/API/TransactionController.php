<?php

namespace App\Http\Controllers\Frontend\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CalculateTotalBalanceRequest;
use App\Http\Requests\Frontend\TransactionListRequest;
use App\Http\Requests\Frontend\TransactionSaveOrUpdateRequest;
use App\Models\Transaction;
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
            return $this->errorResponse(__('site.response.an_error_occurred'));
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
            return $this->successResponse(__('site.response.transaction_added'), $transaction);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('site.response.an_error_occurred'));
        }
    }


    public function destroy(Transaction $transaction): JsonResponse
    {
        try {
            if ($transaction->user_id !== auth()->id()) {
                return $this->errorResponse(__('site.response.you_dont_have_permission'), 403);
            }

            $transaction->delete();
            return $this->successResponse(data: $transaction);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('site.response.an_error_occurred'));
        }
    }

    public function update(Transaction $transaction, TransactionSaveOrUpdateRequest $request): JsonResponse
    {
        try {
            if ($transaction->user_id !== auth()->id()) {
                return $this->errorResponse(__('site.response.you_dont_have_permission'), 403);
            }

            $transaction = $this->transactionService->updateTransaction($transaction, $request);
            return $this->successResponse(__('site.response.transaction_updated'), $transaction);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('site.response.an_error_occurred'));
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
            return $this->errorResponse(__('site.response.an_error_occurred'));
        }
    }
}
