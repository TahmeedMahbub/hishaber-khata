@php
    $val = fn ($field, $default = '') => old($field, $customer->{$field} ?? $default);
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">কাস্টমারের নাম</label>
        <input type="text" id="name" name="name" class="form-control"
            value="{{ $val('name') }}" placeholder="যেমন: করিম মিয়া" autofocus required>
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
            {{ ($customer ?? null) ? 'disabled' : '' }}>
        @if ($customer ?? null)
            <small class="text-muted">বাকি এখান থেকে পরিবর্তন করা যাবে না। <a href="{{ route('due-payments.create', ['party_type' => 'customer', 'party_id' => $customer->id]) }}">বাকি আদায়</a> পেজ ব্যবহার করুন।</small>
        @endif
    </div>
</div>
