@extends('contents.body')

@section('title', t('report.expense'))

@section('content')
    @include('contents.reports.partials.print-style', [
        'reportTitle' => t('report.expense'),
        'reportDate'  => \Illuminate\Support\Carbon::parse($report['from'])->format('d M Y') . ' — ' . \Illuminate\Support\Carbon::parse($report['to'])->format('d M Y'),
    ])

    <div class="row gy-4 report-sheet">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => t('report.expense')])
            @include('contents.reports.partials.range-filter', [
                'action' => route('reports.expenses'),
                'from'   => $report['from'],
                'to'     => $report['to'],
            ])

            <div class="row g-3 mb-3 report-summary-cards">
                <div class="col-6">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">{{ t('report.total_expenses') }}</small>
                        <h5 class="mb-0 text-danger">৳ {{ number_format($report['total'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-6">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">{{ t('report.entry_count') }}</small>
                        <h5 class="mb-0">{{ $report['count'] }}</h5>
                    </div></div>
                </div>
            </div>

            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ t('common.date') }}</th>
                                <th>{{ t('report.expense_head') }}</th>
                                <th>{{ t('common.note') }}</th>
                                <th class="text-end">{{ t('common.amount') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($report['expenses'] as $e)
                                <tr>
                                    <td>{{ $e->expense_date->format('d M Y') }}</td>
                                    <td class="fw-medium">{{ $e->title }}</td>
                                    <td class="text-muted">{{ $e->note ?? '—' }}</td>
                                    <td class="text-end">৳ {{ number_format($e->amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">{{ t('report.no_expense_period') }}</td></tr>
                            @endforelse
                        </tbody>
                        @if ($report['count'])
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="3">{{ t('report.grand_total') }}</td>
                                    <td class="text-end">৳ {{ number_format($report['total'], 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

            <div class="report-print-footer">
                <span>{{ t('report.expense') }} — {{ \Illuminate\Support\Carbon::parse($report['from'])->format('d M Y') }} {{ t('report.to') }} {{ \Illuminate\Support\Carbon::parse($report['to'])->format('d M Y') }}</span>
                <span>{{ t('common.print') }}: {{ now()->format('d M Y, h:i A') }}</span>
            </div>
        </div>
    </div>
@endsection
