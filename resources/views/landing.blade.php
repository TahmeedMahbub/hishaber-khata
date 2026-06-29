@php($seo = $seo ?? \App\Support\LandingSeo::make(request()))
<!DOCTYPE html>
<html lang="{{ $seo['htmlLocale'] }}" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $seo['title'] }}</title>
<meta name="description" content="{{ $seo['description'] }}">
<meta name="keywords" content="{{ $seo['keywords'] }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="author" content="{{ $seo['brand'] }}">
<meta name="theme-color" content="#1B8B5A">
<link rel="canonical" href="{{ $seo['canonical'] }}">
@foreach ($seo['alternates'] as $hreflang => $href)
<link rel="alternate" hreflang="{{ $hreflang }}" href="{{ $href }}">
@endforeach
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $seo['brand'] }}">
<meta property="og:title" content="{{ $seo['title'] }}">
<meta property="og:description" content="{{ $seo['description'] }}">
<meta property="og:url" content="{{ $seo['canonical'] }}">
<meta property="og:image" content="{{ $seo['image'] }}">
<meta property="og:image:alt" content="{{ $seo['brand'] }} dashboard preview">
<meta property="og:locale" content="{{ str_replace('-', '_', $seo['htmlLocale']) }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seo['title'] }}">
<meta name="twitter:description" content="{{ $seo['description'] }}">
<meta name="twitter:image" content="{{ $seo['image'] }}">
<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="image" href="{{ asset('assets/img/project/screenshot.webp') }}" type="image/webp" fetchpriority="high">
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons&display=swap" rel="stylesheet">
<script type="application/ld+json">@json($seo['jsonLd'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4DFZS3SYH6"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'G-4DFZS3SYH6');
</script>
<style>
:root {
  --green: #1B8B5A;
  --green-dark: #136642;
  --green-light: #E8F5EE;
  --green-mid: #27AE72;
  --accent: #F4A300;
  --accent-light: #FFF8E6;
  --red: #E53E3E;
  --blue: #2563EB;
  --text: #1A202C;
  --text-2: #4A5568;
  --text-3: #718096;
  --border: #E2E8F0;
  --bg: #F7FAFC;
  --white: #FFFFFF;
  --shadow: 0 4px 24px rgba(27,139,90,0.10);
  --shadow-md: 0 8px 40px rgba(27,139,90,0.13);
  --radius: 16px;
  --radius-sm: 10px;
}
* { margin:0; padding:0; box-sizing:border-box; }
html { scroll-behavior:smooth; }
body {
  font-family: 'Hind Siliguri', 'Poppins', sans-serif;
  color: var(--text);
  background: var(--white);
  font-size: 16px;
  line-height: 1.6;
}
.en { font-family: 'Poppins', sans-serif; }

/* ── NAV ── */
nav {
  position: sticky; top:0; z-index: 999;
  background: rgba(255,255,255,0.97);
  backdrop-filter: blur(12px);
  border-bottom: 1px solid var(--border);
  padding: 0 5%;
}
.nav-inner {
  max-width:1200px; margin:0 auto;
  display:flex; align-items:center; justify-content:space-between;
  height: 64px;
}
.logo {
  display:flex; align-items:center; gap:1px; text-decoration:none;
}
.logo-icon {
  height:40px;
  border-radius:10px; display:flex; align-items:center; justify-content:center;
  font-size:20px; overflow:hidden;
}
.logo-icon img { width:100%; height:100%; object-fit:cover; }
.logo-text { font-size:1.25rem; font-weight:700; color:var(--green); letter-spacing:-0.3px; }
.logo-text span { color: var(--accent); }
.nav-links { display:flex; align-items:center; gap:8px; }
.nav-links a {
  text-decoration:none; color:var(--text-2); font-size:0.9rem; font-weight:500;
  padding:7px 14px; border-radius:8px; transition:all .2s;
}
.nav-links a:hover { background:var(--green-light); color:var(--green); }
.btn-nav-login {
  border:2px solid var(--green) !important; color:var(--green) !important;
}
.btn-nav-cta {
  background:var(--green) !important; color:var(--white) !important;
  border-radius:8px !important;
}
.btn-nav-cta:hover { background:var(--green-dark) !important; }
.hamburger {
  display:none; background:none; border:none; cursor:pointer; padding:8px;
  flex-direction:column; gap:5px;
}
.hamburger span {
  display:block; width:24px; height:2px; background:var(--text); border-radius:2px;
  transition: all .3s;
}
.mobile-menu {
  display:none; flex-direction:column; gap:4px;
  padding:12px 0 16px; border-top:1px solid var(--border);
}
.mobile-menu a {
  text-decoration:none; color:var(--text-2); font-size:1rem; font-weight:500;
  padding:11px 16px; border-radius:8px; display:block; transition:all .2s;
}
.mobile-menu a:hover { background:var(--green-light); color:var(--green); }
.mobile-menu-btns { display:flex; gap:8px; padding: 8px 16px 0; }

/* ── HERO ── */
.hero {
  background: linear-gradient(135deg, #EFFAF5 0%, #F0FDF8 50%, #E8F5EE 100%);
  padding: 70px 5% 60px;
  position: relative; overflow:hidden;
}
.hero::before {
  content:'';
  position:absolute; top:-80px; right:-80px;
  width:400px; height:400px;
  background: radial-gradient(circle, rgba(27,139,90,0.08) 0%, transparent 70%);
  border-radius:50%;
}
.hero::after {
  content:'';
  position:absolute; bottom:-60px; left:-60px;
  width:300px; height:300px;
  background: radial-gradient(circle, rgba(244,163,0,0.07) 0%, transparent 70%);
  border-radius:50%;
}
.hero-inner {
  max-width:1200px; margin:0 auto;
  display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center;
  position:relative; z-index:1;
}
.hero-badge {
  display:inline-flex; align-items:center; gap:8px;
  background:var(--green-light); color:var(--green);
  border:1px solid rgba(27,139,90,0.2);
  padding:7px 16px; border-radius:50px; font-size:0.85rem; font-weight:600;
  margin-bottom:20px;
}
.hero-badge .dot { width:8px; height:8px; background:var(--green); border-radius:50%; animation:pulse 2s infinite; }
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.6;transform:scale(1.3)} }
.hero h1 {
  font-size: clamp(1.9rem, 4vw, 3rem);
  font-weight:800; line-height:1.2;
  color:var(--text); margin-bottom:18px;
}
.hero h1 .highlight { color:var(--green); }
.hero-sub {
  font-size:1.1rem; color:var(--text-2); margin-bottom:32px; max-width:480px;
}
.hero-btns { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:36px; }
.btn-primary {
  background:var(--green); color:#fff;
  padding:14px 28px; border-radius:12px; font-size:1rem; font-weight:700;
  text-decoration:none; border:none; cursor:pointer; display:inline-flex;
  align-items:center; gap:8px; transition:all .25s;
  box-shadow: 0 4px 16px rgba(27,139,90,0.3);
}
.btn-primary:hover { background:var(--green-dark); transform:translateY(-2px); box-shadow:0 8px 24px rgba(27,139,90,0.35); }
.btn-secondary {
  background:#fff; color:var(--green);
  padding:14px 28px; border-radius:12px; font-size:1rem; font-weight:700;
  text-decoration:none; border:2px solid var(--green); cursor:pointer;
  display:inline-flex; align-items:center; gap:8px; transition:all .25s;
}
.btn-secondary:hover { background:var(--green-light); transform:translateY(-2px); }
.trust-badges { display:flex; gap:16px; flex-wrap:wrap; }
.trust-badge {
  display:flex; align-items:center; gap:6px;
  background:#fff; border:1px solid var(--border);
  padding:8px 14px; border-radius:50px; font-size:0.82rem; font-weight:600; color:var(--text-2);
  box-shadow:0 2px 8px rgba(0,0,0,0.05);
}
.trust-badge .material-icons { font-size:16px; color:var(--green); }

/* Dashboard Preview */
.hero-visual { position:relative; }
.dashboard-preview {
  background:#fff; border-radius:20px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.12);
  overflow:hidden; border:1px solid var(--border);
}
.dash-header {
  background:var(--green); padding:14px 18px;
  display:flex; align-items:center; justify-content:space-between;
}
.dash-header-title { color:#fff; font-weight:700; font-size:0.95rem; }
.dash-header-date { color:rgba(255,255,255,0.8); font-size:0.78rem; }
.dash-body { padding:16px; }
.dash-stats { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:14px; }
.dash-stat {
  background:var(--bg); border-radius:12px; padding:12px;
  border:1px solid var(--border);
}
.dash-stat-label { font-size:0.72rem; color:var(--text-3); margin-bottom:4px; font-weight:500; }
.dash-stat-value { font-size:1.1rem; font-weight:800; color:var(--text); }
.dash-stat-value.green { color:var(--green); }
.dash-stat-value.accent { color:var(--accent); }
.dash-stat-value.blue { color:var(--blue); }
.dash-chart-label { font-size:0.78rem; color:var(--text-3); font-weight:600; margin-bottom:8px; }
.dash-bars { display:flex; align-items:flex-end; gap:5px; height:60px; }
.dash-bar { flex:1; background:var(--green); border-radius:4px 4px 0 0; opacity:.2; transition:.3s; }
.dash-bar.active { opacity:1; }
.dash-bar:nth-child(1){height:40%}
.dash-bar:nth-child(2){height:60%}
.dash-bar:nth-child(3){height:45%}
.dash-bar:nth-child(4){height:80%}
.dash-bar:nth-child(5){height:55%}
.dash-bar:nth-child(6){height:90%}
.dash-bar:nth-child(7){height:70%;opacity:1}
.dash-recent { margin-top:12px; }
.dash-recent-label { font-size:0.72rem; color:var(--text-3); font-weight:600; margin-bottom:6px; }
.dash-sale-item {
  display:flex; justify-content:space-between; align-items:center;
  padding:6px 0; border-bottom:1px solid var(--border); font-size:0.8rem;
}
.dash-sale-item:last-child { border-bottom:none; }
.dash-sale-name { color:var(--text); font-weight:500; }
.dash-sale-amt { color:var(--green); font-weight:700; }

/* Phone mockup float */
.phone-float {
  position:absolute; bottom:-20px; right:-20px;
  width:120px; background:#1A202C; border-radius:22px; border:5px solid #1A202C;
  box-shadow: 0 12px 40px rgba(0,0,0,0.25);
  overflow:hidden;
}
.phone-screen { background:var(--green-light); padding:8px; }
.phone-sale-row {
  background:#fff; border-radius:6px; padding:5px 7px; margin-bottom:5px;
  display:flex; justify-content:space-between; font-size:0.6rem;
}
.phone-sale-row .label { color:var(--text-3); }
.phone-sale-row .val { color:var(--green); font-weight:700; }
.phone-btn-mock {
  background:var(--green); color:#fff; text-align:center;
  padding:6px; border-radius:6px; font-size:0.62rem; font-weight:700; margin-top:4px;
}

/* ── SECTIONS ── */
section { padding:70px 5%; }
.section-inner { max-width:1200px; margin:0 auto; }
.section-tag {
  display:inline-flex; align-items:center; gap:6px;
  background:var(--green-light); color:var(--green);
  padding:6px 16px; border-radius:50px; font-size:0.82rem; font-weight:700;
  margin-bottom:14px;
}
.section-title { font-size:clamp(1.6rem,3.5vw,2.4rem); font-weight:800; margin-bottom:12px; line-height:1.25; }
.section-sub { font-size:1.05rem; color:var(--text-2); max-width:580px; }
.text-center { text-align:center; }
.text-center .section-sub { margin:0 auto; }
.section-bg { background:var(--bg); }
.section-green { background:linear-gradient(135deg,#1B8B5A,#136642); color:#fff; }
.section-green .section-title { color:#fff; }
.section-green .section-sub { color:rgba(255,255,255,0.85); }
.section-green .section-tag { background:rgba(255,255,255,0.15); color:#fff; }

/* ── PROBLEMS ── */
.problems-grid {
  display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
  gap:20px; margin-top:48px;
}
.problem-card {
  background:#fff; border-radius:var(--radius); padding:24px;
  border:1px solid var(--border); transition:all .3s;
  display:flex; gap:16px; align-items:flex-start;
}
.problem-card:hover { box-shadow:var(--shadow); transform:translateY(-3px); }
.prob-icon {
  width:48px; height:48px; flex-shrink:0; border-radius:12px;
  display:flex; align-items:center; justify-content:center;
  font-size:22px; background:var(--bg); border:1px solid var(--border);
}
.prob-arrow {
  display:flex; align-items:center; justify-content:center;
  font-size:1.5rem; color:var(--green); flex-shrink:0;
  padding:0 4px; align-self:center;
}
.prob-text h4 { font-size:0.95rem; font-weight:700; margin-bottom:4px; }
.prob-text p { font-size:0.85rem; color:var(--text-2); }
.prob-text .before { color:var(--red); }
.prob-text .after { color:var(--green); }

/* ── FEATURES ── */
.features-grid {
  display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
  gap:22px; margin-top:48px;
}
.feature-card {
  background:#fff; border-radius:var(--radius); padding:28px;
  border:1px solid var(--border); transition:all .3s; position:relative; overflow:hidden;
}
.feature-card::before {
  content:''; position:absolute; top:0; left:0; right:0; height:3px;
  background:var(--green); border-radius:3px 3px 0 0;
  transform:scaleX(0); transform-origin:left; transition:.3s;
}
.feature-card:hover::before { transform:scaleX(1); }
.feature-card:hover { box-shadow:var(--shadow-md); transform:translateY(-4px); }
.feat-icon {
  width:56px; height:56px; border-radius:14px;
  background:var(--green-light); display:flex; align-items:center; justify-content:center;
  font-size:26px; margin-bottom:16px; border:1px solid rgba(27,139,90,0.15);
}
.feature-card h3 { font-size:1.1rem; font-weight:700; margin-bottom:10px; }
.feature-card ul { list-style:none; }
.feature-card ul li {
  font-size:0.88rem; color:var(--text-2); padding:4px 0;
  display:flex; align-items:center; gap:8px;
}
.feature-card ul li::before {
  content:'✓'; color:var(--green); font-weight:800; font-size:0.82rem;
  width:18px; height:18px; background:var(--green-light);
  border-radius:50%; display:flex; align-items:center; justify-content:center;
  flex-shrink:0;
}

/* SEO content sections */
.use-case-grid,
.testimonial-grid {
  display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
  gap:20px; margin-top:42px;
}
.use-case-card,
.testimonial-card {
  background:#fff; border:1px solid var(--border); border-radius:var(--radius);
  padding:24px; transition:all .3s;
}
.use-case-card:hover,
.testimonial-card:hover { box-shadow:var(--shadow); transform:translateY(-3px); }
.use-case-card h3,
.testimonial-card h3 { font-size:1.05rem; font-weight:800; margin-bottom:8px; }
.use-case-card p,
.testimonial-card p { color:var(--text-2); font-size:0.92rem; }
.testimonial-card blockquote { color:var(--text-2); font-size:0.95rem; margin-bottom:16px; }
.testimonial-role { color:var(--green); font-size:0.82rem; font-weight:700; }
.seo-copy {
  margin-top:32px; background:var(--green-light); border:1px solid rgba(27,139,90,0.16);
  border-radius:var(--radius); padding:24px; color:var(--green-dark);
}
.seo-copy p { margin-bottom:10px; }
.seo-copy p:last-child { margin-bottom:0; }

/* ── BENEFITS ── */
.benefits-grid {
  display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
  gap:18px; margin-top:48px;
}
.benefit-card {
  background:rgba(255,255,255,0.1); border-radius:var(--radius);
  padding:24px; border:1px solid rgba(255,255,255,0.15);
  transition:all .3s; text-align:center;
}
.benefit-card:hover { background:rgba(255,255,255,0.18); transform:translateY(-3px); }
.benefit-icon { font-size:2.2rem; margin-bottom:12px; }
.benefit-card h4 { font-size:1rem; font-weight:700; color:#fff; margin-bottom:6px; }
.benefit-card p { font-size:0.87rem; color:rgba(255,255,255,0.8); }

/* ── HOW IT WORKS ── */
.steps-wrapper {
  display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
  gap:0; margin-top:52px; position:relative;
}
.steps-wrapper::before {
  content:''; position:absolute; top:36px; left:10%; right:10%; height:2px;
  background:linear-gradient(90deg,var(--green-light),var(--green),var(--green-light));
  z-index:0;
}
.step-card {
  text-align:center; position:relative; z-index:1; padding:0 16px;
}
.step-num {
  width:72px; height:72px; border-radius:50%;
  background:var(--green); color:#fff; font-size:1.6rem; font-weight:800;
  display:flex; align-items:center; justify-content:center;
  margin:0 auto 16px; border:4px solid #fff; box-shadow:0 4px 20px rgba(27,139,90,0.3);
}
.step-emoji { font-size:1.8rem; margin-bottom:8px; }
.step-card h4 { font-size:0.95rem; font-weight:700; margin-bottom:6px; }
.step-card p { font-size:0.82rem; color:var(--text-2); }

/* ── PLANS ── */
.plans-grid {
  display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
  gap:20px; margin-top:48px; align-items:start;
}
.plan-card {
  background:#fff; border-radius:var(--radius); padding:28px;
  border:2px solid var(--border); transition:all .3s; position:relative;
}
.plan-card.popular {
  border-color:var(--green);
  box-shadow:0 8px 40px rgba(27,139,90,0.18);
  transform:scale(1.03);
}
.popular-badge {
  position:absolute; top:-14px; left:50%; transform:translateX(-50%);
  background:var(--green); color:#fff; font-size:0.75rem; font-weight:700;
  padding:5px 18px; border-radius:50px; white-space:nowrap;
}
.plan-name { font-size:1.15rem; font-weight:800; margin-bottom:4px; }
.plan-price {
  font-size:2rem; font-weight:800; color:var(--green); line-height:1;
  margin:12px 0 4px;
}
.plan-price span { font-size:0.85rem; font-weight:500; color:var(--text-3); }
.plan-desc { font-size:0.83rem; color:var(--text-2); margin-bottom:18px; padding-bottom:18px; border-bottom:1px solid var(--border); }
.plan-features { list-style:none; margin-bottom:22px; }
.plan-features li {
  font-size:0.87rem; padding:5px 0; display:flex; align-items:flex-start; gap:8px; color:var(--text-2);
}
.plan-features li .check { color:var(--green); font-size:1rem; flex-shrink:0; }
.plan-features li .cross { color:#ccc; font-size:1rem; flex-shrink:0; }
.plan-btn {
  width:100%; padding:13px; border-radius:10px; font-size:0.95rem;
  font-weight:700; cursor:pointer; text-align:center; border:2px solid var(--green);
  color:var(--green); background:#fff; transition:all .25s; text-decoration:none;
  display:block;
}
.plan-btn.primary { background:var(--green); color:#fff; }
.plan-btn:hover { background:var(--green); color:#fff; }

/* Compare table */
.compare-table { margin-top:40px; border-radius:var(--radius); overflow:hidden; border:1px solid var(--border); }
.compare-table table { width:100%; border-collapse:collapse; }
.compare-table th {
  background:var(--green); color:#fff; padding:14px 16px; text-align:center;
  font-size:0.9rem; font-weight:700;
}
.compare-table th:first-child { text-align:left; }
.compare-table td {
  padding:12px 16px; text-align:center; font-size:0.87rem; border-bottom:1px solid var(--border);
}
.compare-table td:first-child { text-align:left; font-weight:500; }
.compare-table tr:last-child td { border-bottom:none; }
.compare-table tr:nth-child(even) td { background:var(--bg); }
.compare-table .check { color:var(--green); font-weight:700; font-size:1.1rem; }
.compare-table .cross { color:#CBD5E0; font-weight:700; font-size:1.1rem; }
.compare-table .pop-col { background:var(--green-light); }

/* ── MOBILE ── */
.mobile-section { background:var(--bg); }
.mobile-inner {
  display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center;
}
.device-chips { display:flex; flex-wrap:wrap; gap:12px; margin-bottom:28px; }
.device-chip {
  display:flex; align-items:center; gap:8px;
  background:#fff; border:1px solid var(--border); border-radius:50px;
  padding:10px 18px; font-size:0.9rem; font-weight:600;
}
.device-chip .material-icons { color:var(--green); font-size:20px; }
.mobile-note {
  background:var(--green-light); border-radius:12px; padding:16px 20px;
  font-size:0.9rem; color:var(--green-dark); font-weight:600;
  display:flex; align-items:center; gap:10px;
}

/* Phone group visual */
.phones-group { display:flex; gap:-10px; justify-content:center; position:relative; }
.phone-mock {
  background:#1A202C; border-radius:28px; border:6px solid #1A202C;
  overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,0.2);
  width:160px; flex-shrink:0;
}
.phone-mock.main { width:180px; transform:scale(1.05); z-index:2; box-shadow:0 24px 70px rgba(0,0,0,0.25); }
.phone-mock-screen { background:var(--green-light); min-height:280px; padding:12px; }
.pm-header { background:var(--green); color:#fff; padding:8px 10px; border-radius:8px; margin-bottom:8px; font-size:0.72rem; font-weight:700; }
.pm-card { background:#fff; border-radius:8px; padding:8px 10px; margin-bottom:6px; }
.pm-card-label { font-size:0.6rem; color:var(--text-3); }
.pm-card-val { font-size:0.85rem; font-weight:800; color:var(--green); }
.pm-row { display:flex; justify-content:space-between; background:#fff; border-radius:7px; padding:6px 8px; margin-bottom:4px; font-size:0.6rem; }
.pm-row .r-name { color:var(--text); font-weight:500; }
.pm-row .r-amt { color:var(--green); font-weight:700; }
.pm-sale-btn { background:var(--green); color:#fff; text-align:center; border-radius:7px; padding:8px; font-size:0.68rem; font-weight:700; margin-top:6px; }

/* ── SECURITY ── */
.security-grid {
  display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
  gap:18px; margin-top:48px;
}
.sec-card {
  background:#fff; border-radius:var(--radius); padding:24px;
  border:1px solid var(--border); text-align:center; transition:all .3s;
}
.sec-card:hover { box-shadow:var(--shadow); transform:translateY(-3px); }
.sec-icon {
  width:60px; height:60px; border-radius:50%;
  background:var(--green-light); display:flex; align-items:center; justify-content:center;
  margin:0 auto 14px; font-size:28px;
}
.sec-card h4 { font-size:1rem; font-weight:700; margin-bottom:6px; }
.sec-card p { font-size:0.85rem; color:var(--text-2); }

/* ── FAQ ── */
.faq-list { max-width:780px; margin:48px auto 0; }
.faq-item {
  background:#fff; border-radius:var(--radius-sm); border:1px solid var(--border);
  margin-bottom:10px; overflow:hidden;
}
.faq-q {
  display:flex; justify-content:space-between; align-items:center;
  padding:18px 22px; cursor:pointer; font-weight:600; font-size:1rem;
  transition:background .2s;
}
.faq-q:hover { background:var(--green-light); }
.faq-q .material-icons { color:var(--green); transition:.3s; }
.faq-item.open .faq-q { background:var(--green-light); color:var(--green); }
.faq-item.open .faq-q .material-icons { transform:rotate(45deg); }
.faq-a { display:none; padding:0 22px 18px; font-size:0.92rem; color:var(--text-2); }
.faq-item.open .faq-a { display:block; }

/* ── FINAL CTA ── */
.cta-section {
  background:linear-gradient(135deg,#1B8B5A 0%,#136642 100%);
  text-align:center; padding:80px 5%;
  position:relative; overflow:hidden;
}
.cta-section::before {
  content:''; position:absolute; top:-100px; left:50%; transform:translateX(-50%);
  width:600px; height:600px;
  background:radial-gradient(circle,rgba(255,255,255,0.06) 0%,transparent 70%);
  border-radius:50%;
}
.cta-section h2 { font-size:clamp(1.8rem,4vw,3rem); font-weight:800; color:#fff; margin-bottom:16px; }
.cta-section p { font-size:1.05rem; color:rgba(255,255,255,0.85); margin-bottom:36px; max-width:520px; margin-left:auto; margin-right:auto; }
.cta-btns { display:flex; gap:14px; justify-content:center; flex-wrap:wrap; }
.btn-cta-white {
  background:#fff; color:var(--green);
  padding:16px 32px; border-radius:12px; font-size:1.05rem; font-weight:800;
  text-decoration:none; display:inline-flex; align-items:center; gap:8px;
  transition:all .25s; box-shadow:0 6px 24px rgba(0,0,0,0.15);
}
.btn-cta-white:hover { transform:translateY(-3px); box-shadow:0 10px 32px rgba(0,0,0,0.2); }
.btn-cta-outline {
  background:transparent; color:#fff;
  padding:16px 32px; border-radius:12px; font-size:1.05rem; font-weight:700;
  text-decoration:none; border:2px solid rgba(255,255,255,0.7);
  display:inline-flex; align-items:center; gap:8px; transition:all .25s;
}
.btn-cta-outline:hover { background:rgba(255,255,255,0.12); transform:translateY(-3px); }
.cta-note { color:rgba(255,255,255,0.7); font-size:0.85rem; margin-top:20px; }

/* ── FOOTER ── */
footer {
  background:#111827; color:rgba(255,255,255,0.7);
  padding:40px 5% 24px;
}
.footer-inner {
  max-width:1200px; margin:0 auto;
  display:flex; flex-wrap:wrap; gap:32px; justify-content:space-between;
  padding-bottom:28px; border-bottom:1px solid rgba(255,255,255,0.1);
  margin-bottom:20px;
}
.footer-brand .logo-text { color:#fff; }
.footer-brand p { font-size:0.87rem; margin-top:10px; max-width:260px; color:rgba(255,255,255,0.6); }
.footer-col h5 { color:#fff; font-size:0.9rem; font-weight:700; margin-bottom:12px; }
.footer-col a {
  display:block; font-size:0.85rem; color:rgba(255,255,255,0.6);
  text-decoration:none; margin-bottom:7px; transition:.2s;
}
.footer-col a:hover { color:#fff; }
.footer-bottom { max-width:1200px; margin:0 auto; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; font-size:0.82rem; }
.footer-bottom a { color:rgba(255,255,255,0.5); text-decoration:none; }
/* Developer credit */
.footer-credit {
  display:inline-flex; align-items:center; gap:8px;
  padding:7px 16px; border-radius:999px;
  background:rgba(255,255,255,0.06);
  border:1px solid rgba(255,255,255,0.12);
  color:rgba(255,255,255,0.75); font-size:0.82rem;
  text-decoration:none; transition:.25s;
}
.footer-credit:hover {
  background:linear-gradient(135deg, var(--green), #0ea371);
  border-color:transparent; color:#fff; transform:translateY(-2px);
  box-shadow:0 8px 20px rgba(16,185,129,0.35);
}
.footer-credit .dev-heart { color:#ef4444; }
.footer-credit .dev-name { font-weight:700; }

/* ── DIVIDER ── */
.divider {
  width:60px; height:4px; background:var(--green); border-radius:4px;
  margin:12px 0 0;
}
.divider.center { margin:12px auto 0; }

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
  .nav-links { display:none; }
  .hamburger { display:flex; }
  .hero-inner { grid-template-columns:1fr; gap:40px; }
  .hero-visual { order:-1; }
  .mobile-inner { grid-template-columns:1fr; }
  .phones-group { flex-direction:column; align-items:center; }
  .phone-mock { width:100%; max-width:220px; }
  .phone-mock.main { transform:none; width:100%; max-width:240px; }
  .steps-wrapper::before { display:none; }
  .steps-wrapper { gap:24px; }
  .plan-card.popular { transform:none; }
  .compare-table { overflow-x:auto; }
  .compare-table table { min-width:520px; }
  section { padding:52px 5%; }
  .hero { padding:50px 5% 50px; }
  .trust-badges { gap:8px; }
  .trust-badge { font-size:0.76rem; padding:6px 10px; }
  .hero-btns .btn-primary, .hero-btns .btn-secondary { padding:13px 22px; font-size:0.95rem; }
}
@media (max-width:480px) {
  .features-grid { grid-template-columns:1fr; }
  .plans-grid { grid-template-columns:1fr; }
  .security-grid { grid-template-columns:1fr 1fr; }
  .cta-btns { flex-direction:column; align-items:center; }
}

/* Animations */
@keyframes fadeUp {
  from { opacity:0; transform:translateY(24px); }
  to   { opacity:1; transform:translateY(0); }
}
.fade-up { animation: fadeUp .7s ease both; }
.delay-1 { animation-delay:.1s; }
.delay-2 { animation-delay:.2s; }
.delay-3 { animation-delay:.3s; }
.delay-4 { animation-delay:.4s; }
</style>
</head>
<body>

<!-- ═══════════════════════════════ NAV ═══════════════════════════════ -->
<nav>
  <div class="nav-inner">
    <a href="{{ route('home') }}" class="logo">
      <div class="logo-icon"><img src="{{ asset('assets/img/project/brand-logo.svg') }}" alt="{{ t('brand.name') }}"></div>
      {{-- <span class="logo-text"><img src="{{ asset('assets/img/project/brand.svg') }}" alt="{{ t('brand.name') }}" style="height:15px;"></span> --}}
    </a>
    <div class="nav-links">
      <a href="#features">{{ t('landing.nav_features') }}</a>
      <a href="#how">{{ t('landing.nav_how') }}</a>
      <a href="#plans">{{ t('landing.nav_plans') }}</a>
      <a href="#faq">FAQ</a>
      <a href="{{ route('login') }}" class="btn-nav-login">{{ t('landing.nav_login') }}</a>
      <a href="{{ route('register') }}" class="btn-nav-cta">{{ t('landing.nav_cta') }}</a>
    </div>
    <button class="hamburger" id="hamburger" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </div>
  <div class="mobile-menu" id="mobileMenu">
    <a href="#features">{{ t('landing.nav_features') }}</a>
    <a href="#how">{{ t('landing.nav_how') }}</a>
    <a href="#plans">{{ t('landing.nav_plans') }}</a>
    <a href="#faq">{{ t('landing.nav_faq') }}</a>
    <div class="mobile-menu-btns">
      <a href="{{ route('login') }}" class="btn-secondary" style="flex:1;text-align:center;padding:11px;">{{ t('landing.nav_login') }}</a>
      <a href="{{ route('register') }}" class="btn-primary" style="flex:1;text-align:center;padding:11px;">{{ t('landing.nav_cta_short') }}</a>
    </div>
  </div>
</nav>

<main id="content">

<!-- ═══════════════════════════════ HERO ═══════════════════════════════ -->
<section class="hero">
  <div class="hero-inner">
    <div class="hero-content">
      <div class="hero-badge fade-up"><span class="dot"></span> {{ t('landing.hero_badge') }}</div>
      <h1 class="fade-up delay-1">
        {{ t('landing.hero_title_1') }} <span class="highlight">{{ t('landing.hero_title_2') }}</span>
      </h1>
      <p class="hero-sub fade-up delay-2">
        {{ t('landing.hero_subtitle') }}
      </p>
      <div class="hero-btns fade-up delay-3">
        <a href="{{ route('register') }}" class="btn-primary">{{ t('landing.nav_cta') }}</a>
        <a href="{{ route('login') }}" class="btn-secondary">{{ t('landing.login_cta') }}</a>
      </div>
      <div class="trust-badges fade-up delay-4">
        <div class="trust-badge"><span class="material-icons">smartphone</span> {{ t('landing.trust_mobile') }}</div>
        <div class="trust-badge"><span class="material-icons">cloud</span> {{ t('landing.trust_cloud') }}</div>
        <div class="trust-badge"><span class="material-icons">lock</span> {{ t('landing.trust_secure') }}</div>
        <div class="trust-badge"><span class="material-icons">devices</span> {{ t('landing.trust_multidevice') }}</div>
      </div>
    </div>

    <!-- Dashboard Preview -->
    <div class="hero-visual fade-up delay-2">
      <picture>
        <source srcset="{{ asset('assets/img/project/screenshot.webp') }}" type="image/webp">
        <img src="{{ asset('assets/img/project/screenshot.jpg') }}" width="1549" height="979" alt="{{ $seo['brand'] }} accounting and inventory management software dashboard" fetchpriority="high" decoding="async" style="width:100%;height:auto;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,0.12);">
      </picture>
      {{-- <div class="dashboard-preview">
        <div class="dash-header">
          <span class="dash-header-title">📒 {{ t('brand.name') }}</span>
          <span class="dash-header-date">{{ t('landing.demo_summary') }}</span>
        </div>
        <div class="dash-body">
          <div class="dash-stats">
            <div class="dash-stat">
              <div class="dash-stat-label">{{ t('dashboard.today_sales') }}</div>
              <div class="dash-stat-value green">৳ ১২,৪৫০</div>
            </div>
            <div class="dash-stat">
              <div class="dash-stat-label">{{ t('landing.demo_total_profit') }}</div>
              <div class="dash-stat-value accent">৳ ৩,৮৮০</div>
            </div>
            <div class="dash-stat">
              <div class="dash-stat-label">{{ t('landing.demo_product_count') }}</div>
              <div class="dash-stat-value blue">২৪৮টি</div>
            </div>
            <div class="dash-stat">
              <div class="dash-stat-label">{{ t('landing.demo_due') }}</div>
              <div class="dash-stat-value" style="color:#E53E3E">৳ ৫,২৩০</div>
            </div>
          </div>
          <div class="dash-chart-label">📊 {{ t('landing.demo_weekly_sales') }}</div>
          <div class="dash-bars">
            <div class="dash-bar"></div>
            <div class="dash-bar"></div>
            <div class="dash-bar"></div>
            <div class="dash-bar"></div>
            <div class="dash-bar"></div>
            <div class="dash-bar"></div>
            <div class="dash-bar active"></div>
          </div>
          <div class="dash-recent">
            <div class="dash-recent-label">🛍️ {{ t('dashboard.recent_sales') }}</div>
            <div class="dash-sale-item">
              <span class="dash-sale-name">{{ t('landing.demo_sale_1') }}</span>
              <span class="dash-sale-amt">৳ ১৮০</span>
            </div>
            <div class="dash-sale-item">
              <span class="dash-sale-name">{{ t('landing.demo_sale_2') }}</span>
              <span class="dash-sale-amt">৳ ৩৫০</span>
            </div>
            <div class="dash-sale-item">
              <span class="dash-sale-name">{{ t('landing.demo_sale_3') }}</span>
              <span class="dash-sale-amt">৳ ৪২০</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Phone float -->
      <div class="phone-float">
        <div class="phone-screen">
          <div style="font-size:0.62rem;font-weight:700;color:var(--green);margin-bottom:6px;">📱 {{ t('landing.add_sale') }}</div>
          <div class="phone-sale-row"><span class="label">{{ t('landing.label_product') }}</span><span class="val">{{ t('landing.demo_rice_5kg') }}</span></div>
          <div class="phone-sale-row"><span class="label">{{ t('common.price') }}</span><span class="val">৳৪২০</span></div>
          <div class="phone-sale-row"><span class="label">{{ t('landing.label_amount') }}</span><span class="val">{{ t('landing.qty_2') }}</span></div>
          <div class="phone-btn-mock">✅ {{ t('landing.save_btn') }}</div>
        </div>
      </div> --}}
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ WHY ═══════════════════════════════ -->
<section class="section-bg" id="why">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag">{{ t('landing.why_tag') }}</div>
      <h2 class="section-title">{{ t('landing.why_title_1') }}<br>{{ t('landing.why_title_2') }}</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:14px">{{ t('landing.why_subtitle') }}</p>
    </div>
    <div class="problems-grid">
      <div class="problem-card">
        <div class="prob-icon">📓</div>
        <div class="prob-arrow">→</div>
        <div class="prob-text">
          <h4 class="before">{{ t('landing.problem_1_before') }}</h4>
          <p class="after">{{ t('landing.problem_1_after') }}</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="prob-icon">📦</div>
        <div class="prob-arrow">→</div>
        <div class="prob-text">
          <h4 class="before">{{ t('landing.problem_2_before') }}</h4>
          <p class="after">{{ t('landing.problem_2_after') }}</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="prob-icon">💰</div>
        <div class="prob-arrow">→</div>
        <div class="prob-text">
          <h4 class="before">{{ t('landing.problem_3_before') }}</h4>
          <p class="after">{{ t('landing.problem_3_after') }}</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="prob-icon">🧾</div>
        <div class="prob-arrow">→</div>
        <div class="prob-text">
          <h4 class="before">{{ t('landing.problem_4_before') }}</h4>
          <p class="after">{{ t('landing.problem_4_after') }}</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="prob-icon">🗂️</div>
        <div class="prob-arrow">→</div>
        <div class="prob-text">
          <h4 class="before">{{ t('landing.problem_5_before') }}</h4>
          <p class="after">{{ t('landing.problem_5_after') }}</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="prob-icon">📊</div>
        <div class="prob-arrow">→</div>
        <div class="prob-text">
          <h4 class="before">{{ t('landing.problem_6_before') }}</h4>
          <p class="after">{{ t('landing.problem_6_after') }}</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-bg" id="use-cases">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag">{{ $seo['locale'] === 'bn' ? 'ব্যবহারের ক্ষেত্র' : 'Use Cases' }}</div>
      <h2 class="section-title">Made for Bangladeshi Businesses</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:14px">
        {{ $seo['locale'] === 'bn' ? 'Trusted Business Software হিসেবে হিসাবিজ দোকান, পাইকারি ও SME ব্যবসার দৈনন্দিন কাজ সহজ করে।' : 'Hishabiz helps shops, wholesalers and SMEs run daily operations with Trusted Business Software.' }}
      </p>
    </div>
    <div class="use-case-grid">
      @foreach ($seo['useCases'] as $useCase)
        <article class="use-case-card">
          <h3>{{ $useCase['title'] }}</h3>
          <p>{{ $useCase['text'] }}</p>
        </article>
      @endforeach
    </div>
    <div class="seo-copy">
      <p>{{ $seo['locale'] === 'bn' ? 'হিসাবিজ একটি Reliable Accounting Software এবং Easy Business Management Software, যা বিক্রয়, খরচ, কাস্টমার বাকি, সাপ্লায়ার বাকি, ইনভয়েস ও রিপোর্ট একসাথে ম্যানেজ করতে সাহায্য করে।' : 'Hishabiz is Reliable Accounting Software and Easy Business Management Software for sales, expenses, customer dues, supplier dues, invoices and reports.' }}</p>
      <p>{{ $seo['locale'] === 'bn' ? 'Inventory Management Software Bangladesh এবং Small Business Software খুঁজছেন এমন ব্যবসার জন্য এটি সহজ, মোবাইল-ফ্রেন্ডলি ও SSR-friendly ওয়েব অ্যাপ।' : 'For teams searching for Inventory Management Software Bangladesh, SME Software Bangladesh or small business software, Hishabiz is simple, mobile-friendly and built for Bangladeshi businesses.' }}</p>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ FEATURES ═══════════════════════════════ -->
<section id="features">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag">{{ t('landing.features_tag') }}</div>
      <h2 class="section-title">{{ t('landing.features_title_1') }}<br>{{ t('landing.features_title_2') }}</h2>
      <div class="divider center"></div>
    </div>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feat-icon">🛍️</div>
        <h3>{{ t('landing.feat_sales_title') }}</h3>
        <ul>
          <li>{{ t('landing.feat_sales_1') }}</li>
          <li>{{ t('landing.feat_sales_2') }}</li>
          <li>{{ t('landing.feat_sales_3') }}</li>
          <li>{{ t('landing.feat_sales_4') }}</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon">🚚</div>
        <h3>{{ t('landing.feat_purchase_title') }}</h3>
        <ul>
          <li>{{ t('landing.feat_purchase_1') }}</li>
          <li>{{ t('landing.feat_purchase_2') }}</li>
          <li>{{ t('landing.feat_purchase_3') }}</li>
          <li>{{ t('landing.feat_purchase_4') }}</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon">📦</div>
        <h3>{{ t('landing.feat_stock_title') }}</h3>
        <ul>
          <li>{{ t('landing.feat_stock_1') }}</li>
          <li>{{ t('landing.feat_stock_2') }}</li>
          <li>{{ t('landing.feat_stock_3') }}</li>
          <li>{{ t('landing.feat_stock_4') }}</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon">👤</div>
        <h3>{{ t('landing.feat_customer_title') }}</h3>
        <ul>
          <li>{{ t('landing.feat_customer_1') }}</li>
          <li>{{ t('landing.feat_customer_2') }}</li>
          <li>{{ t('landing.feat_customer_3') }}</li>
          <li>{{ t('landing.feat_customer_4') }}</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon">💳</div>
        <h3>{{ t('landing.feat_expense_title') }}</h3>
        <ul>
          <li>{{ t('landing.feat_expense_1') }}</li>
          <li>{{ t('landing.feat_expense_2') }}</li>
          <li>{{ t('landing.feat_expense_3') }}</li>
          <li>{{ t('landing.feat_expense_4') }}</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon">📊</div>
        <h3>{{ t('landing.feat_report_title') }}</h3>
        <ul>
          <li>{{ t('landing.feat_report_1') }}</li>
          <li>{{ t('landing.feat_report_2') }}</li>
          <li>{{ t('landing.feat_report_3') }}</li>
          <li>{{ t('landing.feat_report_4') }}</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon">💰</div>
        <h3>{{ t('landing.feat_cashbook_title') }}</h3>
        <ul>
          <li>{{ t('landing.feat_cashbook_1') }}</li>
          <li>{{ t('landing.feat_cashbook_2') }}</li>
          <li>{{ t('landing.feat_cashbook_3') }}</li>
          <li>{{ t('landing.feat_cashbook_4') }}</li>
        </ul>
      </div>
      <div class="feature-card" style="background:var(--green-light);border-color:rgba(27,139,90,0.2)">
        <div class="feat-icon" style="background:#fff">🧾</div>
        <h3>{{ t('landing.feat_invoice_title') }}</h3>
        <ul>
          <li>{{ t('landing.feat_invoice_1') }}</li>
          <li>{{ t('landing.feat_invoice_2') }}</li>
          <li>{{ t('landing.feat_invoice_3') }}</li>
          <li>{{ t('landing.feat_invoice_4') }}</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ BENEFITS ═══════════════════════════════ -->
<section class="section-green">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag">❤️ {{ t('landing.benefits_tag') }}</div>
      <h2 class="section-title">{{ t('landing.benefits_title_1') }}<br>{{ t('landing.benefits_title_2') }}</h2>
      <div class="divider center" style="background:#fff;margin:12px auto 0"></div>
    </div>
    <div class="benefits-grid">
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/responsive.svg') }}" alt="Responsive Design" width="60" height="60" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_1_title') }}</h4>
        <p>{{ t('landing.benefit_1_desc') }}</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/math.svg') }}" alt="No Math Skills Required" width="60" height="60" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_2_title') }}</h4>
        <p>{{ t('landing.benefit_2_desc') }}</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/clock.svg') }}" alt="Save time with business management software" width="60" height="60" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_3_title') }}</h4>
        <p>{{ t('landing.benefit_3_desc') }}</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/stock.svg') }}" alt="Inventory management software" width="60" height="60" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_4_title') }}</h4>
        <p>{{ t('landing.benefit_4_desc') }}</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/b5.svg') }}" alt="Business reporting" width="60" height="60" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_5_title') }}</h4>
        <p>{{ t('landing.benefit_5_desc') }}</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/b6.svg') }}" alt="Small business software" width="60" height="60" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_6_title') }}</h4>
        <p>{{ t('landing.benefit_6_desc') }}</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/b7.svg') }}" alt="Cloud accounting software" width="60" height="60" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_7_title') }}</h4>
        <p>{{ t('landing.benefit_7_desc') }}</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/b8.svg') }}" alt="SME software Bangladesh" width="60" height="60" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_8_title') }}</h4>
        <p>{{ t('landing.benefit_8_desc') }}</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ HOW IT WORKS ═══════════════════════════════ -->
