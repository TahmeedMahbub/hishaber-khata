@extends('contents.body')

@section('title', t('duepay.title'))

@section('content')
    <style>
        @media (min-width: 992px) {
            .duepay-search {
                width: auto !important;
                max-width: 360px;
            }
        }

        .duepay-filter .btn {
            padding-left: 8px;
            padding-right: 8px;
        }
    </style>
    @php
        $rows = collect();
        foreach ($customers as $c) {
            $rows->push((object) [
                'party_type' => 'customer',
                'id'         => $c->public_id,
                'name'       => $c->name,
                'phone'      => $c->phone,
                'due'        => (float) $c->due_balance,
            ]);
        }
        foreach ($suppliers as $s) {
            $rows->push((object) [
                'party_type' => 'supplier',
                'id'         => $s->public_id,
                'name'       => $s->name,
                'phone'      => $s->phone,
                'due'        => (float) $s->due_balance,
            ]);
        }
        $rows = $rows->sortByDesc('due')->values();
    @endphp

    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <h4 class="fw-bold mb-0">{{ t('duepay.title') }}</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('due-payments.history') }}" class="btn btn-outline-secondary">
                        <i class="mdi mdi-history me-1"></i> {{ t('duepay.history') }}
                    </a>
                    <a href="{{ route('due-payments.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-cash-plus me-1"></i> {{ t('duepay.collect_pay') }}
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Summary cards --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <span class="badge bg-label-success rounded p-2 me-3">
                                <i class="mdi mdi-account-arrow-down mdi-24px"></i>
                            </span>
                            <div>
                                <small class="text-muted d-block">{{ t('duepay.receivable') }}</small>
                                <h5 class="mb-0">৳ {{ number_format($customerDueTotal, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <span class="badge bg-label-warning rounded p-2 me-3">
                                <i class="mdi mdi-account-arrow-up mdi-24px"></i>
                            </span>
                            <div>
                                <small class="text-muted d-block">{{ t('duepay.payable') }}</small>
                                <h5 class="mb-0">৳ {{ number_format($supplierDueTotal, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <h5 class="mb-0 order-1">{{ t('duepay.due_list') }}</h5>

                        <form method="GET" action="{{ route('due-payments.index') }}"
                            class="duepay-search order-3 order-lg-2 w-100 ms-lg-auto" role="search">
                            @if ($type)
                                <input type="hidden" name="type" value="{{ $type }}">
                            @endif
                            <div class="input-group input-group-sm">
                                <input type="text" name="q" class="form-control" value="{{ $search }}"
                                    placeholder="{{ t('duepay.search_ph') }}" aria-label="{{ t('duepay.search_ph') }}">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="mdi mdi-magnify"></i>
                                </button>
                                @if ($search !== '')
                                    <a href="{{ route('due-payments.index', $type ? ['type' => $type] : []) }}"
                                        class="btn btn-outline-secondary">
                                        <i class="mdi mdi-close"></i>
                                    </a>
                                @endif
                            </div>
                        </form>

                        <div class="btn-group btn-group-sm duepay-filter order-2 order-lg-3 ms-auto ms-lg-0" role="group">
                            <a href="{{ route('due-payments.index', $search !== '' ? ['q' => $search] : []) }}"
                                class="btn {{ !$type ? 'btn-primary' : 'btn-outline-primary' }}">{{ t('common.all') }}</a>
                            <a href="{{ route('due-payments.index', array_filter(['type' => 'customer', 'q' => $search ?: null])) }}"
                                class="btn {{ $type === 'customer' ? 'btn-primary' : 'btn-outline-primary' }}">{{ t('nav.customers') }}</a>
                            <a href="{{ route('due-payments.index', array_filter(['type' => 'supplier', 'q' => $search ?: null])) }}"
                                class="btn {{ $type === 'supplier' ? 'btn-primary' : 'btn-outline-primary' }}">{{ t('nav.suppliers') }}</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ t('common.name') }}</th>
                                <th>{{ t('supplier.mobile') }}</th>
                                <th>{{ t('duepay.type') }}</th>
                                <th class="text-end">{{ t('duepay.due') }}</th>
                                <th class="text-end">{{ t('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rows as $row)
                                <tr style="cursor:pointer" onclick="window.location='{{ route('due-payments.create', ['party_type' => $row->party_type, 'party_id' => $row->id]) }}'">
                                    <td class="fw-medium">{{ $row->name }}</td>
                                    <td>{{ $row->phone ?: '—' }}</td>
                                    <td>
                                        @if ($row->party_type === 'customer')
                                            <span class="badge bg-label-success">{{ t('nav.customers') }}</span>
                                        @else
                                            <span class="badge bg-label-warning">{{ t('nav.suppliers') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end fw-medium text-danger">৳ {{ number_format($row->due, 2) }}</td>
                                    <td class="text-end" onclick="event.stopPropagation()">
                                        <a href="{{ route('due-payments.create', ['party_type' => $row->party_type, 'party_id' => $row->id]) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="mdi mdi-cash"></i>
                                            {{ $row->party_type === 'customer' ? t('duepay.collect') : t('duepay.pay') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">{{ t('duepay.empty') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

