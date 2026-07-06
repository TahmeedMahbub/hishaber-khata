<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/project/logo.svg') }}" alt="{{ t('brand.name') }}" width="35" height="35" style="border-radius:8px;">
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">{{ t('brand.name') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="mdi mdi-close mdi-24px d-block d-xl-none"></i>
            <i class="mdi mdi-chevron-double-left mdi-24px d-none d-xl-block"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        {{-- Dashboard --}}
        <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-view-dashboard-outline"></i>
                <div>{{ t('nav.dashboard') }}</div>
            </a>
        </li>

        {{-- Sales --}}
        @php $salesActive = request()->is('sales*') || request()->is('sale-returns*'); @endphp
        <li class="menu-item {{ $salesActive ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-cart-outline"></i>
                <div>{{ t('nav.sales') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('sales*') ? 'active' : '' }}">
                    <a href="{{ route('sales.index') }}" class="menu-link">
                        <div>{{ t('sale.list') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('sale-returns*') ? 'active' : '' }}">
                    <a href="{{ route('sale-returns.index') }}" class="menu-link">
                        <div>{{ t('nav.sale_returns') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Products --}}
        @php $productsActive = request()->is('products*') || request()->is('categories*'); @endphp
        <li class="menu-item {{ $productsActive ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-package-variant-closed"></i>
                <div>{{ t('nav.products') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('products*') ? 'active' : '' }}">
                    <a href="{{ url('/products') }}" class="menu-link">
                        <div>{{ t('nav.all_products') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('categories*') ? 'active' : '' }}">
                    <a href="{{ route('categories.index') }}" class="menu-link">
                        <div>{{ t('nav.categories') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Purchases --}}
        @php $purchasesActive = request()->is('purchases*') || request()->is('purchase-returns*'); @endphp
        <li class="menu-item {{ $purchasesActive ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-cart-outline"></i>
                <div>{{ t('nav.purchases') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('purchases*') ? 'active' : '' }}">
                    <a href="{{ url('/purchases') }}" class="menu-link">
                        <div>{{ t('nav.purchases') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('purchase-returns*') ? 'active' : '' }}">
                    <a href="{{ route('purchase-returns.index') }}" class="menu-link">
                        <div>{{ t('nav.purchase_returns') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- More --}}
        @php
            $moreActive = request()->is('customers*')
                || request()->is('suppliers*') || request()->is('expenses*')
                || request()->is('due-payments*')
                || request()->is('damages*') || request()->is('settings*')
                || request()->is('feedback*') || request()->is('profile*');
        @endphp
        <li class="menu-item {{ $moreActive ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-dots-horizontal"></i>
                <div>{{ t('nav.more') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('customers*') ? 'active' : '' }}">
                    <a href="{{ url('/customers') }}" class="menu-link">
                        <div>{{ t('nav.customers') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('suppliers*') ? 'active' : '' }}">
                    <a href="{{ url('/suppliers') }}" class="menu-link">
                        <div>{{ t('nav.suppliers') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('due-payments*') ? 'active' : '' }}">
                    <a href="{{ url('/due-payments') }}" class="menu-link">
                        <div>{{ t('nav.due_payments') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('expenses*') ? 'active' : '' }}">
                    <a href="{{ url('/expenses') }}" class="menu-link">
                        <div>{{ t('nav.expenses') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('damages*') ? 'active' : '' }}">
                    <a href="{{ url('/damages') }}" class="menu-link">
                        <div>{{ t('nav.damages') }}</div>
                    </a>
                </li>
                @if (auth()->user()->isOwner() && auth()->user()->tenant)
                    <li class="menu-item {{ request()->is('employees*') ? 'active' : '' }}">
                        <a href="{{ route('employees.index') }}" class="menu-link">
                            <div>{{ t('nav.employees') }}</div>
                        </a>
                    </li>
                    {{-- <li class="menu-item {{ request()->is('settings*') ? 'active' : '' }}">
                        <a href="{{ route('settings.index') }}" class="menu-link">
                            <div>সেটিংস</div>
                        </a>
                    </li> --}}
                @endif
                <li class="menu-item {{ request()->is('feedback*') ? 'active' : '' }}">
                    <a href="{{ route('feedback.create') }}" class="menu-link">
                        <div>{{ t('nav.feedback') }}</div>
                    </a>
                </li>
            </ul>
        </li>
        
        {{-- Reports --}}
        <li class="menu-item {{ request()->is('reports*') ? 'active' : '' }}">
            <a href="{{ url('/reports') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-chart-box-outline"></i>
                <div>{{ t('nav.reports') }}</div>
            </a>
        </li>
    </ul>
</aside>
