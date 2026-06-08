@extends('contents.body')

@section('title', 'New Damage/Lost')

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <h4 class="fw-bold mb-3">ড্যামেজ / হারানো পণ্য</h4>

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
                                <label for="product_id" class="form-label">পণ্য</label>
                                <div class="d-flex gap-2">
                                    <div class="flex-grow-1">
                                        <select id="product_id" name="product_id" class="form-select" required>
                                            <option value="">— পণ্য নির্বাচন করুন —</option>
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
                                        data-bs-toggle="modal" data-bs-target="#barcodeScanModal" title="বারকোড স্ক্যান">
                                        <i class="mdi mdi-barcode-scan"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="type" class="form-label">ধরন</label>
                                <select id="type" name="type" class="form-select">
                                    <option value="damage" {{ old('type') === 'damage' ? 'selected' : '' }}>ড্যামেজ</option>
                                    <option value="lost" {{ old('type') === 'lost' ? 'selected' : '' }}>হারানো</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="qty" class="form-label">পরিমাণ</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0.01" id="qty" name="qty"
                                        class="form-control" value="{{ old('qty', '1') }}" required>
                                    <span class="input-group-text" id="unitText">একক</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="damage_date" class="form-label">তারিখ</label>
                                <input type="date" id="damage_date" name="damage_date" class="form-control"
                                    value="{{ old('damage_date', now()->toDateString()) }}">
                            </div>

                            <div class="col-md-8">
                                <label for="reason" class="form-label">কারণ <span class="text-muted">(ঐচ্ছিক)</span></label>
                                <input type="text" id="reason" name="reason" class="form-control"
                                    value="{{ old('reason') }}" placeholder="যেমন: মেয়াদ শেষ, ভেঙে গেছে">
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3 mb-0 py-2 small">
                            <i class="mdi mdi-information-outline me-1"></i> এই পরিমাণ স্টক থেকে কমে যাবে।
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                            <a href="{{ route('damages.index') }}" class="btn btn-outline-secondary">বাতিল</a>
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
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script>
(function () {
    var productSelect = document.getElementById('product_id');
    var unitText = document.getElementById('unitText');

    function updateUnit() {
        var opt = productSelect.options[productSelect.selectedIndex];
        var unit = opt ? (opt.getAttribute('data-unit') || '') : '';
        unitText.textContent = unit || 'একক';
    }

    // select2 searchable product dropdown
    if (window.jQuery && jQuery.fn.select2) {
        jQuery(productSelect).select2({
            width: '100%',
            placeholder: '— পণ্য নির্বাচন করুন —',
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
                selectByBarcode(decodedText);
                bootstrap.Modal.getInstance(scanModalEl).hide();
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

