@extends('contents.body')

@section('title', 'Customer Due Report')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => 'কাস্টমার বাকি রিপোর্ট'])

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">মোট বাকি</small>
                        <h5 class="mb-0 text-danger">৳ {{ number_format($report['total'], 2) }}</h5>
                    </div></div>
                </div>
                <div class="col-6">
                    <div class="card"><div class="card-body p-3">
                        <small class="text-muted d-block">বাকিদার কাস্টমার</small>
                        <h5 class="mb-0">{{ $report['count'] }}</h5>
                    </div></div>
                </div>
            </div>

            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>কাস্টমার</th>
                                <th>ফোন</th>
                                <th class="text-end">বাকি</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($report['customers'] as $c)
                                <tr>
                                    <td class="fw-medium">{{ $c->name }}</td>
                                    <td>{{ $c->phone ?? '—' }}</td>
                                    <td class="text-end text-danger">৳ {{ number_format($c->due_balance, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4">কোনো বাকি নেই।</td></tr>
                            @endforelse
                        </tbody>
                        @if ($report['count'])
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="2">সর্বমোট</td>
                                    <td class="text-end text-danger">৳ {{ number_format($report['total'], 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
