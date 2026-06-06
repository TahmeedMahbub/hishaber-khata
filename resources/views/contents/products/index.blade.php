@extends('contents.body')

@section('title', 'Products')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">পণ্য</h4>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus me-1"></i> নতুন পণ্য
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
                    <form method="GET" action="{{ route('products.index') }}" class="row g-2">
                        <div class="col-md-6">
                            <input type="text" name="search" value="{{ $search ?? '' }}"
                                class="form-control" placeholder="নাম বা বারকোড দিয়ে খুঁজুন...">
                        </div>
                        <div class="col-md-4">
                            <select name="category_id" class="form-select">
                                <option value="">সব ক্যাটাগরি</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (string) $categoryId === (string) $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
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
                                <th>নাম</th>
                                <th>ক্যাটাগরি</th>
                                <th class="text-end">ক্রয়মূল্য</th>
                                <th class="text-end">বিক্রয়মূল্য</th>
                                <th class="text-end">স্টক</th>
                                <th>স্ট্যাটাস</th>
                                <th class="text-end">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td class="fw-medium">
                                        {{ $product->name }}
                                        @if ($product->barcode)
                                            <small class="text-muted d-block">{{ $product->barcode }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $product->category->name ?? '—' }}</td>
                                    <td class="text-end">৳ {{ number_format($product->purchase_price, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($product->sale_price, 2) }}</td>
                                    <td class="text-end">
                                        {{ rtrim(rtrim(number_format($product->stock_qty, 2), '0'), '.') }} {{ $product->unit }}
                                        @if ($product->isLowStock())
                                            <span class="badge bg-label-warning ms-1">কম</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->status === 'active')
                                            <span class="badge bg-label-success">সক্রিয়</span>
                                        @else
                                            <span class="badge bg-label-secondary">নিষ্ক্রিয়</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('products.edit', $product) }}"
                                            class="btn btn-sm btn-icon btn-text-secondary">
                                            <i class="mdi mdi-pencil-outline"></i>
                                        </a>
                                        <form method="POST" action="{{ route('products.destroy', $product) }}"
                                            class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত?');">
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
                                    <td colspan="7" class="text-center text-muted py-4">কোনো পণ্য নেই।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($products->hasPages())
                    <div class="card-footer">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
