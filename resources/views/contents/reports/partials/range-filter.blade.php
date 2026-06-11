{{--
    Shared from/to date range filter.
    Usage: @include('contents.reports.partials.range-filter', ['action' => route(...), 'from' => ..., 'to' => ...])
--}}
<div class="card mb-3 d-print-none">
    <div class="card-body">
        <form method="GET" action="{{ $action }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label mb-1">{{ t('report.from') }}</label>
                <input type="date" name="from" value="{{ $from }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label mb-1">{{ t('report.to') }}</label>
                <input type="date" name="to" value="{{ $to }}" class="form-control">
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary">{{ t('common.view') }}</button>
            </div>
        </form>
    </div>
</div>
