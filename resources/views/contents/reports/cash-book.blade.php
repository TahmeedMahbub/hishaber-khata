@extends('contents.body')

@section('title', 'Cash Book Report')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => 'ক্যাশ বুক রিপোর্ট'])
            @include('contents.reports.partials.range-filter', [
                'action' => route('reports.cash-book'),
                'from'   => $report['from'],
                'to'     => $report['to'],
            ])

            <div class="row g-3 mb-3">
                <div class="col-6 col-md-4">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">নগদ আগমন</small>
                        <h5 class="mb-0 text-success">৳ {{ number_format($report['in'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">নগদ নির্গমন</small>
                        <h5 class="mb-0 text-danger">৳ {{ number_format($report['out'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">নিট নগদ</small>
                        <h5 class="mb-0 {{ $report['net'] >= 0 ? 'text-primary' : 'text-danger' }}">৳ {{ number_format($report['net'], 2) }}</h5>
                    </div></div>
                </div>
            </div>

            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>তারিখ</th>
                                <th>খাত</th>
                                <th>বিবরণ</th>
                                <th class="text-end">আগমন (৳)</th>
                                <th class="text-end">নির্গমন (৳)</th>
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
                                <tr><td colspan="5" class="text-center text-muted py-4">এই সময়ে কোনো লেনদেন নেই।</td></tr>
                            @endforelse
                        </tbody>
                        @if ($report['entries']->count())
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="3">সর্বমোট</td>
                                    <td class="text-end text-success">৳ {{ number_format($report['in'], 2) }}</td>
                                    <td class="text-end text-danger">৳ {{ number_format($report['out'], 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
