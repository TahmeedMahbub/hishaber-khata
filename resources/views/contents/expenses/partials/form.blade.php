@php
    $val = fn ($field, $default = '') => old($field, $expense->{$field} ?? $default);
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label for="title" class="form-label">খরচের বিবরণ</label>
        <input type="text" id="title" name="title" class="form-control"
            value="{{ $val('title') }}" placeholder="যেমন: দোকান ভাড়া" autofocus required>
    </div>

    <div class="col-md-3">
        <label for="amount" class="form-label">টাকার পরিমাণ (৳)</label>
        <input type="number" step="0.01" min="0" id="amount" name="amount"
            class="form-control" value="{{ $val('amount', '0') }}" required>
    </div>

    <div class="col-md-3">
        <label for="expense_date" class="form-label">তারিখ</label>
        <input type="date" id="expense_date" name="expense_date" class="form-control"
            value="{{ $val('expense_date', now()->toDateString()) }}">
    </div>

    <div class="col-12">
        <label for="note" class="form-label">নোট <span class="text-muted">(ঐচ্ছিক)</span></label>
        <input type="text" id="note" name="note" class="form-control" value="{{ $val('note') }}">
    </div>
</div>
