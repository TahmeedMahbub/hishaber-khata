@extends('layouts.guest')

@section('title', t('authpage.verify_title'))

@section('auth-content')
    <div class="text-center mb-3">
        <span class="badge bg-label-primary rounded-circle p-3 mb-3">
            <i class="mdi mdi-email-check-outline" style="font-size: 2rem; line-height: 1;"></i>
        </span>
        <h4 class="mb-1">{{ t('authpage.verify_heading') }}</h4>
        <p class="mb-0 text-muted">{{ t('authpage.verify_subtitle') }}</p>
    </div>

    <div class="alert alert-primary text-center" role="alert">
        <strong>{{ auth()->user()->email }}</strong>
    </div>

    @if (session('status') === 'verification-link-sent')
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="mdi mdi-check-circle-outline me-2"></i>
            <span>{{ t('authpage.verify_resent') }}</span>
        </div>
    @endif

    <p class="text-muted small text-center mb-4">{{ t('authpage.verify_spam_note') }}</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary d-grid w-100 mb-3">
            <span><i class="mdi mdi-email-sync-outline me-1"></i>{{ t('authpage.verify_resend_btn') }}</span>
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="text-center">
        @csrf
        <button type="submit" class="btn btn-link p-0">{{ t('authpage.verify_logout') }}</button>
    </form>
@endsection


