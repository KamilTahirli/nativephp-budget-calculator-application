<div
    class="modal fade"
    id="addNewProcessModal"
    tabindex="-1"
    aria-labelledby="addNewProcessLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addNewProcessLabel">@lang('site.user.add_new_transaction')</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            <div class="modal-body">
                <div class="mt-3 p-5">
                    <ul class="nav nav-pills nav-fill">
                        <li class="nav-item me-2">
                            <span class="nav-link income-tab active-tab">
                                {{ __('site.user.income') }}
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link expense-tab">
                                 {{ __('site.user.expense') }}
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="container mt-5">
                    <div class="d-flex justify-content-center">
                        <div
                            class="spinner-border"
                            id="categoryLoader"
                            role="status">
                            <span class="visually-hidden">{{ __('site.user.loading') }}</span>
                        </div>
                    </div>
                    <div class="row g-3" id="categoryList"></div>
                    <div class="error-msg mx-5" id="categoryIdError"></div>
                </div>
            </div>

            <div id="processForm" class="mt-3 p-5 mx-5">

                <div class="nb-3">
                    <label for="memo" class="form-label">{{ __('site.user.memory') }}</label>
                    <textarea
                        name="memo"
                        id="memo"
                        class="form-control"
                        cols="30"
                        rows="10"></textarea>
                    <div class="error-msg" id="memoError"></div>
                </div>

                <div class="mt-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="date" class="form-label">{{ __('site.user.date') }}</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">
                                     <i class="fa-solid fa-calendar"></i>
                                </span>
                                <input id="datepicker" type="text" class="form-control"
                                       placeholder="{{ __('site.user.select_date') }}">
                            </div>
                            <div class="error-msg" id="dateError"></div>
                        </div>

                        <div class="col-lg-6">
                            <label for="amount" class="form-label">{{ __('site.user.amount') }}</label>

                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">
                                     <i class="fa-solid fa-coins"></i>
                                </span>
                                <input
                                    type="number"
                                    id="amount"
                                    name="amount"
                                    min="0"
                                    step="any"
                                    class="form-control">
                            </div>
                            <div class="error-msg" id="amountError"></div>
                        </div>
                    </div>

                </div>

                <div class="form-group mt-5" id="saveProcess">
                    <button type="submit" class="btn btn-success">{{ __('site.user.save') }}</button>
                </div>
            </div>

        </div>
    </div>
</div>

@section('front_scripts')
    @parent
    <script type="module">

        $(document).ready(function () {
            const categoryList = $('#categoryList');
            const categoryLoader = $('#categoryLoader');
            const transactionList = $('#transactionList');
            const amountInput = $('#amount');
            const memoInput = $('#memo');
            const categoriesRoute = `{{ route('categories') }}`;
            const saveRoute = `{{ route('transactions.store') }}`;
            let errors = [];
            let currentDate = moment().format('YYYY-MM-DD HH:mm');
            let selectedDate = currentDate ?? null;
            let type = 'income';
            let categoryId = null;


            function getCategories(type = 'income') {
                categoryLoader.show();
                axios.get(categoriesRoute, {params: {type}})
                    .then(response => categoryList.html(response.data.result ?? ''))
                    .catch(console.error)
                    .finally(() => categoryLoader.hide());
            }

            function toggleActiveClass(el, selectedClass, activeClass) {
                $(selectedClass).removeClass(activeClass);
                $(el).addClass(activeClass);
            }

            function saveProcess() {
                const amount = type === 'expense' ? -Math.abs(amountInput.val()) : amountInput.val();
                const memo = memoInput.val();
                axios.post(saveRoute, {categoryId, date: selectedDate, amount, memo})
                    .then(response => {
                        if (window.calculateTotalBalance) {
                            window.calculateTotalBalance(moment(selectedDate).format('YYYY-MM-DD'));
                        }
                        if (window.getTransactions) {
                            window.getTransactions(moment(selectedDate).format('YYYY-MM-DD'));
                        }
                        transactionList.prepend(response.data.result ?? '');
                        resetForm();
                    })
                    .catch((error) => {
                        $('.error-msg').html('');
                        let errorResponse = error.response;

                        if (errorResponse.status === 422) {
                            errors = errorResponse.data.errors;
                            $.each(errors, function (key, message) {
                                let errorClass = '#' + key + 'Error';
                                $(errorClass).html(message);
                            });
                        }
                    })

            }

            function resetForm() {
                $('.error-msg').html('');
                $('.category-card').removeClass('active-category');
                $('#datepicker').val(currentDate);
                categoryId = null;
                selectedDate = currentDate;
                amountInput.val('');
                memoInput.val('');

                $('#addNewProcessModal').modal('hide');
            }

            $(document).on('click', '.income-tab, .expense-tab', function () {
                type = $(this).hasClass('income-tab') ? 'income' : 'expense';
                toggleActiveClass(this, '.income-tab, .expense-tab', 'active-tab');
                getCategories(type);
            });

            $(document).on('click', '.category-card', function () {
                toggleActiveClass(this, '.category-card', 'active-category');
                categoryId = $(this).data("id");
            });

            $('#saveProcess').off('click').on('click', function () {
                saveProcess();
            });

            new AirDatepicker('#datepicker', {
                timepicker: true,
                selectedDates: currentDate,
                dateFormat: "yyyy-MM-dd",
                onSelect: function ({date}) {
                    selectedDate = moment(date).format('YYYY-MM-DD HH:mm') ?? null;
                },
                position: 'top right'
            });

            getCategories('income');
        });
    </script>
@endsection


