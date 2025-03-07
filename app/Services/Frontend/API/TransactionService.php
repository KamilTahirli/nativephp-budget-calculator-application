<?php

namespace App\Services\Frontend\API;

use App\Http\Requests\Frontend\CalculateBudgetRequest;
use App\Http\Requests\Frontend\TransactionListRequest;
use App\Http\Requests\Frontend\TransactionSaveOrUpdateRequest;
use App\Interfaces\TransactionInterface;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;

readonly class TransactionService
{

    /**
     * @param TransactionInterface $transactionRepository
     */
    public function __construct(private TransactionInterface $transactionRepository)
    {
    }


    /**
     * @param TransactionListRequest $request
     * @return mixed
     */
    public function getTransactions(TransactionListRequest $request): mixed
    {
        return $this->transactionRepository->getTransactionByDate($request->input('date'));
    }


    /**
     * @param TransactionSaveOrUpdateRequest $request
     * @return mixed
     */
    public function createTransaction(TransactionSaveOrUpdateRequest $request): mixed
    {
        $transaction = $this->transactionRepository->create($request);
        $transaction->load(['category:id,name,icon_code,type']);
        return $transaction;
    }

    /**
     * @param Transaction $transaction
     * @return mixed
     */
    public function deleteTransaction(Transaction $transaction): mixed
    {
        return $this->transactionRepository->delete($transaction);
    }


    /**
     * @param Transaction $transaction
     * @param TransactionSaveOrUpdateRequest $request
     * @return mixed
     */
    public function updateTransaction(Transaction $transaction, TransactionSaveOrUpdateRequest $request): mixed
    {
        return $this->transactionRepository->update($request, $transaction);
    }


    /**
     * @param CalculateBudgetRequest $request
     * @return array
     */
    public function calculateBudget(CalculateBudgetRequest $request): array
    {
        $budget = $this->transactionRepository->calculateBudgetByDate($request->input('calculationDate'));
        return [
            'income' => $budget->incomeTotal ?? 0,
            'expense' => $budget->expenseTotal ?? 0,
            'balance' => $budget->incomeTotal + $budget->expenseTotal ?? 0
        ];
    }

    /**
     * @param array $data
     * @return View
     */
    public function transactionRenderView(array $data): View
    {
        return view('frontend.partials.render.__transaction_item', $data);
    }


}