<section class="section-bg" id="how">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag">🗺️ {{ t('landing.nav_how') }}</div>
      <h2 class="section-title">{{ t('landing.how_title') }}</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:14px">{{ t('landing.how_subtitle') }}</p>
    </div>
    <div class="steps-wrapper">
      <div class="step-card">
        <div class="step-num">{{ t('landing.step_1') }}</div>
        <div class="step-emoji">🏪</div>
        <h4>{{ t('landing.step_1_title') }}</h4>
        <p>{{ t('landing.step_1_desc') }}</p>
      </div>
      <div class="step-card">
        <div class="step-num">{{ t('landing.step_2') }}</div>
        <div class="step-emoji">📦</div>
        <h4>{{ t('landing.step_2_title') }}</h4>
        <p>{{ t('landing.step_2_desc') }}</p>
      </div>
      <div class="step-card">
        <div class="step-num">{{ t('landing.step_3') }}</div>
        <div class="step-emoji">🛒</div>
        <h4>{{ t('landing.step_3_title') }}</h4>
        <p>{{ t('landing.step_3_desc') }}</p>
      </div>
      <div class="step-card">
        <div class="step-num">{{ t('landing.step_4') }}</div>
        <div class="step-emoji">💰</div>
        <h4>{{ t('landing.step_4_title') }}</h4>
        <p>{{ t('landing.step_4_desc') }}</p>
      </div>
      <div class="step-card">
        <div class="step-num">{{ t('landing.step_5') }}</div>
        <div class="step-emoji">📊</div>
        <h4>{{ t('landing.step_5_title') }}</h4>
        <p>{{ t('landing.step_5_desc') }}</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ PLANS ═══════════════════════════════ -->
