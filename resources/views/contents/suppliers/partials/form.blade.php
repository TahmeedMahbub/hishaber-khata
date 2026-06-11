@php
    $val = fn ($field, $default = '') => old($field, $supplier->{$field} ?? $default);
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">{{ t('supplier.name_label') }}</label>
        <input type="text" id="name" name="name" class="form-control"
            value="{{ $val('name') }}" placeholder="{{ t('supplier.name_ph') }}" autofocus required>
    </div>

    <div class="col-md-6">
        <label for="phone" class="form-label">{{ t('supplier.mobile') }} <span class="text-muted">({{ t('common.optional') }})</span></label>
        <input type="text" id="phone" name="phone" class="form-control"
            value="{{ $val('phone') }}" placeholder="017XXXXXXXX">
    </div>

    <div class="col-md-8">
        <label for="address" class="form-label">{{ t('common.address') }} <span class="text-muted">({{ t('common.optional') }})</span></label>
        <input type="text" id="address" name="address" class="form-control" value="{{ $val('address') }}">
    </div>

    <div class="col-md-4">
        <label for="due_balance" class="form-label">{{ t('supplier.prev_due') }}</label>
        <input type="number" step="0.01" id="due_balance" name="due_balance"
            class="form-control" value="{{ number_format((float) $val('due_balance', '0'), 2, '.', '') }}"
            {{ ($supplier ?? null) ? 'readonly' : '' }}>
        @if (($supplier ?? null) && (float) $supplier->due_balance > 0)
            <small class="text-muted">{{ t('supplier.due_locked_note') }} <a href="{{ route('due-payments.create', ['party_type' => 'supplier', 'party_id' => $supplier->id]) }}">{{ t('supplier.pay_due') }}</a> {{ t('supplier.use_page') }}</small>
        @endif
    </div>
</div>
