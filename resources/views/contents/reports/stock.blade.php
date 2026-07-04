@extends('contents.body')

@section('title', t('report.stock'))

@section('content')
    @include('contents.reports.partials.print-style', [
        'reportTitle' => t('report.stock'),
        'reportDate'  => now()->format('d M Y'),
    ])

    <div class="row gy-4 report-sheet">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => t('report.stock')])

            <div class="row g-3 mb-3 report-summary-cards">
                <div class="col-6 col-md-4">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">{{ t('report.total_products') }}</small>
                        <h5 class="mb-0">{{ $report['count'] }}</h5>
                    </div></div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">{{ t('report.stock_value_cost') }}</small>
                        <h5 class="mb-0">৳ {{ number_format($report['total_cost'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">{{ t('report.stock_value_sale') }}</small>
                        <h5 class="mb-0 text-primary">৳ {{ number_format($report['total_sale'], 2) }}</h5>
                    </div></div>
                </div>
            </div>

            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ t('nav.products') }}</th>
                                <th>{{ t('product.category') }}</th>
                                <th class="text-end">{{ t('product.stock') }}</th>
                                <th class="text-end">{{ t('product.purchase_price') }}</th>
                                <th class="text-end">{{ t('report.stock_value') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($report['products'] as $p)
                                <tr>
                                    <td class="fw-medium">{{ $p->name }}</td>
                                    <td>{{ $p->category->name ?? '—' }}</td>
                                    <td class="text-end">
                                        {{ rtrim(rtrim(number_format($p->stock_qty, 2), '0'), '.') }} {{ $p->unit }}
                                        @if ($p->isLowStock())
                                            <span class="badge bg-label-warning ms-1">{{ t('product.low') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">৳ {{ number_format($p->purchase_price, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($p->stock_qty * $p->purchase_price, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">{{ t('report.no_products') }}</td></tr>
                            @endforelse
                        </tbody>
                        @if ($report['count'])
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="4">{{ t('report.total_stock_value_cost') }}</td>
                                    <td class="text-end">৳ {{ number_format($report['total_cost'], 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

            <div class="report-print-footer">
                <span>{{ t('report.stock') }}</span>
                <span>{{ t('common.print') }}: {{ now()->format('d M Y, h:i A') }}</span>
            </div>
        </div>
    </div>
@endsection
