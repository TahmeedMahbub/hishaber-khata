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
@include('partials.site-head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="image" href="{{ asset('assets/img/project/screenshot.webp') }}" type="image/webp" fetchpriority="high">
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round&display=swap" rel="stylesheet">
<script type="application/ld+json">@json($seo['jsonLd'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
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
  --shadow: 0 4px 24px rgba(27,139,90,0.08);
  --shadow-md: 0 8px 40px rgba(27,139,90,0.12);
  --shadow-lg: 0 20px 60px rgba(0,0,0,0.10);
  --radius: 16px;
  --radius-sm: 10px;
  --transition: all .3s cubic-bezier(.4,0,.2,1);
}
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{font-family:'Hind Siliguri','Inter',sans-serif;color:var(--text);background:var(--white);font-size:16px;line-height:1.7;-webkit-font-smoothing:antialiased}
.en{font-family:'Inter',sans-serif}
img{max-width:100%;height:auto}
a{text-decoration:none;color:inherit}

/* NAV */
nav{position:sticky;top:0;z-index:999;background:rgba(255,255,255,.97);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);border-bottom:1px solid var(--border);padding:0 5%}
.nav-inner{max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;height:68px}
.logo{display:flex;align-items:center;gap:2px;text-decoration:none}
.logo-icon{height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;overflow:hidden}
.logo-icon img{width:100%;height:100%;object-fit:cover}
.nav-links{display:flex;align-items:center;gap:6px}
.nav-links a{text-decoration:none;color:var(--text-2);font-size:.9rem;font-weight:500;padding:8px 16px;border-radius:8px;transition:var(--transition)}
.nav-links a:hover{background:var(--green-light);color:var(--green)}
.btn-nav-login{border:2px solid var(--green)!important;color:var(--green)!important}
.btn-nav-cta{background:var(--green)!important;color:var(--white)!important;border-radius:8px!important;box-shadow:0 2px 8px rgba(27,139,90,.2)}
.btn-nav-cta:hover{background:var(--green-dark)!important;transform:translateY(-1px)}
.hamburger{display:none;background:none;border:none;cursor:pointer;padding:8px;flex-direction:column;gap:5px}
.hamburger span{display:block;width:24px;height:2.5px;background:var(--text);border-radius:2px;transition:var(--transition)}
.mobile-menu{display:none;flex-direction:column;gap:4px;padding:12px 0 16px;border-top:1px solid var(--border)}
.mobile-menu a{text-decoration:none;color:var(--text-2);font-size:1rem;font-weight:500;padding:11px 16px;border-radius:8px;display:block;transition:var(--transition)}
.mobile-menu a:hover{background:var(--green-light);color:var(--green)}
.mobile-menu-btns{display:flex;gap:8px;padding:8px 16px 0}

/* BUTTONS */
.btn-primary{background:var(--green);color:#fff;padding:14px 30px;border-radius:12px;font-size:1rem;font-weight:700;text-decoration:none;border:none;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:var(--transition);box-shadow:0 4px 16px rgba(27,139,90,.25)}
.btn-primary:hover{background:var(--green-dark);transform:translateY(-2px);box-shadow:0 8px 24px rgba(27,139,90,.3)}
.btn-secondary{background:#fff;color:var(--green);padding:14px 30px;border-radius:12px;font-size:1rem;font-weight:700;text-decoration:none;border:2px solid var(--green);cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:var(--transition)}
.btn-secondary:hover{background:var(--green-light);transform:translateY(-2px)}

/* HERO */
.hero{background:linear-gradient(160deg,#f0fdf8 0%,#ecfdf5 40%,#e8f5ee 100%);padding:40px 5% 90px;position:relative;overflow:hidden}
.hero::before{content:'';position:absolute;top:-150px;right:-150px;width:500px;height:500px;background:radial-gradient(circle,rgba(27,139,90,.06) 0%,transparent 70%);border-radius:50%}
.hero::after{content:'';position:absolute;bottom:-100px;left:-100px;width:400px;height:400px;background:radial-gradient(circle,rgba(244,163,0,.05) 0%,transparent 70%);border-radius:50%}
.hero-inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;position:relative;z-index:1}
.hero-badge{display:inline-flex;align-items:center;gap:8px;background:var(--green-light);color:var(--green);border:1px solid rgba(27,139,90,.15);padding:8px 18px;border-radius:50px;font-size:.85rem;font-weight:600;margin-bottom:22px}
.hero-badge .dot{width:8px;height:8px;background:var(--green);border-radius:50%;animation:pulse 2s infinite}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(1.4)}}
.hero h1{font-size:clamp(2rem,4.2vw,3.2rem);font-weight:800;line-height:1.2;color:var(--text);margin-bottom:20px}
.hero h1 .highlight{color:var(--green);position:relative}
.hero h1 .highlight::after{content:'';position:absolute;bottom:2px;left:0;right:0;height:6px;background:rgba(27,139,90,.12);border-radius:3px;z-index:-1}
.hero-sub{font-size:1.1rem;color:var(--text-2);margin-bottom:34px;max-width:500px;line-height:1.8}
.hero-btns{display:flex;gap:14px;flex-wrap:wrap;margin-bottom:40px}
.trust-badges{display:flex;gap:14px;flex-wrap:nowrap}
.trust-badge{display:flex;align-items:center;gap:7px;background:#fff;border:1px solid var(--border);padding:9px 16px;border-radius:50px;font-size:.82rem;font-weight:600;color:var(--text-2);box-shadow:0 2px 8px rgba(0,0,0,.04);white-space:nowrap}
.trust-badge .material-icons-round{font-size:17px;color:var(--green)}
.hero-visual{position:relative}
.hero-visual picture img{border-radius:20px;box-shadow:var(--shadow-lg);border:1px solid var(--border)}

/* SECTIONS */
section{padding:80px 5%}
.section-inner{max-width:1200px;margin:0 auto}
.section-tag{display:inline-flex;align-items:center;gap:8px;background:var(--green-light);color:var(--green);padding:7px 18px;border-radius:50px;font-size:.82rem;font-weight:700;margin-bottom:14px}
.section-tag .material-icons-round{font-size:16px}
.section-title{font-size:clamp(1.6rem,3.5vw,2.5rem);font-weight:800;margin-bottom:14px;line-height:1.25}
.section-sub{font-size:1.05rem;color:var(--text-2);max-width:600px;line-height:1.7}
.text-center{text-align:center}
.text-center .section-sub{margin:0 auto}
.section-bg{background:var(--bg)}
.section-green{background:linear-gradient(135deg,#1B8B5A,#0f5c3d);color:#fff}
.section-green .section-title{color:#fff}
.section-green .section-sub{color:rgba(255,255,255,.85)}
.section-green .section-tag{background:rgba(255,255,255,.12);color:#fff}
.divider{width:60px;height:4px;background:var(--green);border-radius:4px;margin:14px 0 0}
.divider.center{margin:14px auto 0}

/* PROBLEMS */
.problems-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:20px;margin-top:50px}
.problem-card{background:#fff;border-radius:var(--radius);padding:24px 28px;border:1px solid var(--border);transition:var(--transition);display:flex;gap:16px;align-items:flex-start}
.problem-card:hover{box-shadow:var(--shadow-md);transform:translateY(-4px);border-color:rgba(27,139,90,.2)}
.prob-icon{width:50px;height:50px;flex-shrink:0;border-radius:12px;display:flex;align-items:center;justify-content:center;background:var(--green-light);border:1px solid rgba(27,139,90,.1);color:var(--green)}
.prob-icon .material-icons-round{font-size:24px}
.prob-arrow{display:flex;align-items:center;justify-content:center;color:var(--green);flex-shrink:0;padding:0 4px;align-self:center}
.prob-arrow .material-icons-round{font-size:20px}
.prob-text h4{font-size:.95rem;font-weight:700;margin-bottom:4px}
.prob-text p{font-size:.85rem;color:var(--text-2)}
.prob-text .before{color:var(--red)}
.prob-text .after{color:var(--green)}

/* FEATURES */
.features-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px;margin-top:50px}
.feature-card{background:#fff;border-radius:var(--radius);padding:30px;border:1px solid var(--border);transition:var(--transition);position:relative;overflow:hidden}
.feature-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--green),var(--green-mid));border-radius:3px 3px 0 0;transform:scaleX(0);transform-origin:left;transition:.4s}
.feature-card:hover::before{transform:scaleX(1)}
.feature-card:hover{box-shadow:var(--shadow-md);transform:translateY(-5px);border-color:rgba(27,139,90,.15)}
.feat-icon{width:56px;height:56px;border-radius:14px;background:var(--green-light);display:flex;align-items:center;justify-content:center;margin-bottom:18px;border:1px solid rgba(27,139,90,.1);color:var(--green)}
.feat-icon .material-icons-round{font-size:28px}
.feature-card h3{font-size:1.1rem;font-weight:700;margin-bottom:12px}
.feature-card ul{list-style:none}
.feature-card ul li{font-size:.88rem;color:var(--text-2);padding:5px 0;display:flex;align-items:center;gap:10px}
.feature-card ul li::before{content:'';width:18px;height:18px;background:var(--green-light);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%231B8B5A'%3E%3Cpath d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z'/%3E%3C/svg%3E");background-size:12px;background-repeat:no-repeat;background-position:center}

/* USE CASES */
.use-case-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:22px;margin-top:44px}
.use-case-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:28px;transition:var(--transition)}
.use-case-card:hover{box-shadow:var(--shadow-md);transform:translateY(-4px)}
.use-case-card h3{font-size:1.05rem;font-weight:800;margin-bottom:10px;color:var(--text)}
.use-case-card p{color:var(--text-2);font-size:.92rem}
.seo-copy{margin-top:36px;background:var(--green-light);border:1px solid rgba(27,139,90,.12);border-radius:var(--radius);padding:28px;color:var(--green-dark)}
.seo-copy p{margin-bottom:10px;line-height:1.7}.seo-copy p:last-child{margin-bottom:0}

/* BENEFITS */
.benefits-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:20px;margin-top:50px}
.benefit-card{background:rgba(255,255,255,.08);border-radius:var(--radius);padding:28px;border:1px solid rgba(255,255,255,.12);transition:var(--transition);text-align:center}
.benefit-card:hover{background:rgba(255,255,255,.15);transform:translateY(-4px);border-color:rgba(255,255,255,.25)}
.benefit-icon{margin-bottom:14px;display:flex;justify-content:center}
.benefit-icon img{width:56px;height:56px;filter:brightness(0) invert(1);opacity:.9}
.benefit-card h4{font-size:1rem;font-weight:700;color:#fff;margin-bottom:8px}
.benefit-card p{font-size:.87rem;color:rgba(255,255,255,.8);line-height:1.6}

/* HOW IT WORKS */
.steps-wrapper{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:0;margin-top:54px;position:relative}
.steps-wrapper::before{content:'';position:absolute;top:40px;left:10%;right:10%;height:2px;background:linear-gradient(90deg,var(--green-light),var(--green),var(--green-light));z-index:0}
.step-card{text-align:center;position:relative;z-index:1;padding:0 16px}
.step-num{width:80px;height:80px;border-radius:50%;background:var(--green);color:#fff;font-size:1.8rem;font-weight:800;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;border:5px solid #fff;box-shadow:0 6px 24px rgba(27,139,90,.25)}
.step-icon{margin-bottom:10px;color:var(--green)}
.step-icon .material-icons-round{font-size:28px}
.step-card h4{font-size:.95rem;font-weight:700;margin-bottom:6px}
.step-card p{font-size:.82rem;color:var(--text-2);line-height:1.5}

/* PLANS */
.plans-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:22px;margin-top:50px;align-items:start}
.plan-card{background:#fff;border-radius:var(--radius);padding:30px;border:2px solid var(--border);transition:var(--transition);position:relative}
.plan-card.popular{border-color:var(--green);box-shadow:0 8px 40px rgba(27,139,90,.15);transform:scale(1.03)}
.popular-badge{position:absolute;top:-14px;left:50%;transform:translateX(-50%);background:var(--green);color:#fff;font-size:.75rem;font-weight:700;padding:5px 18px;border-radius:50px;white-space:nowrap}
.plan-name{font-size:1.15rem;font-weight:800;margin-bottom:4px}
.plan-price{font-size:2.1rem;font-weight:800;color:var(--green);line-height:1;margin:12px 0 6px}
.plan-price span{font-size:.85rem;font-weight:500;color:var(--text-3)}
.plan-desc{font-size:.83rem;color:var(--text-2);margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid var(--border)}
.plan-features{list-style:none;margin-bottom:24px}
.plan-features li{font-size:.87rem;padding:5px 0;display:flex;align-items:flex-start;gap:8px;color:var(--text-2)}
.plan-features li .check{color:var(--green);font-size:18px;flex-shrink:0}
.plan-features li .cross{color:#ccc;font-size:18px;flex-shrink:0}
.plan-btn{width:100%;padding:14px;border-radius:10px;font-size:.95rem;font-weight:700;cursor:pointer;text-align:center;border:2px solid var(--green);color:var(--green);background:#fff;transition:var(--transition);text-decoration:none;display:block}
.plan-btn.primary{background:var(--green);color:#fff}
.plan-btn:hover{background:var(--green);color:#fff;transform:translateY(-2px);box-shadow:0 4px 14px rgba(27,139,90,.2)}

/* COMPARE TABLE */
.compare-table{margin-top:44px;border-radius:var(--radius);overflow:hidden;border:1px solid var(--border)}
.compare-table table{width:100%;border-collapse:collapse}
.compare-table th{background:var(--green);color:#fff;padding:14px 16px;text-align:center;font-size:.9rem;font-weight:700}
.compare-table th:first-child{text-align:left}
.compare-table td{padding:12px 16px;text-align:center;font-size:.87rem;border-bottom:1px solid var(--border)}
.compare-table td:first-child{text-align:left;font-weight:500}
.compare-table tr:last-child td{border-bottom:none}
.compare-table tr:nth-child(even) td{background:var(--bg)}
.compare-table .check{color:var(--green);font-weight:700;font-size:1.1rem}
.compare-table .cross{color:#CBD5E0;font-weight:700;font-size:1.1rem}
.compare-table .pop-col{background:var(--green-light)}

/* MOBILE */
.mobile-section{background:var(--bg)}
.mobile-inner{display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center}
.device-chips{display:flex;flex-wrap:wrap;gap:12px;margin-bottom:28px}
.device-chip{display:flex;align-items:center;gap:8px;background:#fff;border:1px solid var(--border);border-radius:50px;padding:10px 20px;font-size:.9rem;font-weight:600;transition:var(--transition)}
.device-chip:hover{border-color:var(--green);box-shadow:0 2px 8px rgba(27,139,90,.1)}
.device-chip .material-icons-round{color:var(--green);font-size:20px}
.mobile-note{background:var(--green-light);border-radius:12px;padding:16px 22px;font-size:.9rem;color:var(--green-dark);font-weight:600;display:flex;align-items:center;gap:12px;border:1px solid rgba(27,139,90,.1)}
.mobile-note .material-icons-round{font-size:22px;color:var(--green)}

/* Phone mockups */
.phones-group{display:flex;gap:-10px;justify-content:center;position:relative}
.phone-mock{background:#1A202C;border-radius:28px;border:6px solid #1A202C;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.18);width:160px;flex-shrink:0}
.phone-mock.main{width:180px;transform:scale(1.05);z-index:2;box-shadow:0 24px 70px rgba(0,0,0,.22)}
.phone-mock-screen{background:var(--green-light);min-height:280px;padding:12px}
.pm-header{background:var(--green);color:#fff;padding:8px 10px;border-radius:8px;margin-bottom:8px;font-size:.72rem;font-weight:700;display:flex;align-items:center;gap:4px}
.pm-header .material-icons-round{font-size:12px}
.pm-card{background:#fff;border-radius:8px;padding:8px 10px;margin-bottom:6px}
.pm-card-label{font-size:.6rem;color:var(--text-3)}
.pm-card-val{font-size:.85rem;font-weight:800;color:var(--green)}
.pm-row{display:flex;justify-content:space-between;background:#fff;border-radius:7px;padding:6px 8px;margin-bottom:4px;font-size:.6rem}
.pm-row .r-name{color:var(--text);font-weight:500}
.pm-row .r-amt{color:var(--green);font-weight:700}
.pm-sale-btn{background:var(--green);color:#fff;text-align:center;border-radius:7px;padding:8px;font-size:.68rem;font-weight:700;margin-top:6px}

/* SECURITY */
.security-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:20px;margin-top:50px}
.sec-card{background:#fff;border-radius:var(--radius);padding:28px;border:1px solid var(--border);text-align:center;transition:var(--transition)}
.sec-card:hover{box-shadow:var(--shadow-md);transform:translateY(-4px);border-color:rgba(27,139,90,.15)}
.sec-icon{width:64px;height:64px;border-radius:50%;background:var(--green-light);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;color:var(--green)}
.sec-icon .material-icons-round{font-size:28px}
.sec-card h4{font-size:1rem;font-weight:700;margin-bottom:8px}
.sec-card p{font-size:.85rem;color:var(--text-2);line-height:1.6}

/* TESTIMONIALS / FEEDBACK */
.testimonial-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:24px;margin-top:50px}
.testimonial-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:28px;transition:var(--transition);position:relative}
.testimonial-card:hover{box-shadow:var(--shadow-md);transform:translateY(-4px)}
.testimonial-card::before{content:'';position:absolute;top:24px;left:24px;width:32px;height:24px;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%231B8B5A' opacity='0.2'%3E%3Cpath d='M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z'/%3E%3C/svg%3E");background-size:contain;background-repeat:no-repeat;opacity:.4}
.testimonial-card blockquote{color:var(--text-2);font-size:.95rem;margin-bottom:18px;padding-top:8px;line-height:1.7;font-style:italic}
.testimonial-card h3{font-size:1rem;font-weight:700;margin-bottom:3px}
.testimonial-role{color:var(--green);font-size:.82rem;font-weight:600}

/* FAQ */
.faq-list{max-width:780px;margin:50px auto 0}
.faq-item{background:#fff;border-radius:var(--radius-sm);border:1px solid var(--border);margin-bottom:12px;overflow:hidden;transition:var(--transition)}
.faq-item:hover{border-color:rgba(27,139,90,.2)}
.faq-q{display:flex;justify-content:space-between;align-items:center;padding:20px 24px;cursor:pointer;font-weight:600;font-size:1rem;transition:background .2s;gap:12px}
.faq-q:hover{background:var(--green-light)}
.faq-q .material-icons-round{color:var(--green);transition:.3s;flex-shrink:0}
.faq-item.open .faq-q{background:var(--green-light);color:var(--green)}
.faq-item.open .faq-q .material-icons-round{transform:rotate(45deg)}
.faq-a{display:none;padding:0 24px 20px;font-size:.92rem;color:var(--text-2);line-height:1.7}
.faq-item.open .faq-a{display:block}

/* CONTACT */
.contact-section{background:var(--bg)}
.contact-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px;margin-top:50px}
.contact-card{background:#fff;border-radius:var(--radius);padding:32px;border:1px solid var(--border);text-align:center;transition:var(--transition)}
.contact-card:hover{box-shadow:var(--shadow-md);transform:translateY(-4px)}
.contact-icon{width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px}
.contact-icon.whatsapp{background:#dcfce7;color:#16a34a}
.contact-icon.email{background:#dbeafe;color:var(--blue)}
.contact-icon.phone{background:var(--green-light);color:var(--green)}
.contact-icon .material-icons-round{font-size:28px}
.contact-card h4{font-size:1.05rem;font-weight:700;margin-bottom:6px}
.contact-card p{font-size:.88rem;color:var(--text-2);margin-bottom:14px;line-height:1.5}
.contact-link{display:inline-flex;align-items:center;gap:6px;font-size:.9rem;font-weight:600;color:var(--green);padding:10px 20px;border-radius:8px;border:1px solid var(--green);transition:var(--transition)}
.contact-link:hover{background:var(--green);color:#fff}
.contact-link.wa{color:#16a34a;border-color:#16a34a}
.contact-link.wa:hover{background:#16a34a;color:#fff}

/* CTA */
.cta-section{background:linear-gradient(135deg,#1B8B5A 0%,#0f5c3d 100%);text-align:center;padding:90px 5%;position:relative;overflow:hidden}
.cta-section::before{content:'';position:absolute;top:-100px;left:50%;transform:translateX(-50%);width:600px;height:600px;background:radial-gradient(circle,rgba(255,255,255,.05) 0%,transparent 70%);border-radius:50%}
.cta-section h2{font-size:clamp(1.8rem,4vw,3rem);font-weight:800;color:#fff;margin-bottom:18px}
.cta-section p{font-size:1.05rem;color:rgba(255,255,255,.85);margin-bottom:38px;max-width:540px;margin-left:auto;margin-right:auto;line-height:1.7}
.cta-btns{display:flex;gap:14px;justify-content:center;flex-wrap:wrap}
.btn-cta-white{background:#fff;color:var(--green);padding:16px 34px;border-radius:12px;font-size:1.05rem;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:var(--transition);box-shadow:0 6px 24px rgba(0,0,0,.12)}
.btn-cta-white:hover{transform:translateY(-3px);box-shadow:0 10px 32px rgba(0,0,0,.18)}
.btn-cta-outline{background:transparent;color:#fff;padding:16px 34px;border-radius:12px;font-size:1.05rem;font-weight:700;text-decoration:none;border:2px solid rgba(255,255,255,.6);display:inline-flex;align-items:center;gap:8px;transition:var(--transition)}
.btn-cta-outline:hover{background:rgba(255,255,255,.1);transform:translateY(-3px);border-color:#fff}
.cta-note{color:rgba(255,255,255,.7);font-size:.85rem;margin-top:22px;display:flex;gap:16px;justify-content:center;flex-wrap:wrap;align-items:center}
.cta-note span{display:inline-flex;align-items:center;gap:4px}
.cta-note .material-icons-round{font-size:16px}

/* FOOTER */
footer{background:#111827;color:rgba(255,255,255,.7);padding:48px 5% 28px}
.footer-inner{max-width:1200px;margin:0 auto;display:flex;flex-wrap:wrap;gap:36px;justify-content:space-between;padding-bottom:32px;border-bottom:1px solid rgba(255,255,255,.08);margin-bottom:24px}
.footer-brand .logo-text{color:#fff}
.footer-brand p{font-size:.87rem;margin-top:12px;max-width:280px;color:rgba(255,255,255,.55);line-height:1.6}
.footer-col h5{color:#fff;font-size:.9rem;font-weight:700;margin-bottom:14px}
.footer-col a{display:block;font-size:.85rem;color:rgba(255,255,255,.55);text-decoration:none;margin-bottom:9px;transition:.2s}
.footer-col a:hover{color:#fff}
.footer-bottom{max-width:1200px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;font-size:.82rem}
.footer-bottom a{color:rgba(255,255,255,.5);text-decoration:none}
.footer-credit{display:inline-flex;align-items:center;gap:8px;padding:7px 16px;border-radius:999px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.75);font-size:.82rem;text-decoration:none;transition:var(--transition)}
.footer-credit:hover{background:linear-gradient(135deg,var(--green),#0ea371);border-color:transparent;color:#fff;transform:translateY(-2px);box-shadow:0 8px 20px rgba(16,185,129,.3)}
.footer-credit .dev-heart{color:#ef4444}
.footer-credit .dev-name{font-weight:700}

/* WHATSAPP FLOATING */
.wa-float{position:fixed;bottom:24px;right:24px;z-index:998;width:56px;height:56px;background:#25D366;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(37,211,102,.4);transition:var(--transition);animation:float-bounce 3s ease-in-out infinite}
.wa-float:hover{transform:scale(1.1);box-shadow:0 6px 28px rgba(37,211,102,.5)}
.wa-float svg{width:28px;height:28px;fill:#fff}
@keyframes float-bounce{0%,100%{transform:translateY(0)}50%{transform:translateY(-4px)}}

/* RESPONSIVE */
@media(max-width:768px){
  .nav-links{display:none}
  .hamburger{display:flex}
  .hero-inner{grid-template-columns:1fr;gap:40px}
  .hero-visual{order:-1}
  .mobile-inner{grid-template-columns:1fr}
  .phones-group{flex-direction:column;align-items:center}
  .phone-mock{width:100%;max-width:220px}
  .phone-mock.main{transform:none;width:100%;max-width:240px}
  .steps-wrapper::before{display:none}
  .steps-wrapper{gap:28px}
  .plan-card.popular{transform:none}
  .compare-table{overflow-x:auto}
  .compare-table table{min-width:520px}
  section{padding:60px 5%}
  .hero{padding:30px 5% 50px}
  .hero-btns{flex-direction:row;flex-wrap:nowrap;gap:10px}
  .hero-btns .btn-primary,.hero-btns .btn-secondary{flex:1 1 0;justify-content:center;padding:14px 10px}
  .trust-badges{flex-wrap:wrap;gap:10px}
  .trust-badge{flex:1 1 calc(50% - 10px);justify-content:center;font-size:.82rem;padding:10px 14px}
  .contact-grid{grid-template-columns:1fr}
}
@media(max-width:480px){
  .features-grid{grid-template-columns:1fr}
  .plans-grid{grid-template-columns:1fr}
  .security-grid{grid-template-columns:1fr 1fr}
  .cta-btns{flex-direction:column;align-items:center}
  .wa-float{bottom:16px;right:16px;width:50px;height:50px}
  .wa-float svg{width:24px;height:24px}
}

/* Animations */
@keyframes fadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
.fade-up{animation:fadeUp .7s ease both}
.delay-1{animation-delay:.1s}
.delay-2{animation-delay:.2s}
.delay-3{animation-delay:.3s}
.delay-4{animation-delay:.4s}
</style>
</head>
<body>

<!-- NAV -->
<nav>
  <div class="nav-inner">
    <a href="{{ route('home') }}" class="logo" aria-label="{{ $seo['brand'] }}">
      <div class="logo-icon"><img src="{{ asset('assets/img/project/brand-logo.svg') }}" alt="{{ $seo['brand'] }}" width="42" height="42"></div>
    </a>
    <div class="nav-links">
      <a href="#features">{{ t('landing.nav_features') }}</a>
      <a href="#how">{{ t('landing.nav_how') }}</a>
      <a href="#plans">{{ t('landing.nav_plans') }}</a>
      <a href="#feedback">{{ $seo['locale'] === 'bn' ? 'মতামত' : 'Feedback' }}</a>
      <a href="#faq">FAQ</a>
      <a href="#contact">{{ $seo['locale'] === 'bn' ? 'যোগাযোগ' : 'Contact' }}</a>
      <a href="{{ route('login') }}" class="btn-nav-login">{{ t('landing.nav_login') }}</a>
      <a href="{{ route('register') }}" class="btn-nav-cta">{{ t('landing.nav_cta') }}</a>
    </div>
    <button class="hamburger" id="hamburger" aria-label="Menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
  <div class="mobile-menu" id="mobileMenu" role="navigation">
    <a href="#features">{{ t('landing.nav_features') }}</a>
    <a href="#how">{{ t('landing.nav_how') }}</a>
    <a href="#plans">{{ t('landing.nav_plans') }}</a>
    <a href="#feedback">{{ $seo['locale'] === 'bn' ? 'মতামত' : 'Feedback' }}</a>
    <a href="#faq">{{ t('landing.nav_faq') }}</a>
    <a href="#contact">{{ $seo['locale'] === 'bn' ? 'যোগাযোগ' : 'Contact' }}</a>
    <div class="mobile-menu-btns">
      <a href="{{ route('login') }}" class="btn-secondary" style="flex:1;text-align:center;padding:11px;">{{ t('landing.nav_login') }}</a>
      <a href="{{ route('register') }}" class="btn-primary" style="flex:1;text-align:center;padding:11px;">{{ t('landing.nav_cta_short') }}</a>
    </div>
  </div>
</nav>

<main id="content">

<!-- HERO -->
<section class="hero">
  <div class="hero-inner">
    <div class="hero-content">
      <div class="hero-badge fade-up"><span class="dot"></span> {{ t('landing.hero_badge') }}</div>
      <h1 class="fade-up delay-1">
        {{ t('landing.hero_title_1') }} <span class="highlight">{{ t('landing.hero_title_2') }}</span>
      </h1>
      <p class="hero-sub fade-up delay-2">{{ t('landing.hero_subtitle') }}</p>
      <div class="hero-btns fade-up delay-3">
        <a href="{{ route('register') }}" class="btn-primary">
          <span class="material-icons-round" style="font-size:20px">rocket_launch</span>
          {{ t('landing.nav_cta') }}
        </a>
        <a href="{{ route('login') }}" class="btn-secondary">
          <span class="material-icons-round" style="font-size:20px">login</span>
          {{ t('landing.login_cta') }}
        </a>
      </div>
      <div class="trust-badges fade-up delay-4">
        <div class="trust-badge"><span class="material-icons-round">smartphone</span> {{ t('landing.trust_mobile') }}</div>
        <div class="trust-badge"><span class="material-icons-round">cloud_done</span> {{ t('landing.trust_cloud') }}</div>
        <div class="trust-badge"><span class="material-icons-round">lock</span> {{ t('landing.trust_secure') }}</div>
        <div class="trust-badge"><span class="material-icons-round">devices</span> {{ t('landing.trust_multidevice') }}</div>
      </div>
    </div>
    <div class="hero-visual fade-up delay-2">
      <picture>
        <source srcset="{{ asset('assets/img/project/screenshot.webp') }}" type="image/webp">
        <img src="{{ asset('assets/img/project/screenshot.jpg') }}" width="1549" height="979" alt="{{ $seo['brand'] }} accounting and inventory management software dashboard" fetchpriority="high" decoding="async" style="width:100%;height:auto;">
      </picture>
    </div>
  </div>
</section>

<!-- WHY -->
<section class="section-bg" id="why">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag"><span class="material-icons-round">lightbulb</span> {{ t('landing.why_tag') }}</div>
      <h2 class="section-title">{{ t('landing.why_title_1') }}<br>{{ t('landing.why_title_2') }}</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:16px">{{ t('landing.why_subtitle') }}</p>
    </div>
    <div class="problems-grid">
      <div class="problem-card">
        <div class="prob-icon"><span class="material-icons-round">menu_book</span></div>
        <div class="prob-arrow"><span class="material-icons-round">arrow_forward</span></div>
        <div class="prob-text">
          <h4 class="before">{{ t('landing.problem_1_before') }}</h4>
          <p class="after">{{ t('landing.problem_1_after') }}</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="prob-icon"><span class="material-icons-round">inventory_2</span></div>
        <div class="prob-arrow"><span class="material-icons-round">arrow_forward</span></div>
        <div class="prob-text">
          <h4 class="before">{{ t('landing.problem_2_before') }}</h4>
          <p class="after">{{ t('landing.problem_2_after') }}</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="prob-icon"><span class="material-icons-round">account_balance_wallet</span></div>
        <div class="prob-arrow"><span class="material-icons-round">arrow_forward</span></div>
        <div class="prob-text">
          <h4 class="before">{{ t('landing.problem_3_before') }}</h4>
          <p class="after">{{ t('landing.problem_3_after') }}</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="prob-icon"><span class="material-icons-round">receipt_long</span></div>
        <div class="prob-arrow"><span class="material-icons-round">arrow_forward</span></div>
        <div class="prob-text">
          <h4 class="before">{{ t('landing.problem_4_before') }}</h4>
          <p class="after">{{ t('landing.problem_4_after') }}</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="prob-icon"><span class="material-icons-round">folder_open</span></div>
        <div class="prob-arrow"><span class="material-icons-round">arrow_forward</span></div>
        <div class="prob-text">
          <h4 class="before">{{ t('landing.problem_5_before') }}</h4>
          <p class="after">{{ t('landing.problem_5_after') }}</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="prob-icon"><span class="material-icons-round">bar_chart</span></div>
        <div class="prob-arrow"><span class="material-icons-round">arrow_forward</span></div>
        <div class="prob-text">
          <h4 class="before">{{ t('landing.problem_6_before') }}</h4>
          <p class="after">{{ t('landing.problem_6_after') }}</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- USE CASES -->
<section class="section-bg" id="use-cases">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag"><span class="material-icons-round">business</span> {{ $seo['locale'] === 'bn' ? 'ব্যবহারের ক্ষেত্র' : 'Use Cases' }}</div>
      <h2 class="section-title">{{ $seo['locale'] === 'bn' ? 'বাংলাদেশি ব্যবসার জন্য তৈরি' : 'Made for Bangladeshi Businesses' }}</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:16px">
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

<!-- FEATURES -->
<section id="features">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag"><span class="material-icons-round">auto_awesome</span> {{ t('landing.features_tag') }}</div>
      <h2 class="section-title">{{ t('landing.features_title_1') }}<br>{{ t('landing.features_title_2') }}</h2>
      <div class="divider center"></div>
    </div>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feat-icon"><span class="material-icons-round">point_of_sale</span></div>
        <h3>{{ t('landing.feat_sales_title') }}</h3>
        <ul>
          <li>{{ t('landing.feat_sales_1') }}</li>
          <li>{{ t('landing.feat_sales_2') }}</li>
          <li>{{ t('landing.feat_sales_3') }}</li>
          <li>{{ t('landing.feat_sales_4') }}</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon"><span class="material-icons-round">local_shipping</span></div>
        <h3>{{ t('landing.feat_purchase_title') }}</h3>
        <ul>
          <li>{{ t('landing.feat_purchase_1') }}</li>
          <li>{{ t('landing.feat_purchase_2') }}</li>
          <li>{{ t('landing.feat_purchase_3') }}</li>
          <li>{{ t('landing.feat_purchase_4') }}</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon"><span class="material-icons-round">inventory</span></div>
        <h3>{{ t('landing.feat_stock_title') }}</h3>
        <ul>
          <li>{{ t('landing.feat_stock_1') }}</li>
          <li>{{ t('landing.feat_stock_2') }}</li>
          <li>{{ t('landing.feat_stock_3') }}</li>
          <li>{{ t('landing.feat_stock_4') }}</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon"><span class="material-icons-round">group</span></div>
        <h3>{{ t('landing.feat_customer_title') }}</h3>
        <ul>
          <li>{{ t('landing.feat_customer_1') }}</li>
          <li>{{ t('landing.feat_customer_2') }}</li>
          <li>{{ t('landing.feat_customer_3') }}</li>
          <li>{{ t('landing.feat_customer_4') }}</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon"><span class="material-icons-round">payments</span></div>
        <h3>{{ t('landing.feat_expense_title') }}</h3>
        <ul>
          <li>{{ t('landing.feat_expense_1') }}</li>
          <li>{{ t('landing.feat_expense_2') }}</li>
          <li>{{ t('landing.feat_expense_3') }}</li>
          <li>{{ t('landing.feat_expense_4') }}</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon"><span class="material-icons-round">analytics</span></div>
        <h3>{{ t('landing.feat_report_title') }}</h3>
        <ul>
          <li>{{ t('landing.feat_report_1') }}</li>
          <li>{{ t('landing.feat_report_2') }}</li>
          <li>{{ t('landing.feat_report_3') }}</li>
          <li>{{ t('landing.feat_report_4') }}</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon"><span class="material-icons-round">account_balance</span></div>
        <h3>{{ t('landing.feat_cashbook_title') }}</h3>
        <ul>
          <li>{{ t('landing.feat_cashbook_1') }}</li>
          <li>{{ t('landing.feat_cashbook_2') }}</li>
          <li>{{ t('landing.feat_cashbook_3') }}</li>
          <li>{{ t('landing.feat_cashbook_4') }}</li>
        </ul>
      </div>
      <div class="feature-card" style="background:var(--green-light);border-color:rgba(27,139,90,.15)">
        <div class="feat-icon" style="background:#fff"><span class="material-icons-round">description</span></div>
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

<!-- BENEFITS -->
<section class="section-green">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag"><span class="material-icons-round">favorite</span> {{ t('landing.benefits_tag') }}</div>
      <h2 class="section-title">{{ t('landing.benefits_title_1') }}<br>{{ t('landing.benefits_title_2') }}</h2>
      <div class="divider center" style="background:#fff"></div>
    </div>
    <div class="benefits-grid">
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/responsive.svg') }}" alt="Responsive Design" width="56" height="56" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_1_title') }}</h4>
        <p>{{ t('landing.benefit_1_desc') }}</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/math.svg') }}" alt="No Math Skills Required" width="56" height="56" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_2_title') }}</h4>
        <p>{{ t('landing.benefit_2_desc') }}</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/clock.svg') }}" alt="Save time" width="56" height="56" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_3_title') }}</h4>
        <p>{{ t('landing.benefit_3_desc') }}</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/stock.svg') }}" alt="Inventory management" width="56" height="56" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_4_title') }}</h4>
        <p>{{ t('landing.benefit_4_desc') }}</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/b5.svg') }}" alt="Business reporting" width="56" height="56" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_5_title') }}</h4>
        <p>{{ t('landing.benefit_5_desc') }}</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/b6.svg') }}" alt="Small business" width="56" height="56" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_6_title') }}</h4>
        <p>{{ t('landing.benefit_6_desc') }}</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/b7.svg') }}" alt="Cloud accounting" width="56" height="56" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_7_title') }}</h4>
        <p>{{ t('landing.benefit_7_desc') }}</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon"><img src="{{ asset('assets/svg/landing/b8.svg') }}" alt="SME software" width="56" height="56" loading="lazy" decoding="async"></div>
        <h4>{{ t('landing.benefit_8_title') }}</h4>
        <p>{{ t('landing.benefit_8_desc') }}</p>
      </div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="section-bg" id="how">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag"><span class="material-icons-round">route</span> {{ t('landing.nav_how') }}</div>
      <h2 class="section-title">{{ t('landing.how_title') }}</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:16px">{{ t('landing.how_subtitle') }}</p>
    </div>
    <div class="steps-wrapper">
      <div class="step-card">
        <div class="step-num">{{ t('landing.step_1') }}</div>
        <div class="step-icon"><span class="material-icons-round">storefront</span></div>
        <h4>{{ t('landing.step_1_title') }}</h4>
        <p>{{ t('landing.step_1_desc') }}</p>
      </div>
      <div class="step-card">
        <div class="step-num">{{ t('landing.step_2') }}</div>
        <div class="step-icon"><span class="material-icons-round">inventory_2</span></div>
        <h4>{{ t('landing.step_2_title') }}</h4>
        <p>{{ t('landing.step_2_desc') }}</p>
      </div>
      <div class="step-card">
        <div class="step-num">{{ t('landing.step_3') }}</div>
        <div class="step-icon"><span class="material-icons-round">shopping_cart</span></div>
        <h4>{{ t('landing.step_3_title') }}</h4>
        <p>{{ t('landing.step_3_desc') }}</p>
      </div>
      <div class="step-card">
        <div class="step-num">{{ t('landing.step_4') }}</div>
        <div class="step-icon"><span class="material-icons-round">account_balance_wallet</span></div>
        <h4>{{ t('landing.step_4_title') }}</h4>
        <p>{{ t('landing.step_4_desc') }}</p>
      </div>
      <div class="step-card">
        <div class="step-num">{{ t('landing.step_5') }}</div>
        <div class="step-icon"><span class="material-icons-round">insights</span></div>
        <h4>{{ t('landing.step_5_title') }}</h4>
        <p>{{ t('landing.step_5_desc') }}</p>
      </div>
    </div>
  </div>
</section>

<!-- PLANS -->
<section id="plans">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag"><span class="material-icons-round">diamond</span> {{ t('landing.plans_tag') }}</div>
      <h2 class="section-title">{{ t('landing.plans_title_1') }}<br>{{ t('landing.plans_title_2') }}</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:16px">{{ t('landing.plans_subtitle') }}</p>
    </div>
    <div class="plans-grid">
      <div class="plan-card">
        <div class="plan-name">{{ t('landing.plan_free_name') }}</div>
        <div class="plan-price">{{ $seo['locale'] === 'bn' ? '৳ ০' : '৳ 0' }} <span>{{ t('landing.per_month') }}</span></div>
        <p class="plan-desc">{{ t('landing.plan_free_desc') }}</p>
        <ul class="plan-features">
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.plan_free_f1') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.plan_free_f2') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.plan_free_f3') }}</li>
          <li><span class="cross material-icons-round">cancel</span> {{ t('landing.plan_free_f4') }}</li>
          <li><span class="cross material-icons-round">cancel</span> {{ t('landing.customer_mgmt') }}</li>
          <li><span class="cross material-icons-round">cancel</span> {{ t('landing.backup') }}</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn">{{ t('landing.nav_cta') }}</a>
      </div>
      <div class="plan-card">
        <div class="plan-name">{{ t('landing.plan_starter_name') }}</div>
        <div class="plan-price">৳ {{ $seo['locale'] === 'bn' ? '২৯৯' : '299' }} <span>{{ t('landing.per_month') }}</span></div>
        <p class="plan-desc">{{ t('landing.plan_starter_desc') }}</p>
        <ul class="plan-features">
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.plan_starter_f1') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.unlimited_sales') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.invoice_create') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.customer_mgmt') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.cloud_backup') }}</li>
          <li><span class="cross material-icons-round">cancel</span> {{ t('landing.multi_user') }}</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn">{{ t('landing.start_btn') }}</a>
      </div>
      <div class="plan-card popular">
        <div class="popular-badge">{{ t('landing.plan_popular_badge') }}</div>
        <div class="plan-name">{{ t('landing.plan_dreamer_name') }}</div>
        <div class="plan-price">৳ {{ $seo['locale'] === 'bn' ? '৫৯৯' : '599' }} <span>{{ t('landing.per_month') }}</span></div>
        <p class="plan-desc">{{ t('landing.plan_dreamer_desc') }}</p>
        <ul class="plan-features">
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.unlimited_products') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.unlimited_sales') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.plan_dreamer_f3') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.plan_dreamer_f4') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.plan_dreamer_f5') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.plan_dreamer_f6') }}</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn primary">{{ t('landing.plan_dreamer_btn') }}</a>
      </div>
      <div class="plan-card">
        <div class="plan-name">{{ t('landing.plan_enterprise_name') }}</div>
        <div class="plan-price">৳ {{ $seo['locale'] === 'bn' ? '১,২৯৯' : '1,299' }} <span>{{ t('landing.per_month') }}</span></div>
        <p class="plan-desc">{{ t('landing.plan_enterprise_desc') }}</p>
        <ul class="plan-features">
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.plan_enterprise_f1') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.plan_enterprise_f2') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.multi_branch') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.plan_enterprise_f4') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.plan_enterprise_f5') }}</li>
          <li><span class="check material-icons-round">check_circle</span> {{ t('landing.plan_enterprise_f6') }}</li>
        </ul>
        <a href="#contact" class="plan-btn">{{ t('landing.contact_btn') }}</a>
      </div>
    </div>

    <div class="compare-table">
      <table>
        <thead>
          <tr>
            <th>{{ t('landing.nav_features') }}</th>
            <th>{{ t('landing.plan_free_name') }}</th>
            <th>{{ t('landing.plan_starter_name') }}</th>
            <th class="pop-col">{{ t('landing.plan_dreamer_name') }}</th>
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
            <td class="cross">&#10007;</td>
            <td class="check">&#10003;</td>
            <td class="pop-col check">&#10003;</td>
            <td class="check">&#10003;</td>
          </tr>
          <tr>
            <td>{{ t('landing.customer_mgmt') }}</td>
            <td class="cross">&#10007;</td>
            <td class="check">&#10003;</td>
            <td class="pop-col check">&#10003;</td>
            <td class="check">&#10003;</td>
          </tr>
          <tr>
            <td>{{ t('landing.cloud_backup') }}</td>
            <td class="cross">&#10007;</td>
            <td class="check">&#10003;</td>
            <td class="pop-col check">&#10003;</td>
            <td class="check">&#10003;</td>
          </tr>
          <tr>
            <td>{{ t('landing.multi_user') }}</td>
            <td class="cross">&#10007;</td>
            <td class="cross">&#10007;</td>
            <td class="pop-col">{{ t('landing.users_3') }}</td>
            <td>{{ t('landing.unlimited') }}</td>
          </tr>
          <tr>
            <td>{{ t('landing.multi_branch') }}</td>
            <td class="cross">&#10007;</td>
            <td class="cross">&#10007;</td>
            <td class="pop-col cross">&#10007;</td>
            <td class="check">&#10003;</td>
          </tr>
          <tr>
            <td>{{ t('landing.compare_row_priority_support') }}</td>
            <td class="cross">&#10007;</td>
            <td class="cross">&#10007;</td>
            <td class="pop-col cross">&#10007;</td>
            <td class="check">&#10003;</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- MOBILE -->
<section class="mobile-section" id="mobile">
  <div class="section-inner">
    <div class="mobile-inner">
      <div>
        <div class="section-tag"><span class="material-icons-round">phone_android</span> {{ t('landing.mobile_tag') }}</div>
        <h2 class="section-title">{{ t('landing.mobile_title_1') }}<br>{{ t('landing.mobile_title_2') }}</h2>
        <div class="divider"></div>
        <p style="color:var(--text-2);margin:18px 0 28px;font-size:1rem;line-height:1.7">{{ t('landing.mobile_subtitle') }}</p>
        <div class="device-chips">
          <div class="device-chip"><span class="material-icons-round">android</span> Android</div>
          <div class="device-chip"><span class="material-icons-round">phone_iphone</span> iPhone</div>
          <div class="device-chip"><span class="material-icons-round">tablet</span> Tablet</div>
          <div class="device-chip"><span class="material-icons-round">computer</span> Desktop</div>
        </div>
        <div class="mobile-note">
          <span class="material-icons-round">info</span>
          <span>{{ t('landing.mobile_note') }}</span>
        </div>
      </div>
      <div class="phones-group">
        <div class="phone-mock">
          <div class="phone-mock-screen">
            <div class="pm-header"><span class="material-icons-round">inventory</span> {{ t('landing.stock_list') }}</div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_rice_kg') }}</span><span class="r-amt">{{ t('landing.val_48kg') }}</span></div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_dal_kg') }}</span><span class="r-amt">{{ t('landing.val_22kg') }}</span></div>
            <div class="pm-row" style="background:#FFF5F5"><span class="r-name" style="color:#E53E3E">{{ t('landing.demo_mustard_oil') }}</span><span class="r-amt" style="color:#E53E3E">{{ t('landing.val_3liter') }}</span></div>
          </div>
        </div>
        <div class="phone-mock main">
          <div class="phone-mock-screen">
            <div class="pm-header"><span class="material-icons-round">dashboard</span> {{ t('nav.dashboard') }}</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;margin-bottom:8px">
              <div class="pm-card"><div class="pm-card-label">{{ t('landing.today_sale_short') }}</div><div class="pm-card-val">{{ $seo['locale'] === 'bn' ? '৮,৪৫০' : '8,450' }}</div></div>
              <div class="pm-card"><div class="pm-card-label">{{ t('landing.profit') }}</div><div class="pm-card-val">{{ $seo['locale'] === 'bn' ? '২,১২০' : '2,120' }}</div></div>
            </div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_soap_5pc') }}</span><span class="r-amt">{{ $seo['locale'] === 'bn' ? '৩০০' : '300' }}</span></div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_shampoo') }}</span><span class="r-amt">{{ $seo['locale'] === 'bn' ? '৩৫০' : '350' }}</span></div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_rice_10kg') }}</span><span class="r-amt">{{ $seo['locale'] === 'bn' ? '৮৪০' : '840' }}</span></div>
            <div class="pm-sale-btn">+ {{ t('dashboard.new_sale') }}</div>
          </div>
        </div>
        <div class="phone-mock">
          <div class="phone-mock-screen">
            <div class="pm-header"><span class="material-icons-round">person</span> {{ t('landing.due_list') }}</div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_name_1') }}</span><span class="r-amt" style="color:#E53E3E">{{ $seo['locale'] === 'bn' ? '১,২০০' : '1,200' }}</span></div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_name_2') }}</span><span class="r-amt" style="color:#E53E3E">{{ $seo['locale'] === 'bn' ? '৬৮০' : '680' }}</span></div>
            <div class="pm-row"><span class="r-name">{{ t('landing.demo_name_3') }}</span><span class="r-amt" style="color:#E53E3E">{{ $seo['locale'] === 'bn' ? '৩৪০' : '340' }}</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECURITY -->
