<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default" data-template="vertical-menu-template">
<head>
    @include('contents.head-section')
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <div class="card">
                    <div class="card-body">
                        {{-- Brand --}}
                        <div class="app-brand justify-content-center mb-3">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <i class="mdi mdi-notebook-outline text-primary" style="font-size: 2rem;"></i>
                                </span>
                                <span class="app-brand-text demo text-body fw-bold ms-1">হিসাবের খাতা</span>
                            </a>
                        </div>

                        @yield('auth-content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('contents.end-section')
</body>
</html>
