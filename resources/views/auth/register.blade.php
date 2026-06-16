@extends('layouts.guest')

@section('title', t('authpage.register_title'))

@section('auth-content')
    <h4 class="mb-1 pt-2">{{ t('authpage.register_heading') }} 🚀</h4>
    <p class="mb-4">{{ t('authpage.register_subtitle') }}</p>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/register') }}">
        @csrf

        <div class="mb-3">
            <label for="business_name" class="form-label">{{ t('authpage.business_name_label') }}</label>
            <input type="text" id="business_name" name="business_name" class="form-control"
                value="{{ old('business_name') }}" placeholder="{{ t('authpage.business_name_ph') }}" autofocus required>
        </div>

        <div class="mb-3">
            <label for="owner_name" class="form-label">{{ t('authpage.owner_name_label') }}</label>
            <input type="text" id="owner_name" name="owner_name" class="form-control"
                value="{{ old('owner_name') }}" placeholder="{{ t('authpage.owner_name_ph') }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">{{ t('authpage.mobile_number') }}</label>
            <input type="text" id="phone" name="phone" class="form-control"
                value="{{ old('phone') }}" placeholder="01XXXXXXXXX" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ t('auth.email') }}</label>
            <input type="email" id="email" name="email" class="form-control"
                value="{{ old('email') }}" placeholder="email@example.com" required>
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

        <div class="mb-3">
            <label for="password" class="form-label">{{ t('auth.password') }}</label>
            <input type="password" id="password" name="password" class="form-control"
                placeholder="••••••••" required>
        </div>

        <button class="btn btn-primary d-grid w-100" type="submit">{{ t('authpage.create_account') }}</button>
    </form>

    <p class="text-center mt-3">
        <span>{{ t('authpage.already_have_account') }}</span>
        <a href="{{ route('login') }}"><span>{{ t('authpage.login_link') }}</span></a>
    </p>
@endsection
