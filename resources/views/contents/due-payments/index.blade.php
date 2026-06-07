@extends('contents.body')

@section('title', 'Due Payments')

@section('content')
    @php
        $methodLabels = [
            'cash'   => 'নগদ',
            'bkash'  => 'বিকাশ',
            'nagad'  => 'নগদ (Nagad)',
            'rocket' => 'রকেট',
            'bank'   => 'ব্যাংক',
            'other'  => 'অন্যান্য',
        ];
        $oldType = old('party_type', 'customer');
    @endphp

    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">বাকি আদায় / পরিশোধ</h4>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

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

            <div class="row g-4">
                {{-- Payment form --}}
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">নতুন লেনদেন</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('due-payments.store') }}" id="duePaymentForm">
                                @csrf

                                {{-- Customer / Supplier toggle --}}
                                <div class="mb-3">
                                    <label class="form-label d-block">ধরন</label>
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="party_type" id="typeCustomer"
                                            value="customer" {{ $oldType === 'customer' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-primary" for="typeCustomer">
                                            <i class="mdi mdi-account-arrow-down"></i> কাস্টমার বাকি আদায়
                                        </label>

                                        <input type="radio" class="btn-check" name="party_type" id="typeSupplier"
                                            value="supplier" {{ $oldType === 'supplier' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-primary" for="typeSupplier">
                                            <i class="mdi mdi-account-arrow-up"></i> সরবরাহকারী পরিশোধ
                                        </label>
                                    </div>
                                </div>

                                {{-- Party (select2) --}}
                                <div class="mb-3">
                                    <label for="partySelect" class="form-label" id="partyLabel">কাস্টমার</label>
                                    <select name="party_id" id="partySelect" class="form-select" required>
                                        <option value="">— নির্বাচন করুন —</option>
                                    </select>
                                    <small class="text-muted" id="dueHint"></small>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="amount" class="form-label">পরিমাণ (৳)</label>
                                        <input type="number" step="0.01" min="0.01" name="amount" id="amount"
                                            onfocus="this.select()" class="form-control"
                                            value="{{ old('amount') }}" placeholder="0.00" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="payment_date" class="form-label">তারিখ</label>
                                        <input type="date" name="payment_date" id="payment_date" class="form-control"
                                            value="{{ old('payment_date', now()->toDateString()) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="method" class="form-label">পেমেন্ট মাধ্যম</label>
                                        <select name="method" id="method" class="form-select">
                                            @foreach ($methodLabels as $key => $label)
                                                <option value="{{ $key }}" {{ old('method') === $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="note" class="form-label">নোট <span class="text-muted">(ঐচ্ছিক)</span></label>
                                        <input type="text" name="note" id="note" class="form-control"
                                            value="{{ old('note') }}" placeholder="যেমন: চেক নং">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mt-3" id="saveBtn">
                                    <i class="mdi mdi-content-save me-1"></i> সংরক্ষণ করুন
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Recent payments --}}
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">সাম্প্রতিক লেনদেন</h5>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('due-payments.index') }}"
                                    class="btn {{ !$type ? 'btn-primary' : 'btn-outline-primary' }}">সব</a>
                                <a href="{{ route('due-payments.index', ['type' => 'customer']) }}"
                                    class="btn {{ $type === 'customer' ? 'btn-primary' : 'btn-outline-primary' }}">কাস্টমার</a>
                                <a href="{{ route('due-payments.index', ['type' => 'supplier']) }}"
                                    class="btn {{ $type === 'supplier' ? 'btn-primary' : 'btn-outline-primary' }}">সরবরাহকারী</a>
                            </div>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>তারিখ</th>
                                        <th>নাম</th>
                                        <th>ধরন</th>
                                        <th>মাধ্যম</th>
                                        <th class="text-end">পরিমাণ</th>
                                        <th class="text-end"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->payment_date?->format('d/m/Y') }}</td>
                                            <td class="fw-medium">
                                                @if ($payment->party_type === 'customer')
                                                    {{ $customerNames[$payment->party_id] ?? '—' }}
                                                @else
                                                    {{ $supplierNames[$payment->party_id] ?? '—' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($payment->party_type === 'customer')
                                                    <span class="badge bg-label-success">আদায়</span>
                                                @else
                                                    <span class="badge bg-label-warning">পরিশোধ</span>
                                                @endif
                                            </td>
                                            <td>{{ $methodLabels[$payment->method] ?? $payment->method }}</td>
                                            <td class="text-end fw-medium">৳ {{ number_format((float) $payment->amount, 2) }}</td>
                                            <td class="text-end">
                                                <form method="POST" action="{{ route('due-payments.destroy', $payment) }}"
                                                    class="d-inline"
                                                    data-confirm="এই লেনদেন মুছলে বাকি পুনরায় যোগ হবে। নিশ্চিত?">
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
                                            <td colspan="6" class="text-center text-muted py-4">কোনো লেনদেন নেই।</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if ($payments->hasPages())
                            <div class="card-footer">
                                {{ $payments->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script>
(function () {
    var CUSTOMERS = @json($customers);
    var SUPPLIERS = @json($suppliers);
    var OLD_PARTY_ID = @json(old('party_id'));

    var partySelect = document.getElementById('partySelect');
    var partyLabel = document.getElementById('partyLabel');
    var dueHint = document.getElementById('dueHint');

    function fmt(n) { return (Math.round(n * 100) / 100).toFixed(2); }

    function currentType() {
        var checked = document.querySelector('input[name="party_type"]:checked');
        return checked ? checked.value : 'customer';
    }

    function fillOptions(preserveId) {
        var type = currentType();
        var list = type === 'supplier' ? SUPPLIERS : CUSTOMERS;
        partyLabel.textContent = type === 'supplier' ? 'সরবরাহকারী' : 'কাস্টমার';

        partySelect.innerHTML = '<option value="">— নির্বাচন করুন —</option>';
        list.forEach(function (p) {
            var due = parseFloat(p.due_balance) || 0;
            var label = p.name + (p.phone ? ' — ' + p.phone : '') +
                        (due > 0 ? '  (বাকিঃ ৳' + fmt(due) + ')' : '');
            var opt = new Option(label, p.id, false, false);
            opt.setAttribute('data-due', due);
            partySelect.appendChild(opt);
        });

        if (preserveId) { partySelect.value = preserveId; }
        if (window.jQuery && jQuery.fn.select2) { jQuery(partySelect).trigger('change'); }
        updateDueHint();
    }

    function updateDueHint() {
        var opt = partySelect.options[partySelect.selectedIndex];
        var due = opt ? parseFloat(opt.getAttribute('data-due')) || 0 : 0;
        if (partySelect.value && due > 0) {
            dueHint.textContent = 'বর্তমান বাকিঃ ৳ ' + fmt(due);
            dueHint.className = 'text-danger';
        } else if (partySelect.value) {
            dueHint.textContent = 'কোনো বাকি নেই।';
            dueHint.className = 'text-muted';
        } else {
            dueHint.textContent = '';
        }
    }

    if (window.jQuery && jQuery.fn.select2) {
        jQuery(partySelect).select2({
            width: '100%',
            dropdownParent: jQuery(partySelect).parent(),
        }).on('select2:open', function () {
            setTimeout(function () {
                var input = document.querySelector('.select2-container--open .select2-search__field');
                if (input) { input.focus(); }
            }, 0);
        }).on('change', updateDueHint);
    } else {
        partySelect.addEventListener('change', updateDueHint);
    }

    document.querySelectorAll('input[name="party_type"]').forEach(function (radio) {
        radio.addEventListener('change', function () { fillOptions(null); });
    });

    fillOptions(OLD_PARTY_ID);
})();
</script>
@endsection
