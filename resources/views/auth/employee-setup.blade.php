@extends('layouts.guest')

@section('title', t('authpage.setup_title'))

@section('auth-content')
    <div class="text-center mb-3">
        <span class="badge bg-label-primary rounded-circle p-3 mb-3">
            <i class="mdi mdi-lock-plus-outline" style="font-size: 2rem; line-height: 1;"></i>
        </span>
        <h4 class="mb-1">{{ t('authpage.setup_heading') }}</h4>
        <p class="mb-0 text-muted">{{ t('authpage.setup_subtitle') }}</p>
    </div>

    <div class="alert alert-primary text-center" role="alert">
        <div class="fw-semibold">{{ $employee->name }}</div>
        <div class="small">{{ $employee->email }}</div>
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

    <form method="POST" action="{{ $actionUrl }}">
        @csrf

        <div class="mb-3">
            <label for="password" class="form-label">{{ t('authpage.setup_password') }}</label>
            <input type="password" id="password" name="password" class="form-control"
                placeholder="••••••••" autocomplete="new-password" autofocus required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ t('employee.confirm_password') }}</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                placeholder="••••••••" autocomplete="new-password" required>
        </div>

        <button type="submit" class="btn btn-primary d-grid w-100">
            <span><i class="mdi mdi-check-circle-outline me-1"></i>{{ t('authpage.setup_btn') }}</span>
        </button>
    </form>
@endsection
