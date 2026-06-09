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
                <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">
                    <i class="mdi mdi-cash-register me-1"></i> বিক্রয় করুন
                </a>
            </li>
            @endunless
            {{-- Notifications --}}
            <li class="nav-item me-2 me-lg-3">
                <a class="nav-link position-relative" href="javascript:void(0);" aria-label="নোটিফিকেশন">
                    <i class="mdi mdi-bell-outline mdi-24px"></i>
                    <span class="badge bg-danger rounded-pill hk-topbar-badge"></span>
                </a>
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
                            <span class="align-middle">প্রোফাইল ও সেটিংস</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="mdi mdi-logout me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            @endauth
        </ul>
    </div>
</nav>