<section id="security">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag"><span class="material-icons-round">verified_user</span> {{ t('landing.security_tag') }}</div>
      <h2 class="section-title">{{ t('landing.security_title_1') }}<br>{{ t('landing.security_title_2') }}</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:16px">{{ t('landing.security_subtitle') }}</p>
    </div>
    <div class="security-grid">
      <div class="sec-card">
        <div class="sec-icon"><span class="material-icons-round">cloud_done</span></div>
        <h4>{{ t('landing.cloud_backup') }}</h4>
        <p>{{ t('landing.sec_1_desc') }}</p>
      </div>
      <div class="sec-card">
        <div class="sec-icon"><span class="material-icons-round">enhanced_encryption</span></div>
        <h4>{{ t('landing.sec_2_title') }}</h4>
        <p>{{ t('landing.sec_2_desc') }}</p>
      </div>
      <div class="sec-card">
        <div class="sec-icon"><span class="material-icons-round">shield</span></div>
        <h4>{{ t('landing.sec_3_title') }}</h4>
        <p>{{ t('landing.sec_3_desc') }}</p>
      </div>
      <div class="sec-card">
        <div class="sec-icon"><span class="material-icons-round">domain</span></div>
        <h4>{{ t('landing.sec_4_title') }}</h4>
        <p>{{ t('landing.sec_4_desc') }}</p>
      </div>
      <div class="sec-card">
        <div class="sec-icon"><span class="material-icons-round">admin_panel_settings</span></div>
        <h4>{{ t('landing.sec_5_title') }}</h4>
        <p>{{ t('landing.sec_5_desc') }}</p>
      </div>
      <div class="sec-card">
        <div class="sec-icon"><span class="material-icons-round">sync</span></div>
        <h4>{{ t('landing.sec_6_title') }}</h4>
        <p>{{ t('landing.sec_6_desc') }}</p>
      </div>
    </div>
  </div>