<section id="plans">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag">💎 {{ t('landing.plans_tag') }}</div>
      <h2 class="section-title">{{ t('landing.plans_title_1') }}<br>{{ t('landing.plans_title_2') }}</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:14px">{{ t('landing.plans_subtitle') }}</p>
    </div>
    <div class="plans-grid">
      <!-- Free -->
      <div class="plan-card">
        <div class="plan-name">🎁 {{ t('landing.plan_free_name') }}</div>
        <div class="plan-price">৳ ০ <span>{{ t('landing.per_month') }}</span></div>
        <p class="plan-desc">{{ t('landing.plan_free_desc') }}</p>
        <ul class="plan-features">
          <li><span class="check">✓</span> {{ t('landing.plan_free_f1') }}</li>
          <li><span class="check">✓</span> {{ t('landing.plan_free_f2') }}</li>
          <li><span class="check">✓</span> {{ t('landing.plan_free_f3') }}</li>
          <li><span class="cross">✗</span> {{ t('landing.plan_free_f4') }}</li>
          <li><span class="cross">✗</span> {{ t('landing.customer_mgmt') }}</li>
          <li><span class="cross">✗</span> {{ t('landing.backup') }}</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn">{{ t('landing.nav_cta') }}</a>
      </div>

      <!-- Starter -->
      <div class="plan-card">
        <div class="plan-name">⭐ {{ t('landing.plan_starter_name') }}</div>
        <div class="plan-price">৳ ২৯৯ <span>{{ t('landing.per_month') }}</span></div>
        <p class="plan-desc">{{ t('landing.plan_starter_desc') }}</p>
        <ul class="plan-features">
          <li><span class="check">✓</span> {{ t('landing.plan_starter_f1') }}</li>
          <li><span class="check">✓</span> {{ t('landing.unlimited_sales') }}</li>
          <li><span class="check">✓</span> {{ t('landing.invoice_create') }}</li>
          <li><span class="check">✓</span> {{ t('landing.customer_mgmt') }}</li>
          <li><span class="check">✓</span> {{ t('landing.cloud_backup') }}</li>
          <li><span class="cross">✗</span> {{ t('landing.multi_user') }}</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn">{{ t('landing.start_btn') }}</a>
      </div>

      <!-- Dreamer plan -->
      <div class="plan-card popular">
        <div class="popular-badge">⭐ {{ t('landing.plan_popular_badge') }}</div>
        <div class="plan-name">🚀 {{ t('landing.plan_dreamer_name') }}</div>
        <div class="plan-price">৳ ৫৯৯ <span>{{ t('landing.per_month') }}</span></div>
        <p class="plan-desc">{{ t('landing.plan_dreamer_desc') }}</p>
        <ul class="plan-features">
          <li><span class="check">✓</span> {{ t('landing.unlimited_products') }}</li>
          <li><span class="check">✓</span> {{ t('landing.unlimited_sales') }}</li>
          <li><span class="check">✓</span> {{ t('landing.plan_dreamer_f3') }}</li>
          <li><span class="check">✓</span> {{ t('landing.plan_dreamer_f4') }}</li>
          <li><span class="check">✓</span> {{ t('landing.plan_dreamer_f5') }}</li>
          <li><span class="check">✓</span> {{ t('landing.plan_dreamer_f6') }}</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn primary">{{ t('landing.plan_dreamer_btn') }}</a>
      </div>

      <!-- Enterprise -->
      <div class="plan-card">
        <div class="plan-name">🏢 {{ t('landing.plan_enterprise_name') }}</div>
        <div class="plan-price">৳ ১,২৯৯ <span>{{ t('landing.per_month') }}</span></div>
        <p class="plan-desc">{{ t('landing.plan_enterprise_desc') }}</p>
        <ul class="plan-features">
          <li><span class="check">✓</span> {{ t('landing.plan_enterprise_f1') }}</li>
          <li><span class="check">✓</span> {{ t('landing.plan_enterprise_f2') }}</li>
          <li><span class="check">✓</span> {{ t('landing.multi_branch') }}</li>
          <li><span class="check">✓</span> {{ t('landing.plan_enterprise_f4') }}</li>
          <li><span class="check">✓</span> {{ t('landing.plan_enterprise_f5') }}</li>
          <li><span class="check">✓</span> {{ t('landing.plan_enterprise_f6') }}</li>
        </ul>
        <a href="#" class="plan-btn">{{ t('landing.contact_btn') }}</a>
      </div>
    </div>

    <!-- Comparison Table -->
    <div class="compare-table">
      <table>
        <thead>
          <tr>
            <th>{{ t('landing.nav_features') }}</th>
            <th>{{ t('landing.plan_free_name') }}</th>
            <th>{{ t('landing.plan_starter_name') }}</th>
            <th class="pop-col">{{ t('landing.plan_dreamer_name') }} ⭐</th>
            <th>{{ t('landing.plan_enterprise_name') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ t('landing.compare_row_product_limit') }}</td>
            <td>{{ t('landing.qty_50') }}</td>
            <td>{{ t('landing.qty_500') }}</td>
            <td class="pop-col">{{ t('landing.unlimited') }}</td>
            <td>{{ t('landing.unlimited') }}</td>
          </tr>
          <tr>
            <td>{{ t('landing.compare_row_sales_entry') }}</td>
            <td>{{ t('landing.sales_100_month') }}</td>
            <td>{{ t('landing.unlimited') }}</td>
            <td class="pop-col">{{ t('landing.unlimited') }}</td>
            <td>{{ t('landing.unlimited') }}</td>
          </tr>
          <tr>
            <td>{{ t('landing.invoice_create') }}</td>
            <td class="cross">✗</td>
            <td class="check">✓</td>
            <td class="pop-col check">✓</td>
            <td class="check">✓</td>
          </tr>
          <tr>
            <td>{{ t('landing.customer_mgmt') }}</td>
            <td class="cross">✗</td>
            <td class="check">✓</td>
            <td class="pop-col check">✓</td>
            <td class="check">✓</td>
          </tr>
          <tr>
            <td>{{ t('landing.cloud_backup') }}</td>
            <td class="cross">✗</td>
            <td class="check">✓</td>
            <td class="pop-col check">✓</td>
            <td class="check">✓</td>
          </tr>
          <tr>
            <td>{{ t('landing.multi_user') }}</td>
            <td class="cross">✗</td>
            <td class="cross">✗</td>
            <td class="pop-col">{{ t('landing.users_3') }}</td>
            <td>{{ t('landing.unlimited') }}</td>
          </tr>
          <tr>
            <td>{{ t('landing.multi_branch') }}</td>
            <td class="cross">✗</td>
            <td class="cross">✗</td>
            <td class="pop-col cross">✗</td>
            <td class="check">✓</td>
          </tr>
          <tr>
            <td>{{ t('landing.compare_row_priority_support') }}</td>
            <td class="cross">✗</td>
            <td class="cross">✗</td>
            <td class="pop-col cross">✗</td>
            <td class="check">✓</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ MOBILE ═══════════════════════════════ -->
