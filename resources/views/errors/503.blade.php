@extends('errors.layout')

@section('title', t('errors.maint_title'))

@section('content')
    <span class="err-badge">
        <span class="dot"></span>
        {{ t('errors.maint_badge') }}
    </span>

    <div class="err-icon accent">
        <span class="material-icons-round">build_circle</span>
    </div>

    <h1 class="err-title">{{ t('errors.maint_title') }}</h1>

    <p class="err-message">{{ t('errors.maint_message') }}</p>

    <div class="err-actions">
        <a href="javascript:location.reload()" class="btn btn-primary">
            <span class="material-icons-round">refresh</span>
            {{ t('errors.maint_refresh') }}
        </a>
    </div>
@endsection
