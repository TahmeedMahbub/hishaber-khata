@extends('contents.body')

@section('title', t('sale_return.receipt'))

@php
    $tenant = optional(auth()->user())->tenant;
    $businessName = optional($tenant)->name ?? config('app.name');
    $businessPhone = optional($tenant)->phone;
    $businessEmail = optional($tenant)->email;
    $itemCount = $return->items->count();
    $totalQty = $return->items->sum('qty');
@endphp

@section('content')
    @include('contents.partials.invoice-style')

    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible d-print-none" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="invoice-toolbar d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 d-print-none">
                <a href="{{ route('sales.show', $return->sale->public_id) }}" class="btn btn-outline-secondary">
                    <i class="mdi mdi-arrow-left me-1"></i> <span class="btn-label">{{ t('sale_return.original_invoice') }}</span>
                </a>
                <div class="d-flex flex-wrap gap-2">
                    <form method="POST" action="{{ route('sale-returns.destroy', $return) }}"
                        onsubmit="return confirm('{{ t('sale_return.delete_confirm') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="mdi mdi-delete-outline me-1"></i> <span class="btn-label">{{ t('common.delete') }}</span>
                        </button>
                    </form>
                    <button type="button" class="btn btn-primary" onclick="window.print()">
                        <i class="mdi mdi-printer me-1"></i> <span class="btn-label">{{ t('common.print') }}</span>
                    </button>
                </div>
            </div>

            <div class="invoice-sheet">
                <div class="invoice-head">
                    <div class="invoice-brand">
                        <h2 class="invoice-business">{{ $businessName }}</h2>
                        <div class="invoice-business-meta">
                            @if ($businessPhone)
                                <span><i class="mdi mdi-phone-outline"></i> {{ $businessPhone }}</span>
                            @endif
                            @if ($businessEmail)
                                <span><i class="mdi mdi-email-outline"></i> {{ $businessEmail }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="invoice-title-box">
                        <div class="invoice-title">{{ t('sale_return.receipt') }}</div>
                        <div class="invoice-no"># {{ $return->return_no }}</div>
                        <span class="inv-badge inv-badge-danger">{{ t('sale_return.returned') }}</span>
                    </div>
                </div>

                <div class="invoice-meta">
                    <div class="invoice-meta-block">
                        <span class="invoice-meta-label">{{ t('sale.customer_label') }}</span>
                        <span class="invoice-meta-name">{{ $return->customer->name ?? t('sale.walkin') }}</span>
                        @if (optional($return->customer)->phone)
                            <span class="invoice-meta-sub">{{ $return->customer->phone }}</span>
                        @endif
                        @if (optional($return->customer)->address)
                            <span class="invoice-meta-sub">{{ $return->customer->address }}</span>
                        @endif
                    </div>
                    <div class="invoice-meta-block text-md-end">
                        <div><span class="invoice-meta-label">{{ t('common.date') }}:</span> {{ $return->return_date->format('d M Y') }}</div>
                        <div><span class="invoice-meta-label">{{ t('sale_return.original_invoice') }}:</span> {{ $return->sale->invoice_no ?? '—' }}</div>
                    </div>
                </div>

                <div class="invoice-table-wrap">
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th class="col-sl">#</th>
                                <th>{{ t('nav.products') }}</th>
                                <th class="text-end">{{ t('common.quantity') }}</th>
                                <th class="text-end">{{ t('sale.price_col') }}</th>
                                <th class="text-end">{{ t('common.total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($return->items as $item)
                                <tr>
                                    <td class="col-sl">{{ $loop->iteration }}</td>
                                    <td>{{ $item->product->name ?? '—' }}</td>
                                    <td class="text-end">{{ rtrim(rtrim(number_format($item->qty, 2), '0'), '.') }}</td>
                                    <td class="text-end">৳ {{ number_format($item->unit_price, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="invoice-summary">
                    <div class="invoice-summary-left">
                        <span>{{ $itemCount }} {{ t('sale.items_suffix') }}</span>
                        <span>{{ t('sale.total_qty') }}: {{ rtrim(rtrim(number_format($totalQty, 2), '0'), '.') }}</span>
                        @if ($return->reason)
                            <div class="mt-1"><strong>{{ t('sale_return.reason') }}:</strong> {{ $return->reason }}</div>
                        @endif
                    </div>
                    <div class="invoice-totals">
                        <div class="invoice-total-row invoice-total-grand">
                            <span>{{ t('sale_return.return_total') }}</span>
                            <span>৳ {{ number_format($return->total, 2) }}</span>
                        </div>
                        @if ($return->refunded > 0)
                            <div class="invoice-total-row">
                                <span>{{ t('sale_return.refunded') }}</span>
                                <span>৳ {{ number_format($return->refunded, 2) }}</span>
                            </div>
                        @endif
                        @if ($return->adjusted_due > 0)
                            <div class="invoice-total-row">
                                <span>{{ t('sale_return.adjusted_due') }}</span>
                                <span>৳ {{ number_format($return->adjusted_due, 2) }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="invoice-foot">
                    <div class="invoice-sign">
                        <span class="invoice-sign-line"></span>
                        <span class="invoice-sign-label">{{ t('sale.authorized_sign') }}</span>
                    </div>
                    <div class="invoice-thanks">{{ t('sale.thanks') }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
