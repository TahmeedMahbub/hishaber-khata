@extends('layouts.guest')

@section('title', 'Log In')

@section('auth-content')
    <h4 class="mb-1 pt-2">স্বাগতম! 👋</h4>
    <p class="mb-4">আপনার মোবাইল নম্বর ও পাসওয়ার্ড দিয়ে লগইন করুন।</p>

    @if (session('show_register_prompt'))
        <div class="alert alert-warning d-flex align-items-center justify-content-between flex-wrap gap-2" role="alert">
            <div>
                <i class="mdi mdi-account-alert-outline me-1"></i>
                এই নম্বরে কোনো অ্যাকাউন্ট নেই। অনুগ্রহ করে প্রথমে রেজিস্টার করুন।
            </div>
            <a href="{{ route('register') }}" class="btn btn-sm btn-warning fw-bold">রেজিস্টার করুন</a>
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
            <label for="phone" class="form-label">মোবাইল নম্বর</label>
            <input type="text" id="phone" name="phone" class="form-control"
                value="{{ old('phone') }}" placeholder="01XXXXXXXXX" autofocus required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">পাসওয়ার্ড</label>
            <input type="password" id="password" name="password" class="form-control"
                placeholder="••••••••" required>
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label" for="remember">মনে রাখুন</label>
            </div>
        </div>

        <button class="btn btn-primary d-grid w-100" type="submit">লগইন</button>
    </form>

    <p class="text-center mt-3">
        <span>নতুন ব্যবসা?</span>
        <a href="{{ route('register') }}"><span>একাউন্ট তৈরি করুন</span></a>
    </p>
@endsection
