@extends('contents.body')

@section('title', 'Purchases')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">ক্রয়</h4>
                <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus me-1"></i> নতুন ক্রয়
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
                    <form method="GET" action="{{ route('purchases.index') }}" class="row g-2">
                        <div class="col-md-10">
                            <input type="text" name="search" value="{{ $search ?? '' }}"
                                class="form-control" placeholder="ইনভয়েস, সরবরাহকারীর নাম বা মোবাইল দিয়ে খুঁজুন...">
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
                                <th>সরবরাহকারী</th>
                                <th>তারিখ</th>
                                <th class="text-center">আইটেম</th>
                                <th class="text-end">মোট</th>
                                <th class="text-end">পরিশোধ</th>
                                <th class="text-end">বাকি</th>
                                <th class="text-end">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($purchases as $purchase)
                                <tr>
                                    <td class="fw-medium">{{ $purchase->invoice_no }}</td>
                                    <td>
                                        {{ $purchase->supplier->name ?? 'নগদ ক্রয়' }}
                                        @if ($purchase->supplier?->phone)
                                            <small class="text-muted d-block">{{ $purchase->supplier->phone }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $purchase->purchase_date?->format('d/m/Y') }}</td>
                                    <td class="text-center">{{ $purchase->items_count }}</td>
                                    <td class="text-end">৳ {{ number_format($purchase->total, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($purchase->paid, 2) }}</td>
                                    <td class="text-end">
                                        @if ($purchase->due > 0)
                                            <span class="text-danger">৳ {{ number_format($purchase->due, 2) }}</span>
                                        @else
                                            <span class="badge bg-label-success">পরিশোধিত</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('purchases.show', $purchase) }}"
                                            class="btn btn-sm btn-icon btn-text-secondary">
                                            <i class="mdi mdi-eye-outline"></i>
                                        </a>
                                        <form method="POST" action="{{ route('purchases.destroy', $purchase) }}"
                                            class="d-inline"
                                            data-confirm="ইনভয়েস <strong>{{ $purchase->invoice_no }}</strong> মুছে ফেলা হবে এবং স্টক ফিরিয়ে নেওয়া হবে।">
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
                                    <td colspan="8" class="text-center text-muted py-4">কোনো ক্রয় নেই।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($purchases->hasPages())
                    <div class="card-footer">
                        {{ $purchases->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
