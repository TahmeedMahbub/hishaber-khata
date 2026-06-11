@extends('contents.body')

@section('title', 'Invoice')

@php
    $tenant = optional(auth()->user())->tenant;
    $businessName = optional($tenant)->name ?? config('app.name');
    $businessPhone = optional($tenant)->phone;
    $businessEmail = optional($tenant)->email;
    $itemCount = $sale->items->count();
    $totalQty = $sale->items->sum('qty');
    $subtotal = $sale->total + $sale->discount;
    $statusMap = [
        'completed' => ['label' => 'পরিশোধিত', 'class' => 'inv-badge-success'],
        'draft' => ['label' => 'খসড়া', 'class' => 'inv-badge-muted'],
        'cancelled' => ['label' => 'বাতিল', 'class' => 'inv-badge-danger'],
    ];
    $status = $statusMap[$sale->status] ?? ['label' => $sale->status, 'class' => 'inv-badge-muted'];
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
                <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
                    <i class="mdi mdi-arrow-left me-1"></i> <span class="btn-label">ফিরে যান</span>
                </a>
                <div class="d-flex flex-wrap gap-2">                    @php
                        $waPhone = preg_replace('/\D+/', '', optional($sale->customer)->phone ?? '');
                        if ($waPhone !== '') {
                            $waPhone = '8801' . substr($waPhone, -9);
                            $waLines = [
                                $businessName,
                                'Invoice #' . $sale->invoice_no,
                            ];
                            foreach ($sale->items as $waIndex => $waItem) {
                                $waQty = rtrim(rtrim(number_format($waItem->qty, 2), '0'), '.');
                                $waUnit = optional($waItem->product)->unit;
                                $waLines[] = ($waIndex + 1) . '. '
                                    . ($waItem->product->name ?? '-')
                                    . ' - ' . $waQty . ($waUnit ? $waUnit : '')
                                    . ' -  Tk ' . number_format($waItem->total, 2);
                            }
                            if ($sale->discount > 0) {
                                $waLines[] = 'Discount: Tk ' . number_format($sale->discount, 2);
                            }
                            $waLines[] = 'Total: Tk ' . number_format($sale->total, 2);
                            if ($sale->due > 0) {
                                $waLines[] = 'Due: Tk ' . number_format($sale->due, 2);
                            }
                            $waMessage = rawurlencode(implode("\n", $waLines));
                            $waUrl = 'https://wa.me/' . $waPhone . '?text=' . $waMessage;
                        }
                    @endphp
                    @if (!empty($waPhone))
                        <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="btn btn-outline-success">
                            <i class="mdi mdi-whatsapp me-1"></i> <span class="btn-label">হোয়াটসঅ্যাপ</span>
                        </a>
                    @endif                    <a href="{{ route('sales.create') }}" class="btn btn-outline-primary">
                        <i class="mdi mdi-plus me-1"></i> <span class="btn-label">নতুন বিক্রয়</span>
                    </a>
                    <button type="button" class="btn btn-primary" onclick="window.print()">
                        <i class="mdi mdi-printer me-1"></i> <span class="btn-label">প্রিন্ট</span>
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
                        <div class="invoice-title">ইনভয়েস</div>
                        <div class="invoice-no"># {{ $sale->invoice_no }}</div>
                        <span class="inv-badge {{ $status['class'] }}">{{ $status['label'] }}</span>
                    </div>
                </div>

                <div class="invoice-meta">
                    <div class="invoice-meta-block">
                        <span class="invoice-meta-label">গ্রাহক</span>
                        <span class="invoice-meta-name">{{ $sale->customer->name ?? 'ওয়াক-ইন কাস্টমার' }}</span>
                        @if (optional($sale->customer)->phone)
                            <span class="invoice-meta-sub">{{ $sale->customer->phone }}</span>
                        @endif
                        @if (optional($sale->customer)->address)
                            <span class="invoice-meta-sub">{{ $sale->customer->address }}</span>
                        @endif
                    </div>
                    <div class="invoice-meta-block text-md-end">
                        <div><span class="invoice-meta-label">তারিখ:</span> {{ $sale->sale_date->format('d M Y') }}</div>
                        @if ($sale->user)
                            <div><span class="invoice-meta-label">বিক্রয়কর্মী:</span> {{ $sale->user->name }}</div>
                        @endif
                    </div>
                </div>

                <div class="invoice-table-wrap">
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th class="col-sl">#</th>
                                <th>পণ্য</th>
                                <th class="text-end">পরিমাণ</th>
                                <th class="text-end">দাম</th>
                                <th class="text-end">মোট</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sale->items as $item)
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
                        <span>{{ $itemCount }} টি পণ্য</span>
                        <span>মোট পরিমাণ: {{ rtrim(rtrim(number_format($totalQty, 2), '0'), '.') }}</span>
                    </div>
                    <div class="invoice-totals">
                        <div class="invoice-total-row">
                            <span>সাবটোটাল</span>
                            <span>৳ {{ number_format($subtotal, 2) }}</span>
                        </div>
                        @if ($sale->discount > 0)
                            <div class="invoice-total-row">
                                <span>ছাড়</span>
                                <span>− ৳ {{ number_format($sale->discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="invoice-total-row invoice-total-grand">
                            <span>সর্বমোট</span>
                            <span>৳ {{ number_format($sale->total, 2) }}</span>
                        </div>
                        <div class="invoice-total-row">
                            <span>পরিশোধ</span>
                            <span>৳ {{ number_format($sale->paid, 2) }}</span>
                        </div>
                        @if ($sale->due > 0)
                            <div class="invoice-total-row invoice-total-due">
                                <span>বাকি</span>
                                <span>৳ {{ number_format($sale->due, 2) }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($sale->note)
                    <div class="invoice-note">
                        <strong>নোট:</strong> {{ $sale->note }}
                    </div>
                @endif

                <div class="invoice-foot">
                    <div class="invoice-sign">
                        <span class="invoice-sign-line"></span>
                        <span class="invoice-sign-label">কর্তৃপক্ষের স্বাক্ষর</span>
                    </div>
                    <div class="invoice-thanks">কেনাকাটার জন্য ধন্যবাদ</div>
                </div>
            </div>
        </div>
    </div>
@endsection

