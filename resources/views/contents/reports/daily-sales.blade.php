@extends('contents.body')

@section('title', 'Daily Sales Report')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => 'ডেইলি সেলস রিপোর্ট'])

            <div class="card mb-3 d-print-none">
                <div class="card-body">
                    <form method="GET" action="{{ route('reports.daily-sales') }}" class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label mb-1">তারিখ</label>
                            <input type="date" name="date" value="{{ $report['date'] }}" class="form-control">
                        </div>
                        <div class="col-md-2 d-grid">
                            <button type="submit" class="btn btn-primary">দেখুন</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-6 col-md-3">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">মোট বিক্রয়</small>
                        <h5 class="mb-0">৳ {{ number_format($report['total'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">পরিশোধ</small>
                        <h5 class="mb-0 text-success">৳ {{ number_format($report['paid'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">বাকি</small>
                        <h5 class="mb-0 text-danger">৳ {{ number_format($report['due'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">আনুমানিক লাভ</small>
                        <h5 class="mb-0 text-primary">৳ {{ number_format($report['profit'], 2) }}</h5>
                    </div></div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ \Illuminate\Support\Carbon::parse($report['date'])->format('d M Y') }} — {{ $report['count'] }} টি বিক্রয়</h6>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ইনভয়েস</th>
                                <th>কাস্টমার</th>
                                <th class="text-center">আইটেম</th>
                                <th class="text-end">মোট</th>
                                <th class="text-end">পরিশোধ</th>
                                <th class="text-end">বাকি</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($report['sales'] as $sale)
                                <tr>
                                    <td class="fw-medium">{{ $sale->invoice_no }}</td>
                                    <td>{{ $sale->customer->name ?? 'ওয়াক-ইন' }}</td>
                                    <td class="text-center">{{ $sale->items_count }}</td>
                                    <td class="text-end">৳ {{ number_format($sale->total, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($sale->paid, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($sale->due, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">এই দিনে কোনো বিক্রয় নেই।</td></tr>
                            @endforelse
                        </tbody>
                        @if ($report['count'])
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="3">সর্বমোট</td>
                                    <td class="text-end">৳ {{ number_format($report['total'], 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($report['paid'], 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($report['due'], 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
