@extends('contents.body')

@section('title', t('purchase.title'))

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">{{ t('purchase.title') }}</h4>
                <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus me-1"></i> {{ t('dashboard.new_purchase') }}
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
                                class="form-control" placeholder="{{ t('purchase.search_ph') }}">
                        </div>
                        <div class="col-md-2 d-grid">
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="mdi mdi-magnify"></i> {{ t('common.search') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive text-nowrap" style="overflow: visible;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ t('dashboard.invoice') }}</th>
                                <th>{{ t('nav.suppliers') }}</th>
                                <th>{{ t('common.date') }}</th>
                                <th class="text-center">{{ t('purchase.items_col') }}</th>
                                <th class="text-end">{{ t('common.total') }}</th>
                                <th class="text-end">{{ t('purchase.paid') }}</th>
                                <th class="text-end">{{ t('purchase.due') }}</th>
                                <th class="text-end">{{ t('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($purchases as $purchase)
                                <tr style="cursor:pointer" onclick="window.location='{{ route('purchases.show', $purchase) }}'">
                                    <td class="fw-medium">{{ $purchase->invoice_no }}</td>
                                    <td>
                                        {{ $purchase->supplier->name ?? t('purchase.cash_purchase') }}
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
                                            <span class="badge bg-label-success">{{ t('purchase.paid_off') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end" onclick="event.stopPropagation()">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-icon btn-text-secondary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a href="{{ route('purchases.show', $purchase) }}" class="dropdown-item">
                                                        <i class="mdi mdi-eye-outline me-2"></i> {{ t('common.view') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('purchases.edit', $purchase) }}" class="dropdown-item">
                                                        <i class="mdi mdi-pencil-outline me-2"></i> {{ t('common.edit') }}
                                                    </a>
                                                </li>
                                                @if ($purchase->status === 'completed')
                                                    <li>
                                                        <a href="{{ route('purchase-returns.create', $purchase) }}" class="dropdown-item">
                                                            <i class="mdi mdi-undo-variant me-2"></i> {{ t('purchase_return.returned') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('purchase-returns.index', ['search' => $purchase->invoice_no]) }}" class="dropdown-item">
                                                            <i class="mdi mdi-clipboard-text-clock-outline me-2"></i> {{ t('nav.purchase_returns') }}
                                                        </a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a href="{{ route('purchases.show', $purchase) }}" class="dropdown-item" onclick="window.open(this.href); return false;">
                                                        <i class="mdi mdi-printer-outline me-2"></i> {{ t('common.print') }}
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="{{ route('purchases.destroy', $purchase) }}"
                                                        onsubmit="return confirm('{{ t('purchase.delete_confirm_pre') }} {{ $purchase->invoice_no }} {{ t('purchase.delete_confirm_post') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="mdi mdi-delete-outline me-2"></i> {{ t('common.delete') }}
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">{{ t('purchase.empty') }}</td>
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
