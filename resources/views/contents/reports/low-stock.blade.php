@extends('contents.body')

@section('title', 'Low Stock Report')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => 'কম স্টক রিপোর্ট'])

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ $report['count'] }} টি পণ্যের স্টক সতর্কতা সীমার নিচে</h6>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>পণ্য</th>
                                <th>ক্যাটাগরি</th>
                                <th class="text-end">বর্তমান স্টক</th>
                                <th class="text-end">সতর্কতা সীমা</th>
                                <th class="text-end">ঘাটতি</th>
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
                                <tr><td colspan="5" class="text-center text-muted py-4">সব পণ্যের স্টক পর্যাপ্ত আছে।</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
