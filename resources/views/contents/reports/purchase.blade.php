@extends('contents.body')

@section('title', 'Purchase Report')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => 'ক্রয় রিপোর্ট'])
            @include('contents.reports.partials.range-filter', [
                'action' => route('reports.purchases'),
                'from'   => $report['from'],
                'to'     => $report['to'],
            ])

            <div class="row g-3 mb-3">
                <div class="col-6 col-md-3">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">মোট ক্রয়</small>
                        <h5 class="mb-0">৳ {{ number_format($report['total'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">পরিশোধ</small>
                        <h5 class="mb-0 text-success">৳ {{ number_format($report['paid'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">বাকি</small>
                        <h5 class="mb-0 text-danger">৳ {{ number_format($report['due'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">ইনভয়েস সংখ্যা</small>
                        <h5 class="mb-0">{{ $report['count'] }}</h5>
                    </div></div>
                </div>
            </div>

            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ইনভয়েস</th>
                                <th>সরবরাহকারী</th>
                                <th>তারিখ</th>
                                <th class="text-center">আইটেম</th>
                                <th class="text-end">মোট</th>
                                <th class="text-end">পরিশোধ</th>
                                <th class="text-end">বাকি</th>
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
                                <tr><td colspan="7" class="text-center text-muted py-4">এই সময়ে কোনো ক্রয় নেই।</td></tr>
                            @endforelse
                        </tbody>
                        @if ($report['count'])
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="4">সর্বমোট</td>
                                    <td class="text-end">৳ {{ number_format($report['total'], 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($report['paid'], 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($report['due'], 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
