@extends('contents.body')

@section('title', t('nav.employees'))

@section('content')
    @php
        $allErrors = collect($errors->getBags())->flatMap(fn ($bag) => $bag->all());
        $openModal = old('name') !== null || $errors->employee->isNotEmpty();
    @endphp
    <div class="row gy-4 justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">{{ t('nav.employees') }}</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                    <i class="mdi mdi-account-plus-outline me-1"></i> {{ t('employee.add_new') }}
                </button>
            </div>

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

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="mdi mdi-account-group-outline me-1"></i> {{ t('employee.current') }}</h6>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>{{ t('common.name') }}</th>
                                <th>{{ t('common.role') }}</th>
                                <th>{{ t('common.phone') }}</th>
                                <th>{{ t('common.email') }}</th>
                                <th>{{ t('common.status') }}</th>
                                <th class="text-end">{{ t('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee)
                                <tr>
                                    <td class="fw-medium">{{ $employee->name }}</td>
                                    <td>{{ ucfirst($employee->role) }}</td>
                                    <td>{{ $employee->phone ?? '—' }}</td>
                                    <td>{{ $employee->email ?? '—' }}</td>
                                    <td>
                                        @if (is_null($employee->email_verified_at))
                                            <span class="badge bg-label-warning">{{ t('employee.pending') }}</span>
                                        @elseif ($employee->status === 'active')
                                            <span class="badge bg-label-success">{{ t('common.active') }}</span>
                                        @else
                                            <span class="badge bg-label-secondary">{{ t('common.inactive') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if (is_null($employee->email_verified_at))
                                            <form method="POST" action="{{ route('settings.employees.resend', $employee) }}"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    <i class="mdi mdi-email-sync-outline me-1"></i> {{ t('employee.resend_invite') }}
                                                </button>
                                            </form>
                                        @elseif ($employee->status === 'active')
                                            <form method="POST" action="{{ route('settings.employees.toggle', $employee) }}"
                                                class="d-inline"
                                                data-confirm="{{ t('employee.deactivate_confirm') }}"
                                                data-confirm-title="{{ t('employee.deactivate') }}"
                                                data-confirm-icon="mdi mdi-account-off-outline"
                                                data-confirm-variant="danger"
                                                data-confirm-process="{{ t('employee.deactivate') }}"
                                                data-confirm-process-class="btn-danger">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="mdi mdi-account-off-outline me-1"></i> {{ t('employee.deactivate') }}
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('settings.employees.toggle', $employee) }}"
                                                class="d-inline"
                                                data-confirm="{{ t('employee.activate_confirm') }}"
                                                data-confirm-title="{{ t('employee.activate') }}"
                                                data-confirm-icon="mdi mdi-account-check-outline"
                                                data-confirm-variant="success"
                                                data-confirm-process="{{ t('employee.activate') }}"
                                                data-confirm-process-class="btn-success">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-success">
                                                    <i class="mdi mdi-account-check-outline me-1"></i> {{ t('employee.activate') }}
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">{{ t('employee.empty') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Add employee modal --}}
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('settings.employees.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="mdi mdi-account-plus-outline me-1"></i> {{ t('employee.add_new') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="e_name" class="form-label">{{ t('common.name') }}</label>
                                <input type="text" id="e_name" name="name" class="form-control"
                                    value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="e_role" class="form-label">{{ t('common.role') }}</label>
                                <select id="e_role" name="role" class="form-select" required>
                                    <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>{{ t('employee.role_staff') }}</option>
                                    <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>{{ t('employee.role_manager') }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="e_phone" class="form-label">{{ t('common.phone') }}</label>
                                <input type="text" id="e_phone" name="phone" class="form-control"
                                    value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="e_email" class="form-label">{{ t('common.email') }}</label>
                                <input type="email" id="e_email" name="email" class="form-control"
                                    value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="alert alert-info d-flex align-items-center mt-3 mb-0" role="alert">
                            <i class="mdi mdi-email-fast-outline me-2"></i>
                            <span>{{ t('employee.invite_note') }}</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ t('common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ t('employee.add_btn') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($openModal)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var modalEl = document.getElementById('addEmployeeModal');
                if (modalEl) { new bootstrap.Modal(modalEl).show(); }
            });
        </script>
    @endif
@endsection
