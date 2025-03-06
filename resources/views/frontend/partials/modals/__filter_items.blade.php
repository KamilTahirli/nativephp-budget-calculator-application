<div
    class="modal fade"
    id="filterItemsModal"
    tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">{{ __('site.user.filter') }}</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            <div class="modal-body">

                <div class="mt-3">
                    <div class="row">
                        <div class="col-8">
                            <label for="filterDate" class="form-label">{{ __('site.user.date') }}</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text">
                                   <i class="fa-regular fa-calendar-check"></i>
                                </span>
                                <input id="filterDate" type="text" class="form-control" placeholder="{{ __('site.user.select_date') }}">
                            </div>
                            <div class="error-msg" id="filterDateError"></div>
                        </div>

                        <div class="col-4 d-flex align-items-end mb-2">
                            <button id="filterSubmit" class="btn btn-success">{{ __('site.user.apply') }}</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    @section('front_scripts')
        @parent
        <script type="module">
            $(document).ready(function () {
                let currentFilterDate = moment().format('YYYY-MM-DD');
                let selectedFilterDate = currentFilterDate ?? null;

                new AirDatepicker('#filterDate', {
                    selectedDates: currentFilterDate,
                    dateFormat: "yyyy-MM-dd",
                    onSelect: function ({date}) {
                        selectedFilterDate = moment(date).format('YYYY-MM-DD') ?? null;
                    },
                    position: 'bottom right'
                });

                $('#filterSubmit').on('click', function () {
                    if (window.getTransactions) {
                        window.getTransactions(selectedFilterDate);
                    }
                });
            });
        </script>
@endsection


