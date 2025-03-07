<?php

namespace App\Interfaces;

use App\Models\Transaction;

interface TransactionInterface
{

    public function create($request);

    public function update($request, Transaction $transaction);

    public function delete(Transaction $transaction);

    public function getTransactionByDate(string $date);

    public function calculateBudgetByDate(string $date);
}