<section class="mobile-section" id="mobile">
  <div class="section-inner">
    <div class="mobile-inner">
      <div>
        <div class="section-tag">📱 {{ t('landing.mobile_tag') }}</div>
        <h2 class="section-title">{{ t('landing.mobile_title_1') }}<br>{{ t('landing.mobile_title_2') }}</h2>
        <div class="divider"></div>
        <p style="color:var(--text-2);margin:16px 0 24px;font-size:1rem">{{ t('landing.mobile_subtitle') }}</p>
        <div class="device-chips">
          <div class="device-chip"><span class="material-icons">android</span> Android</div>
          <div class="device-chip"><span class="material-icons">phone_iphone</span> iPhone</div>
          <div class="device-chip"><span class="material-icons">tablet</span> Tablet</div>
          <div class="device-chip"><span class="material-icons">computer</span> Desktop</div>
        </div>
        <div class="mobile-note">
          <span>💡</span>
          <span>{{ t('landing.mobile_note') }}</span>
        </div>
      </div>
      <div class="phones-group">
        <div class="phone-mock">
          <div class="phone-mock-screen">
            <div class="pm-header">📦 {{ t('landing.stock_list') }}</div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_rice_kg') }}</span><span class="r-amt">{{ t('landing.val_48kg') }}</span></div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_dal_kg') }}</span><span class="r-amt">{{ t('landing.val_22kg') }}</span></div>
            <div class="pm-row" style="background:#FFF5F5"><span class="r-name" style="color:#E53E3E">🔴 {{ t('landing.demo_mustard_oil') }}</span><span class="r-amt" style="color:#E53E3E">{{ t('landing.val_3liter') }}</span></div>
          </div>
        </div>
        <div class="phone-mock main">
          <div class="phone-mock-screen">
            <div class="pm-header">📒 {{ t('nav.dashboard') }}</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;margin-bottom:8px">
              <div class="pm-card"><div class="pm-card-label">{{ t('landing.today_sale_short') }}</div><div class="pm-card-val">৳ ৮,৪৫০</div></div>
              <div class="pm-card"><div class="pm-card-label">{{ t('landing.profit') }}</div><div class="pm-card-val">৳ ২,১২০</div></div>
            </div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_soap_5pc') }}</span><span class="r-amt">৳ ৩০০</span></div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_shampoo') }}</span><span class="r-amt">৳ ৩৫০</span></div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_rice_10kg') }}</span><span class="r-amt">৳ ৮৪০</span></div>
            <div class="pm-sale-btn">+ {{ t('dashboard.new_sale') }}</div>
          </div>
        </div>
        <div class="phone-mock">
          <div class="phone-mock-screen">
            <div class="pm-header">👤 {{ t('landing.due_list') }}</div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_name_1') }}</span><span class="r-amt" style="color:#E53E3E">৳ ১,২০০</span></div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_name_2') }}</span><span class="r-amt" style="color:#E53E3E">৳ ৬৮০</span></div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_name_3') }}</span><span class="r-amt" style="color:#E53E3E">৳ ৩৪০</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ SECURITY ═══════════════════════════════ -->