</section>

<!-- PUBLIC FEEDBACK -->
<section class="section-bg" id="feedback">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag"><span class="material-icons-round">forum</span> {{ $seo['locale'] === 'bn' ? 'ব্যবহারকারীদের মতামত' : 'User Feedback' }}</div>
      <h2 class="section-title">{{ $seo['locale'] === 'bn' ? 'বাংলাদেশি ব্যবসায়ীদের বাস্তব অভিজ্ঞতা' : 'Real experiences from Bangladeshi businesses' }}</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:16px">
        {{ $seo['locale'] === 'bn' ? 'যারা হিসাবিজ ব্যবহার করছেন তাদের মতামত।' : 'What our users are saying about Hishabiz.' }}
      </p>
    </div>
    <div class="testimonial-grid">
      @foreach ($seo['testimonials'] as $testimonial)
        <article class="testimonial-card">
          <blockquote>&ldquo;{{ $testimonial['quote'] }}&rdquo;</blockquote>
          <h3>{{ $testimonial['name'] }}</h3>
          <div class="testimonial-role">{{ $testimonial['role'] }}</div>
        </article>
      @endforeach
    </div>
  </div>
</section>

<!-- FAQ -->
<section id="faq">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag"><span class="material-icons-round">help_outline</span> {{ t('landing.faq_tag') }}</div>
      <h2 class="section-title">{{ t('landing.faq_title') }}</h2>
      <div class="divider center"></div>
    </div>
    <div class="faq-list">
      <div class="faq-item open">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q1') }}</span>
          <span class="material-icons-round">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a1') }}</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q2') }}</span>
          <span class="material-icons-round">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a2') }}</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q3') }}</span>
          <span class="material-icons-round">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a3') }}</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q4') }}</span>
          <span class="material-icons-round">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a4') }}</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q5') }}</span>
          <span class="material-icons-round">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a5') }}</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q6') }}</span>
          <span class="material-icons-round">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a6') }}</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q7') }}</span>
          <span class="material-icons-round">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a7') }}</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>{{ t('landing.faq_q8') }}</span>
          <span class="material-icons-round">add</span>
        </div>
        <div class="faq-a">{{ t('landing.faq_a8') }}</div>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section class="contact-section" id="contact">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag"><span class="material-icons-round">mail</span> {{ $seo['locale'] === 'bn' ? 'যোগাযোগ' : 'Contact Us' }}</div>
      <h2 class="section-title">{{ $seo['locale'] === 'bn' ? 'আমাদের সাথে যোগাযোগ করুন' : 'Get in touch with us' }}</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:16px">
        {{ $seo['locale'] === 'bn' ? 'যেকোনো প্রশ্ন বা সাহায্যের জন্য আমাদের সাথে যোগাযোগ করুন। আমরা সবসময় সাহায্য করতে প্রস্তুত।' : 'Have questions or need help? Reach out to us anytime. We are always happy to assist.' }}
      </p>
    </div>
    <div class="contact-grid">
      <div class="contact-card">
        <div class="contact-icon whatsapp">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        </div>
        <h4>WhatsApp</h4>
        <p>{{ $seo['locale'] === 'bn' ? 'সরাসরি WhatsApp-এ মেসেজ পাঠান। দ্রুত উত্তর পাবেন।' : 'Send us a message on WhatsApp for quick replies.' }}</p>
        <a href="https://wa.me/8801577004929" target="_blank" rel="noopener" class="contact-link wa">
          <span class="material-icons-round" style="font-size:18px">chat</span>
          +880 1577 004929
        </a>
      </div>
      <div class="contact-card">
        <div class="contact-icon email">
          <span class="material-icons-round">email</span>
        </div>
        <h4>{{ $seo['locale'] === 'bn' ? 'ইমেইল' : 'Email' }}</h4>
        <p>{{ $seo['locale'] === 'bn' ? 'বিস্তারিত জানাতে ইমেইল করুন। আমরা দ্রুত উত্তর দেই।' : 'Email us for detailed inquiries. We respond promptly.' }}</p>
        <a href="mailto:hishabiz.support@gmail.com" class="contact-link">
          <span class="material-icons-round" style="font-size:18px">send</span>
          hishabiz.support@gmail.com
        </a>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="section-inner">
    <div class="section-tag" style="margin-bottom:22px;display:inline-flex"><span class="material-icons-round">trending_up</span> {{ t('landing.cta_tag') }}</div>
    <h2>{{ t('landing.cta_title_1') }}<br>{{ t('landing.cta_title_2') }}</h2>
    <p>{{ t('landing.cta_subtitle') }}</p>
    <div class="cta-btns">
      <a href="{{ route('register') }}" class="btn-cta-white">
        <span class="material-icons-round" style="font-size:20px">person_add</span>
        {{ t('landing.cta_create_account') }}
      </a>
      <a href="{{ route('login') }}" class="btn-cta-outline">
        <span class="material-icons-round" style="font-size:20px">login</span>
        {{ t('landing.login_cta') }}
      </a>
    </div>
    <p class="cta-note">
      <span><span class="material-icons-round">check_circle</span> {{ t('landing.cta_note_2') }}</span>
      <span><span class="material-icons-round">check_circle</span> {{ t('landing.cta_note_3') }}</span>
    </p>
  </div>
