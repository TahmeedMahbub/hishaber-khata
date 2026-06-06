@extends('contents.body')

@section('title', 'POS')

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

    <form method="POST" action="{{ route('sales.store') }}" id="posForm">
        @csrf
        <div class="row gy-4">
            {{-- Product picker --}}
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-2">পণ্য নির্বাচন</h5>
                        <input type="text" id="productSearch" class="form-control"
                            placeholder="পণ্যের নাম বা বারকোড লিখুন...">
                    </div>
                    <div class="card-body" style="max-height:60vh;overflow:auto">
                        <div class="row g-2" id="productGrid">
                            @foreach ($products as $p)
                                <div class="col-md-4 col-6 product-cell"
                                    data-name="{{ mb_strtolower($p->name) }}"
                                    data-barcode="{{ $p->barcode }}">
                                    <button type="button" class="btn btn-outline-primary w-100 h-100 text-start p-2 add-product"
                                        data-id="{{ $p->id }}"
                                        data-pname="{{ $p->name }}"
                                        data-price="{{ $p->sale_price }}"
                                        data-stock="{{ $p->stock_qty }}">
                                        <span class="fw-medium d-block text-truncate">{{ $p->name }}</span>
                                        <small class="text-muted">৳ {{ number_format($p->sale_price, 2) }}</small>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        @if ($products->isEmpty())
                            <p class="text-center text-muted py-4 mb-0">কোনো সক্রিয় পণ্য নেই। আগে পণ্য যোগ করুন।</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Cart --}}
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">কার্ট</h5>
                        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-secondary">তালিকা</a>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">কাস্টমার <span class="text-muted">(ঐচ্ছিক)</span></label>
                            <select name="customer_id" class="form-select">
                                <option value="">ওয়াক-ইন কাস্টমার</option>
                                @foreach ($customers as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}{{ $c->phone ? ' — '.$c->phone : '' }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead>
                                    <tr>
                                        <th>পণ্য</th>
                                        <th style="width:70px">পরিমাণ</th>
                                        <th class="text-end">দাম</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="cartBody">
                                    <tr id="cartEmpty"><td colspan="4" class="text-center text-muted py-3">কার্ট খালি</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>সাবটোটাল</span>
                            <span>৳ <span id="subtotalText">0.00</span></span>
                        </div>
                        <div class="row g-2 mb-2 align-items-center">
                            <div class="col-6">ছাড় (৳)</div>
                            <div class="col-6">
                                <input type="number" step="0.01" min="0" name="discount" id="discount"
                                    class="form-control form-control-sm text-end" value="0">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-2 fw-bold">
                            <span>মোট</span>
                            <span>৳ <span id="totalText">0.00</span></span>
                        </div>
                        <div class="row g-2 mb-2 align-items-center">
                            <div class="col-6">পরিশোধ (৳)</div>
                            <div class="col-6">
                                <input type="number" step="0.01" min="0" name="paid" id="paid"
                                    class="form-control form-control-sm text-end" placeholder="পূর্ণ">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>বাকি</span>
                            <span class="text-danger">৳ <span id="dueText">0.00</span></span>
                        </div>

                        <div class="mb-3">
                            <input type="text" name="note" class="form-control form-control-sm" placeholder="নোট (ঐচ্ছিক)">
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="saveBtn" disabled>
                            <i class="mdi mdi-check me-1"></i> বিক্রয় সম্পন্ন করুন
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('page-script')
<script>
(function () {
    var cart = {};
    var cartBody = document.getElementById('cartBody');
    var cartEmpty = document.getElementById('cartEmpty');

    function fmt(n) { return (Math.round(n * 100) / 100).toFixed(2); }

    function render() {
        cartBody.querySelectorAll('tr[data-row]').forEach(function (r) { r.remove(); });
        var ids = Object.keys(cart);
        cartEmpty.style.display = ids.length ? 'none' : '';

        var subtotal = 0;
        ids.forEach(function (id) {
            var it = cart[id];
            var line = it.qty * it.price;
            subtotal += line;

            var tr = document.createElement('tr');
            tr.setAttribute('data-row', id);
            tr.innerHTML =
                '<td>' + it.name +
                  '<input type="hidden" name="items[' + id + '][product_id]" value="' + id + '">' +
                  '<input type="hidden" name="items[' + id + '][unit_price]" value="' + it.price + '"></td>' +
                '<td><input type="number" step="0.01" min="0.01" class="form-control form-control-sm qty-input" ' +
                  'name="items[' + id + '][qty]" value="' + it.qty + '" data-id="' + id + '"></td>' +
                '<td class="text-end">৳ ' + fmt(line) + '</td>' +
                '<td class="text-end"><button type="button" class="btn btn-sm btn-text-danger btn-icon remove-item" data-id="' + id + '"><i class="mdi mdi-close"></i></button></td>';
            cartBody.appendChild(tr);
        });

        var discount = parseFloat(document.getElementById('discount').value) || 0;
        var total = Math.max(0, subtotal - discount);
        var paidEl = document.getElementById('paid');
        var paid = paidEl.value === '' ? total : (parseFloat(paidEl.value) || 0);
        var due = Math.max(0, total - paid);

        document.getElementById('subtotalText').textContent = fmt(subtotal);
        document.getElementById('totalText').textContent = fmt(total);
        document.getElementById('dueText').textContent = fmt(due);
        document.getElementById('saveBtn').disabled = ids.length === 0;
    }

    document.querySelectorAll('.add-product').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = btn.dataset.id;
            if (cart[id]) {
                cart[id].qty += 1;
            } else {
                cart[id] = { name: btn.dataset.pname, price: parseFloat(btn.dataset.price) || 0, qty: 1 };
            }
            render();
        });
    });

    cartBody.addEventListener('input', function (e) {
        if (e.target.classList.contains('qty-input')) {
            var id = e.target.dataset.id;
            var v = parseFloat(e.target.value);
            if (cart[id] && v > 0) { cart[id].qty = v; }
            render();
        }
    });

    cartBody.addEventListener('click', function (e) {
        var btn = e.target.closest('.remove-item');
        if (btn) { delete cart[btn.dataset.id]; render(); }
    });

    document.getElementById('discount').addEventListener('input', render);
    document.getElementById('paid').addEventListener('input', render);

    // Product search filter
    document.getElementById('productSearch').addEventListener('input', function () {
        var q = this.value.toLowerCase();
        document.querySelectorAll('.product-cell').forEach(function (cell) {
            var match = cell.dataset.name.indexOf(q) !== -1 ||
                        (cell.dataset.barcode && cell.dataset.barcode.toLowerCase().indexOf(q) !== -1);
            cell.style.display = match ? '' : 'none';
        });
    });
})();
</script>
@endsection
