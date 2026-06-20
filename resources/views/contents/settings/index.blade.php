@extends('contents.body')

@section('title', t('nav.settings'))

@section('content')
    @php
        $allErrors = collect($errors->getBags())->flatMap(fn ($bag) => $bag->all());
    @endphp
    {{-- <div class="row gy-4 justify-content-center">
        <div class="col-12 col-lg-10">
            <h4 class="fw-bold mb-3">{{ t('nav.settings') }}  (Coming Soon)</h4>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($allErrors->isNotEmpty())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($allErrors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('settings.preferences') }}">
                @csrf
                @method('PUT')

                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="mdi mdi-cog-outline me-1"></i> {{ t('settings.general') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="currency" class="form-label">{{ t('settings.currency') }}</label>
                                <input type="text" id="currency" name="currency" class="form-control"
                                    value="{{ old('currency', $settings->currency) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="currency_symbol" class="form-label">{{ t('settings.currency_symbol') }}</label>
                                <input type="text" id="currency_symbol" name="currency_symbol" class="form-control"
                                    value="{{ old('currency_symbol', $settings->currency_symbol) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="date_format" class="form-label">{{ t('settings.date_format') }}</label>
                                <input type="text" id="date_format" name="date_format" class="form-control"
                                    value="{{ old('date_format', $settings->date_format) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="invoice_prefix" class="form-label">{{ t('settings.invoice_prefix') }}</label>
                                <input type="text" id="invoice_prefix" name="invoice_prefix" class="form-control"
                                    value="{{ old('invoice_prefix', $settings->invoice_prefix) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="mdi mdi-toggle-switch-outline me-1"></i> {{ t('settings.features') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="track_stock" value="0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="track_stock"
                                        name="track_stock" value="1" {{ old('track_stock', $settings->track_stock) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="track_stock">{{ t('settings.track_stock') }}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="low_stock_alert" value="0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="low_stock_alert"
                                        name="low_stock_alert" value="1" {{ old('low_stock_alert', $settings->low_stock_alert) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="low_stock_alert">{{ t('settings.low_stock_alert') }}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="allow_negative_stock" value="0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="allow_negative_stock"
                                        name="allow_negative_stock" value="1" {{ old('allow_negative_stock', $settings->allow_negative_stock) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="allow_negative_stock">{{ t('settings.allow_negative_stock') }}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="enable_barcode" value="0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="enable_barcode"
                                        name="enable_barcode" value="1" {{ old('enable_barcode', $settings->enable_barcode) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enable_barcode">{{ t('settings.enable_barcode') }}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="show_profit" value="0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="show_profit"
                                        name="show_profit" value="1" {{ old('show_profit', $settings->show_profit) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_profit">{{ t('settings.show_profit') }}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="enable_due" value="0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="enable_due"
                                        name="enable_due" value="1" {{ old('enable_due', $settings->enable_due) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enable_due">{{ t('settings.enable_due') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">{{ t('common.save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}
    <br><br><br><br><br><br><br><br>
    <div class="row text-center">
        <h4 class="fw-bold mb-3">{{ t('nav.settings') }} (Coming Soon)</h4>
    </div>
@endsection
