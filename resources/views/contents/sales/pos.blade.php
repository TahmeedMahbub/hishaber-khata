@extends('contents.body')

@section('title', t('sale.new_pos'))

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
                        <h5 class="mb-0">{{ t('sale.new_pos') }}</h5>
                        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-secondary px-2"><i class="mdi mdi-format-list-bulleted me-1"></i> {{ t('sale.list') }}</a>
                    </div>
                    <div class="card-body">
                        {{-- Product search --}}
                        <div class="mb-3 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label mb-0">{{ t('sale.search_product') }}</label>
                                <button type="button" class="btn btn-sm btn-outline-danger d-none py-1 px-1" id="clearCartBtn">
                                    <i class="mdi mdi-delete-sweep me-1"></i> {{ t('sale.clear_cart') ?? 'Clear Cart' }}
                                </button>
                            </div>
                            <div class="input-group">
                                <input type="text" id="productSearch" class="form-control" autocomplete="off"
                                    placeholder="{{ t('sale.search_product_ph') }}">
                                <button type="button" class="btn btn-outline-secondary" id="scanBtn"
                                    data-bs-toggle="modal" data-bs-target="#barcodeScanModal" title="{{ t('product.barcode_scan') }}">
                                    <i class="mdi mdi-barcode-scan"></i>
                                </button>
                            </div>
                            <div id="productResults" class="list-group position-absolute w-100 shadow-sm bg-white"
                                style="z-index:1056;max-height:260px;overflow:auto;display:none"></div>
                        </div>

                        {{-- Cart --}}
                        <div id="cartBody">
                            <div id="cartEmpty" class="text-center text-muted py-3 border rounded">{{ t('sale.cart_empty') }}</div>
                        </div>

                        <hr>

                        {{-- Customer --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label mb-0">{{ t('nav.customers') }} <span class="text-muted">({{ t('common.optional') }})</span></label>
                                <button type="button" class="btn btn-sm btn-text-primary p-0"
                                    data-bs-toggle="modal" data-bs-target="#newCustomerModal">
                                    <i class="mdi mdi-plus"></i> {{ t('customer.new') }}
                                </button>
                            </div>
                            <select name="customer_id" id="customerSelect" class="form-select">
                                <option value="">{{ t('sale.walkin') }}</option>
                                @foreach ($customers as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}{{ $c->phone ? ' — '.$c->phone : '' }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Salesperson / employee; commented to controller too --}}
                        {{-- @if ($employees->count() > 1 && auth()->user()->isOwner())
                            <div class="mb-3">
                                <label class="form-label">{{ t('sale.salesperson') }}</label>
                                <select name="user_id" class="form-select">
                                    @foreach ($employees as $emp)
                                        <option value="{{ $emp->id }}" {{ (string) old('user_id', auth()->id()) === (string) $emp->id ? 'selected' : '' }}>
                                            {{ $emp->name }}{{ $emp->id === auth()->id() ? ' ('.t('sale.you').')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif --}}

                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ t('sale.subtotal') }}</span>
                            <span>৳ <span id="subtotalText">0.00</span></span>
                        </div>
                        <div class="d-none" id="paidRow">
                            <div class="row g-2 mb-2 align-items-center">
                                <div class="col-6">{{ t('sale.discount_amount') }}</div>
                                <div class="col-6">
                                    <input type="number" step="0.01" min="0" name="discount" id="discount"
                                        onfocus="this.select()"
                                        class="form-control form-control-sm text-end" value="0">
                                </div>
                            </div>
                            <div class="row g-2 mb-2 align-items-center">
                                <div class="col-6">{{ t('sale.paid_amount') }}</div>
                                <div class="col-6">
                                    <input type="number" step="0.01" min="0" name="paid" id="paid"
                                        onfocus="this.select()"
                                        class="form-control form-control-sm text-end" placeholder="{{ t('sale.full_ph') }}">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ t('sale.due') }} <span id="prevDueBadge" class="badge bg-label-warning ms-1 d-none"></span></span>
                                <span class="text-danger">৳ <span id="dueText">0.00</span></span>
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between mb-2 fw-bold">
                            <span>{{ t('common.total') }}</span>
                            <span>৳ <span id="totalText">0.00</span></span>
                        </div>
                        <div class="row g-2 mb-2 align-items-center">
                            <div class="col-6">{{ t('sale.tendered') }}</div>
                            <div class="col-6">
                                <input type="number" step="0.01" min="0" id="tendered"
                                    onfocus="this.select()"
                                    class="form-control form-control-sm text-end" placeholder="০">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ t('sale.change_due') }}</span>
                            <span class="text-success">৳ <span id="changeText">0.00</span></span>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-sm btn-text-primary p-0" id="togglePaidBtn">
                                <i class="mdi mdi-cash-multiple"></i> {{ t('sale.toggle_discount_due') }}
                            </button>
                        </div>

                        <div class="mb-3">
                            <input type="text" name="note" class="form-control form-control-sm" placeholder="{{ t('sale.note_ph') }}">
                        </div>

                        <input type="hidden" name="_add_another" id="_add_another" value="0">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1 px-2" id="saveBtn" disabled>
                                <i class="mdi mdi-check me-1"></i> {{ t('sale.complete') }}
                            </button>
                            <button type="submit" class="btn btn-outline-primary flex-shrink-0 px-2" id="saveNewBtn" disabled
                                onclick="document.getElementById('_add_another').value='1'">
                                <i class="mdi mdi-plus me-1"></i> {{ t('common.save_and_add_another') ?? 'Save & New' }}
                            </button>
                        </div>
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
                    <h5 class="modal-title">{{ t('customer.new') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="customerError" class="alert alert-danger d-none mb-3"></div>
                    <div class="mb-3">
                        <label class="form-label">{{ t('common.name') }} <span class="text-danger">*</span></label>
                        <input type="text" id="newCustomerName" class="form-control" placeholder="{{ t('customer.name_label') }}">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">{{ t('common.phone') }} <span class="text-muted">({{ t('common.optional') }})</span></label>
                        <input type="text" id="newCustomerPhone" class="form-control" placeholder="01XXXXXXXXX">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ t('common.cancel') }}</button>
                    <button type="button" class="btn btn-primary" id="saveCustomerBtn">{{ t('sale.save') }}</button>
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
    $productData = $products->map(fn ($p) => [
        'id'      => $p->id,
        'name'    => $p->name,
        'barcode' => (string) $p->barcode,
        'price'   => (float) $p->sale_price,
        'stock'   => (float) $p->stock_qty,
        'unit'    => $p->unit,
    ])->values();
    $customerDue = $customers->mapWithKeys(fn ($c) => [$c->id => (float) $c->due_balance])->all();
