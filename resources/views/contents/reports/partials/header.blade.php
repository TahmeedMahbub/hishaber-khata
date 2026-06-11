{{--
    Shared report page header: back link, title, and print button.
    Usage: @include('contents.reports.partials.header', ['title' => '...'])
--}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('reports.index') }}" class="btn btn-sm btn-icon btn-outline-secondary d-print-none">
            <i class="mdi mdi-arrow-left"></i>
        </a>
        <h4 class="fw-bold mb-0">{{ $title }}</h4>
    </div>
    <button type="button" class="btn btn-sm btn-outline-primary d-print-none" onclick="window.print()">
        <i class="mdi mdi-printer me-1"></i> {{ t('common.print') }}
    </button>
</div>