<section id="security">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag">🔒 {{ t('landing.security_tag') }}</div>
      <h2 class="section-title">{{ t('landing.security_title_1') }}<br>{{ t('landing.security_title_2') }}</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:14px">{{ t('landing.security_subtitle') }}</p>
    </div>
    <div class="security-grid">
      <div class="sec-card">
        <div class="sec-icon">☁️</div>
        <h4>{{ t('landing.cloud_backup') }}</h4>
        <p>{{ t('landing.sec_1_desc') }}</p>
      </div>
      <div class="sec-card">
        <div class="sec-icon">🔐</div>
        <h4>{{ t('landing.sec_2_title') }}</h4>
        <p>{{ t('landing.sec_2_desc') }}</p>
      </div>
      <div class="sec-card">
        <div class="sec-icon">🛡️</div>
        <h4>{{ t('landing.sec_3_title') }}</h4>
        <p>{{ t('landing.sec_3_desc') }}</p>
      </div>
      <div class="sec-card">
        <div class="sec-icon">🏢</div>
        <h4>{{ t('landing.sec_4_title') }}</h4>
        <p>{{ t('landing.sec_4_desc') }}</p>
      </div>
      <div class="sec-card">
        <div class="sec-icon">👥</div>
        <h4>{{ t('landing.sec_5_title') }}</h4>
        <p>{{ t('landing.sec_5_desc') }}</p>
      </div>
      <div class="sec-card">
        <div class="sec-icon">🔄</div>
        <h4>{{ t('landing.sec_6_title') }}</h4>
        <p>{{ t('landing.sec_6_desc') }}</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ FAQ ═══════════════════════════════ -->
