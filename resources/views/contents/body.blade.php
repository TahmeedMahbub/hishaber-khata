<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-template="vertical-menu-template">
    <head>
        @include('contents.head-section')
    </head>

    <body>
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                @include('contents.sidebar')
                <div class="layout-page">
                    @include('contents.navbar')

                    <div class="content-wrapper">
                        <div class="container-xxl flex-grow-1 container-p-y">
                            @hasSection('page-title')
                                <h4 class="fw-bold py-3 mb-2">@yield('page-title')</h4>
                            @endif
                            @yield('content')
                        </div>
                        @include('contents.footer')
                        <div class="content-backdrop fade"></div>
                    </div>
                </div>
            </div>



            <div class="layout-overlay layout-menu-toggle"></div>

            <div class="drag-target"></div>
        </div>
        @include('contents.mobile-bottom-nav')
        @include('contents.partials.global-modal')
        @include('contents.end-section')
    </body>
</html>
