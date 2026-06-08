@extends('contents.body')

@section('title', 'Due List')

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
                <h4 class="fw-bold mb-0">বাকির খাতা</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('due-payments.history') }}" class="btn btn-outline-secondary">
                        <i class="mdi mdi-history me-1"></i> লেনদেন ইতিহাস
                    </a>
                    <a href="{{ route('due-payments.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-cash-plus me-1"></i> আদায় / পরিশোধ
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
                                <small class="text-muted d-block">কাস্টমারের কাছে পাওনা</small>
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
                                <small class="text-muted d-block">সরবরাহকারীকে দেনা</small>
                                <h5 class="mb-0">৳ {{ number_format($supplierDueTotal, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h5 class="mb-0">বাকি তালিকা</h5>
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('due-payments.index') }}"
                            class="btn {{ !$type ? 'btn-primary' : 'btn-outline-primary' }}">সব</a>
                        <a href="{{ route('due-payments.index', ['type' => 'customer']) }}"
                            class="btn {{ $type === 'customer' ? 'btn-primary' : 'btn-outline-primary' }}">কাস্টমার</a>
                        <a href="{{ route('due-payments.index', ['type' => 'supplier']) }}"
                            class="btn {{ $type === 'supplier' ? 'btn-primary' : 'btn-outline-primary' }}">সরবরাহকারী</a>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>নাম</th>
                                <th>মোবাইল</th>
                                <th>ধরন</th>
                                <th class="text-end">বাকি</th>
                                <th class="text-end">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rows as $row)
                                <tr>
                                    <td class="fw-medium">{{ $row->name }}</td>
                                    <td>{{ $row->phone ?: '—' }}</td>
                                    <td>
                                        @if ($row->party_type === 'customer')
                                            <span class="badge bg-label-success">কাস্টমার</span>
                                        @else
                                            <span class="badge bg-label-warning">সরবরাহকারী</span>
                                        @endif
                                    </td>
                                    <td class="text-end fw-medium text-danger">৳ {{ number_format($row->due, 2) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('due-payments.create', ['party_type' => $row->party_type, 'party_id' => $row->id]) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="mdi mdi-cash"></i>
                                            {{ $row->party_type === 'customer' ? 'আদায়' : 'পরিশোধ' }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">কোনো বাকি নেই।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

