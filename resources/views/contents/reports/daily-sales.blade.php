@extends('contents.body')

@section('title', t('report.daily_sales'))

@section('content')
    @include('contents.reports.partials.print-style', [
        'reportTitle' => t('report.daily_sales'),
        'reportDate'  => \Illuminate\Support\Carbon::parse($report['date'])->format('d M Y'),
    ])

    <div class="row gy-4 report-sheet">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => t('report.daily_sales')])

            <div class="card mb-3 d-print-none">
                <div class="card-body">
                    <form method="GET" action="{{ route('reports.daily-sales') }}" class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label mb-1">{{ t('common.date') }}</label>
                            <input type="date" name="date" value="{{ $report['date'] }}" class="form-control">
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
                        <small class="text-muted d-block">{{ t('report.paid') }}</small>
                        <h5 class="mb-0 text-success">৳ {{ number_format($report['paid'], 2) }}</h5>
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
                    <h6 class="mb-0">{{ \Illuminate\Support\Carbon::parse($report['date'])->format('d M Y') }} — {{ $report['count'] }} {{ t('report.sales_suffix') }}</h6>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ t('report.invoice') }}</th>
                                <th>{{ t('nav.customers') }}</th>
                                <th class="text-center">{{ t('report.items') }}</th>
                                <th class="text-end">{{ t('common.total') }}</th>
                                <th class="text-end">{{ t('report.paid') }}</th>
                                <th class="text-end">{{ t('report.due') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($report['sales'] as $sale)
                                <tr>
                                    <td class="fw-medium">{{ $sale->invoice_no }}</td>
                                    <td>{{ $sale->customer->name ?? t('report.walkin') }}</td>
                                    <td class="text-center">{{ $sale->items_count }}</td>
                                    <td class="text-end">৳ {{ number_format($sale->total, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($sale->paid, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($sale->due, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">{{ t('report.no_sales_day') }}</td></tr>
                            @endforelse
                        </tbody>
                        @if ($report['count'])
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="3">{{ t('report.grand_total') }}</td>
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
                <span>{{ t('report.daily_sales') }} — {{ \Illuminate\Support\Carbon::parse($report['date'])->format('d M Y') }}</span>
                <span>{{ t('common.print') }}: {{ now()->format('d M Y, h:i A') }}</span>
            </div>
        </div>
    </div>
@endsection
