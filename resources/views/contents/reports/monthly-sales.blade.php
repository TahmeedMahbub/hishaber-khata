@extends('contents.body')

@section('title', 'Monthly Sales Report')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => 'মাসিক সেলস রিপোর্ট'])

            <div class="card mb-3 d-print-none">
                <div class="card-body">
                    <form method="GET" action="{{ route('reports.monthly-sales') }}" class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label mb-1">মাস</label>
                            <input type="month" name="month" value="{{ $report['month'] }}" class="form-control">
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
                        <small class="text-muted d-block">অর্ডার</small>
                        <h5 class="mb-0">{{ $report['orders'] }}</h5>
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
                    <h6 class="mb-0">{{ $report['label'] }} — দৈনিক বিভাজন</h6>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>তারিখ</th>
                                <th class="text-center">অর্ডার</th>
                                <th class="text-end">বিক্রয়</th>
                                <th class="text-end">পরিশোধ</th>
                                <th class="text-end">বাকি</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($report['rows'] as $row)
                                <tr>
                                    <td class="fw-medium">{{ \Illuminate\Support\Carbon::parse($row->sale_date)->format('d M Y') }}</td>
                                    <td class="text-center">{{ $row->orders }}</td>
                                    <td class="text-end">৳ {{ number_format($row->total, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($row->paid, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($row->due, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">এই মাসে কোনো বিক্রয় নেই।</td></tr>
                            @endforelse
                        </tbody>
                        @if ($report['orders'])
                            <tfoot>
                                <tr class="fw-bold">
                                    <td>সর্বমোট</td>
                                    <td class="text-center">{{ $report['orders'] }}</td>
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
