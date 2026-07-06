<nav
    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="mdi mdi-menu mdi-24px"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        {{-- Business name (links to dashboard) --}}
        <div class="navbar-nav align-items-center">
            <a href="{{ route('dashboard') }}" class="fw-medium text-heading text-decoration-none hk-topbar-title">
                {{ optional(optional(auth()->user())->tenant)->name ?? config('app.name') }}
            </a>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            @auth
            {{-- POS quick access (desktop only — mobile uses the bottom nav) --}}
            @unless (request()->routeIs('sales.create'))
            <li class="nav-item me-3 d-none d-lg-block">
                <a href="{{ route('sales.create') }}" class="btn btn-sm fw-bold hk-sell-btn">
                    <i class="mdi mdi-cash-register me-1"></i> {{ t('nav.sell') }}
                </a>
            </li>
            @endunless
            {{-- Notifications --}}
            <li class="nav-item navbar-dropdown dropdown-notifications me-2 me-lg-3 dropdown" style="display: none;">
                <a class="nav-link dropdown-toggle hide-arrow position-relative" href="javascript:void(0);"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-label="{{ t('nav.notifications') }}">
                    <i class="mdi mdi-bell-outline mdi-24px"></i>
                    @if (($navUnreadCount ?? 0) > 0)
                        <span class="position-absolute translate-middle bg-danger rounded-circle"
                            style="top: 17px; right: 4px; width: 9px; height: 9px;">
                            <span class="visually-hidden">{{ t('nav.notifications_unread') }}</span>
                        </span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-0 hk-notify-dropdown" style="width: 22rem; max-width: 22rem;">
                    <li class="border-bottom">
                        <div class="d-flex align-items-center justify-content-between px-3 py-3">
                            <h6 class="mb-0 fw-bold">{{ t('nav.notifications') }}</h6>
                            @if (($navUnreadCount ?? 0) > 0)
                                <span class="badge bg-label-primary rounded-pill">{{ t('nav.notifications_new') }}</span>
                            @endif
                        </div>
                    </li>
                    <li>
                        <ul class="list-group list-group-flush hk-notify-list" style="max-height: 22rem; overflow-y: auto;">
                            @forelse (($navNotifications ?? collect()) as $notification)
                                <li class="list-group-item p-0 {{ $notification->isUnread() ? 'bg-label-primary' : '' }}">
                                    <form method="POST" action="{{ route('notifications.read', $notification) }}" class="m-0">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-link text-start text-decoration-none w-100 d-flex align-items-start text-body px-3 py-2">
                                            <span class="me-2 mt-1 flex-shrink-0">
                                                <i class="mdi mdi-circle-medium {{ $notification->isUnread() ? 'text-primary' : 'text-muted' }}"></i>
                                            </span>
                                            <span class="flex-grow-1 text-wrap" style="min-width: 0;">
                                                <span class="d-block fw-medium text-truncate">{{ $notification->title }}</span>
                                                @if ($notification->message)
                                                    <small class="d-block text-muted">{{ \Illuminate\Support\Str::limit($notification->message, 70) }}</small>
                                                @endif
                                                <small class="text-muted">{{ $notification->created_at?->diffForHumans() }}</small>
                                            </span>
                                        </button>
                                    </form>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted py-4">{{ t('nav.notifications_empty') }}</li>
                            @endforelse
                        </ul>
                    </li>
                    <li class="border-top">
                        <div class="d-flex align-items-center justify-content-between px-3 py-2">
                            @if (($navUnreadCount ?? 0) > 0)
                                <form method="POST" action="{{ route('notifications.readAll') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-link text-decoration-none p-0">
                                        {{ t('nav.mark_all_read') }}
                                    </button>
                                </form>
                            @else
                                <span></span>
                            @endif
                            <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-link text-decoration-none p-0">
                                {{ t('common.view_all') }}
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
            {{-- User --}}
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            {{ strtoupper(mb_substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </span>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <div class="dropdown-item">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    <div class="avatar avatar-online">
                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                            {{ strtoupper(mb_substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-medium d-block">{{ auth()->user()->name }}</span>
                                    <small class="text-muted">{{ ucfirst(auth()->user()->role ?? 'owner') }}</small>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile') }}">
                            <i class="mdi mdi-account-outline me-2"></i>
                            <span class="align-middle">{{ t('nav.profile_edit') }}</span>
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('language.switch') }}" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="mdi mdi-translate me-2"></i>
                                <span class="align-middle">{{ auth()->user()->language === 'en' ? 'বাংলা ভাষায় দেখুন' : 'See in English' }}</span>
                            </button>
                        </form>
                    </li>
                    {{-- @if (auth()->user()->isOwner() && auth()->user()->tenant)
                        <li>
                            <a class="dropdown-item" href="{{ route('settings.index') }}">
                                <i class="mdi mdi-cog-outline me-2"></i>
                                <span class="align-middle">{{ t('nav.settings') }}</span>
                            </a>
                        </li>
                    @endif --}}
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="mdi mdi-logout me-2"></i>
                                <span class="align-middle">{{ t('nav.logout') }}</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            @endauth
        </ul>
    </div>
</nav>
