@extends('contents.body')

@section('title', t('sale.title'))

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">{{ t('sale.title') }}</h4>
                <a href="{{ route('sales.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-cash-register me-1"></i> {{ t('sale.new_pos') }}
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
                                class="form-control" placeholder="{{ t('sale.search_ph') }}">
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
                                <th>{{ t('dashboard.invoice') }}</th>
                                <th>{{ t('nav.customers') }}</th>
                                <th>{{ t('common.date') }}</th>
                                <th class="text-center">{{ t('sale.items_col') }}</th>
                                <th class="text-end">{{ t('common.total') }}</th>
                                <th class="text-end">{{ t('sale.paid') }}</th>
                                <th class="text-end">{{ t('sale.due') }}</th>
                                <th class="text-end">{{ t('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                                <tr>
                                    <td class="fw-medium">{{ $sale->invoice_no }}</td>
                                    <td>{{ $sale->customer->name ?? t('sale.walkin_short') }}</td>
                                    <td>{{ $sale->sale_date->format('d M Y') }}</td>
                                    <td class="text-center">{{ $sale->items_count }}</td>
                                    <td class="text-end">৳ {{ number_format($sale->total, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($sale->paid, 2) }}</td>
                                    <td class="text-end">
                                        @if ($sale->due > 0)
                                            <span class="badge bg-label-danger">৳ {{ number_format($sale->due, 2) }}</span>
                                        @else
                                            <span class="badge bg-label-success">{{ t('sale.paid_off') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('sales.show', $sale) }}"
                                            class="btn btn-sm btn-icon btn-text-secondary">
                                            <i class="mdi mdi-eye-outline"></i>
                                        </a>
                                        <form method="POST" action="{{ route('sales.destroy', $sale) }}"
                                            class="d-inline" data-confirm="{{ t('sale.delete_confirm') }}">
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
                                    <td colspan="8" class="text-center text-muted py-4">{{ t('sale.empty') }}</td>
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
