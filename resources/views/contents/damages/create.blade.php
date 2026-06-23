@extends('contents.body')

@section('title', t('damage.new_title'))

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">{{ t('damage.new_title') }}</h4>
                <a href="{{ route('damages.index') }}" class="btn btn-sm btn-outline-secondary px-2">
                    <i class="mdi mdi-format-list-bulleted me-1"></i> {{ t('damage.list') }}
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('damages.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="product_id" class="form-label">{{ t('nav.products') }}</label>
                                <div class="d-flex gap-2">
                                    <div class="flex-grow-1">
                                        <select id="product_id" name="product_id" class="form-select" required>
                                            <option value="">{{ t('damage.select_product') }}</option>
                                            @foreach ($products as $p)
                                                <option value="{{ $p->id }}"
                                                    data-unit="{{ $p->unit }}"
                                                    data-barcode="{{ $p->barcode }}"
                                                    {{ (string) old('product_id') === (string) $p->id ? 'selected' : '' }}>
                                                    {{ $p->name }}{{ $p->barcode ? ' (' . $p->barcode . ')' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary flex-shrink-0" id="scanBtn"
                                        data-bs-toggle="modal" data-bs-target="#barcodeScanModal" title="{{ t('product.barcode_scan') }}">
                                        <i class="mdi mdi-barcode-scan"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="type" class="form-label">{{ t('damage.type') }}</label>
                                <select id="type" name="type" class="form-select">
                                    <option value="damage" {{ old('type') === 'damage' ? 'selected' : '' }}>{{ t('damage.damage') }}</option>
                                    <option value="lost" {{ old('type') === 'lost' ? 'selected' : '' }}>{{ t('damage.lost') }}</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="qty" class="form-label">{{ t('common.quantity') }}</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0.01" id="qty" name="qty"
                                        class="form-control" value="{{ old('qty', '1') }}" required>
                                    <span class="input-group-text" id="unitText">{{ t('product.unit') }}</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="damage_date" class="form-label">{{ t('common.date') }}</label>
                                <input type="date" id="damage_date" name="damage_date" class="form-control"
                                    value="{{ old('damage_date', now()->toDateString()) }}">
                            </div>

                            <div class="col-md-8">
                                <label for="reason" class="form-label">{{ t('damage.reason') }} <span class="text-muted">({{ t('common.optional') }})</span></label>
                                <input type="text" id="reason" name="reason" class="form-control"
                                    value="{{ old('reason') }}" placeholder="{{ t('damage.reason_ph') }}">
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3 mb-0 py-2 small">
                            <i class="mdi mdi-information-outline me-1"></i> {{ t('damage.stock_warning') }}
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">{{ t('common.save') }}</button>
                            <a href="{{ route('damages.index') }}" class="btn btn-outline-secondary">{{ t('common.cancel') }}</a>
                        </div>
                    </form>
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
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script src="{{ asset('assets/js/barcode-scanner.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script>
(function () {
    var productSelect = document.getElementById('product_id');
    var unitText = document.getElementById('unitText');

    function updateUnit() {
        var opt = productSelect.options[productSelect.selectedIndex];
        var unit = opt ? (opt.getAttribute('data-unit') || '') : '';
        unitText.textContent = unit || "{{ t('product.unit') }}";
    }

    // select2 searchable product dropdown
    if (window.jQuery && jQuery.fn.select2) {
        jQuery(productSelect).select2({
            width: '100%',
            placeholder: "{{ t('damage.select_product') }}",
            dropdownParent: jQuery(productSelect).parent(),
        }).on('select2:open', function () {
            setTimeout(function () {
                var input = document.querySelector('.select2-container--open .select2-search__field');
                if (input) { input.focus(); }
            }, 0);
        }).on('change', updateUnit);
    } else {
        productSelect.addEventListener('change', updateUnit);
    }

    updateUnit();

    // Select a product by scanned barcode
    function selectByBarcode(code) {
        code = String(code).trim().toLowerCase();
        if (!code) { return false; }
        for (var i = 0; i < productSelect.options.length; i++) {
            var bc = (productSelect.options[i].getAttribute('data-barcode') || '').toLowerCase();
            if (bc && bc === code) {
                productSelect.value = productSelect.options[i].value;
                if (window.jQuery && jQuery.fn.select2) { jQuery(productSelect).trigger('change'); }
                else { updateUnit(); }
                return true;
            }
        }
        return false;
    }

    // Barcode scanner (camera)
    initBarcodeScanner(
        document.getElementById('barcodeScanModal'),
        function (decodedText) {
            selectByBarcode(decodedText);
        },
        "{{ t('product.camera_failed') }}"
    );
})();
</script>
@endsection