</section>

</main>

<!-- FOOTER -->
<footer>
  <div class="footer-inner">
    <div class="footer-brand">
      <a href="{{ route('home') }}" class="logo" aria-label="{{ $seo['brand'] }}">
        <div class="logo-icon"><img src="{{ asset('assets/img/project/brand-logo.svg') }}" alt="{{ $seo['brand'] }}" width="42" height="42"></div>
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
    <div class="footer-col">
      <h5>{{ t('landing.footer_help') }}</h5>
      <a href="#faq">{{ t('landing.nav_faq') }}</a>
      <a href="#contact">{{ $seo['locale'] === 'bn' ? 'যোগাযোগ' : 'Contact' }}</a>
      <a href="#">{{ t('landing.footer_privacy_policy') }}</a>
      <a href="#">{{ t('landing.footer_terms') }}</a>
    </div>
    <div class="footer-col">
      <h5>{{ $seo['locale'] === 'bn' ? 'যোগাযোগ' : 'Contact' }}</h5>
      <a href="https://wa.me/8801577004929" target="_blank" rel="noopener">WhatsApp: +880 1577 004929</a>
      <a href="mailto:hishabiz.support@gmail.com">hishabiz.support@gmail.com</a>
    </div>
  </div>
  <div class="footer-bottom">
    <span>&copy; {{ date('Y') }} {{ $seo['brand'] }}{{ $seo['locale'] === 'bn' ? '।' : '.' }} {{ t('footer.rights') }}</span>
    <a href="https://tahmeed-three.vercel.app/" target="_blank" rel="noopener" class="footer-credit">
      <span class="dev-heart">&hearts;</span>
      <span>Designed &amp; Developed by <span class="dev-name">Tahmeed Mahbub</span></span>
    </a>
    <span><a href="#">{{ t('landing.footer_privacy') }}</a> &middot; <a href="#">{{ t('landing.footer_terms_short') }}</a></span>
  </div>
