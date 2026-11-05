@php
    $canonical = url()->current();
    $brand = 'Hishabiz';
    $metaDescription = trim($__env->yieldContent('meta-description'));
    $pageTitle = trim($__env->yieldContent('title')) . ' | ' . $brand;
@endphp
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
<meta name="robots" content="index, follow">
<meta name="theme-color" content="#1B8B5A">
<link rel="canonical" href="{{ $canonical }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $brand }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ asset('assets/img/project/screenshot.jpg') }}">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
@include('partials.site-head')
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--green:#1B8B5A;--green-dark:#136642;--green-light:#E8F5EE;--text:#1A202C;--text-2:#4A5568;--border:#E2E8F0;--bg:#F7FAFC}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Inter','Hind Siliguri',sans-serif;color:var(--text);background:var(--bg);line-height:1.7}
a{color:var(--green-dark)}
.lg-header{background:#fff;border-bottom:1px solid var(--border)}
.lg-header-inner,.lg-footer-inner{max-width:960px;margin:0 auto;padding:14px 20px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
.lg-logo{display:flex;align-items:center;gap:10px;font-weight:800;font-size:1.2rem;color:var(--green);text-decoration:none}
.lg-logo img{width:36px;height:36px}
.lg-nav a{margin-left:16px;font-size:.92rem;text-decoration:none;color:var(--text-2)}
.lg-nav a:hover,.lg-nav a.active{color:var(--green)}
.lg-hero{background:linear-gradient(135deg,var(--green),#29875e);color:#fff;padding:44px 20px}
.lg-hero-inner{max-width:960px;margin:0 auto}
.lg-hero h1{font-size:2rem;font-weight:800;line-height:1.25}
.lg-hero p{opacity:.9;margin-top:6px}
.lg-main{max-width:960px;margin:-24px auto 40px;padding:0 20px}
.lg-card{background:#fff;border:1px solid var(--border);border-radius:16px;padding:32px;box-shadow:0 4px 24px rgba(27,139,90,.08)}
.lg-card h2{font-size:1.25rem;margin:28px 0 8px;color:var(--green-dark)}
.lg-card h2:first-of-type{margin-top:0}
.lg-card h3{font-size:1rem;margin:16px 0 4px}
.lg-card p,.lg-card li{color:var(--text-2);font-size:.97rem}
.lg-card p{margin:8px 0}
.lg-card ul{margin:8px 0 8px 22px}
.lg-card li{margin:4px 0}
.lg-note{background:var(--green-light);border-radius:10px;padding:12px 16px;margin:12px 0;font-size:.93rem;color:var(--text)}
.lg-toc{background:var(--bg);border-radius:10px;padding:14px 20px;margin-bottom:20px}
.lg-toc ol{margin:6px 0 0 20px;columns:2}
.lg-toc a{font-size:.9rem;text-decoration:none}
.lg-footer{border-top:1px solid var(--border);background:#fff;font-size:.88rem;color:var(--text-2)}
.lg-footer a{margin-right:14px;text-decoration:none}
@media(max-width:640px){.lg-card{padding:22px 18px}.lg-hero h1{font-size:1.5rem}.lg-toc ol{columns:1}}
</style>
</head>
<body>
<header class="lg-header">
  <div class="lg-header-inner">
    <a href="{{ route('home') }}" class="lg-logo"><img src="{{ asset('assets/img/project/brand-logo.svg') }}" alt="" width="36" height="36"><span>Hishabiz</span></a>
    <nav class="lg-nav">
      <a href="{{ route('home') }}">Home</a>
      <a href="{{ route('legal.privacy') }}" class="{{ request()->routeIs('legal.privacy') ? 'active' : '' }}">Privacy Policy</a>
      <a href="{{ route('legal.terms') }}" class="{{ request()->routeIs('legal.terms') ? 'active' : '' }}">Terms of Service</a>
      <a href="{{ route('login') }}">Log in</a>
    </nav>
  </div>
</header>

<section class="lg-hero">
  <div class="lg-hero-inner">
    <h1>@yield('title')</h1>
    <p>Last updated: {{ $lastUpdated ?? '5 November 2026' }}</p>
  </div>
</section>

<main class="lg-main">
  <article class="lg-card">
    @yield('legal-content')
  </article>
</main>

<footer class="lg-footer">
  <div class="lg-footer-inner">
    <span>&copy; {{ date('Y') }} Hishabiz. All rights reserved.</span>
    <span>
      <a href="{{ route('legal.privacy') }}">Privacy Policy</a>
      <a href="{{ route('legal.terms') }}">Terms of Service</a>
      <a href="mailto:hishabiz.support@gmail.com">hishabiz.support@gmail.com</a>
    </span>
  </div>
</footer>
</body>
</html>
