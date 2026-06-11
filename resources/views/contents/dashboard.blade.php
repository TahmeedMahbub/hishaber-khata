@extends('contents.body')

@section('title', 'Dashboard')

@section('content')
    <style>
        /* Shrink + mute the decimal/cents part of stat values */
        .stat-value .stat-cents {
            font-size: .7em;
            font-weight: 400;
            opacity: .55;
        }
        /* Tighter stat cards on mobile: ~50% less horizontal padding & gap */
        @media (max-width: 575.98px) {
            .dashboard-stat-body {
                padding-left: .5rem !important;
                padding-right: .5rem !important;
                gap: .5rem !important;
            }
            .stat-value {
                font-size: 1rem;
                white-space: nowrap;
            }
        }
    </style>
    <div class="dashboard-wrap" id="dashboard">

        {{-- Stat cards (draggable, order persisted in localStorage) --}}
        <div class="row g-3 mb-4" id="dashboard-cards">
            @php
                $cards = [
                    ['key' => 'today_sales',  'label' => t('dashboard.today_sales'),   'icon' => 'mdi-cart-outline',          'color' => 'primary'],
                    ['key' => 'today_profit', 'label' => t('dashboard.today_profit'),      'icon' => 'mdi-trending-up',            'color' => 'success'],
                    ['key' => 'cash_balance', 'label' => t('dashboard.cash_balance'),   'icon' => 'mdi-cash-multiple',          'color' => 'info'],
                    ['key' => 'customer_due', 'label' => t('dashboard.customer_due'),   'icon' => 'mdi-account-arrow-left',     'color' => 'warning'],
                    ['key' => 'supplier_due', 'label' => t('dashboard.supplier_due'), 'icon' => 'mdi-truck-outline',          'color' => 'danger'],
                    ['key' => 'stock_value',  'label' => t('dashboard.stock_value'),       'icon' => 'mdi-package-variant-closed', 'color' => 'secondary'],
                ];
            @endphp
            @foreach ($cards as $card)
                <div class="col-6 col-xl-4 dashboard-card-col" data-widget-id="{{ $card['key'] }}">
                    <div class="card h-100">
                        <div class="card-body dashboard-stat-body d-flex align-items-center gap-3 p-3">
                            <span class="badge bg-label-{{ $card['color'] }} rounded p-2 drag-handle" style="cursor:grab;">
                                <i class="mdi {{ $card['icon'] }} mdi-24px"></i>
                            </span>
                            <div class="text-dark flex-grow-1">
                                <small class=" d-block">{{ $card['label'] }}</small>
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
                    ['label' => t('dashboard.new_sale'), 'icon' => 'mdi-cart-plus',   'color' => 'primary', 'url' => route('sales.create')],
                    ['label' => t('dashboard.new_purchase'),  'icon' => 'mdi-cart-arrow-down', 'color' => 'success', 'url' => route('purchases.create')],
                    ['label' => t('dashboard.add_product'),   'icon' => 'mdi-plus-box',    'color' => 'info',    'url' => route('products.create')],
                    ['label' => t('dashboard.add_expense'),    'icon' => 'mdi-cash-minus',  'color' => 'warning', 'url' => route('expenses.create')],
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
                    <span>{{ t('dashboard.low_stock') }}: <strong class="alert-value" data-alert="low_stock_count">…</strong></span>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="alert alert-info d-flex align-items-center mb-0" role="alert">
                    <i class="mdi mdi-account-cash-outline me-2"></i>
                    <span>{{ t('dashboard.customer_due') }}: <strong class="alert-value" data-alert="customer_due_count">…</strong> {{ t('dashboard.persons') }}</span>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                    <i class="mdi mdi-truck-alert-outline me-2"></i>
                    <span>{{ t('dashboard.supplier_due') }}: <strong class="alert-value" data-alert="supplier_due_count">…</strong> {{ t('dashboard.persons') }}</span>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Recent sales --}}
            <div class="col-12 col-lg-7">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">{{ t('dashboard.recent_sales') }}</h6>
                        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-text-primary p-0">{{ t('common.view_all') }}</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>{{ t('dashboard.invoice') }}</th>
                                    <th>{{ t('nav.customers') }}</th>
                                    <th class="text-end">{{ t('common.total') }}</th>
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
                        <h6 class="mb-0">{{ t('dashboard.top_products') }}</h6>
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

