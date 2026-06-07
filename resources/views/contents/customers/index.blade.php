@extends('contents.body')

@section('title', 'Customers')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">কাস্টমার</h4>
                <a href="{{ route('customers.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus me-1"></i> নতুন কাস্টমার
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
                    <form method="GET" action="{{ route('customers.index') }}" class="row g-2">
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
                                <th class="text-end">অর্ডার</th>
                                <th class="text-end">বিক্রয়</th>
                                <th class="text-end">বাকি</th>
                                <th class="text-end">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $customer)
                                <tr>
                                    <td class="fw-medium">{{ $customer->name }}</td>
                                    <td>{{ $customer->phone ?? '—' }}</td>
                                    <td class="text-end">{{ $customer->sales_count }}</td>
                                    <td class="text-end">৳ {{ number_format($customer->sales_sum_total ?? 0, 2) }}</td>
                                    <td class="text-end">
                                        @if ($customer->due_balance > 0)
                                            <span class="text-danger">৳ {{ number_format($customer->due_balance, 2) }}</span>
                                        @else
                                            <span class="text-muted">৳ 0.00</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('customers.edit', $customer) }}"
                                            class="btn btn-sm btn-icon btn-text-secondary">
                                            <i class="mdi mdi-pencil-outline"></i>
                                        </a>
                                        <form method="POST" action="{{ route('customers.destroy', $customer) }}"
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
                                    <td colspan="6" class="text-center text-muted py-4">কোনো কাস্টমার নেই।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($customers->hasPages())
                    <div class="card-footer">
                        {{ $customers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
