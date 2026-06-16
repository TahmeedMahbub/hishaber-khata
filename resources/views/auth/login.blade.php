@extends('layouts.guest')

@section('title', t('auth.login'))

@section('auth-content')
    <h4 class="mb-1 pt-2 text-center">{{ t('authpage.login_heading') }}</h4>
    <p class="mb-4 text-center">{{ t('authpage.login_subtitle') }}</p>

    @if (session('show_register_prompt'))
        <div class="alert alert-danger d-flex flex-column align-items-center text-center gap-2" role="alert">
            <div>
                {{ t('authpage.login_register_prompt') }}
            </div>
            <a href="{{ route('register') }}" class="btn btn-sm btn-warning fw-bold">{{ t('authpage.register_now') }}</a>
        </div>
    @elseif ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf

        <div class="mb-3">
            <label for="phone" class="form-label">{{ t('authpage.mobile_or_email') }}</label>
            <input type="text" id="phone" name="phone" class="form-control"
                value="{{ old('phone') }}" placeholder="01XXXXXXXXX / you@example.com" autofocus required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ t('auth.password') }}</label>
            <input type="password" id="password" name="password" class="form-control"
                placeholder="••••••••" required>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check mb-0">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label" for="remember">{{ t('auth.remember_me') }}</label>
            </div>
            <a href="{{ route('password.request') }}" class="small">{{ t('auth.forgot_password') }}</a>
        </div>

        <button class="btn btn-primary d-grid w-100" type="submit">{{ t('authpage.login_btn') }}</button>
    </form>

    <p class="text-center mt-3">
        <span>{{ t('authpage.new_user') }}</span>
        <a href="{{ route('register') }}"><span>{{ t('authpage.create_account') }}</span></a>
    </p>
@endsection