<section class="section-bg" id="faq">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag">❓ {{ t('landing.faq_tag') }}</div>
      <h2 class="section-title">{{ t('landing.faq_title') }}</h2>
      <div class="divider center"></div>
    </div>
    <div class="faq-list">
      <div class="faq-item open">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q1') }}</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a1') }}</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q2') }}</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a2') }}</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q3') }}</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a3') }}</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q4') }}</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a4') }}</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q5') }}</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a5') }}</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q6') }}</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a6') }}</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q7') }}</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a7') }}</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q8') }}</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a8') }}</div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ FINAL CTA ═══════════════════════════════ -->
<section id="testimonials">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag">{{ $seo['locale'] === 'bn' ? 'গ্রাহকদের অভিজ্ঞতা' : 'Testimonials' }}</div>
      <h2 class="section-title">{{ $seo['locale'] === 'bn' ? 'বাংলাদেশি ব্যবসার বাস্তব ব্যবহার' : 'Built around real business workflows' }}</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:14px">
        {{ $seo['locale'] === 'bn' ? 'এই মতামতগুলো উদাহরণভিত্তিক ব্যবহার পরিস্থিতি, অতিরঞ্জিত দাবি নয়।' : 'These are representative usage scenarios, without unsupported superlative claims.' }}
      </p>
    </div>
    <div class="testimonial-grid">
      @foreach ($seo['testimonials'] as $testimonial)
        <article class="testimonial-card">
          <blockquote>{{ $testimonial['quote'] }}</blockquote>
          <h3>{{ $testimonial['name'] }}</h3>
          <div class="testimonial-role">{{ $testimonial['role'] }}</div>
        </article>
      @endforeach
    </div>
  </div>
