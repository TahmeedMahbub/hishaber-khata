@extends('contents.body')

@section('title', 'Expenses')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">খরচ</h4>
                <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus me-1"></i> নতুন খরচ
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
                                class="form-control" placeholder="খরচের বিবরণ দিয়ে খুঁজুন...">
                        </div>
                        <div class="col-md-2 d-grid">
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="mdi mdi-magnify"></i> খুঁজুন
                            </button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>বিবরণ</th>
                                <th>তারিখ</th>
                                <th>নোট</th>
                                <th class="text-end">টাকা</th>
                                <th class="text-end">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($expenses as $expense)
                                <tr>
                                    <td class="fw-medium">{{ $expense->title }}</td>
                                    <td>{{ $expense->expense_date?->format('d/m/Y') }}</td>
                                    <td>{{ $expense->note ?? '—' }}</td>
                                    <td class="text-end">৳ {{ number_format($expense->amount, 2) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('expenses.edit', $expense) }}"
                                            class="btn btn-sm btn-icon btn-text-secondary">
                                            <i class="mdi mdi-pencil-outline"></i>
                                        </a>
                                        <form method="POST" action="{{ route('expenses.destroy', $expense) }}"
                                            class="d-inline" data-confirm="আপনি কি নিশ্চিত?">
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
                                    <td colspan="5" class="text-center text-muted py-4">কোনো খরচ নেই।</td>
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
