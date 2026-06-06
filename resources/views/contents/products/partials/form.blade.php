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
        <div class="input-group">
            <input type="text" id="barcode" name="barcode" class="form-control" value="{{ $val('barcode') }}">
            <button type="button" class="btn btn-outline-primary" id="scanBarcodeBtn"
                data-bs-toggle="modal" data-bs-target="#barcodeScanModal" title="ক্যামেরা দিয়ে স্ক্যান করুন">
                <i class="mdi mdi-barcode-scan"></i>
            </button>
        </div>
    </div>

    <div class="col-md-4">
        <label for="unit" class="form-label">একক</label>
        <input type="text" id="unit" name="unit" class="form-control"
            value="{{ $val('unit', 'pcs') }}" placeholder="pcs, kg, litre" required>
    </div>

    <div class="col-md-6">
        <label for="purchase_price" class="form-label">ক্রয়মূল্য (৳)</label>
        <input type="number" step="0.01" min="0" id="purchase_price" name="purchase_price"
            class="form-control" value="{{ $val('purchase_price', '0') }}" required>
    </div>

    <div class="col-md-6">
        <label for="sale_price" class="form-label">বিক্রয়মূল্য (৳)</label>
        <input type="number" step="0.01" min="0" id="sale_price" name="sale_price"
            class="form-control" value="{{ $val('sale_price', '0') }}" required>
    </div>

    <div class="col-md-6">
        <label for="stock_qty" class="form-label">বর্তমান স্টক</label>
        <input type="number" step="0.01" min="0" id="stock_qty" name="stock_qty"
            class="form-control" value="{{ $val('stock_qty', '0') }}" required>
    </div>

    <div class="col-md-6">
        <label for="low_stock_alert" class="form-label">কম স্টক সতর্কতা</label>
        <input type="number" step="0.01" min="0" id="low_stock_alert" name="low_stock_alert"
            class="form-control" value="{{ $val('low_stock_alert', '0') }}">
    </div>
</div>

{{-- Barcode scanner modal --}}
<div class="modal fade" id="barcodeScanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">বারকোড স্ক্যান করুন</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="barcodeReader" class="w-100"></div>
                <p class="text-muted text-center small mt-2 mb-0">পণ্যের বারকোড ক্যামেরার সামনে ধরুন</p>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
(function () {
    var modalEl = document.getElementById('barcodeScanModal');
    if (!modalEl || typeof Html5Qrcode === 'undefined') return;

    var scanner = null;

    function stopScanner() {
        if (scanner) {
            scanner.stop().then(function () { scanner.clear(); }).catch(function () {});
            scanner = null;
        }
    }

    modalEl.addEventListener('shown.bs.modal', function () {
        scanner = new Html5Qrcode('barcodeReader');
        scanner.start(
            { facingMode: 'environment' },
            { fps: 10, qrbox: { width: 250, height: 150 } },
            function (decodedText) {
                document.getElementById('barcode').value = decodedText;
                stopScanner();
                var modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            },
            function () {}
        ).catch(function (err) {
            document.getElementById('barcodeReader').innerHTML =
                '<div class="alert alert-danger mb-0">ক্যামেরা চালু করা যায়নি। অনুমতি দিন বা ম্যানুয়ালি লিখুন।</div>';
        });
    });

    modalEl.addEventListener('hidden.bs.modal', stopScanner);
})();
</script>
