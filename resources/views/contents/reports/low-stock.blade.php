@extends('contents.body')

@section('title', t('report.low_stock'))

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => t('report.low_stock')])

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ $report['count'] }} {{ t('report.low_stock_count_suffix') }}</h6>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ t('nav.products') }}</th>
                                <th>{{ t('product.category') }}</th>
                                <th class="text-end">{{ t('report.current_stock') }}</th>
                                <th class="text-end">{{ t('report.alert_threshold') }}</th>
                                <th class="text-end">{{ t('report.shortage') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($report['products'] as $p)
                                <tr>
                                    <td class="fw-medium">{{ $p->name }}</td>
                                    <td>{{ $p->category->name ?? '—' }}</td>
                                    <td class="text-end">
                                        <span class="badge bg-label-danger">
                                            {{ rtrim(rtrim(number_format($p->stock_qty, 2), '0'), '.') }} {{ $p->unit }}
                                        </span>
                                    </td>
                                    <td class="text-end">{{ rtrim(rtrim(number_format($p->low_stock_alert, 2), '0'), '.') }} {{ $p->unit }}</td>
                                    <td class="text-end">{{ rtrim(rtrim(number_format(max(0, $p->low_stock_alert - $p->stock_qty), 2), '0'), '.') }} {{ $p->unit }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">{{ t('report.stock_sufficient') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
