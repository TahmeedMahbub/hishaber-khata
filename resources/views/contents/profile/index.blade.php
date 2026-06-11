@extends('contents.body')

@section('title', t('nav.profile'))

@section('content')
    @php
        // Decide which tab to show after a redirect-back from validation.
        $activeTab = $errors->password->isNotEmpty() ? 'password' : 'info';
        // All errors across every bag, for the summary alert.
        $allErrors = collect($errors->getBags())->flatMap(fn ($bag) => $bag->all());
    @endphp
    <div class="row gy-4 justify-content-center">
        <div class="col-12 col-lg-10">
            <h4 class="fw-bold mb-3">{{ t('nav.profile_edit') }}</h4>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($allErrors->isNotEmpty())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($allErrors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Tabs (anchor style) --}}
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'info' ? 'active' : '' }}" data-bs-toggle="tab" href="#tab-info" role="tab" aria-selected="{{ $activeTab === 'info' ? 'true' : 'false' }}">
                        <i class="mdi mdi-account-outline me-1"></i> {{ t('profile.tab_info') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'password' ? 'active' : '' }}" data-bs-toggle="tab" href="#tab-password" role="tab" aria-selected="{{ $activeTab === 'password' ? 'true' : 'false' }}">
                        <i class="mdi mdi-lock-outline me-1"></i> {{ t('profile.tab_password') }}
                    </a>
                </li>
            </ul>

            <div class="tab-content p-0">
                {{-- Info update --}}
                <div class="tab-pane fade {{ $activeTab === 'info' ? 'show active' : '' }}" id="tab-info" role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="mdi mdi-account-outline me-1"></i> {{ t('profile.personal_info') }}</h6>
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
                                        <label for="name" class="form-label">{{ t('common.name') }}</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">{{ t('common.phone') }}</label>
                                        <input type="text" id="phone" name="phone" class="form-control"
                                            value="{{ old('phone', $user->phone) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">{{ t('common.email') }}</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            value="{{ old('email', $user->email) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ t('common.role') }}</label>
                                        <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                                    </div>
                                </div>

                                @if ($user->isOwner() && $tenant)
                                    <hr class="my-4">
                                    <h6 class="mb-3"><i class="mdi mdi-store-outline me-1"></i> {{ t('profile.business_info') }}</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="b_name" class="form-label">{{ t('profile.business_name') }}</label>
                                            <input type="text" id="b_name" name="business_name" class="form-control"
                                                value="{{ old('business_name', $tenant->name) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="b_type" class="form-label">{{ t('profile.business_type') }}</label>
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
                                @endif

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">{{ t('common.save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Password update --}}
                <div class="tab-pane fade {{ $activeTab === 'password' ? 'show active' : '' }}" id="tab-password" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('settings.password') }}">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="current_password" class="form-label">{{ t('profile.current_password') }}</label>
                                        <input type="password" id="current_password" name="current_password"
                                            class="form-control" autocomplete="current-password" required>
                                    </div>
                                    <div class="col-md-6 d-none d-md-block"></div>
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">{{ t('profile.new_password') }}</label>
                                        <input type="password" id="password" name="password" class="form-control"
                                            autocomplete="new-password" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">{{ t('profile.confirm_new_password') }}</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control" autocomplete="new-password" required>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">{{ t('profile.change_password_btn') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
