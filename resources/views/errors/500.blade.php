@extends('errors.layout')

@section('title', t('errors.500_title'))

@section('content')
    <div class="err-icon red">
        <span class="material-icons-round">error_outline</span>
    </div>

    <div class="err-code en">{{ t('errors.500_code') }}</div>

    <h1 class="err-title">{{ t('errors.500_title') }}</h1>

    <p class="err-message">{{ t('errors.500_message') }}</p>

    <div class="err-actions">
        <a href="{{ url('/') }}" class="btn btn-primary">
            <span class="material-icons-round">home</span>
            {{ t('errors.home') }}
        </a>
        <a href="javascript:location.reload()" class="btn btn-ghost">
            <span class="material-icons-round">refresh</span>
            {{ t('errors.maint_refresh') }}
        </a>
    </div>
@endsection
