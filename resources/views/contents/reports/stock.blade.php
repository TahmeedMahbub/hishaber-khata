@extends('contents.body')

@section('title', 'Stock Report')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => 'বর্তমান স্টক রিপোর্ট'])

            <div class="row g-3 mb-3">
                <div class="col-6 col-md-4">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">মোট পণ্য</small>
                        <h5 class="mb-0">{{ $report['count'] }}</h5>
                    </div></div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">স্টক মূল্য (ক্রয়)</small>
                        <h5 class="mb-0">৳ {{ number_format($report['total_cost'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">স্টক মূল্য (বিক্রয়)</small>
                        <h5 class="mb-0 text-primary">৳ {{ number_format($report['total_sale'], 2) }}</h5>
                    </div></div>
                </div>
            </div>

            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>পণ্য</th>
                                <th>ক্যাটাগরি</th>
                                <th class="text-end">স্টক</th>
                                <th class="text-end">ক্রয়মূল্য</th>
                                <th class="text-end">স্টক মূল্য</th>
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
                                            <span class="badge bg-label-warning ms-1">কম</span>
                                        @endif
                                    </td>
                                    <td class="text-end">৳ {{ number_format($p->purchase_price, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($p->stock_qty * $p->purchase_price, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">কোনো পণ্য নেই।</td></tr>
                            @endforelse
                        </tbody>
                        @if ($report['count'])
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="4">মোট স্টক মূল্য (ক্রয়)</td>
                                    <td class="text-end">৳ {{ number_format($report['total_cost'], 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
