@extends('contents.body')

@section('title', 'Suppliers')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">সরবরাহকারী</h4>
                <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus me-1"></i> নতুন সরবরাহকারী
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
                    <form method="GET" action="{{ route('suppliers.index') }}" class="row g-2">
                        <div class="col-md-10">
                            <input type="text" name="search" value="{{ $search ?? '' }}"
                                class="form-control" placeholder="নাম বা মোবাইল দিয়ে খুঁজুন...">
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
                                <th>মোবাইল</th>
                                <th>ঠিকানা</th>
                                <th class="text-end">বাকি</th>
                                <th class="text-end">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($suppliers as $supplier)
                                <tr>
                                    <td class="fw-medium">{{ $supplier->name }}</td>
                                    <td>{{ $supplier->phone ?? '—' }}</td>
                                    <td>{{ $supplier->address ?? '—' }}</td>
                                    <td class="text-end">
                                        @if ($supplier->due_balance > 0)
                                            <span class="text-danger">৳ {{ number_format($supplier->due_balance, 2) }}</span>
                                        @else
                                            <span class="text-muted">৳ 0.00</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('suppliers.edit', $supplier) }}"
                                            class="btn btn-sm btn-icon btn-text-secondary">
                                            <i class="mdi mdi-pencil-outline"></i>
                                        </a>
                                        <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}"
                                            class="d-inline" data-confirm="আপনি কি নিশ্চিত?">
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
                                    <td colspan="5" class="text-center text-muted py-4">কোনো সরবরাহকারী নেই।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($suppliers->hasPages())
                    <div class="card-footer">
                        {{ $suppliers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
