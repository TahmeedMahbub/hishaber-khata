@extends('contents.body')

@section('title', t('expense.title'))

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">{{ t('expense.title') }}</h4>
                <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus me-1"></i> {{ t('expense.new') }}
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <form method="GET" action="{{ route('expenses.index') }}" class="row g-2">
                        <div class="col-md-10">
                            <input type="text" name="search" value="{{ $search ?? '' }}"
                                class="form-control" placeholder="{{ t('expense.search_ph') }}">
                        </div>
                        <div class="col-md-2 d-grid">
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="mdi mdi-magnify"></i> {{ t('common.search') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ t('common.description') }}</th>
                                <th>{{ t('common.date') }}</th>
                                <th>{{ t('common.note') }}</th>
                                <th class="text-end">{{ t('expense.money') }}</th>
                                <th class="text-end">{{ t('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($expenses as $expense)
                                <tr style="cursor:pointer" onclick="window.location='{{ route('expenses.edit', $expense) }}'">
                                    <td class="fw-medium">{{ $expense->title }}</td>
                                    <td>{{ $expense->expense_date?->format('d/m/Y') }}</td>
                                    <td>{{ $expense->note ?? '—' }}</td>
                                    <td class="text-end">৳ {{ number_format($expense->amount, 2) }}</td>
                                    <td class="text-end" onclick="event.stopPropagation()">
                                        <a href="{{ route('expenses.edit', $expense) }}"
                                            class="btn btn-sm btn-icon btn-text-secondary">
                                            <i class="mdi mdi-pencil-outline"></i>
                                        </a>
                                        <form method="POST" action="{{ route('expenses.destroy', $expense) }}"
                                            class="d-inline" data-confirm="{{ t('common.are_you_sure') }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-icon btn-text-danger">
                                                <i class="mdi mdi-delete-outline"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">{{ t('expense.empty') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($expenses->hasPages())
                    <div class="card-footer">
                        {{ $expenses->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
