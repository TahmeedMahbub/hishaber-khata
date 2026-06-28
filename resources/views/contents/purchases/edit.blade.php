@extends('contents.body')

@section('title', t('purchase.edit_title') . ' — ' . $purchase->invoice_no)

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

    <form method="POST" action="{{ route('purchases.update', $purchase) }}" id="purchaseForm">
        @csrf
        @method('PUT')
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ t('purchase.edit_title') }} — <span class="text-muted">{{ $purchase->invoice_no }}</span></h5>
                        <a href="{{ route('purchases.show', $purchase) }}" class="btn btn-sm btn-outline-secondary px-2">
                            <i class="mdi mdi-arrow-left me-1"></i> {{ t('common.back') }}
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label mb-0">{{ t('nav.suppliers') }} <span class="text-muted">({{ t('common.optional') }})</span></label>
                                    <button type="button" class="btn btn-sm btn-text-primary p-0"
                                        data-bs-toggle="modal" data-bs-target="#newSupplierModal">
                                        <i class="mdi mdi-plus"></i> {{ t('supplier.new') }}
                                    </button>
                                </div>
                                <select name="supplier_id" id="supplierSelect" class="form-select">
                                    <option value="">{{ t('purchase.cash_purchase') }}</option>
                                    @foreach ($suppliers as $s)
                                        <option value="{{ $s->id }}"
                                            {{ (string) old('supplier_id', $purchase->supplier_id) === (string) $s->id ? 'selected' : '' }}>
                                            {{ $s->name }}{{ $s->phone ? ' — '.$s->phone : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ t('purchase.purchase_date') }}</label>
                                <input type="date" name="purchase_date" class="form-control"
                                    value="{{ old('purchase_date', optional($purchase->purchase_date)->toDateString()) }}">
                            </div>
                        </div>

                        {{-- Product picker --}}
                        <div class="mb-3 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label mb-0">{{ t('purchase.add_product') }}</label>
                                <button type="button" class="btn btn-sm btn-text-primary p-0"
                                    data-bs-toggle="modal" data-bs-target="#newProductModal">
                                    <i class="mdi mdi-plus"></i> {{ t('product.new') }}
                                </button>
                            </div>
                            <div class="input-group">
                                <input type="text" id="productSearch" class="form-control" autocomplete="off"
                                    placeholder="{{ t('purchase.product_search_ph') }}">
                                <button type="button" class="btn btn-outline-secondary" id="scanBtn"
                                    data-bs-toggle="modal" data-bs-target="#barcodeScanModal" title="{{ t('product.barcode_scan') }}">
                                    <i class="mdi mdi-barcode-scan"></i>
                                </button>
                            </div>
                            <div id="productResults" class="list-group position-absolute w-100 shadow-sm bg-white"
                                style="z-index:1056;max-height:260px;overflow:auto;display:none"></div>
                        </div>

                        {{-- Items --}}
                        <div id="itemsBody">
                            <div id="itemsEmpty" class="text-center text-muted py-3 border rounded" style="display:none">{{ t('purchase.no_items') }}</div>
                        </div>

                        <hr class="my-2">
                        <div class="d-flex justify-content-between mb-2 fw-bold">
                            <span>{{ t('common.total') }}</span>
                            <span>৳ <span id="totalText">0.00</span></span>
                        </div>
                        <div class="row g-2 mb-3 align-items-center">
                            <div class="col-6">{{ t('purchase.paid_amount') }}</div>
                            <div class="col-6">
                                <input type="number" step="0.01" min="0" name="paid" id="paid"
                                    onfocus="this.select()"
                                    class="form-control form-control-sm text-end"
                                    value="{{ old('paid', $purchase->paid) }}"
                                    placeholder="{{ t('purchase.full_ph') }}">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>{{ t('purchase.due') }}</span>
                            <span class="text-danger">৳ <span id="dueText">0.00</span></span>
                        </div>

                        <div class="mb-3">
                            <input type="text" name="note" class="form-control form-control-sm"
                                value="{{ old('note', $purchase->note) }}"
                                placeholder="{{ t('purchase.note_ph') }}">
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="saveBtn">
                            <i class="mdi mdi-content-save me-1"></i> {{ t('common.update') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- New product modal --}}
    <div class="modal fade" id="newProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ t('product.new') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="productError" class="alert alert-danger d-none mb-3"></div>
                    <div class="mb-3">
                        <label class="form-label">{{ t('product.name_label') }} <span class="text-danger">*</span></label>
                        <input type="text" id="newProductName" class="form-control" placeholder="{{ t('product.name_ph') }}">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label">{{ t('product.purchase_price_label') }}</label>
                            <input type="number" step="0.01" min="0" id="newProductPurchase" class="form-control" value="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label">{{ t('product.sale_price_label') }}</label>
                            <input type="number" step="0.01" min="0" id="newProductSale" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="row g-2 mb-0">
                        <div class="col-5">
                            <label class="form-label">{{ t('product.unit') }}</label>
                            <input type="text" id="newProductUnit" class="form-control" value="pcs" placeholder="pcs, kg">
                        </div>
                        <div class="col-7">
                            <label class="form-label">{{ t('product.barcode') }} <span class="text-muted">({{ t('common.optional') }})</span></label>
                            <div class="input-group">
                                <input type="text" id="newProductBarcode" class="form-control">
                                <button type="button" class="btn btn-outline-secondary" id="scanNewProductBtn"
                                    data-bs-toggle="modal" data-bs-target="#barcodeScanModal" title="{{ t('product.barcode_scan') }}">
                                    <i class="mdi mdi-barcode-scan"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ t('common.cancel') }}</button>
                    <button type="button" class="btn btn-primary" id="saveProductBtn">{{ t('purchase.save_and_add') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- New supplier modal --}}
    <div class="modal fade" id="newSupplierModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ t('supplier.new') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="supplierError" class="alert alert-danger d-none mb-3"></div>
                    <div class="mb-3">
                        <label class="form-label">{{ t('common.name') }} <span class="text-danger">*</span></label>
                        <input type="text" id="newSupplierName" class="form-control" placeholder="{{ t('supplier.name_label') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ t('supplier.mobile') }} <span class="text-muted">({{ t('common.optional') }})</span></label>
                        <input type="text" id="newSupplierPhone" class="form-control" placeholder="01XXXXXXXXX">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">{{ t('common.address') }} <span class="text-muted">({{ t('common.optional') }})</span></label>
                        <input type="text" id="newSupplierAddress" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ t('common.cancel') }}</button>
                    <button type="button" class="btn btn-primary" id="saveSupplierBtn">{{ t('purchase.save_and_select') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Barcode scan modal --}}
    <div class="modal fade" id="barcodeScanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ t('product.barcode_scan') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="scanReader" style="width:100%"></div>
                    <p class="text-muted small text-center mt-2 mb-0">{{ t('product.hold_barcode') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
@php
    $productsJson = $products->map(fn ($p) => [
        'id'      => $p->id,
        'name'    => $p->name,
        'barcode' => (string) $p->barcode,
        'price'   => (float) $p->purchase_price,
        'unit'    => $p->unit,
    ])->values();

    $existingItems = $purchase->items->map(fn ($it) => [
        'id'    => $it->product_id,
        'name'  => $it->product->name ?? '—',
        'price' => (float) $it->unit_price,
        'qty'   => (float) $it->qty,
        'unit'  => $it->product->unit ?? '',
    ])->values();
@endphp
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script src="{{ asset('assets/js/barcode-scanner.js') }}"></script>
<script>
(function () {
    var products  = @json($productsJson);
    var EXISTING  = @json($existingItems);

    // Pre-populate from existing items (index-based array)
    var items = EXISTING.map(function (it) {
        return { id: it.id, name: it.name, price: it.price, qty: it.qty, unit: it.unit };
    });

    var searchEl  = document.getElementById('productSearch');
    var resultsEl = document.getElementById('productResults');
    var bodyEl    = document.getElementById('itemsBody');
    var emptyEl   = document.getElementById('itemsEmpty');
    var totalEl   = document.getElementById('totalText');
    var dueEl     = document.getElementById('dueText');
    var paidEl    = document.getElementById('paid');
    var saveBtn   = document.getElementById('saveBtn');

    function fmt(n) { return (Math.round(n * 100) / 100).toFixed(2); }

    function recalc() {
        var total = 0;
        items.forEach(function (it) { total += it.qty * it.price; });
        totalEl.textContent = fmt(total);
        var paid = parseFloat(paidEl.value);
        if (isNaN(paid) || paidEl.value === '') paid = total;
        dueEl.textContent  = fmt(Math.max(0, total - paid));
        saveBtn.disabled   = items.length === 0;
    }

    function render() {
        bodyEl.querySelectorAll('.item-row').forEach(function (r) { r.remove(); });
        emptyEl.style.display = items.length ? 'none' : '';
        items.forEach(function (it, i) {
            var row = document.createElement('div');
            row.className = 'item-row border rounded p-2 mb-2';
            row.innerHTML =
                '<div class="d-flex justify-content-between align-items-start mb-2">' +
                    '<span class="fw-medium" style="word-break:break-word">' + it.name + '</span>' +
                    '<button type="button" class="btn btn-sm btn-icon btn-text-danger rm-btn ms-2 flex-shrink-0"><i class="mdi mdi-close"></i></button>' +
                    '<input type="hidden" name="items[' + i + '][product_id]" value="' + it.id + '">' +
                '</div>' +
                '<div class="row g-2 align-items-end">' +
                    '<div class="col-4">' +
                        '<label class="form-label small text-muted mb-1">{{ t('common.quantity') }}' +
                            (it.unit ? ' <span class="text-body">(' + it.unit + ')</span>' : '') + '</label>' +
                        '<input type="number" step="any" min="0.01" name="items[' + i + '][qty]" value="' + it.qty +
                            '" onfocus="this.select()" class="form-control form-control-sm qty-in">' +
                    '</div>' +
                    '<div class="col-4">' +
                        '<label class="form-label small text-muted mb-1">{{ t('product.purchase_price') }}</label>' +
                        '<input type="number" step="0.01" min="0" name="items[' + i + '][unit_price]" value="' + it.price +
                            '" onfocus="this.select()" class="form-control form-control-sm price-in">' +
                    '</div>' +
                    '<div class="col-4 text-end">' +
                        '<label class="form-label small text-muted mb-1 d-block">{{ t('common.total') }}</label>' +
                        '<span class="line-total fw-medium">' + fmt(it.qty * it.price) + '</span>' +
                    '</div>' +
                '</div>';
            bodyEl.appendChild(row);

            row.querySelector('.qty-in').addEventListener('input', function () {
                it.qty = parseFloat(this.value) || 0;
                row.querySelector('.line-total').textContent = fmt(it.qty * it.price);
                recalc();
            });
            row.querySelector('.price-in').addEventListener('input', function () {
                it.price = parseFloat(this.value) || 0;
                row.querySelector('.line-total').textContent = fmt(it.qty * it.price);
                recalc();
            });
            row.querySelector('.rm-btn').addEventListener('click', function () {
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
        else { items.push({ id: p.id, name: p.name, price: p.price, qty: 1, unit: p.unit }); }
        render();
    }

    searchEl.addEventListener('input', function () {
        var q = this.value.trim().toLowerCase();
        if (!q) { resultsEl.style.display = 'none'; return; }
        var exact = products.filter(function (p) { return p.barcode && p.barcode.toLowerCase() === q; });
        if (exact.length === 1) { addProduct(exact[0]); searchEl.value = ''; resultsEl.style.display = 'none'; return; }
        var matches = products.filter(function (p) {
            return p.name.toLowerCase().indexOf(q) !== -1 || (p.barcode && p.barcode.toLowerCase().indexOf(q) !== -1);
        }).slice(0, 8);
        resultsEl.innerHTML = matches.map(function (p) {
            return '<button type="button" class="list-group-item list-group-item-action d-flex justify-content-between" data-id="' + p.id + '">' +
                '<span>' + p.name + (p.barcode ? ' <small class="text-muted">(' + p.barcode + ')</small>' : '') + '</span>' +
                '<span class="text-muted">৳ ' + fmt(p.price) + '</span></button>';
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

    // New product (AJAX)
    var saveProductBtn = document.getElementById('saveProductBtn');
    saveProductBtn.addEventListener('click', function () {
        var nameEl     = document.getElementById('newProductName');
        var purchaseEl = document.getElementById('newProductPurchase');
        var saleEl     = document.getElementById('newProductSale');
        var unitEl     = document.getElementById('newProductUnit');
        var barcodeEl  = document.getElementById('newProductBarcode');
        var errBox     = document.getElementById('productError');
        errBox.classList.add('d-none');
        saveProductBtn.disabled = true;

        fetch('{{ route('products.quickStore') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value },
            body: JSON.stringify({ name: nameEl.value, purchase_price: purchaseEl.value || 0, sale_price: saleEl.value || 0, unit: unitEl.value || 'pcs', barcode: barcodeEl.value || null }),
        })
        .then(function (res) { return res.json().then(function (d) { return { ok: res.ok, d: d }; }); })
        .then(function (r) {
            saveProductBtn.disabled = false;
            if (!r.ok) {
                var msg = r.d.message || "{{ t('purchase.product_add_failed') }}";
                if (r.d.errors) msg = Object.values(r.d.errors).flat().join(' ');
                errBox.textContent = msg; errBox.classList.remove('d-none'); return;
            }
            var p = { id: r.d.id, name: r.d.name, barcode: r.d.barcode, price: r.d.purchase_price, unit: r.d.unit };
            products.push(p); addProduct(p);
            nameEl.value = ''; purchaseEl.value = '0'; saleEl.value = '0'; unitEl.value = 'pcs'; barcodeEl.value = '';
            var pm = bootstrap.Modal.getInstance(document.getElementById('newProductModal'));
            if (pm) pm.hide();
        })
        .catch(function () { saveProductBtn.disabled = false; errBox.textContent = "{{ t('purchase.server_error') }}"; errBox.classList.remove('d-none'); });
    });

    // New supplier (AJAX)
    var saveSupplierBtn = document.getElementById('saveSupplierBtn');
    var supplierSelect  = document.getElementById('supplierSelect');

    if (window.jQuery && jQuery.fn.select2) {
        jQuery(supplierSelect).select2({ width: '100%', dropdownParent: jQuery(supplierSelect).parent() })
            .on('select2:open', function () {
                setTimeout(function () { var input = document.querySelector('.select2-container--open .select2-search__field'); if (input) input.focus(); }, 0);
            });
    }
    saveSupplierBtn.addEventListener('click', function () {
        var nameEl    = document.getElementById('newSupplierName');
        var phoneEl   = document.getElementById('newSupplierPhone');
        var addressEl = document.getElementById('newSupplierAddress');
        var errBox    = document.getElementById('supplierError');
        errBox.classList.add('d-none'); saveSupplierBtn.disabled = true;

        fetch('{{ route('suppliers.quickStore') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value },
            body: JSON.stringify({ name: nameEl.value, phone: phoneEl.value || null, address: addressEl.value || null }),
        })
        .then(function (res) { return res.json().then(function (d) { return { ok: res.ok, d: d }; }); })
        .then(function (r) {
            saveSupplierBtn.disabled = false;
            if (!r.ok) {
                var msg = r.d.message || "{{ t('purchase.supplier_add_failed') }}";
                if (r.d.errors) msg = Object.values(r.d.errors).flat().join(' ');
                errBox.textContent = msg; errBox.classList.remove('d-none'); return;
            }
            var label = r.d.name + (r.d.phone ? ' — ' + r.d.phone : '');
            var opt = new Option(label, r.d.id, true, true);
            supplierSelect.add(opt);
            if (window.jQuery && jQuery.fn.select2) jQuery(supplierSelect).trigger('change');
            nameEl.value = ''; phoneEl.value = ''; addressEl.value = '';
            var sm = bootstrap.Modal.getInstance(document.getElementById('newSupplierModal'));
            if (sm) sm.hide();
        })
        .catch(function () { saveSupplierBtn.disabled = false; errBox.textContent = "{{ t('purchase.server_error') }}"; errBox.classList.remove('d-none'); });
    });

    // Barcode scanner
    var scanModalEl = document.getElementById('barcodeScanModal');
    var scanTarget  = 'search';
    scanModalEl.addEventListener('show.bs.modal', function (event) {
        scanTarget = (event.relatedTarget && event.relatedTarget.id === 'scanNewProductBtn') ? 'newProduct' : 'search';
    });
    initBarcodeScanner(scanModalEl, function (decodedText) {
        if (scanTarget === 'newProduct') { document.getElementById('newProductBarcode').value = decodedText; return; }
        var code  = decodedText.toLowerCase();
        var match = products.filter(function (p) { return p.barcode && p.barcode.toLowerCase() === code; })[0];
        if (match) { addProduct(match); } else { searchEl.value = decodedText; searchEl.dispatchEvent(new Event('input')); }
    }, "{{ t('product.camera_failed') }}");

    // Initial render
    render();
})();
</script>
@endsection
