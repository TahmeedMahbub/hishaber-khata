{{-- Shared invoice styling for sales & purchase printable documents. --}}
<style>
    .invoice-sheet {
        background: #fff;
        border: 1px solid #e6e9ef;
        border-radius: 10px;
        padding: 2rem 2.25rem;
        color: #2f2f3a;
        box-shadow: 0 2px 14px rgba(15, 23, 42, .05);
    }

    .invoice-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        padding-bottom: 1.25rem;
        border-bottom: 2px solid #1B8B5A;
        flex-wrap: wrap;
    }

    .invoice-business {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 .35rem;
        color: #1B8B5A;
    }

    .invoice-business-meta {
        display: flex;
        flex-direction: column;
        gap: .15rem;
        font-size: .85rem;
        color: #6b7280;
    }

    .invoice-business-meta i {
        width: 1rem;
    }

    .invoice-title-box {
        text-align: right;
    }

    .invoice-title {
        font-size: 1.35rem;
        font-weight: 700;
        letter-spacing: .5px;
        color: #2f2f3a;
    }

    .invoice-no {
        font-size: .95rem;
        color: #6b7280;
        margin-bottom: .4rem;
    }

    .inv-badge {
        display: inline-block;
        padding: .2rem .65rem;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 600;
    }

    .inv-badge-success { background: #e3f5ec; color: #1B8B5A; }
    .inv-badge-danger { background: #fdecec; color: #d9534f; }
    .inv-badge-muted { background: #eef0f4; color: #6b7280; }

    .invoice-meta {
        display: flex;
        justify-content: space-between;
        gap: 1.5rem;
        flex-wrap: wrap;
        padding: 1.25rem 0;
    }

    .invoice-meta-block {
        display: flex;
        flex-direction: column;
        gap: .15rem;
        font-size: .9rem;
    }

    .invoice-meta-label {
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .4px;
        color: #9098a5;
    }

    .invoice-meta-name {
        font-size: 1.05rem;
        font-weight: 600;
        color: #2f2f3a;
    }

    .invoice-meta-sub {
        font-size: .85rem;
        color: #6b7280;
    }

    .invoice-table-wrap {
        overflow-x: auto;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .92rem;
    }

    .invoice-table thead th {
        background: #1B8B5A;
        color: #fff;
        font-weight: 600;
        padding: .65rem .75rem;
        text-align: left;
        white-space: nowrap;
    }

    .invoice-table thead th.text-end { text-align: right; }
    .invoice-table .col-sl { width: 3rem; text-align: center; }

    .invoice-table tbody td {
        padding: .6rem .75rem;
        border-bottom: 1px solid #edf0f4;
    }

    .invoice-table tbody tr:nth-child(even) td {
        background: #fafbfc;
    }

    .invoice-summary {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 1.5rem;
        margin-top: 1.25rem;
        flex-wrap: wrap;
    }

    .invoice-summary-left {
        display: flex;
        flex-direction: column;
        gap: .25rem;
        font-size: .85rem;
        color: #6b7280;
    }

    .invoice-totals {
        width: 100%;
        max-width: 19rem;
        margin-left: auto;
    }

    .invoice-total-row {
        display: flex;
        justify-content: space-between;
        padding: .35rem 0;
        font-size: .92rem;
        border-bottom: 1px dashed #e6e9ef;
    }

    .invoice-total-row:last-child { border-bottom: none; }

    .invoice-total-grand {
        font-weight: 700;
        font-size: 1.05rem;
        color: #1B8B5A;
        border-bottom: 2px solid #1B8B5A;
    }

    .invoice-total-due {
        font-weight: 600;
        color: #d9534f;
    }

    .invoice-note {
        margin-top: 1.25rem;
        padding: .75rem 1rem;
        background: #f7f8fa;
        border-left: 3px solid #1B8B5A;
        border-radius: 4px;
        font-size: .9rem;
    }

    .invoice-foot {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 2.5rem;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .invoice-sign {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .35rem;
    }

    .invoice-sign-line {
        display: block;
        width: 11rem;
        border-top: 1px solid #9098a5;
    }

    .invoice-sign-label {
        font-size: .82rem;
        color: #6b7280;
    }

    .invoice-thanks {
        font-size: .9rem;
        font-style: italic;
        color: #1B8B5A;
    }

    @media (max-width: 575.98px) {
        .invoice-toolbar {
            flex-wrap: nowrap !important;
            gap: .4rem !important;
        }

        .invoice-toolbar .btn {
            padding: .35rem .55rem;
            font-size: .8rem;
            line-height: 1;
        }

        .invoice-toolbar .btn i {
            margin: 0 !important;
            font-size: 1rem;
        }

        .invoice-toolbar .btn .btn-label {
            display: none;
        }

        .invoice-sheet {
            padding: 1.1rem 1rem;
            border-radius: 8px;
        }

        .invoice-head {
            flex-direction: column;
            gap: .75rem;
            padding-bottom: 1rem;
        }

        .invoice-business {
            font-size: 1.25rem;
        }

        .invoice-title-box {
            text-align: left;
        }

        .invoice-meta {
            flex-direction: column;
            gap: 1rem;
            padding: 1rem 0;
        }

        .invoice-meta-block.text-md-end {
            text-align: left !important;
        }

        .invoice-table {
            font-size: .82rem;
        }

        .invoice-table thead th,
        .invoice-table tbody td {
            padding: .5rem .5rem;
        }

        .invoice-summary {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }

        .invoice-totals {
            max-width: 100%;
            margin-left: 0;
        }

        .invoice-foot {
            flex-direction: column;
            align-items: stretch;
            gap: 1.25rem;
            margin-top: 1.75rem;
        }

        .invoice-sign-line {
            width: 100%;
        }
    }

    @media print {
        .invoice-sheet {
            border: none;
            border-radius: 0;
            box-shadow: none;
            padding: 0;
            margin: 0 !important;
            page-break-inside: avoid;
        }

        .invoice-table thead th,
        .invoice-total-grand,
        .invoice-business {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .invoice-foot {
            margin-top: 1.25rem;
        }

        .col-lg-9,
        .col-xl-8 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }
    }
</style>
