@extends('contents.body')

@section('title', t('duepay.title'))

@section('content')
    @php
        $rows = collect();
        foreach ($customers as $c) {
            $rows->push((object) [
                'party_type' => 'customer',
                'id'         => $c->id,
                'name'       => $c->name,
                'phone'      => $c->phone,
                'due'        => (float) $c->due_balance,
            ]);
        }
        foreach ($suppliers as $s) {
            $rows->push((object) [
                'party_type' => 'supplier',
                'id'         => $s->id,
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
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h5 class="mb-0">{{ t('duepay.due_list') }}</h5>
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('due-payments.index') }}"
                            class="btn {{ !$type ? 'btn-primary' : 'btn-outline-primary' }}">{{ t('common.all') }}</a>
                        <a href="{{ route('due-payments.index', ['type' => 'customer']) }}"
                            class="btn {{ $type === 'customer' ? 'btn-primary' : 'btn-outline-primary' }}">{{ t('nav.customers') }}</a>
                        <a href="{{ route('due-payments.index', ['type' => 'supplier']) }}"
                            class="btn {{ $type === 'supplier' ? 'btn-primary' : 'btn-outline-primary' }}">{{ t('nav.suppliers') }}</a>
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
                                <tr>
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
                                    <td class="text-end">
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

