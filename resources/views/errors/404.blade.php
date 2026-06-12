@extends('errors.layout')

@section('title', t('errors.404_title'))

@section('content')
    <div class="err-icon green">
        <span class="material-icons-round">travel_explore</span>
    </div>

    <div class="err-code en">{{ t('errors.404_code') }}</div>

    <h1 class="err-title">{{ t('errors.404_title') }}</h1>

    <p class="err-message">{{ t('errors.404_message') }}</p>

    <div class="err-actions">
        <a href="{{ url('/') }}" class="btn btn-primary">
            <span class="material-icons-round">home</span>
            {{ t('errors.home') }}
        </a>
        <a href="javascript:history.back()" class="btn btn-ghost">
            <span class="material-icons-round">arrow_back</span>
            {{ t('errors.go_back') }}
        </a>
    </div>
@endsection
