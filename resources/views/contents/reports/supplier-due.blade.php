@extends('contents.body')

@section('title', t('report.supplier_due'))

@section('content')
    @include('contents.reports.partials.print-style', [
        'reportTitle' => t('report.supplier_due'),
        'reportDate'  => now()->format('d M Y'),
    ])

    <div class="row gy-4 report-sheet">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => t('report.supplier_due')])

            <div class="row g-3 mb-3 report-summary-cards">
                <div class="col-6">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">{{ t('report.total_due') }}</small>
                        <h5 class="mb-0 text-danger">৳ {{ number_format($report['total'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-6">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">{{ t('report.due_suppliers') }}</small>
                        <h5 class="mb-0">{{ $report['count'] }}</h5>
                    </div></div>
                </div>
            </div>

            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ t('nav.suppliers') }}</th>
                                <th>{{ t('common.phone') }}</th>
                                <th class="text-end">{{ t('report.due') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($report['suppliers'] as $s)
                                <tr>
                                    <td class="fw-medium">{{ $s->name }}</td>
                                    <td>{{ $s->phone ?? '—' }}</td>
                                    <td class="text-end text-danger">৳ {{ number_format($s->due_balance, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4">{{ t('report.no_due') }}</td></tr>
                            @endforelse
                        </tbody>
                        @if ($report['count'])
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="2">{{ t('report.grand_total') }}</td>
                                    <td class="text-end text-danger">৳ {{ number_format($report['total'], 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

            <div class="report-print-footer">
                <span>{{ t('report.supplier_due') }}</span>
                <span>{{ t('common.print') }}: {{ now()->format('d M Y, h:i A') }}</span>
            </div>
        </div>
    </div>
@endsection
