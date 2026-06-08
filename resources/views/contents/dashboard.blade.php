@extends('contents.body')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
    <style>
        .dashboard-bottom-nav {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1030;
            display: flex;
            justify-content: space-around;
            background: #fff;
            border-top: 1px solid rgba(0, 0, 0, .08);
            box-shadow: 0 -2px 8px rgba(0, 0, 0, .04);
        }
        .dashboard-bottom-nav a {
            flex: 1;
            padding: .5rem 0;
            text-align: center;
            color: #697a8d;
            text-decoration: none;
            font-size: .7rem;
            line-height: 1.4;
        }
        .dashboard-bottom-nav a .mdi {
            display: block;
            font-size: 1.35rem;
        }
        .dashboard-bottom-nav a.active {
            color: var(--bs-primary, #696cff);
        }
        @media (max-width: 1199.98px) {
            .content-wrapper {
                padding-bottom: 4.5rem;
            }
        }
    </style>

    <div class="dashboard-wrap" id="dashboard">
        {{-- Greeting --}}
        <div class="mb-3">
            <h5 class="mb-0">স্বাগতম, {{ auth()->user()->name }}!</h5>
            <small class="text-muted">আপনার ব্যবসার আজকের চিত্র</small>
        </div>

        {{-- Stat cards (draggable, order persisted in localStorage) --}}
        <div class="row g-3 mb-4" id="dashboard-cards">
            @php
                $cards = [
                    ['key' => 'today_sales',  'label' => 'আজকের বিক্রয়',   'icon' => 'mdi-cart-outline',          'color' => 'primary'],
                    ['key' => 'today_profit', 'label' => 'আজকের লাভ',      'icon' => 'mdi-trending-up',            'color' => 'success'],
                    ['key' => 'cash_balance', 'label' => 'নগদ ব্যালেন্স',   'icon' => 'mdi-cash-multiple',          'color' => 'info'],
                    ['key' => 'customer_due', 'label' => 'কাস্টমার বাকি',   'icon' => 'mdi-account-arrow-left',     'color' => 'warning'],
                    ['key' => 'supplier_due', 'label' => 'সরবরাহকারী বাকি', 'icon' => 'mdi-truck-outline',          'color' => 'danger'],
                    ['key' => 'stock_value',  'label' => 'স্টক মূল্য',       'icon' => 'mdi-package-variant-closed', 'color' => 'secondary'],
                ];
            @endphp
            @foreach ($cards as $card)
                <div class="col-6 col-xl-4 dashboard-card-col" data-widget-id="{{ $card['key'] }}">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center gap-3 p-3">
                            <span class="badge bg-label-{{ $card['color'] }} rounded p-2 drag-handle" style="cursor:grab;">
                                <i class="mdi {{ $card['icon'] }} mdi-24px"></i>
                            </span>
                            <div class="flex-grow-1">
                                <small class="text-muted d-block">{{ $card['label'] }}</small>
                                <h5 class="mb-0 stat-value" data-stat="{{ $card['key'] }}">
                                    <span class="placeholder-glow"><span class="placeholder col-7"></span></span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Quick actions --}}
        <div class="row g-3 mb-4">
            @php
                $actions = [
                    ['label' => 'নতুন বিক্রয়', 'icon' => 'mdi-cart-plus',   'color' => 'primary', 'url' => route('sales.create')],
                    ['label' => 'নতুন ক্রয়',  'icon' => 'mdi-cart-arrow-down', 'color' => 'success', 'url' => route('purchases.create')],
                    ['label' => 'পণ্য যোগ',   'icon' => 'mdi-plus-box',    'color' => 'info',    'url' => route('products.create')],
                    ['label' => 'খরচ যোগ',    'icon' => 'mdi-cash-minus',  'color' => 'warning', 'url' => route('expenses.create')],
                ];
            @endphp
            @foreach ($actions as $action)
                <div class="col-6 col-md-3">
                    <a href="{{ $action['url'] }}"
                        class="btn btn-{{ $action['color'] }} w-100 d-flex flex-column align-items-center justify-content-center gap-1 py-3">
                        <i class="mdi {{ $action['icon'] }} mdi-24px"></i>
                        <span class="small fw-medium">{{ $action['label'] }}</span>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Alerts --}}
        <div class="row g-3 mb-4" id="dashboard-alerts">
            <div class="col-12 col-md-4">
                <div class="alert alert-warning d-flex align-items-center mb-0" role="alert">
                    <i class="mdi mdi-alert-outline me-2"></i>
                    <span>কম স্টক: <strong class="alert-value" data-alert="low_stock_count">…</strong></span>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="alert alert-info d-flex align-items-center mb-0" role="alert">
                    <i class="mdi mdi-account-cash-outline me-2"></i>
                    <span>কাস্টমার বাকি: <strong class="alert-value" data-alert="customer_due_count">…</strong> জন</span>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                    <i class="mdi mdi-truck-alert-outline me-2"></i>
                    <span>সরবরাহকারী বাকি: <strong class="alert-value" data-alert="supplier_due_count">…</strong> জন</span>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Recent sales --}}
            <div class="col-12 col-lg-7">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">সাম্প্রতিক বিক্রয়</h6>
                        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-text-primary p-0">সব দেখুন</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>ইনভয়েস</th>
                                    <th>কাস্টমার</th>
                                    <th class="text-end">মোট</th>
                                </tr>
                            </thead>
                            <tbody id="recent-sales-body">
                                @for ($i = 0; $i < 5; $i++)
                                    <tr class="skeleton-row">
                                        <td><span class="placeholder-glow"><span class="placeholder col-6"></span></span></td>
                                        <td><span class="placeholder-glow"><span class="placeholder col-8"></span></span></td>
                                        <td class="text-end"><span class="placeholder-glow"><span class="placeholder col-5"></span></span></td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Top products --}}
            <div class="col-12 col-lg-5">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="mb-0">টপ সেলিং পণ্য</h6>
                    </div>
                    <ul class="list-group list-group-flush" id="top-products-list">
                        @for ($i = 0; $i < 5; $i++)
                            <li class="list-group-item d-flex justify-content-between align-items-center skeleton-row">
                                <span class="placeholder-glow"><span class="placeholder col-6"></span></span>
                                <span class="placeholder-glow"><span class="placeholder col-3"></span></span>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile bottom navigation --}}
    <nav class="dashboard-bottom-nav d-xl-none">
        <a href="{{ route('dashboard') }}" class="active">
            <i class="mdi mdi-view-dashboard-outline"></i><span>ড্যাশবোর্ড</span>
        </a>
        <a href="{{ route('sales.index') }}">
            <i class="mdi mdi-cart-outline"></i><span>বিক্রয়</span>
        </a>
        <a href="{{ route('products.index') }}">
            <i class="mdi mdi-package-variant-closed"></i><span>পণ্য</span>
        </a>
        <a href="{{ route('reports.index') }}">
            <i class="mdi mdi-chart-box-outline"></i><span>রিপোর্ট</span>
        </a>
        <a href="{{ route('suppliers.index') }}">
            <i class="mdi mdi-dots-horizontal"></i><span>আরও</span>
        </a>
    </nav>
@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/sortablejs/sortable.js') }}"></script>
    <script>
        window.dashboardRoutes = {
            stats: '{{ route('dashboard.stats') }}',
            alerts: '{{ route('dashboard.alerts') }}',
            recentSales: '{{ route('dashboard.recent-sales') }}',
            topProducts: '{{ route('dashboard.top-products') }}',
        };
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endsection

