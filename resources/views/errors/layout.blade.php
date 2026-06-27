<!DOCTYPE html>
<html lang="{{ optional(auth()->user())->language ?? 'bn' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', t('brand.name')) — {{ t('brand.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        :root {
            --green: #1B8B5A;
            --green-dark: #136642;
            --green-light: #E8F5EE;
            --green-mid: #27AE72;
            --accent: #F4A300;
            --red: #E53E3E;
            --text: #1A202C;
            --text-2: #4A5568;
            --text-3: #718096;
            --border: #E2E8F0;
            --bg: #F7FAFC;
            --white: #FFFFFF;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html { -webkit-text-size-adjust: 100%; }

        body {
            font-family: 'Hind Siliguri', 'Poppins', sans-serif;
            color: var(--text);
            background:
                radial-gradient(900px 500px at 12% 10%, rgba(27, 139, 90, .10), transparent 60%),
                radial-gradient(800px 500px at 90% 100%, rgba(244, 163, 0, .08), transparent 60%),
                var(--bg);
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .en { font-family: 'Poppins', sans-serif; }

        .err-card {
            position: relative;
            width: 100%;
            max-width: 540px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 3rem 2.25rem;
            text-align: center;
            box-shadow: 0 24px 60px rgba(27, 139, 90, .12);
            overflow: hidden;
        }

        .err-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            margin-bottom: 2rem;
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--green-dark);
        }

        .err-brand .logo {
            width: 70%;
            /* height: 38px; */
            border-radius: 11px;
            /* background: linear-gradient(135deg, var(--green) 0%, var(--green-mid) 100%); */
            color: #fff;
            display: grid;
            place-items: center;
            overflow: hidden;
            /* box-shadow: 0 6px 16px rgba(27, 139, 90, .35); */
        }

        .err-brand .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .err-icon {
            width: 96px;
            height: 96px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            display: grid;
            place-items: center;
        }

        .err-icon .material-icons-round { font-size: 50px; }

        .err-icon.green { background: var(--green-light); color: var(--green); }
        .err-icon.red { background: #FDECEC; color: var(--red); }
        .err-icon.accent { background: #FFF6E5; color: var(--accent); }

        .err-code {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(3.75rem, 14vw, 6rem);
            font-weight: 800;
            line-height: 1;
            letter-spacing: -.04em;
            background: linear-gradient(135deg, var(--green) 0%, var(--green-mid) 60%, var(--accent) 130%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: .5rem;
        }

        .err-title {
            font-size: 1.55rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: .75rem;
        }

        .err-message {
            font-size: 1.02rem;
            color: var(--text-2);
            line-height: 1.7;
            margin: 0 auto 2rem;
            max-width: 40ch;
        }

        .err-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
            justify-content: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .7rem 1.5rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            transition: transform .15s ease, box-shadow .15s ease, background .15s ease;
        }

        .btn .material-icons-round { font-size: 20px; }

        .btn-primary {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-mid) 100%);
            color: #fff;
            box-shadow: 0 8px 20px rgba(27, 139, 90, .28);
        }

        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(27, 139, 90, .34); }

        .btn-ghost {
            background: var(--white);
            color: var(--text-2);
            border-color: var(--border);
        }

        .btn-ghost:hover { background: var(--bg); transform: translateY(-2px); }

        .err-badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .35rem .85rem;
            border-radius: 999px;
            font-size: .85rem;
            font-weight: 600;
            background: var(--accent);
            color: #fff;
            margin-bottom: 1.5rem;
        }

        .err-badge .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #fff;
            animation: pulse 1.4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .4; transform: scale(.7); }
        }

        @media (max-width: 480px) {
            .err-card { padding: 2.25rem 1.5rem; border-radius: 20px; }
            .err-actions { flex-direction: column; }
            .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="err-card">
        <div class="err-brand">
            <span class="logo"><img src="{{ asset('assets/img/project/brand-logo.svg') }}" alt="{{ t('brand.name') }}"></span>
            <!-- <span>{{ t('brand.name') }}</span> -->
        </div>

        @yield('content')
    </div>
</body>
</html>
