<?php

namespace App\Http\Controllers\Frontend\API;

use App\Exports\TransactionExportExcel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\GenerateReportRequest;
use App\Services\Frontend\API\TransactionService;
use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    /**
     * @param TransactionService $transactionService
     */
    public function __construct(private readonly TransactionService $transactionService)
    {
    }

    public function generate(GenerateReportRequest $request)
    {
        try {
            $transactions = $this->transactionService->getTransactions($request, true, false);
            if ($transactions->isEmpty()) {
                $this->nativeAlertNotify(__('site.response.error'), __('site.user.selected_date_transaction_not_working'));
            } else {
                $filePath = 'reports/reports.xlsx';
                Excel::store(new TransactionExportExcel($transactions), $filePath, 'local');
                $this->nativeAlertNotify(__('site.response.success'), 'smdmkdndk');
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('site.response.internal_error'));
        }
    }
}
