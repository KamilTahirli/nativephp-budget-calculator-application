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


