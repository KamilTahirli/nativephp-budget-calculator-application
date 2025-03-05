@php
    use App\Constants\LimitConst
@endphp

@extends('frontend.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-xl-4">
                            <div class="page-title-content">
                                <h3>@lang('site.user.income_and_expenses_calculator')</h3>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex">
                                <button type="button"
                                        class="btn btn-secondary filter-btn d-flex justify-content-center align-items-center me-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#filterItemsModal">
                                    <i class="fa-solid fa-filter"></i>
                                </button>
                                <button type="button"
                                        class="btn btn-danger d-flex justify-content-center align-items-center me-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#generateReportModal">
                                    @lang('site.user.report')
                                </button>
                                <button type="button"
                                        class="btn btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addNewProcessModal">
                                    @lang('site.user.add')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-12 col-xl-12">

                <div class="row">
                    <div class="col-xl-4 col-sm-6">
                        <div class="analytics-widget">
                            <div class="widget-icon me-3 bg-success">
                                <span>
                                   <i class="fa-solid fa-coins"></i>
                                </span>
                            </div>
                            <div class="widget-content">
                                <p>@lang('site.user.expenses')</p>
                                <h3 id="expenseTotal">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <div class="analytics-widget">
                            <div class="widget-icon me-3 bg-primary"><span>
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                </span>
                            </div>
                            <div class="widget-content">
                                <p>@lang('site.user.incomes')</p>
                                <h3 id="incomeTotal">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <div class="analytics-widget">
                            <div class="widget-icon me-3 bg-warning">
                                <span>
                                    <i class="fa-solid fa-wallet"></i>
                                </span>
                            </div>
                            <div class="widget-content">
                                <p>@lang('site.user.balance')</p>
                                <h3 id="balanceTotal">0</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">@lang('site.user.transactions')</h4>
                            </div>
                            <div class="card-body">
                                <div class="transaction-table">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-responsive-sm">
                                            <thead>
                                            <tr>
                                                <th>@lang('site.user.category')</th>
                                                <th>@lang('site.user.type')</th>
                                                <th>@lang('site.user.date')</th>
                                                <th>@lang('site.user.memory')</th>
                                                <th>@lang('site.user.amount')</th>
                                                <th>@lang('site.user.transactions')</th>
                                            </tr>
                                            </thead>

                                            <tbody id="transactionList"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('frontend.partials.modals.__add_new_process')
    @include('frontend.partials.modals.__edit_transaction')
    @include('frontend.partials.modals.__generate_report')
    @include('frontend.partials.modals.__filter_items')
@endsection

@section('front_scripts')
    @parent
    <script type="module">
        $(document).ready(function () {
            let currentDateTime = moment().format('YYYY-MM-DD');
            let listEmpty = `{{ __('site.user.list_empty') }}`;
            let showMore = `{{ __('site.user.show_more') }}`;
            let showLess = `{{ __('site.user.show_less') }}`;

            function getTransactions(transactionDate = null, page = 1) {
                transactionDate = transactionDate == null ? currentDateTime : transactionDate;
                const transactionList = $('#transactionList');
                const route = `{{ route('transactions.list') }}`;

                axios.get(route, {params: {date: transactionDate, page: page}})
                    .then(response => {
                        transactionList.html(response.data.result ?? '');
                        $('#pagination-links').html(response.data.pagination ?? '');
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        showLessTransactions();
                    });
            }

            window.getTransactions = getTransactions;
            getTransactions();


            function calculateTotalBalance(calculationDate = null) {
                calculationDate = calculationDate == null ? currentDateTime : calculationDate;
                const route = `{{ route('transactions.calculate.total-balance') }}`
                axios.get(route, {params: {calculationDate}})
                    .then((response) => {
                        let total = response.data.result;
                        $('#incomeTotal').html(total.income ?? 0)
                        $('#expenseTotal').html(Math.abs(total.expense) ?? 0)
                        $('#balanceTotal').html(total.balance ?? 0)
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }

            function destroy() {
                $(document).on("click", ".delete-btn", async function () {
                    const selectedTransactionData = $(this).data("delete-transaction");
                    const deleteTransactionRoute = '{{ route("transactions.destroy", ["transaction" => ":transactionId"]) }}'
                        .replace(':transactionId', selectedTransactionData.id);

                    if (confirm(`{{ __('site.alert.do_you_want_to_delete') }}`)) {
                        try {
                            const response = await axios.delete(deleteTransactionRoute);

                            if (response.status === 200) {
                                location.reload();
                            }
                        } catch (error) {
                            alert(`{{ __('site.response.an_error_occurred') }}`);
                            console.error(error);
                        }
                    }
                });
            }

            destroy();
            function showLessTransactions() {

                let showLessLimit = `{{ LimitConst::USER_TRANSACTION_LIMIT }}`;

                let items = $(".table-item");

                if (items.length === 0) {
                    $("#loadMore").append(`<div id="list-empty" class="alert alert-warning">${listEmpty}</div>`);
                } else if (items.length > showLessLimit) {
                    items.slice(showLessLimit).hide();

                    $("#loadMore").append(`<button id="toggle-btn" class="btn btn-primary">${showMore}</button>`);

                    $("#toggle-btn").click(function () {
                        if ($(this).text() === showMore) {
                            items.slice(showLessLimit).slideDown();
                            $(this).text(`${showLess}`);
                        } else {
                            items.slice(showLessLimit).slideUp();
                            $(this).text(`${showMore}`);
                        }
                    });
                }
            }




            window.calculateTotalBalance = calculateTotalBalance;
            calculateTotalBalance();

        })
    </script>

@endsection
