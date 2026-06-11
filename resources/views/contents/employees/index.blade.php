@extends('contents.body')

@section('title', 'Employees')

@section('content')
    @php
        $allErrors = collect($errors->getBags())->flatMap(fn ($bag) => $bag->all());
    @endphp
    <div class="row gy-4 justify-content-center">
        <div class="col-12 col-lg-10">
            <h4 class="fw-bold mb-3">কর্মচারী</h4>

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
    </div>
@endsection
