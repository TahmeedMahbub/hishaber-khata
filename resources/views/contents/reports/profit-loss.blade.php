@extends('contents.body')

@section('title', t('report.profit_loss'))

@section('content')
    @include('contents.reports.partials.print-style', [
        'reportTitle' => t('report.profit_loss'),
        'reportDate'  => \Illuminate\Support\Carbon::parse($report['from'])->format('d M Y') . ' — ' . \Illuminate\Support\Carbon::parse($report['to'])->format('d M Y'),
    ])

    <div class="row gy-4 report-sheet">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => t('report.profit_loss')])
            @include('contents.reports.partials.range-filter', [
                'action' => route('reports.profit-loss'),
                'from'   => $report['from'],
                'to'     => $report['to'],
            ])

            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                {{ \Illuminate\Support\Carbon::parse($report['from'])->format('d M Y') }}
                                — {{ \Illuminate\Support\Carbon::parse($report['to'])->format('d M Y') }}
                            </h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td>{{ t('report.revenue') }}</td>
                                        <td class="text-end fw-medium">৳ {{ number_format($report['revenue'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-4">{{ t('report.included_discount') }}</td>
                                        <td class="text-end text-muted">৳ {{ number_format($report['discount'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ t('report.cogs') }}</td>
                                        <td class="text-end text-danger">− ৳ {{ number_format($report['cogs'], 2) }}</td>
                                    </tr>
                                    <tr class="table-active">
                                        <td class="fw-bold">{{ t('report.gross_profit') }}</td>
                                        <td class="text-end fw-bold">৳ {{ number_format($report['gross_profit'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ t('report.total_expenses') }}</td>
                                        <td class="text-end text-danger">− ৳ {{ number_format($report['expenses'], 2) }}</td>
                                    </tr>
                                    <tr class="table-active">
                                        <td class="fw-bold">{{ t('report.net_profit') }}</td>
                                        <td class="text-end fw-bold {{ $report['net_profit'] >= 0 ? 'text-success' : 'text-danger' }}">
                                            ৳ {{ number_format($report['net_profit'], 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-print-footer">
                <span>{{ t('report.profit_loss') }} — {{ \Illuminate\Support\Carbon::parse($report['from'])->format('d M Y') }} {{ t('report.to') }} {{ \Illuminate\Support\Carbon::parse($report['to'])->format('d M Y') }}</span>
                <span>{{ t('common.print') }}: {{ now()->format('d M Y, h:i A') }}</span>
            </div>
        </div>
    </div>
@endsection
