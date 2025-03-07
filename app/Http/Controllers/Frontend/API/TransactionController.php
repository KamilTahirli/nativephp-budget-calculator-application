<?php

namespace App\Http\Controllers\Frontend\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CalculateBudgetRequest;
use App\Http\Requests\Frontend\TransactionListRequest;
use App\Http\Requests\Frontend\TransactionSaveOrUpdateRequest;
use App\Models\Transaction;
use App\Services\Frontend\API\TransactionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as StatusCode;

class TransactionController extends Controller
{

    /**
     * @param TransactionService $transactionService
     */
    public function __construct(private readonly TransactionService $transactionService)
    {
    }


    /**
     * @param TransactionListRequest $request
     * @return JsonResponse
     */
    public function getTransactions(TransactionListRequest $request): JsonResponse
    {
        try {
            $transactions = $this->transactionService->getTransactions($request);
            $transactionView = $this->transactionService->transactionRenderView(['transactions' => $transactions]);
            return $this->successResponse(data: $transactionView->render());
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
            $transactionView = $this->transactionService->transactionRenderView(['transaction' => $transaction]);
            return $this->successResponse(__('site.response.transaction_added'), $transactionView->render());
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('site.response.an_error_occurred'));
        }
    }


    /**
     * @param Transaction $transaction
     * @return JsonResponse
     */
    public function destroy(Transaction $transaction): JsonResponse
    {
        try {
            $this->authorize('delete', $transaction);
            $this->transactionService->deleteTransaction($transaction);
            return $this->successResponse(__('site.response.transaction_deleted'), StatusCode::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('site.response.an_error_occurred'));
        }
    }

    /**
     * @param Transaction $transaction
     * @param TransactionSaveOrUpdateRequest $request
     * @return JsonResponse
     */
    public function update(Transaction $transaction, TransactionSaveOrUpdateRequest $request): JsonResponse
    {
        try {
            $this->authorize('update', $transaction);
            $transactionView = $this->transactionService->transactionRenderView([
                'transaction' => $this->transactionService->updateTransaction($transaction, $request)
            ]);
            return $this->successResponse(__('site.response.transaction_updated'), $transactionView);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('site.response.an_error_occurred'));
        }
    }

    /**
     * @param CalculateBudgetRequest $request
     * @return JsonResponse
     */
    public function calculateBudget(CalculateBudgetRequest $request): JsonResponse
    {
        try {
            $transactions = $this->transactionService->calculateBudget($request);
            return $this->successResponse(data: $transactions);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('site.response.an_error_occurred'));
        }
    }
}
