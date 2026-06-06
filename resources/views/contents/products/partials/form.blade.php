@php
    $val = fn ($field, $default = '') => old($field, $product->{$field} ?? $default);
@endphp

<div class="row g-3">
    <div class="col-md-8">
        <label for="name" class="form-label">পণ্যের নাম</label>
        <input type="text" id="name" name="name" class="form-control"
            value="{{ $val('name') }}" placeholder="যেমন: মিনিকেট চাল" autofocus required>
    </div>

    <div class="col-md-4">
        <label for="category_id" class="form-label">ক্যাটাগরি</label>
        <select id="category_id" name="category_id" class="form-select">
            <option value="">— নেই —</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ (string) $val('category_id') === (string) $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-8">
        <label for="barcode" class="form-label">বারকোড <span class="text-muted">(ঐচ্ছিক)</span></label>
        <input type="text" id="barcode" name="barcode" class="form-control" value="{{ $val('barcode') }}">
    </div>

    <div class="col-md-4">
        <label for="unit" class="form-label">একক</label>
        <input type="text" id="unit" name="unit" class="form-control"
            value="{{ $val('unit', 'pcs') }}" placeholder="pcs, kg, litre" required>
    </div>

    <div class="col-md-4">
        <label for="purchase_price" class="form-label">ক্রয়মূল্য (৳)</label>
        <input type="number" step="0.01" min="0" id="purchase_price" name="purchase_price"
            class="form-control" value="{{ $val('purchase_price', '0') }}" required>
    </div>

    <div class="col-md-4">
        <label for="sale_price" class="form-label">বিক্রয়মূল্য (৳)</label>
        <input type="number" step="0.01" min="0" id="sale_price" name="sale_price"
            class="form-control" value="{{ $val('sale_price', '0') }}" required>
    </div>

    <div class="col-md-4">
        <label for="stock_qty" class="form-label">বর্তমান স্টক</label>
        <input type="number" step="0.01" min="0" id="stock_qty" name="stock_qty"
            class="form-control" value="{{ $val('stock_qty', '0') }}" required>
    </div>

    <div class="col-md-6">
        <label for="low_stock_alert" class="form-label">কম স্টক সতর্কতা</label>
        <input type="number" step="0.01" min="0" id="low_stock_alert" name="low_stock_alert"
            class="form-control" value="{{ $val('low_stock_alert', '0') }}">
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label">স্ট্যাটাস</label>
        <select id="status" name="status" class="form-select" required>
            @php $current = $val('status', 'active'); @endphp
            <option value="active" {{ $current === 'active' ? 'selected' : '' }}>সক্রিয়</option>
            <option value="inactive" {{ $current === 'inactive' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
        </select>
    </div>
</div>
