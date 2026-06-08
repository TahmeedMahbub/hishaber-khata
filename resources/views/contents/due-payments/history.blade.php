@extends('contents.body')

@section('title', 'Payment History')

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
    @endphp

    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <h4 class="fw-bold mb-0">লেনদেন ইতিহাস</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('due-payments.index') }}" class="btn btn-outline-secondary">
                        <i class="mdi mdi-book-open-variant me-1"></i> বাকির খাতা
                    </a>
                    <a href="{{ route('due-payments.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-cash-plus me-1"></i> আদায় / পরিশোধ
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
                    <h5 class="mb-0">সকল লেনদেন</h5>
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('due-payments.history') }}"
                            class="btn {{ !$type ? 'btn-primary' : 'btn-outline-primary' }}">সব</a>
                        <a href="{{ route('due-payments.history', ['type' => 'customer']) }}"
                            class="btn {{ $type === 'customer' ? 'btn-primary' : 'btn-outline-primary' }}">কাস্টমার</a>
                        <a href="{{ route('due-payments.history', ['type' => 'supplier']) }}"
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
@endsection
