@extends('contents.body')

@section('title', t('damage.title'))

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">{{ t('damage.title') }}</h4>
                <a href="{{ route('damages.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus me-1"></i> {{ t('damage.new_record') }}
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
                    <form method="GET" action="{{ route('damages.index') }}" class="row g-2">
                        <div class="col-md-10">
                            <input type="text" name="search" value="{{ $search ?? '' }}"
                                class="form-control" placeholder="{{ t('damage.search_ph') }}">
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
                                <th>{{ t('nav.products') }}</th>
                                <th>{{ t('damage.type') }}</th>
                                <th class="text-end">{{ t('common.quantity') }}</th>
                                <th>{{ t('damage.reason') }}</th>
                                <th>{{ t('common.date') }}</th>
                                <th class="text-end">{{ t('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($damages as $damage)
                                <tr>
                                    <td class="fw-medium">{{ $damage->product->name ?? '—' }}</td>
                                    <td>
                                        @if ($damage->type === 'lost')
                                            <span class="badge bg-label-secondary">{{ t('damage.lost') }}</span>
                                        @else
                                            <span class="badge bg-label-warning">{{ t('damage.damage') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">{{ rtrim(rtrim(number_format($damage->qty, 2), '0'), '.') }}</td>
                                    <td>{{ $damage->reason ?? '—' }}</td>
                                    <td>{{ $damage->damage_date?->format('d/m/Y') }}</td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('damages.destroy', $damage) }}"
                                            class="d-inline" data-confirm="{{ t('common.are_you_sure') }} {{ t('damage.stock_restore') }}">
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
                                    <td colspan="6" class="text-center text-muted py-4">{{ t('damage.empty') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($damages->hasPages())
                    <div class="card-footer">
                        {{ $damages->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
