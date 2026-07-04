@extends('contents.body')

@section('title', t('customer.title'))

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">{{ t('customer.title') }}</h4>
                <a href="{{ route('customers.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus me-1"></i> {{ t('customer.new') }}
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
                                class="form-control" placeholder="{{ t('customer.search_ph') }}">
                        </div>
                        <div class="col-md-2 d-grid">
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="mdi mdi-magnify"></i> {{ t('common.search') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ t('common.name') }}</th>
                                <th>{{ t('customer.mobile') }}</th>
                                <th class="text-end">{{ t('customer.orders') }}</th>
                                <th class="text-end">{{ t('customer.sales') }}</th>
                                <th class="text-end">{{ t('customer.due') }}</th>
                                <th class="text-end">{{ t('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $customer)
                                <tr style="cursor:pointer" onclick="window.location='{{ route('customers.edit', $customer) }}'">
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
                                    <td class="text-end" onclick="event.stopPropagation()">
                                        <a href="{{ route('customers.edit', $customer) }}"
                                            class="btn btn-sm btn-icon btn-text-secondary">
                                            <i class="mdi mdi-pencil-outline"></i>
                                        </a>
                                        <form method="POST" action="{{ route('customers.destroy', $customer) }}"
                                            class="d-inline" data-confirm="{{ t('common.are_you_sure') }}">
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
                                    <td colspan="6" class="text-center text-muted py-4">{{ t('customer.empty') }}</td>
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
