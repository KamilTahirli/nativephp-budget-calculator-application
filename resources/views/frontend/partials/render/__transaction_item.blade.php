@php
    use App\Constants\TypeConst;
@endphp

@php
    function renderTransactionRow($transaction) {
@endphp
<tr class="table-item">
    <td>
        <span class="table-icon-rounded">
            <i class="{{ $transaction->category?->icon_code }}"></i>
        </span>
        {{ $transaction->category?->name }}
    </td>
    <td>
        {{ TypeConst::getTypeName($transaction->category?->type) }}
    </td>
    <td>
        {{ $transaction->date }}
    </td>
    <td>
        {{ Str::limit($transaction->memo, 50) ?? '---' }}
    </td>
    <td>
        {{ $transaction->amount }}
    </td>
    <td>
        <div class="d-flex justify-content-end">
            <button data-edit-transaction="{{ json_encode($transaction) }}"
                    class="btn btn-warning edit-btn d-flex justify-content-center align-items-center me-1">
                <i class="fa-solid fa-pen-to-square"></i>
            </button>
            <button data-delete-transaction="{{ json_encode($transaction) }}" class="btn btn-danger delete-btn d-flex justify-content-center">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    </td>
</tr>
@php
    }
@endphp

@isset($transactions)
    @foreach($transactions as $transaction)
        @php renderTransactionRow($transaction); @endphp
    @endforeach

    <tr>
        <td colspan="5" class="text-center" id="loadMore"></td>
    </tr>
@elseif(isset($transaction))
    @php renderTransactionRow($transaction); @endphp
@endif


