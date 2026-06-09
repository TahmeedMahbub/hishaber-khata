@extends('contents.body')

@section('title', 'Profile')

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12 col-lg-10">
            <h4 class="fw-bold mb-3">প্রোফাইল ও সেটিংস</h4>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

            {{-- Tabs (anchor style) --}}
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-info" role="tab" aria-selected="true">
                        <i class="mdi mdi-account-outline me-1"></i> তথ্য আপডেট
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-password" role="tab" aria-selected="false">
                        <i class="mdi mdi-lock-outline me-1"></i> পাসওয়ার্ড আপডেট
                    </a>
                </li>
            </ul>

            <div class="tab-content p-0">
                {{-- Info update --}}
                <div class="tab-pane fade show active" id="tab-info" role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="mdi mdi-account-outline me-1"></i> ব্যক্তিগত তথ্য</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div class="avatar avatar-lg me-3">
                                    <span class="avatar-initial rounded-circle bg-label-primary fs-4">
                                        {{ strtoupper(mb_substr($user->name ?? 'U', 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $user->name }}</h5>
                                    <small class="text-muted">{{ ucfirst($user->role ?? 'owner') }}</small>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('settings.profile') }}">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">নাম</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">ফোন</label>
                                        <input type="text" id="phone" name="phone" class="form-control"
                                            value="{{ old('phone', $user->phone) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">ইমেইল</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            value="{{ old('email', $user->email) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">ভূমিকা</label>
                                        <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">প্রোফাইল সংরক্ষণ</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if ($user->isOwner() && $tenant)
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="mdi mdi-store-outline me-1"></i> ব্যবসার তথ্য</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('settings.business') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="b_name" class="form-label">ব্যবসার নাম</label>
                                            <input type="text" id="b_name" name="name" class="form-control"
                                                value="{{ old('name', $tenant->name) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="b_owner" class="form-label">মালিকের নাম</label>
                                            <input type="text" id="b_owner" name="owner_name" class="form-control"
                                                value="{{ old('owner_name', $tenant->owner_name) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="b_phone" class="form-label">ফোন</label>
                                            <input type="text" id="b_phone" name="phone" class="form-control"
                                                value="{{ old('phone', $tenant->phone) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="b_email" class="form-label">ইমেইল</label>
                                            <input type="email" id="b_email" name="email" class="form-control"
                                                value="{{ old('email', $tenant->email) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="b_type" class="form-label">ব্যবসার ধরন</label>
                                            <select id="b_type" name="business_type" class="form-select" required>
                                                @foreach ($businessTypes as $key => $label)
                                                    <option value="{{ $key }}"
                                                        {{ old('business_type', $tenant->business_type) === $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary">ব্যবসার তথ্য সংরক্ষণ</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Password update --}}
                <div class="tab-pane fade" id="tab-password" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('settings.password') }}">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="current_password" class="form-label">বর্তমান পাসওয়ার্ড</label>
                                        <input type="password" id="current_password" name="current_password"
                                            class="form-control" autocomplete="current-password" required>
                                    </div>
                                    <div class="col-md-6 d-none d-md-block"></div>
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">নতুন পাসওয়ার্ড</label>
                                        <input type="password" id="password" name="password" class="form-control"
                                            autocomplete="new-password" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">নতুন পাসওয়ার্ড (পুনরায়)</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control" autocomplete="new-password" required>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">পাসওয়ার্ড পরিবর্তন করুন</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        // Re-open the password tab if its validation failed.
        (function () {
            var hasErr = @json($errors->any());
            if (!hasErr) return;
            var fields = @json(array_keys($errors->messages()));
            var passwordFields = ['current_password', 'password'];
            if (fields.some(function (f) { return passwordFields.indexOf(f) !== -1; })) {
                var link = document.querySelector('[href="#tab-password"]');
                if (link && window.bootstrap) new bootstrap.Tab(link).show();
            }
        })();
    </script>
@endsection
