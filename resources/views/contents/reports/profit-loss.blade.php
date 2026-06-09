@extends('contents.body')

@section('title', 'Profit & Loss Report')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            @include('contents.reports.partials.header', ['title' => 'লাভ ও ক্ষতি রিপোর্ট'])
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
                                        <td>মোট বিক্রয় (রাজস্ব)</td>
                                        <td class="text-end fw-medium">৳ {{ number_format($report['revenue'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-4">এর মধ্যে ছাড়</td>
                                        <td class="text-end text-muted">৳ {{ number_format($report['discount'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>বিক্রিত পণ্যের ক্রয়মূল্য (COGS)</td>
                                        <td class="text-end text-danger">− ৳ {{ number_format($report['cogs'], 2) }}</td>
                                    </tr>
                                    <tr class="table-active">
                                        <td class="fw-bold">গ্রস লাভ</td>
                                        <td class="text-end fw-bold">৳ {{ number_format($report['gross_profit'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>মোট খরচ</td>
                                        <td class="text-end text-danger">− ৳ {{ number_format($report['expenses'], 2) }}</td>
                                    </tr>
                                    <tr class="table-active">
                                        <td class="fw-bold">নিট লাভ / ক্ষতি</td>
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
        </div>
    </div>
@endsection
