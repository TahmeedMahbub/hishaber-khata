@php
    $val = fn ($field, $default = '') => old($field, $supplier->{$field} ?? $default);
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">সরবরাহকারীর নাম</label>
        <input type="text" id="name" name="name" class="form-control"
            value="{{ $val('name') }}" placeholder="যেমন: ঢাকা ট্রেডার্স" autofocus required>
    </div>

    <div class="col-md-6">
        <label for="phone" class="form-label">মোবাইল <span class="text-muted">(ঐচ্ছিক)</span></label>
        <input type="text" id="phone" name="phone" class="form-control"
            value="{{ $val('phone') }}" placeholder="017XXXXXXXX">
    </div>

    <div class="col-md-8">
        <label for="address" class="form-label">ঠিকানা <span class="text-muted">(ঐচ্ছিক)</span></label>
        <input type="text" id="address" name="address" class="form-control" value="{{ $val('address') }}">
    </div>

    <div class="col-md-4">
        <label for="due_balance" class="form-label">পূর্ববর্তী বাকি (৳)</label>
        <input type="number" step="0.01" id="due_balance" name="due_balance"
            class="form-control" value="{{ number_format((float) $val('due_balance', '0'), 2, '.', '') }}"
            {{ ($supplier ?? null) ? 'readonly' : '' }}>
        @if ($supplier ?? null)
            <small class="text-muted">বাকি এখান থেকে পরিবর্তন করা যাবে না। <a href="{{ route('due-payments.index') }}">বাকি পরিশোধ</a> পেজ ব্যবহার করুন।</small>
        @endif
    </div>
</div>
