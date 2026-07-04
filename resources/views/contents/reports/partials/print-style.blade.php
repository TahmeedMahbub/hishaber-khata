{{-- Shared report print styling – mirrors the polished look of sales/purchase invoices. --}}
@php
    $tenant = optional(auth()->user())->tenant;
    $businessName = optional($tenant)->name ?? config('app.name');
    $businessPhone = optional($tenant)->phone;
    $businessEmail = optional($tenant)->email;
@endphp

<style>
    /* ===== Report Print Header (visible only in print) ===== */
    .report-print-header {
        display: none;
    }

    /* ===== Report table styling (screen + print) ===== */
    .report-sheet .table {
        border-collapse: collapse;
        font-size: .92rem;
    }

    .report-sheet .table thead th {
        background: #1B8B5A;
        color: #fff;
        font-weight: 600;
        padding: .65rem .75rem;
        white-space: nowrap;
        border: none;
    }

    .report-sheet .table tbody td {
        padding: .6rem .75rem;
        border-bottom: 1px solid #edf0f4;
    }

    .report-sheet .table tbody tr:nth-child(even) td {
        background: #fafbfc;
    }

    .report-sheet .table tfoot td {
        padding: .7rem .75rem;
        border-top: 2px solid #1B8B5A;
        background: #f0faf5;
    }

    /* ===== Summary cards styling for print ===== */
    .report-summary-cards .card {
        border: 1px solid #e6e9ef;
        border-radius: 8px;
    }

    /* ===== Print-only footer ===== */
    .report-print-footer {
        display: none;
    }

    /* ===== Print media rules ===== */
    @media print {
        body {
            font-size: 12pt;
            color: #2f2f3a;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Hide non-essential elements */
        .layout-navbar,
        .layout-menu,
        .layout-footer,
        .content-backdrop,
        .d-print-none,
        .btn,
        .card-body form,
        nav,
        .alert {
            display: none !important;
        }

        /* Remove layout wrapper margins */
        .layout-wrapper,
        .layout-container,
        .layout-page,
        .content-wrapper {
            padding: 0 !important;
            margin: 0 !important;
        }

        .container-xxl,
        .container-fluid {
            padding: 0 !important;
            max-width: 100% !important;
        }

        .col-12, .col-lg-8, .col-xl-8 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding: 0 !important;
        }

        .row {
            margin: 0 !important;
        }

        /* Show print header */
        .report-print-header {
            display: flex !important;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid #1B8B5A;
        }

        .report-print-header .rph-brand h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1B8B5A;
            margin: 0 0 .25rem;
        }

        .report-print-header .rph-brand .rph-meta {
            font-size: .85rem;
            color: #6b7280;
        }

        .report-print-header .rph-title-box {
            text-align: right;
        }

        .report-print-header .rph-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2f2f3a;
        }

        .report-print-header .rph-date {
            font-size: .85rem;
            color: #6b7280;
        }

        /* Summary cards row */
        .report-summary-cards .card {
            border: 1px solid #dde1e7 !important;
            box-shadow: none !important;
            break-inside: avoid;
        }

        .report-summary-cards .card-body {
            padding: .5rem .75rem !important;
        }

        .report-summary-cards h5 {
            font-size: 1rem !important;
        }

        /* Table styles in print */
        .report-sheet .card {
            border: none !important;
            box-shadow: none !important;
        }

        .report-sheet .card-header {
            padding: .5rem 0 !important;
            background: none !important;
            border-bottom: 1px solid #e6e9ef !important;
        }

        .report-sheet .table {
            font-size: 11pt;
        }

        .report-sheet .table thead th {
            background: #1B8B5A !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            padding: .5rem .6rem;
        }

        .report-sheet .table tbody td {
            padding: .45rem .6rem;
        }

        .report-sheet .table tbody tr:nth-child(even) td {
            background: #f8faf9 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .report-sheet .table tfoot td {
            background: #f0faf5 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            border-top: 2px solid #1B8B5A !important;
        }

        /* Print footer */
        .report-print-footer {
            display: flex !important;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            padding-top: .75rem;
            border-top: 1px solid #e6e9ef;
            font-size: .8rem;
            color: #9098a5;
        }

        /* Avoid page breaks inside tables */
        .table-responsive {
            overflow: visible !important;
        }

        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        /* Status colors */
        .text-success { color: #1B8B5A !important; }
        .text-danger { color: #d9534f !important; }
        .text-primary { color: #3b7ddd !important; }
    }
</style>

{{-- Print header (business info + report title) — shown only on print --}}
<div class="report-print-header">
    <div class="rph-brand">
        <h2>{{ $businessName }}</h2>
        <div class="rph-meta">
            @if ($businessPhone)<span><i class="mdi mdi-phone-outline"></i> {{ $businessPhone }}</span><br>@endif
            @if ($businessEmail)<span><i class="mdi mdi-email-outline"></i> {{ $businessEmail }}</span>@endif
        </div>
    </div>
    <div class="rph-title-box">
        <div class="rph-title">{{ $reportTitle ?? '' }}</div>
        <div class="rph-date">{{ $reportDate ?? now()->format('d M Y') }}</div>
    </div>
</div>
