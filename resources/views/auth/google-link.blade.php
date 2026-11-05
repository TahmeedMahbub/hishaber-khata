@extends('layouts.guest')

@section('title', t('auth.login'))

@section('auth-content')
    <h4 class="mb-1 pt-2 text-center">{{ t('authpage.google_link_heading') }}</h4>
    <p class="mb-4 text-center">{{ t('authpage.google_link_subtitle') }}</p>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('auth.google.link') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">{{ t('auth.email') }}</label>
            <input type="email" class="form-control" value="{{ $email }}" readonly disabled>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">{{ t('auth.password') }}</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" autofocus required>
        </div>
        <button class="btn btn-primary d-grid w-100" type="submit">{{ t('authpage.google_link_btn') }}</button>
    </form>

    <p class="text-center mt-3"><a href="{{ route('login') }}">{{ t('authpage.login_link') }}</a></p>
@endsection
