
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<title>@yield('title') | Hishaber Khata</title>

<meta name="description" content="" />

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/project/favicon.ico')}} " />

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
</style>
