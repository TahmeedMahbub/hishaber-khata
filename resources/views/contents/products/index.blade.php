@extends('contents.body')

@section('title', t('product.title'))

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">{{ t('product.title') }}</h4>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-success text-dark" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="mdi mdi-file-excel me-1"></i> {{ t('product.excel_import') }}
                    </button>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus me-1"></i> {{ t('product.new') }}
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('import_errors'))
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <strong>{{ t('product.some_rows_skipped') }}</strong>
                    <ul class="mb-0 mt-1">
                        @foreach (session('import_errors') as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <form method="GET" action="{{ route('products.index') }}" class="row g-2" id="productSearchForm">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="search" id="productSearchInput" value="{{ $search ?? '' }}"
                                    class="form-control" placeholder="{{ t('product.search_ph') }}">
                                <button type="button" class="btn btn-outline-secondary" id="scanBtn"
                                    data-bs-toggle="modal" data-bs-target="#barcodeScanModal" title="{{ t('product.barcode_scan') }}">
                                    <i class="mdi mdi-barcode-scan"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="category_id" class="form-select">
                                <option value="">{{ t('product.all_categories') }}</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (string) $categoryId === (string) $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 d-grid">
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="mdi mdi-magnify"></i> {{ t('common.search') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ t('common.name') }}</th>
                                <th>{{ t('product.category') }}</th>
                                <th class="text-end">{{ t('product.purchase_price') }}</th>
                                <th class="text-end">{{ t('product.sale_price') }}</th>
                                <th class="text-end">{{ t('product.stock') }}</th>
                                <th>{{ t('common.status') }}</th>
                                <th class="text-end">{{ t('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td class="fw-medium">
                                        {{ $product->name }}
                                        @if ($product->barcode)
                                            <small class="text-muted d-block">{{ $product->barcode }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $product->category->name ?? '—' }}</td>
                                    <td class="text-end">৳ {{ number_format($product->purchase_price, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($product->sale_price, 2) }}</td>
                                    <td class="text-end">
                                        {{ rtrim(rtrim(number_format($product->stock_qty, 2), '0'), '.') }} {{ $product->unit }}
                                        @if ($product->isLowStock())
                                            <span class="badge bg-label-warning ms-1">{{ t('product.low') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->status === 'active')
                                            <span class="badge bg-label-success">{{ t('common.active') }}</span>
                                        @else
                                            <span class="badge bg-label-secondary">{{ t('common.inactive') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('products.edit', $product) }}"
                                            class="btn btn-sm btn-icon btn-text-secondary">
                                            <i class="mdi mdi-pencil-outline"></i>
                                        </a>
                                        <form method="POST" action="{{ route('products.destroy', $product) }}"
                                            class="d-inline" data-confirm="{{ t('common.are_you_sure') }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-icon btn-text-danger">
                                                <i class="mdi mdi-delete-outline"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">{{ t('product.empty') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($products->hasPages())
                    <div class="card-footer">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Excel import modal --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('products.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">{{ t('product.import_title') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ol class="ps-3 mb-3 small text-muted">
                            <li>{{ t('product.import_step1') }}</li>
                            <li>{{ t('product.import_step2_pre') }} <strong>{{ t('product.import_step2_strong') }}</strong> {{ t('product.import_step2_post') }}</li>
                            <li>{{ t('product.import_step3') }}</li>
                        </ol>

                        <a href="{{ route('products.import.template') }}" class="btn btn-sm btn-outline-secondary mb-3">
                            <i class="mdi mdi-download me-1"></i> {{ t('product.template_download') }}
                        </a>

                        <div class="mb-2">
                            <label for="importFile" class="form-label">{{ t('product.excel_csv_file') }}</label>
                            <input type="file" name="file" id="importFile" class="form-control"
                                accept=".xlsx,.xls,.csv" required>
                            @error('file')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <p class="small text-muted mb-0">
                            {{ t('product.header_order') }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ t('common.cancel') }}</button>
                        <button type="submit" class="btn btn-success">
                            <i class="mdi mdi-upload me-1"></i> {{ t('product.import_btn') }}
                        </button>
                    </div>
                </form>
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
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
(function () {
    var scanModalEl = document.getElementById('barcodeScanModal');
    if (!scanModalEl) { return; }

    var searchInput = document.getElementById('productSearchInput');
    var searchForm = document.getElementById('productSearchForm');
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
                // Fill the search box with the scanned barcode and submit.
                searchInput.value = String(decodedText).trim();
                bootstrap.Modal.getInstance(scanModalEl).hide();
                searchForm.submit();
            },
            function () {}
        ).catch(function () {
            document.getElementById('scanReader').innerHTML =
                '<p class="text-danger text-center mb-0">{{ t('product.camera_failed') }}</p>';
        });
    });

    scanModalEl.addEventListener('hidden.bs.modal', stopScanner);
})();
</script>
@endsection
