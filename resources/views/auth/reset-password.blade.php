@extends('layouts.guest')

@section('title', t('authpage.reset_title'))

@section('auth-content')
    <div class="text-center mb-3">
        <span class="badge bg-label-primary rounded-circle p-3 mb-3">
            <i class="mdi mdi-lock-reset" style="font-size: 2rem; line-height: 1;"></i>
        </span>
        <h4 class="mb-1">{{ t('authpage.reset_heading') }}</h4>
        <p class="mb-0 text-muted">{{ t('authpage.reset_subtitle') }}</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label for="email" class="form-label">{{ t('auth.email') }}</label>
            <input type="email" id="email" name="email" class="form-control"
                value="{{ old('email', $email) }}" placeholder="email@example.com" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ t('authpage.reset_password') }}</label>
            <input type="password" id="password" name="password" class="form-control"
                placeholder="••••••••" autocomplete="new-password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ t('auth.confirm_password') }}</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                placeholder="••••••••" autocomplete="new-password" required>
        </div>

        <button type="submit" class="btn btn-primary d-grid w-100 mb-3">
            <span><i class="mdi mdi-check-circle-outline me-1"></i>{{ t('authpage.reset_btn') }}</span>
        </button>
    </form>

    <p class="text-center mb-0">
        <a href="{{ route('login') }}"><i class="mdi mdi-chevron-left"></i>{{ t('authpage.back_to_login') }}</a>
    </p>
@endsection
