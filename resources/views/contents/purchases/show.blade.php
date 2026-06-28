@extends('contents.body')

@section('title', t('purchase.voucher'))

@php
    $tenant = optional(auth()->user())->tenant;
    $businessName = optional($tenant)->name ?? config('app.name');
    $businessPhone = optional($tenant)->phone;
    $businessEmail = optional($tenant)->email;
    $itemCount = $purchase->items->count();
    $totalQty = $purchase->items->sum('qty');
    $statusMap = [
        'completed' => ['label' => t('purchase.status_completed'), 'class' => 'inv-badge-success'],
        'draft' => ['label' => t('purchase.status_draft'), 'class' => 'inv-badge-muted'],
        'cancelled' => ['label' => t('sale.status_cancelled'), 'class' => 'inv-badge-danger'],
    ];
    $status = $statusMap[$purchase->status] ?? ['label' => $purchase->status, 'class' => 'inv-badge-muted'];
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
                <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary">
                    <i class="mdi mdi-arrow-left me-1"></i> <span class="btn-label">{{ t('common.back') }}</span>
                </a>
                <div class="d-flex flex-wrap gap-2">                    @php
                        $waPhone = preg_replace('/\D+/', '', optional($purchase->supplier)->phone ?? '');
                        if ($waPhone !== '') {
                            $waPhone = '8801' . substr($waPhone, -9);
                            $waLines = [
                                $businessName,
                                'Voucher #' . $purchase->invoice_no,
                            ];
                            foreach ($purchase->items as $waIndex => $waItem) {
                                $waQty = rtrim(rtrim(number_format($waItem->qty, 2), '0'), '.');
                                $waUnit = optional($waItem->product)->unit;
                                $waLines[] = ($waIndex + 1) . '. '
                                    . ($waItem->product->name ?? '-')
                                    . ' - ' . $waQty . ($waUnit ? $waUnit : '')
                                    . ' -  Tk ' . number_format($waItem->total, 2);
                            }
                            $waLines[] = 'Total: Tk ' . number_format($purchase->total, 2);
                            $waLines[] = 'Paid: Tk ' . number_format($purchase->paid, 2);
                            if ($purchase->due > 0) {
                                $waLines[] = 'Due: Tk ' . number_format($purchase->due, 2);
                            }
                            $waMessage = rawurlencode(implode("\n", $waLines));
                            $waUrl = 'https://wa.me/' . $waPhone . '?text=' . $waMessage;
                        }
                    @endphp
                    @if (!empty($waPhone))
                        <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="btn btn-outline-success">
                            <i class="mdi mdi-whatsapp me-1"></i> <span class="btn-label">{{ t('purchase.whatsapp') }}</span>
                        </a>
                    @endif                    <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-outline-secondary">
                        <i class="mdi mdi-pencil-outline me-1"></i> <span class="btn-label">{{ t('common.edit') }}</span>
                    </a>
                    <a href="{{ route('purchases.create') }}" class="btn btn-outline-primary">
                        <i class="mdi mdi-plus me-1"></i> <span class="btn-label">{{ t('dashboard.new_purchase') }}</span>
                    </a>
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
                        <div class="invoice-title">{{ t('purchase.voucher') }}</div>
                        <div class="invoice-no"># {{ $purchase->invoice_no }}</div>
                        <span class="inv-badge {{ $status['class'] }}">{{ $status['label'] }}</span>
                    </div>
                </div>

                <div class="invoice-meta">
                    <div class="invoice-meta-block">
                        <span class="invoice-meta-label">{{ t('nav.suppliers') }}</span>
                        <span class="invoice-meta-name">{{ $purchase->supplier->name ?? t('purchase.cash_purchase') }}</span>
                        @if (optional($purchase->supplier)->phone)
                            <span class="invoice-meta-sub">{{ $purchase->supplier->phone }}</span>
                        @endif
                        @if (optional($purchase->supplier)->address)
                            <span class="invoice-meta-sub">{{ $purchase->supplier->address }}</span>
                        @endif
                    </div>
                    <div class="invoice-meta-block text-md-end">
                        <div><span class="invoice-meta-label">{{ t('common.date') }}:</span> {{ $purchase->purchase_date->format('d M Y') }}</div>
                        @if ($purchase->user)
                            <div><span class="invoice-meta-label">{{ t('purchase.received_by') }}:</span> {{ $purchase->user->name }}</div>
                        @endif
                    </div>
                </div>

                <div class="invoice-table-wrap">
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th class="col-sl">#</th>
                                <th>{{ t('nav.products') }}</th>
                                <th class="text-end">{{ t('common.quantity') }}</th>
                                <th class="text-end">{{ t('product.purchase_price') }}</th>
                                <th class="text-end">{{ t('common.total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase->items as $item)
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
                        <span>{{ $itemCount }} {{ t('purchase.items_suffix') }}</span>
                        <span>{{ t('purchase.total_qty') }}: {{ rtrim(rtrim(number_format($totalQty, 2), '0'), '.') }}</span>
                    </div>
                    <div class="invoice-totals">
                        <div class="invoice-total-row invoice-total-grand">
                            <span>{{ t('purchase.grand_total') }}</span>
                            <span>৳ {{ number_format($purchase->total, 2) }}</span>
                        </div>
                        <div class="invoice-total-row">
                            <span>{{ t('purchase.paid') }}</span>
                            <span>৳ {{ number_format($purchase->paid, 2) }}</span>
                        </div>
                        @if ($purchase->due > 0)
                            <div class="invoice-total-row invoice-total-due">
                                <span>{{ t('purchase.due') }}</span>
                                <span>৳ {{ number_format($purchase->due, 2) }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($purchase->note)
                    <div class="invoice-note">
                        <strong>{{ t('common.note') }}:</strong> {{ $purchase->note }}
                    </div>
                @endif

                <div class="invoice-foot">
                    <div class="invoice-sign">
                        <span class="invoice-sign-line"></span>
                        <span class="invoice-sign-label">{{ t('purchase.authorized_sign') }}</span>
                    </div>
                    <div class="invoice-thanks">{{ t('purchase.thanks') }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

