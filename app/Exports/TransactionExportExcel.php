<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionExportExcel implements FromView
{

    /**
     * @param $transactions
     */
    public function __construct(private $transactions)
    {
    }

    public function view(): View
    {
        return view('frontend.partials.render.__transaction_item', [
            'transactions' => $this->transactions
        ]);
    }
}
