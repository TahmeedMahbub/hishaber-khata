@extends('contents.body')

@section('title', t('duepay.collect_pay'))

@section('content')
    @php
        $methodLabels = [
            'cash'   => t('duepay.method_cash'),
            'bkash'  => t('duepay.method_bkash'),
            'nagad'  => t('duepay.method_nagad'),
            'rocket' => t('duepay.method_rocket'),
            'bank'   => t('duepay.method_bank'),
            'other'  => t('duepay.method_other'),
        ];
        $selectedType = old('party_type', $partyType);
    @endphp

    <div class="row gy-4 justify-content-center">
        <div class="col-12 col-lg-7">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">{{ t('duepay.collect_pay') }}</h4>
                <a href="{{ route('due-payments.index') }}" class="btn btn-outline-secondary">
                    <i class="mdi mdi-arrow-left me-1"></i> {{ t('common.back') }}
                </a>
            </div>

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

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ t('duepay.new_transaction') }}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('due-payments.store') }}" id="duePaymentForm">
                        @csrf

                        {{-- Customer / Supplier toggle --}}
                        <div class="mb-3 {{ $lockType ? 'd-none' : '' }}">
                            <label class="form-label d-block">{{ t('duepay.type') }}</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="party_type" id="typeCustomer"
                                    value="customer" {{ $selectedType === 'customer' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="typeCustomer">
                                    <i class="mdi mdi-account-arrow-down"></i> {{ t('duepay.collect_customer') }}
                                </label>

                                <input type="radio" class="btn-check" name="party_type" id="typeSupplier"
                                    value="supplier" {{ $selectedType === 'supplier' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="typeSupplier">
                                    <i class="mdi mdi-account-arrow-up"></i> {{ t('duepay.pay_supplier') }}
                                </label>
                            </div>
                        </div>

                        {{-- Party (select2) --}}
                        <div class="mb-3">
                            <label for="partySelect" class="form-label" id="partyLabel">{{ t('nav.customers') }}</label>
                            <select name="party_id" id="partySelect" class="form-select" required>
                                <option value="">{{ t('duepay.select_ph') }}</option>
                            </select>
                            <small class="text-muted" id="dueHint"></small>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="amount" class="form-label">{{ t('duepay.amount_tk') }}</label>
                                <input type="number" step="0.01" min="0.01" name="amount" id="amount"
                                    onfocus="this.select()" class="form-control"
                                    value="{{ old('amount') }}" placeholder="0.00" required>
                            </div>
                            <div class="col-md-6">
                                <label for="payment_date" class="form-label">{{ t('common.date') }}</label>
                                <input type="date" name="payment_date" id="payment_date" class="form-control"
                                    value="{{ old('payment_date', now()->toDateString()) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="method" class="form-label">{{ t('duepay.method_label') }}</label>
                                <select name="method" id="method" class="form-select">
                                    @foreach ($methodLabels as $key => $label)
                                        <option value="{{ $key }}" {{ old('method') === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="note" class="form-label">{{ t('common.note') }} <span class="text-muted">({{ t('common.optional') }})</span></label>
                                <input type="text" name="note" id="note" class="form-control"
                                    value="{{ old('note') }}" placeholder="{{ t('duepay.note_ph') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3" id="saveBtn">
                            <i class="mdi mdi-content-save me-1"></i> {{ t('common.save') }}
                        </button>
                    </form>
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
    var PRESELECT_ID = @json(old('party_id', $partyId));

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
        partyLabel.textContent = type === 'supplier' ? "{{ t('nav.suppliers') }}" : "{{ t('nav.customers') }}";

        partySelect.innerHTML = '<option value="">{{ t('duepay.select_ph') }}</option>';
        list.forEach(function (p) {
            var due = parseFloat(p.due_balance) || 0;
            var label = p.name + (p.phone ? ' — ' + p.phone : '') +
                        (due > 0 ? '  (' + "{{ t('duepay.due_inline') }}" + ' ৳' + fmt(due) + ')' : '');
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
            dueHint.textContent = "{{ t('duepay.current_due') }}" + ' ৳ ' + fmt(due);
            dueHint.className = 'text-danger';
        } else if (partySelect.value) {
            dueHint.textContent = "{{ t('duepay.empty') }}";
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

    fillOptions(PRESELECT_ID);
})();
</script>
@endsection
