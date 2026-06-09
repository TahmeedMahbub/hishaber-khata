@extends('contents.body')

@section('title', 'Reports')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">রিপোর্ট</h4>
            </div>

            {{-- Phase 1 --}}
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">ফেজ ১</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['ডেইলি সেলস রিপোর্ট', 'mdi-calendar-today', 'reports.daily-sales'],
                            ['মাসিক সেলস রিপোর্ট', 'mdi-calendar-month', 'reports.monthly-sales'],
                            ['ক্রয় রিপোর্ট', 'mdi-cart-arrow-down', 'reports.purchases'],
                            ['বর্তমান স্টক রিপোর্ট', 'mdi-package-variant-closed', 'reports.stock'],
                            ['কম স্টক রিপোর্ট', 'mdi-package-variant-remove', 'reports.low-stock'],
                            ['কাস্টমার বাকি রিপোর্ট', 'mdi-account-cash', 'reports.customer-due'],
                            ['সরবরাহকারী বাকি রিপোর্ট', 'mdi-truck-cargo-container', 'reports.supplier-due'],
                            ['খরচ রিপোর্ট', 'mdi-cash-minus', 'reports.expenses'],
                            ['ক্যাশ বুক রিপোর্ট', 'mdi-book-open-variant', 'reports.cash-book'],
                            ['লাভ ও ক্ষতি রিপোর্ট', 'mdi-chart-line', 'reports.profit-loss'],
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
                    <h5 class="mb-0">ফেজ ২</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['পণ্য অনুযায়ী লাভ', 'mdi-tag-text-outline'],
                            ['স্টক লেজার', 'mdi-clipboard-list-outline'],
                            ['কাস্টমার লেজার', 'mdi-account-details'],
                            ['সরবরাহকারী লেজার', 'mdi-account-tie'],
                            ['টপ সেলিং পণ্য', 'mdi-trophy-outline'],
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
                    <h5 class="mb-0">ফেজ ৩</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['বিজনেস হেলথ', 'mdi-heart-pulse'],
                            ['এআই ইনসাইটস', 'mdi-robot-outline'],
                            ['ফোরকাস্টিং', 'mdi-chart-timeline-variant'],
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
