@extends('contents.body')

@section('title', 'Categories')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">ক্যাটাগরি</h4>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus me-1"></i> নতুন ক্যাটাগরি
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
                    <form method="GET" action="{{ route('categories.index') }}" class="d-flex gap-2">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            class="form-control" placeholder="নাম দিয়ে খুঁজুন...">
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </form>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>নাম</th>
                                <th>স্ট্যাটাস</th>
                                <th class="text-end">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td class="fw-medium">{{ $category->name }}</td>
                                    <td>
                                        @if ($category->status === 'active')
                                            <span class="badge bg-label-success">সক্রিয়</span>
                                        @else
                                            <span class="badge bg-label-secondary">নিষ্ক্রিয়</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('categories.edit', $category) }}"
                                            class="btn btn-sm btn-icon btn-text-secondary">
                                            <i class="mdi mdi-pencil-outline"></i>
                                        </a>
                                        <form method="POST" action="{{ route('categories.destroy', $category) }}"
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
                                    <td colspan="3" class="text-center text-muted py-4">
                                        কোনো ক্যাটাগরি নেই।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($categories->hasPages())
                    <div class="card-footer">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