</footer>

<!-- WhatsApp Floating Button -->
<a href="https://wa.me/8801577004929" target="_blank" rel="noopener" class="wa-float" aria-label="Chat on WhatsApp">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

<script>
// Hamburger
const hamburger=document.getElementById('hamburger');
const mobileMenu=document.getElementById('mobileMenu');
hamburger.addEventListener('click',()=>{
  const isOpen=mobileMenu.style.display==='flex';
  mobileMenu.style.display=isOpen?'none':'flex';
  hamburger.setAttribute('aria-expanded',!isOpen);
});

// FAQ
function toggleFaq(el){
  const item=el.parentElement;
  const isOpen=item.classList.contains('open');
  document.querySelectorAll('.faq-item').forEach(i=>i.classList.remove('open'));
  if(!isOpen)item.classList.add('open');
}

// Scroll-triggered reveal with IntersectionObserver (performant, no scroll listener)
const observer=new IntersectionObserver((entries)=>{
  entries.forEach(entry=>{
    if(entry.isIntersecting){
      entry.target.style.opacity='1';
      entry.target.style.transform='translateY(0)';
      observer.unobserve(entry.target);
    }
  });
},{threshold:0.08,rootMargin:'0px 0px -40px 0px'});

document.querySelectorAll('.feature-card,.benefit-card,.sec-card,.plan-card,.step-card,.problem-card,.use-case-card,.testimonial-card,.contact-card').forEach(el=>{
  el.style.opacity='0';
  el.style.transform='translateY(24px)';
  el.style.transition='opacity .6s ease,transform .6s ease';
  observer.observe(el);
});

// Close mobile menu on link click
document.querySelectorAll('.mobile-menu a').forEach(a=>{
  a.addEventListener('click',()=>{mobileMenu.style.display='none'});
});

// Smooth scroll polyfill for anchor links
document.querySelectorAll('a[href^="#"]').forEach(a=>{
  a.addEventListener('click',e=>{
    const target=document.querySelector(a.getAttribute('href'));
    if(target){e.preventDefault();target.scrollIntoView({behavior:'smooth',block:'start'})}
  });
});
</script>
</body>
</html>
