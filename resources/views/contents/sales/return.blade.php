@extends('contents.body')

@section('title', t('sale_return.new_title'))

@php
    $returnTotal = 0;
@endphp

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">{{ t('sale_return.new_title') }}</h4>
                <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-outline-secondary px-2">
                    <i class="mdi mdi-arrow-left me-1"></i> {{ t('common.back') }}
                </a>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-6">
                            <small class="text-muted">{{ t('sale_return.original_invoice') }}</small>
                            <div class="fw-semibold">{{ $sale->invoice_no }}</div>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-muted">{{ t('common.date') }}</small>
                            <div>{{ $sale->sale_date->format('d M Y') }}</div>
                        </div>
                    </div>
                    @if ($sale->customer)
                        <div>
                            <small class="text-muted">{{ t('sale.customer_label') }}</small>
                            <span class="fw-semibold ms-1">{{ $sale->customer->name }}</span>
                        </div>
                    @endif
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('sale-returns.store', $sale) }}" id="returnForm">
                @csrf

                <div class="card mb-3">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ t('nav.products') }}</th>
                                        <th class="text-center">{{ t('sale_return.sold_qty') }}</th>
                                        <th class="text-center">{{ t('sale_return.returnable_qty') }}</th>
                                        <th class="text-center" style="width:120px">{{ t('sale_return.return_qty') }}</th>
                                        <th class="text-end">{{ t('common.total') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $index => $item)
                                        <tr>
                                            <td>
                                                {{ $item->product->name ?? '—' }}
                                                <input type="hidden" name="items[{{ $index }}][sale_item_id]" value="{{ $item->id }}">
                                            </td>
                                            <td class="text-center">
                                                {{ rtrim(rtrim(number_format($item->qty, 2), '0'), '.') }}
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-label-info">
                                                    {{ rtrim(rtrim(number_format($item->returnable_qty, 2), '0'), '.') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if ($item->returnable_qty > 0)
                                                    <input type="number"
                                                        name="items[{{ $index }}][qty]"
                                                        class="form-control form-control-sm text-center return-qty-input"
                                                        value="0"
                                                        min="0"
                                                        max="{{ $item->returnable_qty }}"
                                                        step="0.01"
                                                        data-unit-price="{{ $item->unit_price }}">
                                                @else
                                                    <span class="text-muted">—</span>
                                                    <input type="hidden" name="items[{{ $index }}][qty]" value="0">
                                                @endif
                                            </td>
                                            <td class="text-end line-total" data-index="{{ $index }}">৳ 0.00</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end">{{ t('sale_return.return_total') }}</th>
                                        <th class="text-end" id="grandTotal">৳ 0.00</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="reason" class="form-label">{{ t('sale_return.reason') }} <span class="text-muted">({{ t('common.optional') }})</span></label>
                                <input type="text" id="reason" name="reason" class="form-control"
                                    value="{{ old('reason') }}" placeholder="{{ t('sale_return.reason_ph') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-outline-secondary" id="returnAllBtn">
                        <i class="mdi mdi-select-all me-1"></i> {{ t('sale_return.return_all') }}
                    </button>
                    <button type="submit" class="btn btn-danger" id="submitBtn" disabled>
                        <i class="mdi mdi-check me-1"></i> {{ t('sale_return.confirm_btn') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.return-qty-input');
    const grandTotalEl = document.getElementById('grandTotal');
    const submitBtn = document.getElementById('submitBtn');
    const returnAllBtn = document.getElementById('returnAllBtn');

    function recalculate() {
        let total = 0;
        inputs.forEach(function (input) {
            const qty = parseFloat(input.value) || 0;
            const price = parseFloat(input.dataset.unitPrice) || 0;
            const lineTotal = qty * price;
            const row = input.closest('tr');
            row.querySelector('.line-total').textContent = '৳ ' + lineTotal.toFixed(2);
            total += lineTotal;
        });
        grandTotalEl.textContent = '৳ ' + total.toFixed(2);
        submitBtn.disabled = total <= 0;
    }

    inputs.forEach(function (input) {
        input.addEventListener('input', function () {
            const max = parseFloat(this.max);
            if (parseFloat(this.value) > max) {
                this.value = max;
            }
            if (parseFloat(this.value) < 0) {
                this.value = 0;
            }
            recalculate();
        });
    });

    returnAllBtn.addEventListener('click', function () {
        inputs.forEach(function (input) {
            input.value = input.max;
        });
        recalculate();
    });
});
</script>
@endsection
