@extends('layouts.guest')

@section('title', t('authpage.verify_title'))

@section('auth-content')
    <div class="text-center mb-3">
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

    {{-- 4-digit verification code entry --}}
    <form method="POST" action="{{ route('verification.code') }}" class="mb-3">
        @csrf
        <div class="mb-3">
            <label for="code" class="form-label">{{ t('authpage.verify_code_label') }}</label>
            <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="4"
                   class="form-control form-control-lg text-center fw-bold @error('code') is-invalid @enderror"
                   id="code" name="code" value="{{ old('code') }}"
                   placeholder="••••" autocomplete="one-time-code" autofocus
                   style="letter-spacing: .6rem; font-size: 1.6rem;">
            @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted d-block mt-1">{{ t('authpage.verify_code_hint') }}</small>
        </div>
        <button type="submit" class="btn btn-primary d-grid w-100">
            <span><i class="mdi mdi-shield-check-outline me-1"></i>{{ t('authpage.verify_code_btn') }}</span>
        </button>
    </form>

    <p class="text-muted small text-center mb-4">{{ t('authpage.verify_spam_note') }}</p>

    <div class="row g-2">
        <div class="col-7">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-outline-primary d-grid w-100 p-2">
                    <span><i class="mdi mdi-email-sync-outline me-1"></i>{{ t('authpage.verify_resend_btn') }}</span>
                </button>
            </form>
        </div>
        <div class="col-5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary d-grid w-100">
                    <span><i class="mdi mdi-logout me-1"></i>{{ t('authpage.verify_logout') }}</span>
                </button>
            </form>
        </div>
    </div>
@endsection


