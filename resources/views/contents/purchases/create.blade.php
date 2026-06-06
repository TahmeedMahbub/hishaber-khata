@extends('contents.body')

@section('title', 'New Purchase')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('purchases.store') }}" id="purchaseForm">
        @csrf
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">নতুন ক্রয়</h5>
                        <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-outline-secondary">তালিকা</a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label mb-0">সরবরাহকারী <span class="text-muted">(ঐচ্ছিক)</span></label>
                                </div>
                                <select name="supplier_id" id="supplierSelect" class="form-select">
                                    <option value="">নগদ ক্রয়</option>
                                    @foreach ($suppliers as $s)
                                        <option value="{{ $s->id }}" {{ (string) old('supplier_id') === (string) $s->id ? 'selected' : '' }}>
                                            {{ $s->name }}{{ $s->phone ? ' — '.$s->phone : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">ক্রয়ের তারিখ</label>
                                <input type="date" name="purchase_date" class="form-control"
                                    value="{{ old('purchase_date', now()->toDateString()) }}">
                            </div>
                        </div>

                        {{-- Product picker --}}
                        <div class="mb-3 position-relative">
                            <label class="form-label">পণ্য যোগ করুন</label>
                            <input type="text" id="productSearch" class="form-control" autocomplete="off"
                                placeholder="পণ্যের নাম লিখুন...">
                            <div id="productResults" class="list-group position-absolute w-100 shadow-sm bg-white"
                                style="z-index:1056;max-height:260px;overflow:auto;display:none"></div>
                        </div>

                        {{-- Items --}}
                        <div class="table-responsive">
                            <table class="table table-sm align-middle" style="table-layout:fixed">
                                <thead>
                                    <tr>
                                        <th>পণ্য</th>
                                        <th style="width:90px">পরিমাণ</th>
                                        <th style="width:120px">ক্রয়মূল্য</th>
                                        <th class="text-end" style="width:110px">মোট</th>
                                        <th style="width:44px"></th>
                                    </tr>
                                </thead>
                                <tbody id="itemsBody">
                                    <tr id="itemsEmpty"><td colspan="5" class="text-center text-muted py-3">কোনো পণ্য যোগ করা হয়নি</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <hr class="my-2">
                        <div class="d-flex justify-content-between mb-2 fw-bold">
                            <span>মোট</span>
                            <span>৳ <span id="totalText">0.00</span></span>
                        </div>
                        <div class="row g-2 mb-3 align-items-center">
                            <div class="col-6">পরিশোধ (৳)</div>
                            <div class="col-6">
                                <input type="number" step="0.01" min="0" name="paid" id="paid"
                                    onfocus="this.select()"
                                    class="form-control form-control-sm text-end" placeholder="পূর্ণ">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>বাকি</span>
                            <span class="text-danger">৳ <span id="dueText">0.00</span></span>
                        </div>

                        <div class="mb-3">
                            <input type="text" name="note" class="form-control form-control-sm"
                                value="{{ old('note') }}" placeholder="নোট (ঐচ্ছিক)">
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="saveBtn" disabled>
                            <i class="mdi mdi-content-save me-1"></i> ক্রয় সংরক্ষণ করুন
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('page-script')
@php
    $productsJson = $products->map(fn ($p) => [
        'id'    => $p->id,
        'name'  => $p->name,
        'price' => (float) $p->purchase_price,
        'unit'  => $p->unit,
    ])->values();
@endphp
<script>
(function () {
    var products = @json($productsJson);
    var items = [];

    var searchEl = document.getElementById('productSearch');
    var resultsEl = document.getElementById('productResults');
    var bodyEl = document.getElementById('itemsBody');
    var emptyEl = document.getElementById('itemsEmpty');
    var totalEl = document.getElementById('totalText');
    var dueEl = document.getElementById('dueText');
    var paidEl = document.getElementById('paid');
    var saveBtn = document.getElementById('saveBtn');

    function fmt(n) { return (Math.round(n * 100) / 100).toFixed(2); }

    function recalc() {
        var total = 0;
        items.forEach(function (it) { total += it.qty * it.price; });
        totalEl.textContent = fmt(total);
        var paid = parseFloat(paidEl.value);
        if (isNaN(paid) || paidEl.value === '') paid = total;
        dueEl.textContent = fmt(Math.max(0, total - paid));
        saveBtn.disabled = items.length === 0;
    }

    function render() {
        bodyEl.querySelectorAll('tr.item-row').forEach(function (r) { r.remove(); });
        emptyEl.style.display = items.length ? 'none' : '';
        items.forEach(function (it, i) {
            var tr = document.createElement('tr');
            tr.className = 'item-row';
            tr.innerHTML =
                '<td style="word-break:break-word" title="' + it.name + '">' + it.name +
                    '<input type="hidden" name="items[' + i + '][product_id]" value="' + it.id + '"></td>' +
                '<td><input type="number" step="any" min="0.01" name="items[' + i + '][qty]" value="' + it.qty +
                    '" onfocus="this.select()" class="form-control form-control-sm qty-in"></td>' +
                '<td><input type="number" step="0.01" min="0" name="items[' + i + '][unit_price]" value="' + it.price +
                    '" onfocus="this.select()" class="form-control form-control-sm price-in"></td>' +
                '<td class="text-end line-total">' + fmt(it.qty * it.price) + '</td>' +
                '<td class="text-center"><button type="button" class="btn btn-sm btn-icon btn-text-danger rm-btn"><i class="mdi mdi-close"></i></button></td>';
            bodyEl.appendChild(tr);

            tr.querySelector('.qty-in').addEventListener('input', function () {
                it.qty = parseFloat(this.value) || 0;
                tr.querySelector('.line-total').textContent = fmt(it.qty * it.price);
                recalc();
            });
            tr.querySelector('.price-in').addEventListener('input', function () {
                it.price = parseFloat(this.value) || 0;
                tr.querySelector('.line-total').textContent = fmt(it.qty * it.price);
                recalc();
            });
            tr.querySelector('.rm-btn').addEventListener('click', function () {
                items.splice(i, 1);
                render();
                recalc();
            });
        });
        recalc();
    }

    function addProduct(p) {
        var existing = items.find(function (it) { return it.id === p.id; });
        if (existing) { existing.qty += 1; }
        else { items.push({ id: p.id, name: p.name, price: p.price, qty: 1 }); }
        render();
    }

    searchEl.addEventListener('input', function () {
        var q = this.value.trim().toLowerCase();
        if (!q) { resultsEl.style.display = 'none'; return; }
        var matches = products.filter(function (p) { return p.name.toLowerCase().indexOf(q) !== -1; }).slice(0, 8);
        resultsEl.innerHTML = matches.map(function (p) {
            return '<button type="button" class="list-group-item list-group-item-action d-flex justify-content-between" data-id="' + p.id + '">' +
                '<span>' + p.name + '</span><span class="text-muted">৳ ' + fmt(p.price) + '</span></button>';
        }).join('');
        resultsEl.style.display = matches.length ? '' : 'none';
    });

    resultsEl.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-id]');
        if (!btn) return;
        var p = products.find(function (x) { return x.id === parseInt(btn.dataset.id, 10); });
        if (p) addProduct(p);
        searchEl.value = '';
        resultsEl.style.display = 'none';
        searchEl.focus();
    });

    document.addEventListener('click', function (e) {
        if (!searchEl.contains(e.target) && !resultsEl.contains(e.target)) resultsEl.style.display = 'none';
    });

    paidEl.addEventListener('input', recalc);
})();
</script>
@endsection
