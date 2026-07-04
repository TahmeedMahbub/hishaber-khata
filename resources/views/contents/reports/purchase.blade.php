@extends('contents.body')

@section('title', t('report.purchase'))

@section('content')
    @include('contents.reports.partials.print-style', [
        'reportTitle' => t('report.purchase'),
        'reportDate'  => \Illuminate\Support\Carbon::parse($report['from'])->format('d M Y') . ' — ' . \Illuminate\Support\Carbon::parse($report['to'])->format('d M Y'),
    ])

    <div class="row gy-4 report-sheet">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => t('report.purchase')])
            @include('contents.reports.partials.range-filter', [
                'action' => route('reports.purchases'),
                'from'   => $report['from'],
                'to'     => $report['to'],
            ])

            <div class="row g-3 mb-3 report-summary-cards">
                <div class="col-6 col-md-3">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">{{ t('report.total_purchase') }}</small>
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
                        <small class="text-muted d-block">{{ t('report.invoice_count') }}</small>
                        <h5 class="mb-0">{{ $report['count'] }}</h5>
                    </div></div>
                </div>
            </div>

            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ t('report.invoice') }}</th>
                                <th>{{ t('nav.suppliers') }}</th>
                                <th>{{ t('common.date') }}</th>
                                <th class="text-center">{{ t('report.items') }}</th>
                                <th class="text-end">{{ t('common.total') }}</th>
                                <th class="text-end">{{ t('report.paid') }}</th>
                                <th class="text-end">{{ t('report.due') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($report['purchases'] as $p)
                                <tr>
                                    <td class="fw-medium">{{ $p->invoice_no }}</td>
                                    <td>{{ $p->supplier->name ?? '—' }}</td>
                                    <td>{{ $p->purchase_date->format('d M Y') }}</td>
                                    <td class="text-center">{{ $p->items_count }}</td>
                                    <td class="text-end">৳ {{ number_format($p->total, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($p->paid, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($p->due, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted py-4">{{ t('report.no_purchase_period') }}</td></tr>
                            @endforelse
                        </tbody>
                        @if ($report['count'])
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="4">{{ t('report.grand_total') }}</td>
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
                <span>{{ t('report.purchase') }} — {{ \Illuminate\Support\Carbon::parse($report['from'])->format('d M Y') }} {{ t('report.to') }} {{ \Illuminate\Support\Carbon::parse($report['to'])->format('d M Y') }}</span>
                <span>{{ t('common.print') }}: {{ now()->format('d M Y, h:i A') }}</span>
            </div>
        </div>
    </div>
@endsection
