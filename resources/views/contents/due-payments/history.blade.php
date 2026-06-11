@extends('contents.body')

@section('title', t('duepay.history'))

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
    @endphp

    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <h4 class="fw-bold mb-0">{{ t('duepay.history') }}</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('due-payments.index') }}" class="btn btn-outline-secondary">
                        <i class="mdi mdi-book-open-variant me-1"></i> {{ t('duepay.title') }}
                    </a>
                    <a href="{{ route('due-payments.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-cash-plus me-1"></i> {{ t('duepay.collect_pay') }}
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h5 class="mb-0">{{ t('duepay.all_transactions') }}</h5>
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('due-payments.history') }}"
                            class="btn {{ !$type ? 'btn-primary' : 'btn-outline-primary' }}">{{ t('common.all') }}</a>
                        <a href="{{ route('due-payments.history', ['type' => 'customer']) }}"
                            class="btn {{ $type === 'customer' ? 'btn-primary' : 'btn-outline-primary' }}">{{ t('nav.customers') }}</a>
                        <a href="{{ route('due-payments.history', ['type' => 'supplier']) }}"
                            class="btn {{ $type === 'supplier' ? 'btn-primary' : 'btn-outline-primary' }}">{{ t('nav.suppliers') }}</a>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ t('common.date') }}</th>
                                <th>{{ t('common.name') }}</th>
                                <th>{{ t('duepay.type') }}</th>
                                <th>{{ t('duepay.method_col') }}</th>
                                <th class="text-end">{{ t('common.amount') }}</th>
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
                                            <span class="badge bg-label-success">{{ t('duepay.collect') }}</span>
                                        @else
                                            <span class="badge bg-label-warning">{{ t('duepay.pay') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $methodLabels[$payment->method] ?? $payment->method }}</td>
                                    <td class="text-end fw-medium">৳ {{ number_format((float) $payment->amount, 2) }}</td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('due-payments.destroy', $payment) }}"
                                            class="d-inline"
                                            data-confirm="{{ t('duepay.delete_confirm') }}">
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
                                    <td colspan="6" class="text-center text-muted py-4">{{ t('duepay.empty_transactions') }}</td>
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
@endsection
