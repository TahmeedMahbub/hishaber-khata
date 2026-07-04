@extends('contents.body')

@section('title', t('report.monthly_sales'))

@section('content')
    @include('contents.reports.partials.print-style', [
        'reportTitle' => t('report.monthly_sales'),
        'reportDate'  => $report['label'],
    ])

    <div class="row gy-4 report-sheet">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => t('report.monthly_sales')])

            <div class="card mb-3 d-print-none">
                <div class="card-body">
                    <form method="GET" action="{{ route('reports.monthly-sales') }}" class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label mb-1">{{ t('report.month') }}</label>
                            <input type="month" name="month" value="{{ $report['month'] }}" class="form-control">
                        </div>
                        <div class="col-md-2 d-grid">
                            <button type="submit" class="btn btn-primary">{{ t('common.view') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row g-3 mb-3 report-summary-cards">
                <div class="col-6 col-md-3">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">{{ t('report.total_sales') }}</small>
                        <h5 class="mb-0">৳ {{ number_format($report['total'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">{{ t('report.orders') }}</small>
                        <h5 class="mb-0">{{ $report['orders'] }}</h5>
                    </div></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">{{ t('report.due') }}</small>
                        <h5 class="mb-0 text-danger">৳ {{ number_format($report['due'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">{{ t('report.estimated_profit') }}</small>
                        <h5 class="mb-0 text-primary">৳ {{ number_format($report['profit'], 2) }}</h5>
                    </div></div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ $report['label'] }} — {{ t('report.daily_breakdown') }}</h6>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ t('common.date') }}</th>
                                <th class="text-center">{{ t('report.orders') }}</th>
                                <th class="text-end">{{ t('nav.sales') }}</th>
                                <th class="text-end">{{ t('report.paid') }}</th>
                                <th class="text-end">{{ t('report.due') }}</th>
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
                                <tr><td colspan="5" class="text-center text-muted py-4">{{ t('report.no_sales_month') }}</td></tr>
                            @endforelse
                        </tbody>
                        @if ($report['orders'])
                            <tfoot>
                                <tr class="fw-bold">
                                    <td>{{ t('report.grand_total') }}</td>
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

            <div class="report-print-footer">
                <span>{{ t('report.monthly_sales') }} — {{ $report['label'] }}</span>
                <span>{{ t('common.print') }}: {{ now()->format('d M Y, h:i A') }}</span>
            </div>
        </div>
    </div>
@endsection
