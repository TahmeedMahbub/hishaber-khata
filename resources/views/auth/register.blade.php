@extends('layouts.guest')

@section('title', 'Register Business')

@section('auth-content')
    <h4 class="mb-1 pt-2">ব্যবসা শুরু করুন 🚀</h4>
    <p class="mb-4">কয়েক সেকেন্ডে আপনার হিসাবের খাতা খুলুন।</p>

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
            <label for="business_name" class="form-label">ব্যবসার নাম</label>
            <input type="text" id="business_name" name="business_name" class="form-control"
                value="{{ old('business_name') }}" placeholder="যেমন: রহিম স্টোর" autofocus required>
        </div>

        <div class="mb-3">
            <label for="owner_name" class="form-label">মালিকের নাম</label>
            <input type="text" id="owner_name" name="owner_name" class="form-control"
                value="{{ old('owner_name') }}" placeholder="আপনার নাম" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">মোবাইল নম্বর</label>
            <input type="text" id="phone" name="phone" class="form-control"
                value="{{ old('phone') }}" placeholder="01XXXXXXXXX" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">ইমেইল <span class="text-muted">(ঐচ্ছিক)</span></label>
            <input type="email" id="email" name="email" class="form-control"
                value="{{ old('email') }}" placeholder="email@example.com">
        </div>

        <div class="mb-3">
            <label for="business_type" class="form-label">ব্যবসার ধরন</label>
            <select id="business_type" name="business_type" class="form-select" required>
                <option value="" disabled {{ old('business_type') ? '' : 'selected' }}>নির্বাচন করুন</option>
                @foreach ($businessTypes as $value => $label)
                    <option value="{{ $value }}" {{ old('business_type') === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">পাসওয়ার্ড</label>
            <input type="password" id="password" name="password" class="form-control"
                placeholder="••••••••" required>
        </div>

        <button class="btn btn-primary d-grid w-100" type="submit">একাউন্ট তৈরি করুন</button>
    </form>

    <p class="text-center mt-3">
        <span>আগে থেকেই একাউন্ট আছে?</span>
        <a href="{{ route('login') }}"><span>লগইন করুন</span></a>
    </p>
@endsection
