@extends('contents.body')

@section('title', t('nav.reports'))

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">{{ t('nav.reports') }}</h4>
            </div>

            {{-- Phase 1 --}}
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">{{ t('report.phase1') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            [t('report.daily_sales'), 'mdi-calendar-today', 'reports.daily-sales'],
                            [t('report.monthly_sales'), 'mdi-calendar-month', 'reports.monthly-sales'],
                            [t('report.purchase'), 'mdi-cart-arrow-down', 'reports.purchases'],
                            [t('report.stock'), 'mdi-package-variant-closed', 'reports.stock'],
                            [t('report.low_stock'), 'mdi-package-variant-remove', 'reports.low-stock'],
                            [t('report.customer_due'), 'mdi-account-cash', 'reports.customer-due'],
                            [t('report.supplier_due'), 'mdi-truck-cargo-container', 'reports.supplier-due'],
                            [t('report.expense'), 'mdi-cash-minus', 'reports.expenses'],
                            [t('report.cash_book'), 'mdi-book-open-variant', 'reports.cash-book'],
                            [t('report.profit_loss'), 'mdi-chart-line', 'reports.profit-loss'],
                        ] as $report)
                            <div class="col-md-6 col-lg-4">
                                <a href="{{ route($report[2]) }}"
                                    class="border rounded p-3 h-100 d-flex align-items-center text-body text-decoration-none report-link">
                                    <i class="mdi {{ $report[1] }} mdi-24px text-primary me-3"></i>
                                    <span class="fw-medium">{{ $report[0] }}</span>
                                    <i class="mdi mdi-chevron-right ms-auto text-muted"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Phase 2 --}}
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">{{ t('report.phase2') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            [t('report.profit_by_product'), 'mdi-tag-text-outline'],
                            [t('report.stock_ledger'), 'mdi-clipboard-list-outline'],
                            [t('report.customer_ledger'), 'mdi-account-details'],
                            [t('report.supplier_ledger'), 'mdi-account-tie'],
                            [t('report.top_selling'), 'mdi-trophy-outline'],
                        ] as $report)
                            <div class="col-md-6 col-lg-4">
                                <div class="border rounded p-3 h-100 d-flex align-items-center">
                                    <i class="mdi {{ $report[1] }} mdi-24px text-info me-3"></i>
                                    <span class="fw-medium">{{ $report[0] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Phase 3 --}}
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">{{ t('report.phase3') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            [t('report.business_health'), 'mdi-heart-pulse'],
                            [t('report.ai_insights'), 'mdi-robot-outline'],
                            [t('report.forecasting'), 'mdi-chart-timeline-variant'],
                        ] as $report)
                            <div class="col-md-6 col-lg-4">
                                <div class="border rounded p-3 h-100 d-flex align-items-center">
                                    <i class="mdi {{ $report[1] }} mdi-24px text-warning me-3"></i>
                                    <span class="fw-medium">{{ $report[0] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
