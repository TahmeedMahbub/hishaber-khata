
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<title>@yield('title') | Hishabiz</title>

<meta name="description" content="" />

<!-- Favicon & Analytics (shared) -->
@include('partials.site-head')

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

<!-- Icons -->
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/materialdesignicons.css')}} " />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css')}} " />
<!-- Menu waves for no-customizer fix -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css')}} " />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ asset('assets/css/demo.css')}} " />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}} " />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css')}} " />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css')}} " />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css')}} " />

<!-- Page CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-statistics.css')}} " />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-analytics.css')}} " />

<!-- Mobile bottom navigation -->
<link rel="stylesheet" href="{{ asset('assets/css/mobile-bottom-nav.css')}}" />
<!-- Helpers -->
<script src="{{ asset('assets/vendor/js/helpers.js')}} "></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
<script src="{{ asset('assets/vendor/js/template-customizer.js')}} "></script>
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ asset('assets/js/config.js')}} "></script>

<!-- Custom navbar theme: dark background with light text -->
<style>
    :root {
        --hk-navbar-bg: #1B8B5A;
        --hk-navbar-bg-2: #29875e;
        --hk-navbar-text: #e7e7f0;
        --hk-navbar-muted: #b4b4cc;
    }

    #layout-navbar.bg-navbar-theme {
        background: linear-gradient(90deg, var(--hk-navbar-bg) 0%, var(--hk-navbar-bg-2) 100%) !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.18);
    }

    /* Full-width navbar attached to the top (remove detached floating look) */
    #layout-navbar.navbar-detached {
        margin: 0 !important;
        width: auto !important;
        max-width: none !important;
        border-radius: 0 !important;
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
        box-sizing: border-box;
    }

    .layout-page > .content-wrapper {
        padding-top: 0 !important;
    }

    /* Ensure the right cluster (business name, POS button, profile) fills the
       width and stays visible on desktop after the full-width override */
    #layout-navbar .navbar-nav-right {
        flex: 1 1 auto;
        min-width: 0;
    }

    #layout-navbar .text-heading,
    #layout-navbar .nav-link,
    #layout-navbar .nav-item .nav-link i,
    #layout-navbar i {
        color: var(--hk-navbar-text) !important;
    }

    #layout-navbar .navbar-nav > .nav-item > span.fw-medium {
        color: var(--hk-navbar-text) !important;
        letter-spacing: .2px;
    }

    #layout-navbar .text-muted,
    #layout-navbar small.text-muted {
        color: var(--hk-navbar-muted) !important;
    }

    #layout-navbar .nav-link:hover i {
        color: #fff !important;
    }

    /* Keep dropdown menu readable on light surface */
    #layout-navbar .dropdown-menu .dropdown-item,
    #layout-navbar .dropdown-menu .dropdown-item i,
    #layout-navbar .dropdown-menu small.text-muted {
        color: inherit !important;
    }

    /* Reduce content horizontal padding by 50% on mobile (keep desktop as-is) */
    @media (max-width: 767.98px) {
        .content-wrapper .container-xxl.container-p-y {
            padding-left: 0.7rem !important;
            padding-right: 0.7rem !important;
        }
    }

    /* ===============================================================
       Custom sidebar theme: clean white/light menu with brand accents
       =============================================================== */
    :root {
        --hk-menu-bg: #effaef;
        --hk-menu-text: #2f3a45;
        --hk-menu-muted: #566373;
        --hk-menu-brand: #1B8B5A;
        --hk-menu-brand-soft: rgba(27, 139, 90, 0.10);
        --hk-menu-accent: #F4A300;
    }

    #layout-menu.bg-menu-theme {
        background: var(--hk-menu-bg) !important;
        border-right: 1px solid #eef1f4 !important;
        box-shadow: 2px 0 18px rgba(16, 24, 40, 0.04);
    }

    /* Brand / logo area */
    #layout-menu .app-brand {
        margin-top: 0.35rem;
        padding-bottom: 0.25rem;
        border-bottom: 1px solid #eef1f4;
        margin-bottom: 0.35rem;
    }

    #layout-menu .app-brand .app-brand-text {
        color: var(--hk-menu-brand) !important;
        letter-spacing: .3px;
        font-size: 1.15rem;
    }

    #layout-menu .app-brand .layout-menu-toggle i {
        color: #98a2b3 !important;
    }

    #layout-menu .app-brand .app-brand-logo img {
        box-shadow: 0 4px 12px rgba(27, 139, 90, 0.18);
    }

    /* Menu inner shadow (top fade) tuned for light bg */
    #layout-menu .menu-inner-shadow {
        background: linear-gradient(#ffffff 41%, rgba(255, 255, 255, 0.6) 60%, rgba(255, 255, 255, 0)) !important;
    }

    /* Base link */
    #layout-menu .menu-inner > .menu-item {
        margin: 2px 0;
    }

    #layout-menu .menu-link {
        color: var(--hk-menu-text) !important;
        border-radius: 10px;
        margin: 0 0.6rem;
        padding-top: 0.55rem;
        padding-bottom: 0.55rem;
        font-weight: 500;
        transition: background-color .18s ease, color .18s ease, transform .18s ease;
    }

    #layout-menu .menu-link i,
    #layout-menu .menu-icon {
        color: var(--hk-menu-muted) !important;
        transition: color .18s ease, transform .18s ease;
    }

    /* Hover */
    #layout-menu .menu-item:not(.active) > .menu-link:hover {
        background: var(--hk-menu-brand-soft) !important;
        color: var(--hk-menu-brand) !important;
        transform: translateX(3px);
    }

    #layout-menu .menu-item:not(.active) > .menu-link:hover i {
        color: var(--hk-menu-brand) !important;
    }

    /* Active top-level item: brand pill with accent bar */
    #layout-menu .menu-inner > .menu-item.active > .menu-link {
        background: linear-gradient(90deg, rgba(27, 139, 90, 0.16), rgba(27, 139, 90, 0.06)) !important;
        color: var(--hk-menu-brand) !important;
        font-weight: 600;
        box-shadow: inset 3px 0 0 var(--hk-menu-accent);
    }

    #layout-menu .menu-inner > .menu-item.active > .menu-link i {
        color: var(--hk-menu-brand) !important;
    }

    /* Submenu container */
    #layout-menu .menu-sub {
        position: relative;
        margin-left: 1.35rem;
    }

    #layout-menu .menu-sub::before {
        content: "";
        position: absolute;
        left: 0.35rem;
        top: 0.15rem;
        bottom: 0.15rem;
        width: 2px;
        background: #e7ebf0;
        border-radius: 2px;
    }

    #layout-menu .menu-sub .menu-link {
        color: var(--hk-menu-muted) !important;
        font-weight: 400;
        padding-top: 0.42rem;
        padding-bottom: 0.42rem;
    }

    #layout-menu .menu-sub .menu-item.active > .menu-link {
        background: var(--hk-menu-brand-soft) !important;
        color: var(--hk-menu-brand) !important;
        font-weight: 600;
    }

    #layout-menu .menu-sub .menu-item.active > .menu-link::before {
        background: var(--hk-menu-accent) !important;
    }

    #layout-menu .menu-sub .menu-item > .menu-link::before {
        background: #c3ccd6;
    }

    /* Toggle chevron */
    #layout-menu .menu-toggle::after {
        opacity: .55;
    }

    /* Custom scrollbar */
    #layout-menu .ps__thumb-y,
    #layout-menu .ps__rail-y.ps--clicking .ps__thumb-y {
        background: rgba(27, 139, 90, 0.35) !important;
        width: 5px !important;
    }

    /* ===============================================================
       Brand primary buttons: vibrant, eye-catching green
       =============================================================== */
    :root {
        --hk-btn: #1B8B5A;
        --hk-btn-2: #23a86c;
        --hk-btn-dark: #136642;
    }

    .btn-primary {
        --bs-btn-bg: var(--hk-btn);
        --bs-btn-border-color: var(--hk-btn);
        --bs-btn-hover-bg: var(--hk-btn-dark);
        --bs-btn-hover-border-color: var(--hk-btn-dark);
        --bs-btn-active-bg: var(--hk-btn-dark);
        --bs-btn-active-border-color: var(--hk-btn-dark);
        --bs-btn-disabled-bg: var(--hk-btn);
        --bs-btn-disabled-border-color: var(--hk-btn);
        background: linear-gradient(135deg, var(--hk-btn-2) 0%, var(--hk-btn) 100%) !important;
        border-color: var(--hk-btn) !important;
        box-shadow: 0 4px 14px rgba(27, 139, 90, 0.30);
        font-weight: 600;
        transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--hk-btn) 0%, var(--hk-btn-dark) 100%) !important;
        border-color: var(--hk-btn-dark) !important;
        box-shadow: 0 8px 22px rgba(27, 139, 90, 0.38);
        transform: translateY(-1px);
        filter: brightness(1.02);
    }

    .btn-primary:active,
    .btn-primary:focus,
    .btn-primary.active,
    .show > .btn-primary.dropdown-toggle {
        background: var(--hk-btn-dark) !important;
        border-color: var(--hk-btn-dark) !important;
        box-shadow: 0 0 0 0.2rem rgba(27, 139, 90, 0.25) !important;
    }

    .btn-primary:disabled,
    .btn-primary.disabled {
        background: var(--hk-btn) !important;
        box-shadow: none;
    }

    /* Outline variant matches the brand green */
    .btn-outline-primary {
        --bs-btn-color: var(--hk-btn);
        --bs-btn-border-color: var(--hk-btn);
        --bs-btn-hover-bg: var(--hk-btn);
        --bs-btn-hover-border-color: var(--hk-btn);
        --bs-btn-active-bg: var(--hk-btn);
        --bs-btn-active-border-color: var(--hk-btn);
        --bs-btn-focus-shadow-rgb: 27, 139, 90;
        color: var(--hk-btn);
        border-color: var(--hk-btn);
        font-weight: 600;
    }

    .btn-outline-primary:hover,
    .btn-outline-primary:active,
    .btn-outline-primary.active {
        background: var(--hk-btn) !important;
        border-color: var(--hk-btn) !important;
        color: #fff !important;
    }

    /* Link/text primary tone */
    .text-primary {
        color: var(--hk-btn) !important;
    }

    /* Navbar "Sell" button: white pill, amber icon, hover lift */
    .hk-sell-btn {
        background: #fff !important;
        color: #1B8B5A !important;
        border: none !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        transition: transform .15s ease, box-shadow .15s ease, background-color .15s ease;
    }

    .hk-sell-btn i {
        color: #1B8B5A !important;
        transition: transform .15s ease;
    }

    .hk-sell-btn:hover {
        background: #F4A300 !important;
        color: #fff !important;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
        transform: translateY(-2px);
    }

    .hk-sell-btn:hover i {
        color: #fff !important;
        transform: scale(1.12);
    }

    /* Beat the navbar's global "#layout-navbar i" rule for the Sell button */
    #layout-navbar .hk-sell-btn i {
        color: #1B8B5A !important;
    }

    #layout-navbar .hk-sell-btn:hover i {
        color: #fff !important;
    }

    /* ---------------------------------------------------------------
       Print: strip the application chrome so only page content prints.
       Used by invoices (sales/purchase) and report pages.
       --------------------------------------------------------------- */
    @media print {
        @page {
            margin: 12mm;
        }

        #layout-menu,
        #layout-navbar,
        .content-footer,
        .layout-overlay,
        .content-backdrop,
        .drag-target,
        .hk-mnav,
        .hk-sheet,
        .hk-sheet-backdrop,
        .d-print-none {
            display: none !important;
        }

        html,
        body {
            background: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
            height: auto !important;
            min-height: 0 !important;
        }

        .layout-wrapper,
        .layout-container,
        .layout-page,
        .content-wrapper,
        .content-wrapper .container-xxl {
            display: block !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            min-height: 0 !important;
            height: auto !important;
            box-shadow: none !important;
            overflow: visible !important;
        }

        /* Override the runtime <style> the theme's helpers.js injects
           (.layout-page { padding-top: navbarHeight } /
            .content-wrapper { padding-bottom: footerHeight }).
           Higher specificity beats it regardless of source order. */
        html .layout-page,
        html.layout-navbar-fixed .layout-page {
            padding-top: 0 !important;
        }

        html .content-wrapper,
        html.layout-footer-fixed .content-wrapper {
            padding-bottom: 0 !important;
        }

        /* Drop Bootstrap row/column gutters that add stray top/side space */
        .content-wrapper .row {
            margin: 0 !important;
        }

        .content-wrapper [class*="col-"] {
            padding: 0 !important;
        }

        a[href]::after {
            content: none !important;
        }
    }
</style>