</section>

<section class="cta-section">
  <div class="section-inner">
    <div class="section-tag" style="margin-bottom:20px;display:inline-flex">🚀 {{ t('landing.cta_tag') }}</div>
    <h2>{{ t('landing.cta_title_1') }}<br>{{ t('landing.cta_title_2') }}</h2>
    <p>{{ t('landing.cta_subtitle') }}</p>
    <div class="cta-btns">
      <a href="{{ route('register') }}" class="btn-cta-white">
        <span>📒</span> {{ t('landing.cta_create_account') }}
      </a>
      <a href="{{ route('login') }}" class="btn-cta-outline">
        <span>🔑</span> {{ t('landing.login_cta') }}
      </a>
    </div>
    <p class="cta-note">✅ {{ t('landing.cta_note_2') }} &nbsp;·&nbsp; ✅ {{ t('landing.cta_note_3') }}</p>
  </div>
</section>

<!-- ═══════════════════════════════ FOOTER ═══════════════════════════════ -->
</main>

<footer>
  <div class="footer-inner">
    <div class="footer-brand">
      <a href="{{ route('home') }}" class="logo" style="text-decoration:none">
        <div class="logo-icon"><img src="{{ asset('assets/img/project/brand-logo.svg') }}" alt="{{ t('brand.name') }}"></div>
        {{-- <span class="logo-text"><img src="{{ asset('assets/img/project/brand.svg') }}" alt="{{ t('brand.name') }}" style="height:15px;"></span> --}}
      </a>
      <p>{{ t('landing.footer_about') }}</p>
    </div>
    <div class="footer-col">
      <h5>{{ t('landing.nav_features') }}</h5>
      <a href="#features">{{ t('landing.feat_sales_title') }}</a>
      <a href="#features">{{ t('landing.feat_stock_title') }}</a>
      <a href="#features">{{ t('landing.feat_customer_title') }}</a>
      <a href="#features">{{ t('nav.reports') }}</a>
      <a href="#features">{{ t('dashboard.invoice') }}</a>
    </div>
    {{-- <div class="footer-col">
      <h5>{{ t('landing.nav_plans') }}</h5>
      <a href="#plans">{{ t('landing.plan_free_name') }}</a>
      <a href="#plans">{{ t('landing.plan_starter_name') }}</a>
      <a href="#plans">{{ t('landing.plan_dreamer_name') }}</a>
      <a href="#plans">{{ t('landing.plan_enterprise_name') }}</a>
    </div> --}}
    <div class="footer-col">
      <h5>{{ t('landing.footer_help') }}</h5>
      <a href="#faq">{{ t('landing.nav_faq') }}</a>
      <a href="#">{{ t('landing.footer_support_center') }}</a>
      <a href="#">{{ t('landing.contact_btn') }}</a>
      <a href="#">{{ t('landing.footer_privacy_policy') }}</a>
      <a href="#">{{ t('landing.footer_terms') }}</a>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© {{ t('footer.year') }} {{ t('brand.name') }}। {{ t('footer.rights') }}</span>
    <a href="https://tahmeed-three.vercel.app/" target="_blank" rel="noopener" class="footer-credit">
      <span class="dev-heart">❤</span>
      <span>Designed &amp; Developed by <span class="dev-name">Tahmeed Mahbub</span></span>
    </a>
    <span><a href="#">{{ t('landing.footer_privacy') }}</a> · <a href="#">{{ t('landing.footer_terms_short') }}</a></span>
  </div>
</footer>

<script>
// Hamburger
const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');
hamburger.addEventListener('click', () => {
  mobileMenu.style.display = mobileMenu.style.display === 'flex' ? 'none' : 'flex';
});

// FAQ
function toggleFaq(el) {
  const item = el.parentElement;
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
  if (!isOpen) item.classList.add('open');
}

// Scroll-based fade-in
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = '1';
      entry.target.style.transform = 'translateY(0)';
    }
  });
}, { threshold: 0.1 });

document.querySelectorAll('.feature-card, .benefit-card, .sec-card, .plan-card, .step-card, .problem-card, .use-case-card, .testimonial-card').forEach(el => {
  el.style.opacity = '0';
  el.style.transform = 'translateY(20px)';
  el.style.transition = 'opacity .5s ease, transform .5s ease';
  observer.observe(el);
});

// Close mobile menu on link click
document.querySelectorAll('.mobile-menu a').forEach(a => {
  a.addEventListener('click', () => {
    mobileMenu.style.display = 'none';
  });
});
</script>
</body>
</html>
