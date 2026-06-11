@extends('contents.body')

@section('title', t('nav.notifications'))

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">{{ t('nav.notifications') }}</h4>
                @if ($notifications->total() > 0)
                    <form method="POST" action="{{ route('notifications.readAll') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="mdi mdi-check-all me-1"></i> {{ t('nav.mark_all_read') }}
                        </button>
                    </form>
                @endif
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <ul class="list-group list-group-flush">
                    @forelse ($notifications as $notification)
                        <li class="list-group-item d-flex align-items-start {{ $notification->isUnread() ? 'bg-label-primary' : '' }}">
                            <span class="me-3 mt-1">
                                <i class="mdi mdi-bell-outline mdi-24px {{ $notification->isUnread() ? 'text-primary' : 'text-muted' }}"></i>
                            </span>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center">
                                    <span class="fw-medium">{{ $notification->title }}</span>
                                    @if ($notification->isUnread())
                                        <span class="badge bg-primary rounded-pill ms-2">{{ t('nav.notifications_new') }}</span>
                                    @endif
                                </div>
                                @if ($notification->message)
                                    <div class="text-muted">{{ $notification->message }}</div>
                                @endif
                                <small class="text-muted">{{ $notification->created_at?->diffForHumans() }}</small>
                            </div>
                            @if ($notification->isUnread())
                                <form method="POST" action="{{ route('notifications.read', $notification) }}" class="ms-2">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-icon btn-text-secondary"
                                        title="{{ t('notify.mark_read') }}">
                                        <i class="mdi mdi-check"></i>
                                    </button>
                                </form>
                            @endif
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted py-5">{{ t('nav.notifications_empty') }}</li>
                    @endforelse
                </ul>
                @if ($notifications->hasPages())
                    <div class="card-footer">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
