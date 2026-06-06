@extends('contents.body')

@section('title', 'Sales')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">বিক্রয়</h4>
                <a href="{{ route('sales.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-cash-register me-1"></i> নতুন বিক্রয় (POS)
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <form method="GET" action="{{ route('sales.index') }}" class="row g-2">
                        <div class="col-md-10">
                            <input type="text" name="search" value="{{ $search ?? '' }}"
                                class="form-control" placeholder="ইনভয়েস বা কাস্টমার দিয়ে খুঁজুন...">
                        </div>
                        <div class="col-md-2 d-grid">
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="mdi mdi-magnify"></i> খুঁজুন
                            </button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ইনভয়েস</th>
                                <th>কাস্টমার</th>
                                <th>তারিখ</th>
                                <th class="text-end">মোট</th>
                                <th class="text-end">পরিশোধ</th>
                                <th class="text-end">বাকি</th>
                                <th class="text-end">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                                <tr>
                                    <td class="fw-medium">{{ $sale->invoice_no }}</td>
                                    <td>{{ $sale->customer->name ?? 'ওয়াক-ইন' }}</td>
                                    <td>{{ $sale->sale_date->format('d M Y') }}</td>
                                    <td class="text-end">৳ {{ number_format($sale->total, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($sale->paid, 2) }}</td>
                                    <td class="text-end">
                                        @if ($sale->due > 0)
                                            <span class="badge bg-label-danger">৳ {{ number_format($sale->due, 2) }}</span>
                                        @else
                                            <span class="badge bg-label-success">পরিশোধিত</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('sales.show', $sale) }}"
                                            class="btn btn-sm btn-icon btn-text-secondary">
                                            <i class="mdi mdi-eye-outline"></i>
                                        </a>
                                        <form method="POST" action="{{ route('sales.destroy', $sale) }}"
                                            class="d-inline" onsubmit="return confirm('এই বিক্রয় মুছলে স্টক ফেরত যাবে। নিশ্চিত?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-icon btn-text-danger">
                                                <i class="mdi mdi-delete-outline"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">কোনো বিক্রয় নেই।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($sales->hasPages())
                    <div class="card-footer">
                        {{ $sales->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
