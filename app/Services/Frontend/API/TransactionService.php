<?php

namespace App\Services\Frontend\API;

use App\Http\Requests\Frontend\CalculateTotalBalanceRequest;
use App\Http\Requests\Frontend\TransactionListRequest;
use App\Http\Requests\Frontend\TransactionSaveOrUpdateRequest;
use App\Models\Transaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionService
{

    /**
     * @param TransactionSaveOrUpdateRequest $request
     * @return string
     */
    public function createTransaction(TransactionSaveOrUpdateRequest $request): string
    {
        $transaction = Transaction::create([
            'user_id' => auth()->user()->id,
            'category_id' => $request->input('categoryId'),
            'amount' => $request->input('amount'),
            'memo' => $request->input('memo'),
            'date' => $request->input('date') ?? now()->format('Y-m-d'),
        ]);

        $transaction->load(['category:id,name,icon_code,type']);

        return view('frontend.partials.render.__transaction_item', compact('transaction'))->render();
    }

    /**
     * @param Transaction $transaction
     * @param TransactionSaveOrUpdateRequest $request
     * @return string
     */
    public function updateTransaction(Transaction $transaction, TransactionSaveOrUpdateRequest $request): string
    {
        $transaction->update([
            'user_id' => auth()->user()->id,
            'category_id' => $request->input('categoryId'),
            'amount' => $request->input('amount'),
            'memo' => $request->input('memo'),
            'date' => $request->input('date') ?? now()->format('Y-m-d'),
        ]);

        $transaction->load(['category:id,name,icon_code,type']);

        return view('frontend.partials.render.__transaction_item', compact('transaction'))->render();
    }


    /**
     * @param TransactionListRequest $request
     * @param bool $collection
     * @param bool $render
     * @return mixed
     */
    public function getTransactions(Request $request, bool $collection = false, bool $render = true): mixed
    {
        $transactions = Transaction::where('user_id', auth()->user()->id)
            ->whereDate('date', $request->input('date'))
            ->orderBy('date', 'desc')
            ->with('category:id,name,icon_code,type')
            ->get();

        if ($collection) {
            return $transactions;
        }
        $view = view('frontend.partials.render.__transaction_item', compact('transactions'));
        if (!$render) {
            return $view;
        }
        return $view->render();
    }


    /**
     * @param CalculateTotalBalanceRequest $request
     * @return array
     */
    public function calculateTotalBalance(CalculateTotalBalanceRequest $request): array
    {
        $calculationDate = $request->input('calculationDate');

        $totals = Transaction::selectRaw("
            SUM(CASE WHEN categories.type = 'income' THEN amount ELSE 0 END) AS incomeTotal,
            SUM(CASE WHEN categories.type = 'expense' THEN amount ELSE 0 END) AS expenseTotal")
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', auth()->user()->id)
            ->whereDate('transactions.date', $calculationDate)
            ->first();


        return [
            'income' => $totals->incomeTotal,
            'expense' => $totals->expenseTotal,
            'balance' => $totals->incomeTotal + $totals->expenseTotal
        ];
    }


}