@endphp
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script src="{{ asset('assets/js/barcode-scanner.js') }}"></script>
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
    var clearCartBtn = document.getElementById('clearCartBtn');

    function saveCart() {
        localStorage.setItem('pos_cart', JSON.stringify(cart));
    }

    function loadCart() {
        try {
            var saved = localStorage.getItem('pos_cart');
            if (saved) {
                var parsed = JSON.parse(saved);
                // Validate that saved products still exist
                var productIds = PRODUCTS.map(function (p) { return String(p.id); });
                Object.keys(parsed).forEach(function (id) {
                    if (productIds.indexOf(id) !== -1 && parsed[id].qty > 0) {
                        cart[id] = parsed[id];
                    }
                });
            }
        } catch (e) {}
    }

    function fmt(n) { return (Math.round(n * 100) / 100).toFixed(2); }

    function addToCart(p) {
        var id = p.id;
        if (cart[id]) { cart[id].qty += 1; }
        else { cart[id] = { name: p.name, price: p.price, qty: 1, unit: p.unit }; }
        render();
    }

    function render() {
        cartBody.querySelectorAll('.item-row').forEach(function (r) { r.remove(); });
        var ids = Object.keys(cart);
        cartEmpty.style.display = ids.length ? 'none' : '';
        clearCartBtn.classList.toggle('d-none', !ids.length);
        saveCart();

        ids.forEach(function (id) {
            var it = cart[id];
            var line = (parseFloat(it.qty) || 0) * it.price;

            var row = document.createElement('div');
            row.className = 'item-row border rounded p-2 mb-2';
            row.setAttribute('data-row', id);
            row.innerHTML =
                '<div class="d-flex justify-content-between align-items-start mb-2">' +
                    '<span class="fw-medium" style="word-break:break-word" title="' + it.name + '">' + it.name + '</span>' +
                    '<button type="button" class="btn btn-sm btn-icon btn-text-danger remove-item ms-2 flex-shrink-0" data-id="' + id + '"><i class="mdi mdi-close"></i></button>' +
                    '<input type="hidden" name="items[' + id + '][product_id]" value="' + id + '">' +
                    '<input type="hidden" name="items[' + id + '][unit_price]" value="' + it.price + '">' +
                '</div>' +
                '<div class="row g-2 align-items-end">' +
                    '<div class="col-4">' +
                        '<label class="form-label small text-muted mb-1">{{ t('common.quantity') }}' +
                            (it.unit ? ' <span class="text-body">(' + it.unit + ')</span>' : '') + '</label>' +
                        '<input type="number" step="any" min="0.01" onfocus="this.select()" class="form-control form-control-sm qty-input" ' +
                            'name="items[' + id + '][qty]" value="' + it.qty + '" data-id="' + id + '">' +
                    '</div>' +
                    '<div class="col-4">' +
                        '<label class="form-label small text-muted mb-1">{{ t('sale.unit_price') }}</label>' +
                        '<div class="form-control form-control-sm bg-light text-end">৳ ' + fmt(it.price) + '</div>' +
                    '</div>' +
                    '<div class="col-4 text-end">' +
                        '<label class="form-label small text-muted mb-1 d-block">{{ t('common.total') }}</label>' +
                        '<span class="line-total fw-medium">৳ ' + fmt(line) + '</span>' +
                    '</div>' +
                '</div>';
            cartBody.appendChild(row);
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
        document.getElementById('saveNewBtn').disabled = Object.keys(cart).length === 0;
    }

    function hideResults() { resultsBox.style.display = 'none'; resultsBox.innerHTML = ''; activeIndex = -1; }

    // Currently highlighted result for keyboard navigation
    var activeIndex = -1;

    function resultItems() {
        return resultsBox.querySelectorAll('.list-group-item-action');
    }

    function setActive(idx) {
        var items = resultItems();
        if (!items.length) { return; }
        if (idx < 0) { idx = items.length - 1; }
        if (idx >= items.length) { idx = 0; }
        items.forEach(function (el) { el.classList.remove('active'); });
        items[idx].classList.add('active');
        items[idx].scrollIntoView({ block: 'nearest' });
        activeIndex = idx;
    }

    function showResults(matches) {
        if (!matches.length) {
            resultsBox.innerHTML = '<span class="list-group-item text-muted">{{ t('sale.no_product_found') }}</span>';
            resultsBox.style.display = '';
            activeIndex = -1;
            return;
        }
        resultsBox.innerHTML = '';
        matches.slice(0, 15).forEach(function (p) {
            var a = document.createElement('button');
            a.type = 'button';
            a.className = 'list-group-item list-group-item-action d-flex justify-content-between';
            a.innerHTML = '<span>' + p.name + (p.barcode ? ' <small class="text-muted">(' + p.barcode + ')</small>' : '') + '</span>' +
                          '<span class="text-muted">৳ ' + fmt(p.price) + '</span>';
            a.addEventListener('mouseenter', function () {
                var items = Array.prototype.slice.call(resultItems());
                setActive(items.indexOf(a));
            });
            a.addEventListener('click', function () {
                addToCart(p);
                searchInput.value = '';
                hideResults();
                searchInput.focus();
            });
            resultsBox.appendChild(a);
        });
        resultsBox.style.display = '';
        activeIndex = -1;
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

    // Keyboard: arrows to navigate results, Enter to select
    searchInput.addEventListener('keydown', function (e) {
        var open = resultsBox.style.display !== 'none' && resultItems().length;

        if (e.key === 'ArrowDown') {
            if (open) { e.preventDefault(); setActive(activeIndex + 1); }
            return;
        }
        if (e.key === 'ArrowUp') {
            if (open) { e.preventDefault(); setActive(activeIndex - 1); }
            return;
        }
        if (e.key === 'Escape') {
            hideResults();
            return;
        }
        if (e.key !== 'Enter') { return; }
        e.preventDefault();

        // If an item is highlighted, pick it directly.
        if (open && activeIndex > -1) {
            resultItems()[activeIndex].click();
            return;
        }

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
            var cell = e.target.closest('.item-row').querySelector('.line-total');
            if (cell) { cell.textContent = '৳ ' + fmt(line); }
            saveCart();
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
            prevDueBadge.textContent = '(' + "{{ t('sale.prev_due_label') }}" + ' ' + fmt(due) + '৳)';
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
                var msg = r.d.message || "{{ t('sale.customer_add_failed') }}";
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
            errBox.textContent = "{{ t('sale.server_error') }}";
            errBox.classList.remove('d-none');
        });
    });

    // Clear cart button
    clearCartBtn.addEventListener('click', function () {
        cart = {};
        render();
    });

    // Clear localStorage on form submit (successful sale)
    document.getElementById('posForm').addEventListener('submit', function () {
        localStorage.removeItem('pos_cart');
    });

    // Load cart from localStorage on page load
    loadCart();
    if (Object.keys(cart).length) { render(); }

    // Barcode scanner -> finds product by barcode and adds (like scan + enter)
    initBarcodeScanner(
        document.getElementById('barcodeScanModal'),
        function (decodedText) {
            var code = decodedText.toLowerCase();
            var match = PRODUCTS.filter(function (p) { return p.barcode && p.barcode.toLowerCase() === code; })[0];
            if (match) {
                addToCart(match);
            } else {
                searchInput.value = decodedText;
                searchInput.dispatchEvent(new Event('input'));
            }
        },
        "{{ t('product.camera_failed') }}"
    );
})();
</script>
@endsection
