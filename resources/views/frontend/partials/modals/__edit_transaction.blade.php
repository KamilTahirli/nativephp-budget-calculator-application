<div
    class="modal fade"
    id="editTransactionModal"
    tabindex="-1"
    aria-labelledby="editTransactionLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editTransactionLabel">@lang('site.user.update_transaction')</h5>
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
                            <span class="nav-link edit-income-tab active-tab">
                                {{ __('site.user.income') }}
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link edit-expense-tab">
                                 {{ __('site.user.expense') }}
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="container mt-5">
                    <div class="d-flex justify-content-center">
                        <div
                            class="spinner-border"
                            id="editCategoryLoader"
                            role="status">
                            <span class="visually-hidden">{{ __('site.user.loading') }}</span>
                        </div>
                    </div>
                    <div class="row g-3" id="editCategoryList"></div>
                    <div class="edit-error-msg mx-5" id="categoryIdErrorEdit"></div>
                </div>
            </div>

            <div id="processForm" class="mt-3 p-5 mx-5">

                <div class="nb-3">
                    <label for="memo" class="form-label">{{ __('site.user.memory') }}</label>
                    <textarea
                        name="memo"
                        id="editMemo"
                        class="form-control"
                        cols="30"
                        rows="10"></textarea>
                    <div class="edit-error-msg" id="memoErrorEdit"></div>
                </div>

                <div class="mt-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="date" class="form-label">{{ __('site.user.date') }}</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">
                                     <i class="fa-solid fa-calendar"></i>
                                </span>
                                <input id="editDatePicker" type="text" class="form-control"
                                       placeholder="{{ __('site.user.select_date') }}">
                            </div>
                            <div class="edit-error-msg" id="dateErrorEdit"></div>
                        </div>

                        <div class="col-lg-6">
                            <label for="amount" class="form-label">{{ __('site.user.amount') }}</label>

                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">
                                     <i class="fa-solid fa-coins"></i>
                                </span>
                                <input
                                    type="number"
                                    id="editAmount"
                                    name="amount"
                                    min="0"
                                    step="any"
                                    class="form-control">
                            </div>
                            <div class="edit-error-msg" id="amountErrorEdit"></div>
                        </div>
                    </div>

                </div>

                <div class="form-group mt-5" id="updateTransaction">
                    <button type="submit" class="btn btn-success">{{ __('site.user.update') }}</button>
                </div>
            </div>

        </div>
    </div>
</div>

@section('front_scripts')
    @parent
    <script type="module">
        $(document).ready(function () {
            const editCategoryList = $('#editCategoryList');
            const editCategoryLoader = $('#editCategoryLoader');
            const editTransactionList = $('#editTransactionList');
            const editMemoInput = $('#editMemo');
            const categoriesRoute = `{{ route('categories') }}`;
            let errors = [];
            let editAmountInput = $('#editAmount');
            let currentDate = moment().format('YYYY-MM-DD HH:mm');
            let selectedDate = null;
            let type = 'income';
            let categoryId = null;
            let deleteTransactionRoute = null;

            function getCategoriesList(type = 'income') {
                return new Promise((resolve, reject) => {
                    editCategoryLoader.show();
                    axios.get(categoriesRoute, {params: {type}})
                        .then((response) => {
                            editCategoryList.html(response.data.result ?? '');
                            resolve(response);
                        })
                        .catch((error) => {
                            console.error(error);
                            reject(error);
                        })
                        .finally(() => {
                            editCategoryLoader.hide();
                        });
                });
            }

            function toggleActiveClass(el, selectedClass, activeClass) {
                $(selectedClass).removeClass(activeClass);
                $(el).addClass(activeClass);
            }

            function edit() {
                $(document).on("click", ".edit-btn", async function () {
                    const selectedTransactionData = $(this).data("edit-transaction");
                    deleteTransactionRoute = '{{ route("transactions.update", ["transaction" => ":transactionId"]) }}'.replace(':transactionId', selectedTransactionData.id);
                    $("#editTransactionModal").modal("show");

                    type = selectedTransactionData.category.type;
                    editAmountInput.val(Math.abs(selectedTransactionData.amount));
                    editMemoInput.val(selectedTransactionData.memo);
                    setupDatePicker(selectedTransactionData.date);

                    await selectDefaultTab(selectedTransactionData.category);

                });
            }

            edit();



            async function selectDefaultTab(category) {
                toggleActiveClass($(`.edit-${category.type}-tab`), '.edit-income-tab, .edit-expense-tab', 'active-tab');
                await getCategoriesList(category.type);
                selectDefaultCategory(category.id);

                $(document).on('click', '.edit-income-tab, .edit-expense-tab', async function () {
                    type = $(this).hasClass('edit-income-tab') ? 'income' : 'expense';
                    toggleActiveClass(this, '.edit-income-tab, .edit-expense-tab', 'active-tab');
                    await getCategoriesList(type);
                    selectDefaultCategory(category.id);
                });
            }

            function selectDefaultCategory(id) {
                let selectCategory = $(".category-card[data-id='" + id + "']");
                toggleActiveClass(selectCategory, '.category-card', 'active-category');
                categoryId = id
            }

            function setupDatePicker(itemDate) {
                selectedDate = itemDate
                new AirDatepicker('#editDatePicker', {
                    timepicker: true,
                    selectedDates: itemDate ?? currentDate,
                    dateFormat: "yyyy-MM-dd",
                    onSelect: function ({date}) {
                        selectedDate = moment(date).format('YYYY-MM-DD HH:mm') ?? null;
                    },
                    position: 'top right'
                });
            }

            function updateTransaction() {
                const amount = type === 'expense' ? -Math.abs(editAmountInput.val()) : editAmountInput.val();
                const memo = editMemoInput.val();
                axios.put(deleteTransactionRoute, {categoryId, date: selectedDate, amount, memo})
                    .then(response => {
                        if (window.calculateTotalBalance) {
                            window.calculateTotalBalance(moment(selectedDate).format('YYYY-MM-DD'));
                        }
                        if (window.getTransactions) {
                            window.getTransactions(moment(selectedDate).format('YYYY-MM-DD'));
                        }
                        editTransactionList.prepend(response.data.result ?? '');
                        resetForm();
                    })
                    .catch((error) => {
                        $('.edit-error-msg').html('');
                        let errorResponse = error.response;

                        if (errorResponse.status === 422) {
                            errors = errorResponse.data.errors;
                            $.each(errors, function (key, message) {
                                let errorClass = '#' + key + 'ErrorEdit';
                                $(errorClass).html(message);
                            });
                        }
                    })
            }

            function resetForm() {
                $('.edit-error-msg').html('');
                $('#editTransactionModal').modal('hide');
            }

            $(document).on('click', '.category-card', function () {
                toggleActiveClass(this, '.category-card', 'active-category');
                categoryId = $(this).data("id");
            });


            $('#updateTransaction').off('click').on('click', function () {
                updateTransaction();
            });
        });
    </script>
@endsection


