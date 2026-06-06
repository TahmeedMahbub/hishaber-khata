<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/project/logo.png') }}" alt="হিসাবের খাতা" width="35" height="35" style="border-radius:8px;">
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">হিসাবের খাতা</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="mdi mdi-close mdi-24px d-block d-xl-none"></i>
            <i class="mdi mdi-radiobox-blank mdi-24px d-none d-xl-block"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        {{-- Dashboard --}}
        <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-view-dashboard-outline"></i>
                <div>ড্যাশবোর্ড</div>
            </a>
        </li>

        {{-- Sales --}}
        <li class="menu-item {{ request()->is('sales*') ? 'active' : '' }}">
            <a href="{{ route('sales.index') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-cart-outline"></i>
                <div>বিক্রয়</div>
            </a>
        </li>

        {{-- Products --}}
        @php $productsActive = request()->is('products*') || request()->is('categories*'); @endphp
        <li class="menu-item {{ $productsActive ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-package-variant-closed"></i>
                <div>পণ্য</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('products*') ? 'active' : '' }}">
                    <a href="{{ url('/products') }}" class="menu-link">
                        <div>সকল পণ্য</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('categories*') ? 'active' : '' }}">
                    <a href="{{ route('categories.index') }}" class="menu-link">
                        <div>ক্যাটাগরি</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Reports --}}
        <li class="menu-item {{ request()->is('reports*') ? 'active' : '' }}">
            <a href="{{ url('/reports') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-chart-box-outline"></i>
                <div>রিপোর্ট</div>
            </a>
        </li>

        {{-- More --}}
        @php
            $moreActive = request()->is('purchases*') || request()->is('customers*')
                || request()->is('suppliers*') || request()->is('expenses*') || request()->is('settings*');
        @endphp
        <li class="menu-item {{ $moreActive ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-dots-horizontal"></i>
                <div>আরও</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('purchases*') ? 'active' : '' }}">
                    <a href="{{ url('/purchases') }}" class="menu-link">
                        <div>ক্রয়</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('customers*') ? 'active' : '' }}">
                    <a href="{{ url('/customers') }}" class="menu-link">
                        <div>কাস্টমার</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('suppliers*') ? 'active' : '' }}">
                    <a href="{{ url('/suppliers') }}" class="menu-link">
                        <div>সরবরাহকারী</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('expenses*') ? 'active' : '' }}">
                    <a href="{{ url('/expenses') }}" class="menu-link">
                        <div>খরচ</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('settings*') ? 'active' : '' }}">
                    <a href="{{ url('/settings') }}" class="menu-link">
                        <div>সেটিংস</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
