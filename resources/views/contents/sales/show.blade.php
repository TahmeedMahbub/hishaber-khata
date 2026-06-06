@extends('contents.body')

@section('title', 'Invoice')

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-lg-8">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">ইনভয়েস</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('sales.create') }}" class="btn btn-outline-primary">
                        <i class="mdi mdi-plus me-1"></i> নতুন বিক্রয়
                    </a>
                    <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="mdi mdi-printer me-1"></i> প্রিন্ট
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-wrap mb-4">
                        <div>
                            <h5 class="mb-1">{{ optional(optional(auth()->user())->tenant)->name ?? config('app.name') }}</h5>
                            <small class="text-muted">ইনভয়েস: {{ $sale->invoice_no }}</small>
                        </div>
                        <div class="text-end">
                            <div><strong>তারিখ:</strong> {{ $sale->sale_date->format('d M Y') }}</div>
                            <div><strong>কাস্টমার:</strong> {{ $sale->customer->name ?? 'ওয়াক-ইন' }}</div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>পণ্য</th>
                                    <th class="text-end">পরিমাণ</th>
                                    <th class="text-end">দাম</th>
                                    <th class="text-end">মোট</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sale->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name ?? '—' }}</td>
                                        <td class="text-end">{{ rtrim(rtrim(number_format($item->qty, 2), '0'), '.') }}</td>
                                        <td class="text-end">৳ {{ number_format($item->unit_price, 2) }}</td>
                                        <td class="text-end">৳ {{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <div class="d-flex justify-content-between mb-1">
                                <span>সাবটোটাল</span>
                                <span>৳ {{ number_format($sale->total + $sale->discount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>ছাড়</span>
                                <span>৳ {{ number_format($sale->discount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 fw-bold">
                                <span>মোট</span>
                                <span>৳ {{ number_format($sale->total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>পরিশোধ</span>
                                <span>৳ {{ number_format($sale->paid, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between text-danger">
                                <span>বাকি</span>
                                <span>৳ {{ number_format($sale->due, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    @if ($sale->note)
                        <hr>
                        <p class="mb-0"><strong>নোট:</strong> {{ $sale->note }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
