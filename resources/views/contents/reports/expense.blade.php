@extends('contents.body')

@section('title', 'Expense Report')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => 'খরচ রিপোর্ট'])
            @include('contents.reports.partials.range-filter', [
                'action' => route('reports.expenses'),
                'from'   => $report['from'],
                'to'     => $report['to'],
            ])

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">মোট খরচ</small>
                        <h5 class="mb-0 text-danger">৳ {{ number_format($report['total'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-6">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">এন্ট্রি সংখ্যা</small>
                        <h5 class="mb-0">{{ $report['count'] }}</h5>
                    </div></div>
                </div>
            </div>

            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>তারিখ</th>
                                <th>খরচের খাত</th>
                                <th>নোট</th>
                                <th class="text-end">পরিমাণ</th>
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
                                <tr><td colspan="4" class="text-center text-muted py-4">এই সময়ে কোনো খরচ নেই।</td></tr>
                            @endforelse
                        </tbody>
                        @if ($report['count'])
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="3">সর্বমোট</td>
                                    <td class="text-end">৳ {{ number_format($report['total'], 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
