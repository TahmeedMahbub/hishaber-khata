<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default" data-template="vertical-menu-template">
<head>
    @include('contents.head-section')

    {{-- Auth (login / register) page styling --}}
    <style>
        :root {
            --hk-auth-brand: #1B8B5A;
            --hk-auth-brand-2: #29875e;
            --hk-auth-brand-soft: rgba(27, 139, 90, 0.08);
        }

        .hk-auth-wrapper {
            min-height: 100vh;
            min-height: 100dvh;
        }

        /* Full-screen gradient background */
        .hk-auth-cover {
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(1200px 600px at 15% 15%, rgba(255, 255, 255, .18), transparent 60%),
                linear-gradient(135deg, var(--hk-auth-brand) 0%, var(--hk-auth-brand-2) 100%);
        }

        .hk-auth-cover .hk-cover-blob {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            z-index: 1;
        }

        .hk-auth-cover .hk-cover-blob.b1 {
            width: 420px;
            height: 420px;
            top: -120px;
            right: -120px;
        }

        .hk-auth-cover .hk-cover-blob.b2 {
            width: 300px;
            height: 300px;
            bottom: -100px;
            left: -80px;
        }

        /* Centered card (modal) */
        .hk-auth-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 18px;
            padding: 2rem;
            box-shadow: 0 24px 60px rgba(0, 0, 0, .28);
        }

        @media (max-width: 575.98px) {
            .hk-auth-card {
                padding: 1.5rem;
                border-radius: 14px;
            }
        }

        .hk-auth-brand-link {
            display: inline-flex;
            align-items: center;
            gap: .65rem;
            text-decoration: none;
        }

        .hk-auth-brand-logo {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: var(--hk-auth-brand-soft);
            color: var(--hk-auth-brand);
            font-size: 1.75rem;
            overflow: hidden;
        }

        .hk-auth-brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .hk-auth-brand-text {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--hk-auth-brand);
            letter-spacing: .2px;
        }

        .hk-auth-card .form-control,
        .hk-auth-card .form-select {
            padding-block: .6rem;
        }

        .hk-auth-card .btn-primary {
            background: linear-gradient(135deg, var(--hk-auth-brand) 0%, var(--hk-auth-brand-2) 100%);
            border: none;
            padding-block: .65rem;
            font-weight: 600;
            box-shadow: 0 8px 18px rgba(27, 139, 90, .25);
        }

        .hk-auth-card .btn-primary:hover {
            filter: brightness(.96);
        }

        .hk-auth-card a {
            color: var(--hk-auth-brand);
            font-weight: 600;
        }

        @media (max-width: 575.98px) {
            .hk-auth-brand-text {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    {{-- Full-screen gradient background with a centered card (modal) --}}
    <div class="hk-auth-cover hk-auth-wrapper d-flex align-items-center justify-content-center p-3 p-sm-4">
        <span class="hk-cover-blob b1"></span>
        <span class="hk-cover-blob b2"></span>

        <div class="hk-auth-card">
            {{-- Brand --}}
            <div class="text-center mb-4">
                <a href="{{ url('/') }}" class="hk-auth-brand-link">
                    <span class="hk-auth-brand-logo">
                        <img src="{{ asset('assets/img/project/logo.svg') }}" alt="logo"
                            onerror="this.style.display='none';this.parentNode.innerHTML='<i class=&quot;mdi mdi-notebook-outline&quot;></i>';">
                    </span>
                    <span class="hk-auth-brand-text">{{ t('brand.name') }}</span>
                </a>
            </div>

            @yield('auth-content')
        </div>
    </div>

    @include('contents.end-section')
</body>
</html>
