@extends('layouts.guest')

@section('title', t('authpage.forgot_title'))

@section('auth-content')
    <div class="text-center mb-3">
        <span class="badge bg-label-primary rounded-circle p-3 mb-3">
            <i class="mdi mdi-lock-reset" style="font-size: 2rem; line-height: 1;"></i>
        </span>
        <h4 class="mb-1">{{ t('authpage.forgot_heading') }}</h4>
        <p class="mb-0 text-muted">{{ t('authpage.forgot_subtitle') }}</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="mdi mdi-check-circle-outline me-2"></i>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">{{ t('auth.email') }}</label>
            <input type="email" id="email" name="email" class="form-control"
                value="{{ old('email') }}" placeholder="email@example.com" autofocus required>
        </div>

        <button type="submit" class="btn btn-primary d-grid w-100 mb-3">
            <span><i class="mdi mdi-email-send-outline me-1"></i>{{ t('authpage.forgot_btn') }}</span>
        </button>
    </form>

    <p class="text-center mb-0">
        <a href="{{ route('login') }}"><i class="mdi mdi-chevron-left"></i>{{ t('authpage.back_to_login') }}</a>
    </p>
@endsection
