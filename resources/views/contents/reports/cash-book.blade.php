@extends('contents.body')

@section('title', t('report.cash_book'))

@section('content')
    @include('contents.reports.partials.print-style', [
        'reportTitle' => t('report.cash_book'),
        'reportDate'  => \Illuminate\Support\Carbon::parse($report['from'])->format('d M Y') . ' — ' . \Illuminate\Support\Carbon::parse($report['to'])->format('d M Y'),
    ])

    <div class="row gy-4 report-sheet">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => t('report.cash_book')])
            @include('contents.reports.partials.range-filter', [
                'action' => route('reports.cash-book'),
                'from'   => $report['from'],
                'to'     => $report['to'],
            ])

            <div class="row g-3 mb-3 report-summary-cards">
                <div class="col-6 col-md-4">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">{{ t('report.cash_in') }}</small>
                        <h5 class="mb-0 text-success">৳ {{ number_format($report['in'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">{{ t('report.cash_out') }}</small>
                        <h5 class="mb-0 text-danger">৳ {{ number_format($report['out'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">{{ t('report.net_cash') }}</small>
                        <h5 class="mb-0 {{ $report['net'] >= 0 ? 'text-primary' : 'text-danger' }}">৳ {{ number_format($report['net'], 2) }}</h5>
                    </div></div>
                </div>
            </div>

            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ t('common.date') }}</th>
                                <th>{{ t('report.head') }}</th>
                                <th>{{ t('common.description') }}</th>
                                <th class="text-end">{{ t('report.in_tk') }}</th>
                                <th class="text-end">{{ t('report.out_tk') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($report['entries'] as $row)
                                <tr>
                                    <td>{{ optional($row['date'])->format('d M Y') }}</td>
                                    <td class="fw-medium">{{ $row['head'] }}</td>
                                    <td class="text-muted">{{ $row['detail'] }}</td>
                                    <td class="text-end text-success">
                                        {{ $row['type'] === 'in' ? number_format($row['amount'], 2) : '—' }}
                                    </td>
                                    <td class="text-end text-danger">
                                        {{ $row['type'] === 'out' ? number_format($row['amount'], 2) : '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">{{ t('report.no_transactions_period') }}</td></tr>
                            @endforelse
                        </tbody>
                        @if ($report['entries']->count())
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="3">{{ t('report.grand_total') }}</td>
                                    <td class="text-end text-success">৳ {{ number_format($report['in'], 2) }}</td>
                                    <td class="text-end text-danger">৳ {{ number_format($report['out'], 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

            <div class="report-print-footer">
                <span>{{ t('report.cash_book') }} — {{ \Illuminate\Support\Carbon::parse($report['from'])->format('d M Y') }} {{ t('report.to') }} {{ \Illuminate\Support\Carbon::parse($report['to'])->format('d M Y') }}</span>
                <span>{{ t('common.print') }}: {{ now()->format('d M Y, h:i A') }}</span>
            </div>
        </div>
    </div>
@endsection
