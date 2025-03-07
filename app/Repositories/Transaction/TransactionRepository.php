<?php

namespace App\Repositories\Transaction;

use App\Interfaces\TransactionInterface;
use App\Models\Transaction;

class TransactionRepository implements TransactionInterface
{
    /**
     * @param string $date
     * @return mixed
     */
    public function getTransactionByDate(string $date): mixed
    {
        return Transaction::where('user_id', auth()->user()->id)
            ->whereDate('date', $date)
            ->orderBy('date', 'desc')
            ->with('category:id,name,icon_code,type')
            ->get();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function create($request): mixed
    {
        return Transaction::create([
            'user_id' => auth()->user()->id,
            'category_id' => $request->input('categoryId'),
            'amount' => $request->input('amount'),
            'memo' => $request->input('memo'),
            'date' => $request->input('date') ?? now()->format('Y-m-d'),
        ]);
    }


    /**
     * @param $request
     * @param Transaction $transaction
     * @return bool
     */
    public function update($request, Transaction $transaction): bool
    {
        return $transaction->update([
            'user_id' => auth()->user()->id,
            'category_id' => $request->input('categoryId'),
            'amount' => $request->input('amount'),
            'memo' => $request->input('memo'),
            'date' => $request->input('date') ?? now()->format('Y-m-d'),
        ]);
    }

    /**
     * @param Transaction $transaction
     * @return void
     */
    public function delete(Transaction $transaction): void
    {
        $transaction->delete();
    }

    /**
     * @param string $date
     * @return mixed
     */
    public function calculateBudgetByDate(string $date): mixed
    {
        return Transaction::selectRaw("
            SUM(CASE WHEN categories.type = 'income' THEN amount ELSE 0 END) AS incomeTotal,
            SUM(CASE WHEN categories.type = 'expense' THEN amount ELSE 0 END) AS expenseTotal")
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', auth()->user()->id)
            ->whereDate('transactions.date', $date)
            ->first();
    }

}
