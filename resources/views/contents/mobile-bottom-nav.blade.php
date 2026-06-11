{{--
    Mobile bottom navigation + "More" bottom sheet.
    Visible only below 992px (CSS-controlled). Desktop keeps the existing sidebar.
--}}
@php
    $isDashboard = request()->is('dashboard') || request()->is('dashboard/*');
    $isSales     = request()->is('sales*');
    $isProducts  = request()->is('products*') || request()->is('categories*');
    $isReports   = request()->is('reports*');
    $isMore = request()->is('purchases*') || request()->is('customers*')
        || request()->is('suppliers*') || request()->is('expenses*')
        || request()->is('due-payments*') || request()->is('damages*')
        || request()->is('settings*') || request()->is('feedback*')
        || request()->is('profile*');
@endphp

<nav class="hk-mnav" aria-label="মূল মেনু">
    <a href="{{ route('dashboard') }}" class="hk-mnav__item {{ $isDashboard ? 'active' : '' }}">
        <i class="hk-mnav__icon mdi mdi-view-dashboard-outline"></i>
        <span>ড্যাশবোর্ড</span>
    </a>

    <a href="{{ route('products.index') }}" class="hk-mnav__item {{ $isProducts ? 'active' : '' }}">
        <i class="hk-mnav__icon mdi mdi-package-variant-closed"></i>
        <span>পণ্য</span>
    </a>

    <a href="{{ route('sales.create') }}"
        class="hk-mnav__item hk-mnav__item--primary {{ $isSales ? 'active' : '' }}">
        <i class="hk-mnav__icon mdi mdi-cart-plus"></i>
        <span>বিক্রয়</span>
    </a>

    <a href="{{ route('reports.index') }}" class="hk-mnav__item {{ $isReports ? 'active' : '' }}">
        <i class="hk-mnav__icon mdi mdi-chart-box-outline"></i>
        <span>রিপোর্ট</span>
    </a>

    <a href="javascript:void(0);"
        class="hk-mnav__item {{ $isMore ? 'active' : '' }}"
        data-hk-sheet-open
        data-active="{{ $isMore ? 'true' : 'false' }}"
        role="button"
        aria-haspopup="dialog"
        aria-expanded="false"
        aria-controls="hk-more-sheet">
        <i class="hk-mnav__icon mdi mdi-dots-horizontal"></i>
        <span>আরও</span>
    </a>
</nav>

<div class="hk-sheet-backdrop" id="hk-sheet-backdrop"></div>

<div class="hk-sheet" id="hk-more-sheet" role="dialog" aria-modal="true" aria-labelledby="hk-sheet-title">
    <div class="hk-sheet__handle" data-hk-sheet-close></div>

    <div class="hk-sheet__header">
        <h6 class="hk-sheet__title" id="hk-sheet-title">আরও অপশন</h6>
        <button type="button" class="hk-sheet__close" data-hk-sheet-close aria-label="বন্ধ করুন">
            <i class="mdi mdi-close"></i>
        </button>
    </div>

    <div class="hk-sheet__grid">
        <a href="{{ route('purchases.index') }}" class="hk-sheet__link {{ request()->is('purchases*') ? 'active' : '' }}">
            <i class="mdi mdi-cart-arrow-down"></i><span>ক্রয়</span>
        </a>
        <a href="{{ route('sales.index') }}" class="hk-sheet__link {{ request()->is('sales*') ? 'active' : '' }}">
            <i class="mdi mdi-cart-outline"></i><span>বিক্রয়</span>
        </a>
        <a href="{{ route('expenses.index') }}" class="hk-sheet__link {{ request()->is('expenses*') ? 'active' : '' }}">
            <i class="mdi mdi-cash-minus"></i><span>খরচ</span>
        </a>
        <a href="{{ route('customers.index') }}" class="hk-sheet__link {{ request()->is('customers*') ? 'active' : '' }}">
            <i class="mdi mdi-account-group-outline"></i><span>কাস্টমার</span>
        </a>
        <a href="{{ route('suppliers.index') }}" class="hk-sheet__link {{ request()->is('suppliers*') ? 'active' : '' }}">
            <i class="mdi mdi-truck-outline"></i><span>সরবরাহকারী</span>
        </a>
        @if (auth()->user()->isOwner() && auth()->user()->tenant)
            <a href="{{ route('employees.index') }}" class="hk-sheet__link {{ request()->is('employees*') ? 'active' : '' }}">
                <i class="mdi mdi-account-group-outline"></i><span>কর্মচারী</span>
            </a>
            {{-- <a href="{{ route('settings.index') }}" class="hk-sheet__link {{ request()->is('settings*') ? 'active' : '' }}">
                <i class="mdi mdi-cog-outline"></i><span>সেটিংস</span>
            </a> --}}
        @endif
        <a href="{{ route('due-payments.index') }}" class="hk-sheet__link {{ request()->is('due-payments*') ? 'active' : '' }}">
            <i class="mdi mdi-account-cash-outline"></i><span>বাকির হিসাব</span>
        </a>
        <a href="{{ route('damages.index') }}" class="hk-sheet__link {{ request()->is('damages*') ? 'active' : '' }}">
            <i class="mdi mdi-package-variant-remove"></i><span>ড্যামেজ</span>
        </a>
        {{-- <a href="{{ route('profile') }}" class="hk-sheet__link {{ request()->is('profile*') ? 'active' : '' }}">
            <i class="mdi mdi-account-outline"></i><span>প্রোফাইল</span>
        </a> --}}
        <a href="{{ route('feedback.create') }}" class="hk-sheet__link {{ request()->is('feedback*') ? 'active' : '' }}">
            <i class="mdi mdi-message-text-outline"></i><span>মতামত</span>
        </a>
    </div>
</div>
