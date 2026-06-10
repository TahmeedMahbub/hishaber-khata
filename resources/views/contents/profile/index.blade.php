@extends('contents.body')

@section('title', 'Profile')

@section('content')
    @php
        // Decide which tab to show after a redirect-back from validation.
        $activeTab = 'info';
        if ($errors->password->isNotEmpty()) {
            $activeTab = 'password';
        } elseif ($errors->employee->isNotEmpty()) {
            $activeTab = 'employee';
        }
        // All errors across every bag, for the summary alert.
        $allErrors = collect($errors->getBags())->flatMap(fn ($bag) => $bag->all());
    @endphp
    <div class="row gy-4 justify-content-center">
        <div class="col-12 col-lg-10">
            <h4 class="fw-bold mb-3">প্রোফাইল তথ্য পরিবর্তন</h4>

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
                        <i class="mdi mdi-account-outline me-1"></i> তথ্য আপডেট
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'password' ? 'active' : '' }}" data-bs-toggle="tab" href="#tab-password" role="tab" aria-selected="{{ $activeTab === 'password' ? 'true' : 'false' }}">
                        <i class="mdi mdi-lock-outline me-1"></i> পাসওয়ার্ড আপডেট
                    </a>
                </li>
                @if ($user->isOwner() && $tenant)
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab === 'employee' ? 'active' : '' }}" data-bs-toggle="tab" href="#tab-employee" role="tab" aria-selected="{{ $activeTab === 'employee' ? 'true' : 'false' }}">
                            <i class="mdi mdi-account-plus-outline me-1"></i> কর্মচারী যোগ করুন
                        </a>
                    </li>
                @endif
            </ul>

            <div class="tab-content p-0">
                {{-- Info update --}}
                <div class="tab-pane fade {{ $activeTab === 'info' ? 'show active' : '' }}" id="tab-info" role="tabpanel">
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

                                @if ($user->isOwner() && $tenant)
                                    <hr class="my-4">
                                    <h6 class="mb-3"><i class="mdi mdi-store-outline me-1"></i> ব্যবসার তথ্য</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="b_name" class="form-label">ব্যবসার নাম</label>
                                            <input type="text" id="b_name" name="business_name" class="form-control"
                                                value="{{ old('business_name', $tenant->name) }}" required>
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
                                @endif

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
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

                {{-- Add employee (owner only) --}}
                @if ($user->isOwner() && $tenant)
                    <div class="tab-pane fade {{ $activeTab === 'employee' ? 'show active' : '' }}" id="tab-employee" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="mdi mdi-account-plus-outline me-1"></i> নতুন কর্মচারী যোগ করুন</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('settings.employees.store') }}">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="e_name" class="form-label">নাম</label>
                                            <input type="text" id="e_name" name="name" class="form-control"
                                                value="{{ old('name') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="e_role" class="form-label">ভূমিকা</label>
                                            <select id="e_role" name="role" class="form-select" required>
                                                <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>স্টাফ</option>
                                                <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>ম্যানেজার</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="e_phone" class="form-label">ফোন</label>
                                            <input type="text" id="e_phone" name="phone" class="form-control"
                                                value="{{ old('phone') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="e_email" class="form-label">ইমেইল</label>
                                            <input type="email" id="e_email" name="email" class="form-control"
                                                value="{{ old('email') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="e_password" class="form-label">পাসওয়ার্ড</label>
                                            <input type="password" id="e_password" name="password" class="form-control"
                                                autocomplete="new-password" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="e_password_confirmation" class="form-label">পাসওয়ার্ড (পুনরায়)</label>
                                            <input type="password" id="e_password_confirmation" name="password_confirmation"
                                                class="form-control" autocomplete="new-password" required>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary">কর্মচারী যোগ করুন</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="mdi mdi-account-group-outline me-1"></i> বর্তমান কর্মচারী</h6>
                            </div>
                            <div class="table-responsive text-nowrap">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>নাম</th>
                                            <th>ভূমিকা</th>
                                            <th>ফোন</th>
                                            <th>ইমেইল</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($employees as $employee)
                                            <tr>
                                                <td class="fw-medium">{{ $employee->name }}</td>
                                                <td>{{ ucfirst($employee->role) }}</td>
                                                <td>{{ $employee->phone ?? '—' }}</td>
                                                <td>{{ $employee->email ?? '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">কোনো কর্মচারী নেই।</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
