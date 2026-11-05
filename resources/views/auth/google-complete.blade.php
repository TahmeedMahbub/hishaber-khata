@extends('layouts.guest')

@section('title', t('authpage.register_title'))

@section('auth-content')
    <h4 class="mb-1 pt-2">{{ t('authpage.google_complete_heading') }}</h4>
    <p class="mb-4">{{ t('authpage.google_complete_subtitle') }}</p>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('auth.google.complete') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">{{ t('auth.email') }}</label>
            <input type="email" id="email" class="form-control" value="{{ $google['email'] }}" readonly disabled>
        </div>

        <div class="mb-3">
            <label for="business_name" class="form-label">{{ t('authpage.business_name_label') }}</label>
            <input type="text" id="business_name" name="business_name" class="form-control"
                value="{{ old('business_name', $defaultBusinessName) }}" placeholder="{{ t('authpage.business_name_ph') }}" autofocus required>
        </div>

        <div class="mb-3">
            <label for="owner_name" class="form-label">{{ t('authpage.owner_name_label') }}</label>
            <input type="text" id="owner_name" name="owner_name" class="form-control"
                value="{{ old('owner_name', $google['name']) }}" placeholder="{{ t('authpage.owner_name_ph') }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">{{ t('authpage.mobile_number') }}</label>
            <input type="text" id="phone" name="phone" class="form-control"
                value="{{ old('phone') }}" placeholder="01XXXXXXXXX" required>
        </div>

        <div class="mb-3">
            <label for="business_type" class="form-label">{{ t('authpage.business_type_label') }}</label>
            <select id="business_type" name="business_type" class="form-select" required>
                <option value="" disabled {{ old('business_type') ? '' : 'selected' }}>{{ t('common.select') }}</option>
                @foreach ($businessTypes as $value => $label)
                    <option value="{{ $value }}" {{ old('business_type') === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary d-grid w-100" type="submit">{{ t('authpage.google_complete_btn') }}</button>
    </form>

    <p class="text-center mt-3">
        <a href="{{ route('login') }}">{{ t('authpage.login_link') }}</a>
    </p>
@endsection
