@extends('contents.body')

@section('title', t('sale_return.title'))

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">{{ t('nav.sale_returns') }}</h4>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <form method="GET" action="{{ route('sale-returns.index') }}" class="row g-2">
                        <div class="col-md-10">
                            <input type="text" name="search" value="{{ $search ?? '' }}"
                                class="form-control" placeholder="{{ t('sale_return.return_no') }} / {{ t('dashboard.invoice') }} / {{ t('nav.customers') }}">
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
                                <th>{{ t('sale_return.return_no') }}</th>
                                <th>{{ t('dashboard.invoice') }}</th>
                                <th>{{ t('nav.customers') }}</th>
                                <th>{{ t('common.date') }}</th>
                                <th class="text-end">{{ t('sale_return.return_total') }}</th>
                                <th class="text-end">{{ t('sale_return.refunded') }}</th>
                                <th class="text-end">{{ t('sale_return.adjusted_due') }}</th>
                                <th class="text-end">{{ t('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($returns as $return)
                                <tr>
                                    <td>{{ $return->return_no }}</td>
                                    <td>
                                        <a href="{{ route('sales.show', $return->sale_id) }}">
                                            {{ $return->sale->invoice_no ?? '-' }}
                                        </a>
                                    </td>
                                    <td>{{ $return->customer->name ?? '-' }}</td>
                                    <td>{{ $return->return_date->format('d M Y') }}</td>
                                    <td class="text-end">{{ number_format($return->total, 2) }}</td>
                                    <td class="text-end">{{ number_format($return->refunded, 2) }}</td>
                                    <td class="text-end">{{ number_format($return->adjusted_due, 2) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('sale-returns.show', $return) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="mdi mdi-eye-outline"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        {{ t('sale_return.none_yet') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($returns->hasPages())
                    <div class="card-footer d-flex justify-content-center">
                        {{ $returns->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
