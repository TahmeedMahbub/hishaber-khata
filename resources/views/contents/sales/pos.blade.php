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
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">নতুন বিক্রয় (POS)</h5>
                        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-secondary">তালিকা</a>
                    </div>
                    <div class="card-body">
                        {{-- Product search --}}
                        <div class="mb-3 position-relative">
                            <label class="form-label">পণ্য খুঁজুন</label>
                            <div class="input-group">
                                <input type="text" id="productSearch" class="form-control" autocomplete="off"
                                    placeholder="পণ্যের নাম লিখুন বা বারকোড স্ক্যান করুন...">
                                <button type="button" class="btn btn-outline-secondary" id="scanBtn"
                                    data-bs-toggle="modal" data-bs-target="#barcodeScanModal" title="বারকোড স্ক্যান">
                                    <i class="mdi mdi-barcode-scan"></i>
                                </button>
                            </div>
                            <div id="productResults" class="list-group position-absolute w-100 shadow-sm bg-white"
                                style="z-index:1056;max-height:260px;overflow:auto;display:none"></div>
                        </div>

                        {{-- Cart --}}
                        <div class="table-responsive">
                            <table class="table table-sm align-middle" style="table-layout:fixed">
                                <thead>
                                    <tr>
                                        <th>পণ্য</th>
                                        <th style="width:90px">পরিমাণ</th>
                                        <th class="text-end" style="width:110px">দাম</th>
                                        <th style="width:44px"></th>
                                    </tr>
                                </thead>
                                <tbody id="cartBody">
                                    <tr id="cartEmpty"><td colspan="4" class="text-center text-muted py-3">কার্ট খালি</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        {{-- Customer --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label mb-0">কাস্টমার <span class="text-muted">(ঐচ্ছিক)</span></label>
                                <button type="button" class="btn btn-sm btn-text-primary p-0"
                                    data-bs-toggle="modal" data-bs-target="#newCustomerModal">
                                    <i class="mdi mdi-plus"></i> নতুন কাস্টমার
                                </button>
                            </div>
                            <select name="customer_id" id="customerSelect" class="form-select">
                                <option value="">ওয়াক-ইন কাস্টমার</option>
                                @foreach ($customers as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}{{ $c->phone ? ' — '.$c->phone : '' }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>সাবটোটাল</span>
                            <span>৳ <span id="subtotalText">0.00</span></span>
                        </div>
                        <div class="d-none" id="paidRow">
                            <div class="row g-2 mb-2 align-items-center">
                                <div class="col-6">ছাড় (৳)</div>
                                <div class="col-6">
                                    <input type="number" step="0.01" min="0" name="discount" id="discount"
                                        onfocus="this.select()"
                                        class="form-control form-control-sm text-end" value="0">
                                </div>
                            </div>
                            <div class="row g-2 mb-2 align-items-center">
                                <div class="col-6">পরিশোধ (৳)</div>
                                <div class="col-6">
                                    <input type="number" step="0.01" min="0" name="paid" id="paid"
                                        onfocus="this.select()"
                                        class="form-control form-control-sm text-end" placeholder="পূর্ণ">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>বাকি <span id="prevDueBadge" class="badge bg-label-warning ms-1 d-none"></span></span>
                                <span class="text-danger">৳ <span id="dueText">0.00</span></span>
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between mb-2 fw-bold">
                            <span>মোট</span>
                            <span>৳ <span id="totalText">0.00</span></span>
                        </div>
                        <div class="row g-2 mb-2 align-items-center">
                            <div class="col-6">প্রদানকৃত টাকা (৳)</div>
                            <div class="col-6">
                                <input type="number" step="0.01" min="0" id="tendered"
                                    onfocus="this.select()"
                                    class="form-control form-control-sm text-end" placeholder="০">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>ফেরতযোগ্য টাকা</span>
                            <span class="text-success">৳ <span id="changeText">0.00</span></span>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-sm btn-text-primary p-0" id="togglePaidBtn">
                                <i class="mdi mdi-cash-multiple"></i> ছাড় / বাকি রাখুন
                            </button>
                        </div>

                        <div class="mb-3">
                            <input type="text" name="note" class="form-control form-control-sm" placeholder="নোট (ঐচ্ছিক)">
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="saveBtn" disabled>
                            <i class="mdi mdi-check me-1"></i> বিক্রয় সম্পন্ন করুন
                        </button>
                    </hr>
                </div>
            </div>
        </div>
    </form>

    {{-- New customer modal --}}
    <div class="modal fade" id="newCustomerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">নতুন কাস্টমার</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="customerError" class="alert alert-danger d-none mb-3"></div>
                    <div class="mb-3">
                        <label class="form-label">নাম <span class="text-danger">*</span></label>
                        <input type="text" id="newCustomerName" class="form-control" placeholder="কাস্টমারের নাম">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">ফোন <span class="text-muted">(ঐচ্ছিক)</span></label>
                        <input type="text" id="newCustomerPhone" class="form-control" placeholder="01XXXXXXXXX">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">বাতিল</button>
                    <button type="button" class="btn btn-primary" id="saveCustomerBtn">সংরক্ষণ</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Barcode scan modal --}}
    <div class="modal fade" id="barcodeScanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">বারকোড স্ক্যান</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="scanReader" style="width:100%"></div>
                    <p class="text-muted small text-center mt-2 mb-0">ক্যামেরার সামনে বারকোড ধরুন</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
@php
    $productData = $products->map(fn ($p) => [
        'id'      => $p->id,
        'name'    => $p->name,
        'barcode' => (string) $p->barcode,
        'price'   => (float) $p->sale_price,
        'stock'   => (float) $p->stock_qty,
    ])->values();
    $customerDue = $customers->mapWithKeys(fn ($c) => [$c->id => (float) $c->due_balance])->all();
@endphp
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script>
(function () {
    var PRODUCTS = {!! $productData->toJson() !!};
    var CUSTOMER_DUE = {!! json_encode($customerDue) !!};

    var cart = {};
    var cartBody = document.getElementById('cartBody');
    var cartEmpty = document.getElementById('cartEmpty');
    var searchInput = document.getElementById('productSearch');
    var resultsBox = document.getElementById('productResults');

    function fmt(n) { return (Math.round(n * 100) / 100).toFixed(2); }

    function shortName(name) {
        return name.length > 25 ? name.slice(0, 18) + '......' + name.slice(-10) : name;
    }

    function addToCart(p) {
        var id = p.id;
        if (cart[id]) { cart[id].qty += 1; }
        else { cart[id] = { name: p.name, price: p.price, qty: 1 }; }
        render();
    }

    function render() {
        cartBody.querySelectorAll('tr[data-row]').forEach(function (r) { r.remove(); });
        var ids = Object.keys(cart);
        cartEmpty.style.display = ids.length ? 'none' : '';

        ids.forEach(function (id) {
            var it = cart[id];
            var line = (parseFloat(it.qty) || 0) * it.price;

            var tr = document.createElement('tr');
            tr.setAttribute('data-row', id);
            tr.innerHTML =
                '<td style="word-break:break-word" title="' + it.name + '">' + shortName(it.name) +
                  '<input type="hidden" name="items[' + id + '][product_id]" value="' + id + '">' +
                  '<input type="hidden" name="items[' + id + '][unit_price]" value="' + it.price + '"></td>' +
                '<td><input type="number" step="any" min="0.01" onfocus="this.select()" class="form-control form-control-sm qty-input" ' +
                  'name="items[' + id + '][qty]" value="' + it.qty + '" data-id="' + id + '"></td>' +
                '<td class="text-end line-total">৳ ' + fmt(line) + '</td>' +
                '<td class="text-end"><button type="button" class="btn btn-sm btn-text-danger btn-icon remove-item" data-id="' + id + '"><i class="mdi mdi-close"></i></button></td>';
            cartBody.appendChild(tr);
        });

        recalc();
    }

    function recalc() {
        var subtotal = 0;
        Object.keys(cart).forEach(function (id) {
            subtotal += (parseFloat(cart[id].qty) || 0) * cart[id].price;
        });

        var discount = parseFloat(document.getElementById('discount').value) || 0;
        var total = Math.max(0, subtotal - discount);
        var paidEl = document.getElementById('paid');
        var paid = paidEl.value === '' ? total : (parseFloat(paidEl.value) || 0);
        var due = Math.max(0, total - paid);

        var tendered = parseFloat(document.getElementById('tendered').value) || 0;
        var change = Math.max(0, tendered - paid);

        document.getElementById('subtotalText').textContent = fmt(subtotal);
        document.getElementById('totalText').textContent = fmt(total);
        document.getElementById('changeText').textContent = fmt(change);
        document.getElementById('dueText').textContent = fmt(due);
        document.getElementById('saveBtn').disabled = Object.keys(cart).length === 0;
    }

    function hideResults() { resultsBox.style.display = 'none'; resultsBox.innerHTML = ''; }

    function showResults(matches) {
        if (!matches.length) {
            resultsBox.innerHTML = '<span class="list-group-item text-muted">কোনো পণ্য পাওয়া যায়নি</span>';
            resultsBox.style.display = '';
            return;
        }
        resultsBox.innerHTML = '';
        matches.slice(0, 15).forEach(function (p) {
            var a = document.createElement('button');
            a.type = 'button';
            a.className = 'list-group-item list-group-item-action d-flex justify-content-between';
            a.innerHTML = '<span>' + p.name + (p.barcode ? ' <small class="text-muted">(' + p.barcode + ')</small>' : '') + '</span>' +
                          '<span class="text-muted">৳ ' + fmt(p.price) + '</span>';
            a.addEventListener('click', function () {
                addToCart(p);
                searchInput.value = '';
                hideResults();
                searchInput.focus();
            });
            resultsBox.appendChild(a);
        });
        resultsBox.style.display = '';
    }

    searchInput.addEventListener('input', function () {
        var q = this.value.trim().toLowerCase();
        if (!q) { hideResults(); return; }

        // Exact barcode match -> auto add (barcode scanner behaviour)
        var exact = PRODUCTS.filter(function (p) { return p.barcode && p.barcode.toLowerCase() === q; });
        if (exact.length === 1) {
            addToCart(exact[0]);
            searchInput.value = '';
            hideResults();
            return;
        }

        var matches = PRODUCTS.filter(function (p) {
            return p.name.toLowerCase().indexOf(q) !== -1 ||
                   (p.barcode && p.barcode.toLowerCase().indexOf(q) !== -1);
        });
        showResults(matches);
    });

    // Enter key: add exact barcode or first match
    searchInput.addEventListener('keydown', function (e) {
        if (e.key !== 'Enter') { return; }
        e.preventDefault();
        var q = this.value.trim().toLowerCase();
        if (!q) { return; }
        var exact = PRODUCTS.filter(function (p) { return p.barcode && p.barcode.toLowerCase() === q; });
        var pick = exact.length ? exact[0] : PRODUCTS.filter(function (p) {
            return p.name.toLowerCase().indexOf(q) !== -1 ||
                   (p.barcode && p.barcode.toLowerCase().indexOf(q) !== -1);
        })[0];
        if (pick) { addToCart(pick); searchInput.value = ''; hideResults(); }
    });

    document.addEventListener('click', function (e) {
        if (!resultsBox.contains(e.target) && e.target !== searchInput) { hideResults(); }
    });

    cartBody.addEventListener('input', function (e) {
        if (e.target.classList.contains('qty-input')) {
            var id = e.target.dataset.id;
            if (!cart[id]) { return; }
            // Keep raw string so the field can be cleared while typing
            cart[id].qty = e.target.value;
            var line = (parseFloat(e.target.value) || 0) * cart[id].price;
            var cell = e.target.closest('tr').querySelector('.line-total');
            if (cell) { cell.textContent = '৳ ' + fmt(line); }
            recalc();
        }
    });

    // On blur, restore a valid quantity (default 1)
    cartBody.addEventListener('blur', function (e) {
        if (e.target.classList.contains('qty-input')) {
            var id = e.target.dataset.id;
            if (!cart[id]) { return; }
            var v = parseFloat(e.target.value);
            if (!(v > 0)) {
                cart[id].qty = 1;
                e.target.value = 1;
                render();
            }
        }
    }, true);

    cartBody.addEventListener('click', function (e) {
        var btn = e.target.closest('.remove-item');
        if (btn) { delete cart[btn.dataset.id]; render(); }
    });

    document.getElementById('discount').addEventListener('input', recalc);
    document.getElementById('paid').addEventListener('input', recalc);
    document.getElementById('tendered').addEventListener('input', recalc);

    // Toggle discount / due section
    document.getElementById('togglePaidBtn').addEventListener('click', function () {
        var row = document.getElementById('paidRow');
        row.classList.toggle('d-none');
        if (!row.classList.contains('d-none')) {
            document.getElementById('discount').focus();
        } else {
            document.getElementById('discount').value = '0';
            document.getElementById('paid').value = '';
            recalc();
        }
    });

    // Searchable customer dropdown (defaults to walk-in customer)
    var prevDueBadge = document.getElementById('prevDueBadge');
    function updatePrevDue() {
        var id = document.getElementById('customerSelect').value;
        var due = id ? (CUSTOMER_DUE[id] || 0) : 0;
        if (due > 0) {
            prevDueBadge.textContent = '(পূর্ববর্তী বকেয়াঃ ' + fmt(due) + '৳)';
            prevDueBadge.classList.remove('d-none');
        } else {
            prevDueBadge.classList.add('d-none');
        }
    }

    if (window.jQuery && jQuery.fn.select2) {
        jQuery('#customerSelect').select2({
            width: '100%',
            dropdownParent: jQuery('#customerSelect').parent(),
        }).on('select2:open', function () {
            // Auto-focus the search box so it works on first click
            setTimeout(function () {
                var input = document.querySelector('.select2-container--open .select2-search__field');
                if (input) { input.focus(); }
            }, 0);
        }).on('change', updatePrevDue);
    } else {
        document.getElementById('customerSelect').addEventListener('change', updatePrevDue);
    }

    // New customer (AJAX)
    var saveCustomerBtn = document.getElementById('saveCustomerBtn');
    saveCustomerBtn.addEventListener('click', function () {
        var nameEl = document.getElementById('newCustomerName');
        var phoneEl = document.getElementById('newCustomerPhone');
        var errBox = document.getElementById('customerError');
        errBox.classList.add('d-none');
        saveCustomerBtn.disabled = true;

        fetch('{{ route('customers.quickStore') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
            },
            body: JSON.stringify({ name: nameEl.value, phone: phoneEl.value }),
        })
        .then(function (res) { return res.json().then(function (d) { return { ok: res.ok, d: d }; }); })
        .then(function (r) {
            saveCustomerBtn.disabled = false;
            if (!r.ok) {
                var msg = r.d.message || 'কাস্টমার যোগ করা যায়নি।';
                if (r.d.errors) { msg = Object.values(r.d.errors).flat().join(' '); }
                errBox.textContent = msg;
                errBox.classList.remove('d-none');
                return;
            }
            var sel = document.getElementById('customerSelect');
            var opt = document.createElement('option');
            opt.value = r.d.id;
            opt.textContent = r.d.name + (r.d.phone ? ' — ' + r.d.phone : '');
            sel.appendChild(opt);
            sel.value = r.d.id;
            CUSTOMER_DUE[r.d.id] = 0;
            if (window.jQuery && jQuery.fn.select2) { jQuery(sel).trigger('change'); }
            nameEl.value = '';
            phoneEl.value = '';
            bootstrap.Modal.getInstance(document.getElementById('newCustomerModal')).hide();
        })
        .catch(function () {
            saveCustomerBtn.disabled = false;
            errBox.textContent = 'সার্ভার ত্রুটি। আবার চেষ্টা করুন।';
            errBox.classList.remove('d-none');
        });
    });

    // Barcode scanner -> finds product by barcode and adds (like scan + enter)
    var scanModalEl = document.getElementById('barcodeScanModal');
    var html5Qr = null;

    function stopScanner() {
        if (html5Qr) {
            html5Qr.stop().then(function () { html5Qr.clear(); html5Qr = null; }).catch(function () { html5Qr = null; });
        }
    }

    scanModalEl.addEventListener('shown.bs.modal', function () {
        if (typeof Html5Qrcode === 'undefined') { return; }
        html5Qr = new Html5Qrcode('scanReader');
        html5Qr.start(
            { facingMode: 'environment' },
            { fps: 10, qrbox: { width: 250, height: 150 } },
            function (decodedText) {
                var code = String(decodedText).trim().toLowerCase();
                var match = PRODUCTS.filter(function (p) { return p.barcode && p.barcode.toLowerCase() === code; })[0];
                if (match) {
                    addToCart(match);
                    bootstrap.Modal.getInstance(scanModalEl).hide();
                } else {
                    searchInput.value = decodedText;
                    bootstrap.Modal.getInstance(scanModalEl).hide();
                    searchInput.dispatchEvent(new Event('input'));
                }
            },
            function () {}
        ).catch(function () {
            document.getElementById('scanReader').innerHTML =
                '<p class="text-danger text-center mb-0">ক্যামেরা চালু করা যায়নি। অনুমতি দিন।</p>';
        });
    });

    scanModalEl.addEventListener('hidden.bs.modal', stopScanner);
})();
</script>
@endsection
