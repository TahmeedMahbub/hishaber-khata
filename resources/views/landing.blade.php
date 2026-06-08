<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>হিসাবের খাতা – ছোট ব্যবসার ডিজিটাল খাতা</title>
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
  display:flex; align-items:center; gap:10px; text-decoration:none;
}
.logo-icon {
  width:40px; height:40px; background: var(--green);
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
.footer-bottom { max-width:1200px; margin:0 auto; display:flex; justify-content:space-between; flex-wrap:wrap; gap:8px; font-size:0.82rem; }
.footer-bottom a { color:rgba(255,255,255,0.5); text-decoration:none; }

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
      <div class="logo-icon"><img src="{{ asset('assets/img/project/logo.png') }}" alt="হিসাবের খাতা"></div>
      <span class="logo-text">হিসাবের <span>খাতা</span></span>
    </a>
    <div class="nav-links">
      <a href="#features">ফিচার</a>
      <a href="#how">কিভাবে কাজ করে</a>
      <a href="#plans">প্ল্যান</a>
      <a href="#faq">FAQ</a>
      <a href="{{ route('login') }}" class="btn-nav-login">লগইন</a>
      <a href="{{ route('register') }}" class="btn-nav-cta">বিনামূল্যে শুরু করুন</a>
    </div>
    <button class="hamburger" id="hamburger" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </div>
  <div class="mobile-menu" id="mobileMenu">
    <a href="#features">ফিচার</a>
    <a href="#how">কিভাবে কাজ করে</a>
    <a href="#plans">প্ল্যান</a>
    <a href="#faq">প্রশ্ন-উত্তর</a>
    <div class="mobile-menu-btns">
      <a href="{{ route('login') }}" class="btn-secondary" style="flex:1;text-align:center;padding:11px;">লগইন</a>
      <a href="{{ route('register') }}" class="btn-primary" style="flex:1;text-align:center;padding:11px;">বিনামূল্যে শুরু</a>
    </div>
  </div>
</nav>

<!-- ═══════════════════════════════ HERO ═══════════════════════════════ -->
<section class="hero">
  <div class="hero-inner">
    <div class="hero-content">
      <div class="hero-badge fade-up"><span class="dot"></span> ১০,০০০+ দোকানদার বিশ্বাস করেন</div>
      <h1 class="fade-up delay-1">
        প্রতিটি দোকানের জন্য <span class="highlight">সহজ ব্যবসা ব্যবস্থাপনা</span>
      </h1>
      <p class="hero-sub fade-up delay-2">
        মোবাইল থেকেই বিক্রয়, কেনাকাটা, স্টক, খরচ ও লাভ ট্র্যাক করুন। কোনো অ্যাকাউন্টিং জ্ঞান দরকার নেই।
      </p>
      <div class="hero-btns fade-up delay-3">
        <a href="{{ route('register') }}" class="btn-primary"><span>🚀</span> বিনামূল্যে শুরু করুন</a>
        <a href="{{ route('login') }}" class="btn-secondary"><span>🔑</span> লগইন করুন</a>
      </div>
      <div class="trust-badges fade-up delay-4">
        <div class="trust-badge"><span class="material-icons">smartphone</span> মোবাইল ফ্রেন্ডলি</div>
        <div class="trust-badge"><span class="material-icons">cloud</span> ক্লাউড ভিত্তিক</div>
        <div class="trust-badge"><span class="material-icons">lock</span> নিরাপদ ডেটা</div>
        <div class="trust-badge"><span class="material-icons">devices</span> মাল্টি ডিভাইস</div>
      </div>
    </div>

    <!-- Dashboard Preview -->
    <div class="hero-visual fade-up delay-2">
      <div class="dashboard-preview">
        <div class="dash-header">
          <span class="dash-header-title">📒 হিসাবের খাতা</span>
          <span class="dash-header-date">আজকের সারসংক্ষেপ</span>
        </div>
        <div class="dash-body">
          <div class="dash-stats">
            <div class="dash-stat">
              <div class="dash-stat-label">আজকের বিক্রয়</div>
              <div class="dash-stat-value green">৳ ১২,৪৫০</div>
            </div>
            <div class="dash-stat">
              <div class="dash-stat-label">মোট লাভ</div>
              <div class="dash-stat-value accent">৳ ৩,৮৮০</div>
            </div>
            <div class="dash-stat">
              <div class="dash-stat-label">পণ্য সংখ্যা</div>
              <div class="dash-stat-value blue">২৪৮টি</div>
            </div>
            <div class="dash-stat">
              <div class="dash-stat-label">বকেয়া</div>
              <div class="dash-stat-value" style="color:#E53E3E">৳ ৫,২৩০</div>
            </div>
          </div>
          <div class="dash-chart-label">📊 সাপ্তাহিক বিক্রয়</div>
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
            <div class="dash-recent-label">🛍️ সাম্প্রতিক বিক্রয়</div>
            <div class="dash-sale-item">
              <span class="dash-sale-name">সাবান - ৩ পিস</span>
              <span class="dash-sale-amt">৳ ১৮০</span>
            </div>
            <div class="dash-sale-item">
              <span class="dash-sale-name">শ্যাম্পু বোতল</span>
              <span class="dash-sale-amt">৳ ৩৫০</span>
            </div>
            <div class="dash-sale-item">
              <span class="dash-sale-name">চাল - ৫ কেজি</span>
              <span class="dash-sale-amt">৳ ৪২০</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Phone float -->
      <div class="phone-float">
        <div class="phone-screen">
          <div style="font-size:0.62rem;font-weight:700;color:var(--green);margin-bottom:6px;">📱 বিক্রয় যোগ করুন</div>
          <div class="phone-sale-row"><span class="label">পণ্য</span><span class="val">চাল ৫কেজি</span></div>
          <div class="phone-sale-row"><span class="label">মূল্য</span><span class="val">৳৪২০</span></div>
          <div class="phone-sale-row"><span class="label">পরিমাণ</span><span class="val">২টি</span></div>
          <div class="phone-btn-mock">✅ সেভ করুন</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ WHY ═══════════════════════════════ -->
<section class="section-bg" id="why">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag">😟 সমস্যা থেকে সমাধান</div>
      <h2 class="section-title">দোকানদারদের প্রতিদিনের সমস্যাগুলো<br>আমরা বুঝি</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:14px">পুরনো পদ্ধতি আর নয়। হিসাবের খাতা আপনার ব্যবসাকে সহজ ও স্মার্ট করে তুলবে।</p>
    </div>
    <div class="problems-grid">
      <div class="problem-card">
        <div class="prob-icon">📓</div>
        <div class="prob-arrow">→</div>
        <div class="prob-text">
          <h4 class="before">কাগজের খাতা হারিয়ে যায়</h4>
          <p class="after">ক্লাউডে সংরক্ষিত, কখনো হারাবে না</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="prob-icon">📦</div>
        <div class="prob-arrow">→</div>
        <div class="prob-text">
          <h4 class="before">স্টক হিসাব করা কঠিন</h4>
          <p class="after">স্বয়ংক্রিয়ভাবে স্টক আপডেট হয়</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="prob-icon">💰</div>
        <div class="prob-arrow">→</div>
        <div class="prob-text">
          <h4 class="before">লাভ কত হলো বোঝা যায় না</h4>
          <p class="after">রিয়েল-টাইম লাভের রিপোর্ট দেখুন</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="prob-icon">🧾</div>
        <div class="prob-arrow">→</div>
        <div class="prob-text">
          <h4 class="before">বাকির হিসাব গুলিয়ে যায়</h4>
          <p class="after">কাস্টমার বাকির সম্পূর্ণ ইতিহাস</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="prob-icon">🗂️</div>
        <div class="prob-arrow">→</div>
        <div class="prob-text">
          <h4 class="before">ব্যবসার তথ্য ছড়িয়ে থাকে</h4>
          <p class="after">একটি অ্যাপে সব তথ্য একসাথে</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="prob-icon">📊</div>
        <div class="prob-arrow">→</div>
        <div class="prob-text">
          <h4 class="before">মাসের হিসাব বের করা ঝামেলা</h4>
          <p class="after">এক ক্লিকেই মাসিক রিপোর্ট</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ FEATURES ═══════════════════════════════ -->
<section id="features">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag">✨ মূল ফিচারসমূহ</div>
      <h2 class="section-title">আপনার দোকানের জন্য দরকারি<br>সব কিছু এক জায়গায়</h2>
      <div class="divider center"></div>
    </div>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feat-icon">🛍️</div>
        <h3>বিক্রয় ব্যবস্থাপনা</h3>
        <ul>
          <li>দ্রুত বিক্রয় এন্ট্রি</li>
          <li>ইনভয়েস তৈরি করুন</li>
          <li>বিক্রয়ের ইতিহাস দেখুন</li>
          <li>প্রতিদিনের বিক্রয় সারসংক্ষেপ</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon">🚚</div>
        <h3>ক্রয় ব্যবস্থাপনা</h3>
        <ul>
          <li>কেনাকাটার রেকর্ড রাখুন</li>
          <li>সরবরাহকারী ট্র্যাকিং</li>
          <li>ক্রয় বিল সংরক্ষণ</li>
          <li>সাপ্লায়ার বকেয়া ব্যবস্থাপনা</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon">📦</div>
        <h3>স্টক ব্যবস্থাপনা</h3>
        <ul>
          <li>বর্তমান স্টক দেখুন</li>
          <li>কম স্টক এলার্ট পান</li>
          <li>স্টক মুভমেন্ট ট্র্যাক করুন</li>
          <li>স্টক রিপোর্ট পান</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon">👤</div>
        <h3>কাস্টমার ব্যবস্থাপনা</h3>
        <ul>
          <li>কাস্টমারের তথ্য সংরক্ষণ</li>
          <li>বাকির হিসাব ট্র্যাক করুন</li>
          <li>পেমেন্টের ইতিহাস দেখুন</li>
          <li>কাস্টমারকে মনে করিয়ে দিন</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon">💳</div>
        <h3>খরচ ব্যবস্থাপনা</h3>
        <ul>
          <li>ভাড়ার খরচ রেকর্ড</li>
          <li>কর্মচারীর বেতন</li>
          <li>বিদ্যুৎ ও ইউটিলিটি খরচ</li>
          <li>অন্যান্য খরচ ট্র্যাক</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon">📊</div>
        <h3>রিপোর্ট ও বিশ্লেষণ</h3>
        <ul>
          <li>দৈনিক বিক্রয় রিপোর্ট</li>
          <li>মাসিক বিক্রয় সারসংক্ষেপ</li>
          <li>লাভ-লোকসান রিপোর্ট</li>
          <li>স্টক রিপোর্ট</li>
        </ul>
      </div>
      <div class="feature-card">
        <div class="feat-icon">💰</div>
        <h3>ক্যাশবুক</h3>
        <ul>
          <li>নগদ আয় রেকর্ড</li>
          <li>নগদ খরচ রেকর্ড</li>
          <li>বর্তমান ব্যালেন্স দেখুন</li>
          <li>দৈনিক ক্যাশ সারসংক্ষেপ</li>
        </ul>
      </div>
      <div class="feature-card" style="background:var(--green-light);border-color:rgba(27,139,90,0.2)">
        <div class="feat-icon" style="background:#fff">🧾</div>
        <h3>ইনভয়েস ও রশিদ</h3>
        <ul>
          <li>প্রফেশনাল ইনভয়েস তৈরি</li>
          <li>ডিজিটাল রশিদ শেয়ার করুন</li>
          <li>WhatsApp-এ পাঠান</li>
          <li>প্রিন্ট করুন সহজেই</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ BENEFITS ═══════════════════════════════ -->
<section class="section-green">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag">❤️ কেন দোকানদাররা ভালোবাসেন</div>
      <h2 class="section-title">হিসাবের খাতা ব্যবহার করলে<br>যা পাবেন</h2>
      <div class="divider center" style="background:#fff;margin:12px auto 0"></div>
    </div>
    <div class="benefits-grid">
      <div class="benefit-card">
        <div class="benefit-icon">📱</div>
        <h4>যেকোনো ডিভাইসে চলে</h4>
        <p>মোবাইল, ট্যাবলেট বা কম্পিউটার — সব জায়গায় ব্যবহার করুন</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon">🎓</div>
        <h4>হিসাবের জ্ঞান লাগে না</h4>
        <p>যে কেউ সহজেই শিখতে ও ব্যবহার করতে পারবেন</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon">⚡</div>
        <h4>সময় বাঁচায়</h4>
        <p>ম্যানুয়াল হিসাবের ঝামেলা থেকে মুক্তি, বেশি সময় ব্যবসায়</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon">🔍</div>
        <h4>স্টক ভুল হয় না</h4>
        <p>প্রতিটি বিক্রয়ে স্বয়ংক্রিয়ভাবে স্টক আপডেট হয়</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon">💡</div>
        <h4>সত্যিকারের লাভ দেখায়</h4>
        <p>খরচ বাদ দিয়ে আসল লাভ কত তা স্পষ্টভাবে দেখুন</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon">📈</div>
        <h4>ব্যবসা বাড়াতে সাহায্য করে</h4>
        <p>ডেটা দেখে সঠিক সিদ্ধান্ত নিন, ব্যবসাকে এগিয়ে নিন</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon">🌙</div>
        <h4>২৪/৭ সহজলভ্য</h4>
        <p>যেকোনো সময়, যেকোনো জায়গা থেকে হিসাব দেখুন</p>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon">🤝</div>
        <h4>বাংলায় সম্পূর্ণ</h4>
        <p>সম্পূর্ণ বাংলা ভাষায়, বাংলাদেশের দোকানদারদের জন্য</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ HOW IT WORKS ═══════════════════════════════ -->
<section class="section-bg" id="how">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag">🗺️ কিভাবে কাজ করে</div>
      <h2 class="section-title">মাত্র ৫টি ধাপে শুরু করুন</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:14px">জটিল কিছু নেই। সহজ ধাপগুলো অনুসরণ করুন এবং আজই ব্যবসা ম্যানেজ শুরু করুন।</p>
    </div>
    <div class="steps-wrapper">
      <div class="step-card">
        <div class="step-num">১</div>
        <div class="step-emoji">🏪</div>
        <h4>ব্যবসা নিবন্ধন করুন</h4>
        <p>দোকানের নাম ও তথ্য দিয়ে বিনামূল্যে অ্যাকাউন্ট খুলুন</p>
      </div>
      <div class="step-card">
        <div class="step-num">২</div>
        <div class="step-emoji">📦</div>
        <h4>পণ্য যোগ করুন</h4>
        <p>আপনার দোকানের পণ্যের তালিকা ও দাম সেট করুন</p>
      </div>
      <div class="step-card">
        <div class="step-num">৩</div>
        <div class="step-emoji">🛒</div>
        <h4>কেনাকাটা রেকর্ড করুন</h4>
        <p>পাইকারি থেকে পণ্য কিনলে তা রেকর্ড করুন</p>
      </div>
      <div class="step-card">
        <div class="step-num">৪</div>
        <div class="step-emoji">💰</div>
        <h4>বিক্রয় রেকর্ড করুন</h4>
        <p>প্রতিটি বিক্রয় দ্রুত এন্ট্রি করুন, ইনভয়েস তৈরি করুন</p>
      </div>
      <div class="step-card">
        <div class="step-num">৫</div>
        <div class="step-emoji">📊</div>
        <h4>লাভ ট্র্যাক করুন</h4>
        <p>রিয়েল-টাইম রিপোর্টে দেখুন কতটুকু লাভ হচ্ছে</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ PLANS ═══════════════════════════════ -->
<section id="plans">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag">💎 সাবস্ক্রিপশন প্ল্যান</div>
      <h2 class="section-title">আপনার ব্যবসার আকার অনুযায়ী<br>প্ল্যান বেছে নিন</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:14px">বিনামূল্যে শুরু করুন, যখন প্রয়োজন আপগ্রেড করুন</p>
    </div>
    <div class="plans-grid">
      <!-- Free -->
      <div class="plan-card">
        <div class="plan-name">🎁 ফ্রি</div>
        <div class="plan-price">৳ ০ <span>/ মাস</span></div>
        <p class="plan-desc">নতুন দোকানদারদের জন্য শুরু করার সুযোগ</p>
        <ul class="plan-features">
          <li><span class="check">✓</span> ৫০টি পণ্য</li>
          <li><span class="check">✓</span> মাসে ১০০টি বিক্রয়</li>
          <li><span class="check">✓</span> বেসিক রিপোর্ট</li>
          <li><span class="cross">✗</span> ইনভয়েস</li>
          <li><span class="cross">✗</span> কাস্টমার ম্যানেজমেন্ট</li>
          <li><span class="cross">✗</span> ব্যাকআপ</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn">বিনামূল্যে শুরু করুন</a>
      </div>

      <!-- Starter -->
      <div class="plan-card">
        <div class="plan-name">⭐ স্টার্টার</div>
        <div class="plan-price">৳ ২৯৯ <span>/ মাস</span></div>
        <p class="plan-desc">ছোট দোকানের জন্য আদর্শ</p>
        <ul class="plan-features">
          <li><span class="check">✓</span> ৫০০টি পণ্য</li>
          <li><span class="check">✓</span> সীমাহীন বিক্রয়</li>
          <li><span class="check">✓</span> ইনভয়েস তৈরি</li>
          <li><span class="check">✓</span> কাস্টমার ম্যানেজমেন্ট</li>
          <li><span class="check">✓</span> ক্লাউড ব্যাকআপ</li>
          <li><span class="cross">✗</span> একাধিক ব্যবহারকারী</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn">শুরু করুন</a>
      </div>

      <!-- Dreamer — Most Popular -->
      <div class="plan-card popular">
        <div class="popular-badge">⭐ সবচেয়ে জনপ্রিয়</div>
        <div class="plan-name">🚀 ড্রিমার</div>
        <div class="plan-price">৳ ৫৯৯ <span>/ মাস</span></div>
        <p class="plan-desc">বেড়ে ওঠা ব্যবসার জন্য সেরা পছন্দ</p>
        <ul class="plan-features">
          <li><span class="check">✓</span> সীমাহীন পণ্য</li>
          <li><span class="check">✓</span> সীমাহীন বিক্রয়</li>
          <li><span class="check">✓</span> সব ফিচার অন্তর্ভুক্ত</li>
          <li><span class="check">✓</span> ৩ জন ব্যবহারকারী</li>
          <li><span class="check">✓</span> প্রিমিয়াম রিপোর্ট</li>
          <li><span class="check">✓</span> WhatsApp ইনভয়েস</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn primary">এখনই শুরু করুন</a>
      </div>

      <!-- Enterprise -->
      <div class="plan-card">
        <div class="plan-name">🏢 এন্টারপ্রাইজ</div>
        <div class="plan-price">৳ ১,২৯৯ <span>/ মাস</span></div>
        <p class="plan-desc">একাধিক শাখা বা বড় ব্যবসার জন্য</p>
        <ul class="plan-features">
          <li><span class="check">✓</span> সব ড্রিমার ফিচার</li>
          <li><span class="check">✓</span> সীমাহীন ব্যবহারকারী</li>
          <li><span class="check">✓</span> একাধিক শাখা</li>
          <li><span class="check">✓</span> ডেডিকেটেড সাপোর্ট</li>
          <li><span class="check">✓</span> কাস্টম রিপোর্ট</li>
          <li><span class="check">✓</span> API অ্যাক্সেস</li>
        </ul>
        <a href="#" class="plan-btn">যোগাযোগ করুন</a>
      </div>
    </div>

    <!-- Comparison Table -->
    <div class="compare-table">
      <table>
        <thead>
          <tr>
            <th>ফিচার</th>
            <th>ফ্রি</th>
            <th>স্টার্টার</th>
            <th class="pop-col">ড্রিমার ⭐</th>
            <th>এন্টারপ্রাইজ</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>পণ্যের সীমা</td>
            <td>৫০টি</td>
            <td>৫০০টি</td>
            <td class="pop-col">সীমাহীন</td>
            <td>সীমাহীন</td>
          </tr>
          <tr>
            <td>বিক্রয় এন্ট্রি</td>
            <td>১০০/মাস</td>
            <td>সীমাহীন</td>
            <td class="pop-col">সীমাহীন</td>
            <td>সীমাহীন</td>
          </tr>
          <tr>
            <td>ইনভয়েস তৈরি</td>
            <td class="cross">✗</td>
            <td class="check">✓</td>
            <td class="pop-col check">✓</td>
            <td class="check">✓</td>
          </tr>
          <tr>
            <td>কাস্টমার ম্যানেজমেন্ট</td>
            <td class="cross">✗</td>
            <td class="check">✓</td>
            <td class="pop-col check">✓</td>
            <td class="check">✓</td>
          </tr>
          <tr>
            <td>ক্লাউড ব্যাকআপ</td>
            <td class="cross">✗</td>
            <td class="check">✓</td>
            <td class="pop-col check">✓</td>
            <td class="check">✓</td>
          </tr>
          <tr>
            <td>একাধিক ব্যবহারকারী</td>
            <td class="cross">✗</td>
            <td class="cross">✗</td>
            <td class="pop-col">৩ জন</td>
            <td>সীমাহীন</td>
          </tr>
          <tr>
            <td>একাধিক শাখা</td>
            <td class="cross">✗</td>
            <td class="cross">✗</td>
            <td class="pop-col cross">✗</td>
            <td class="check">✓</td>
          </tr>
          <tr>
            <td>অগ্রাধিকার সাপোর্ট</td>
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
        <div class="section-tag">📱 যেকোনো ডিভাইসে</div>
        <h2 class="section-title">মোবাইল ফ্রেন্ডলি<br>অ্যাপ</h2>
        <div class="divider"></div>
        <p style="color:var(--text-2);margin:16px 0 24px;font-size:1rem">ইন্সটল করার ঝামেলা নেই। ব্রাউজার খুলুন, ব্যবহার করুন।</p>
        <div class="device-chips">
          <div class="device-chip"><span class="material-icons">android</span> Android</div>
          <div class="device-chip"><span class="material-icons">phone_iphone</span> iPhone</div>
          <div class="device-chip"><span class="material-icons">tablet</span> Tablet</div>
          <div class="device-chip"><span class="material-icons">computer</span> Desktop</div>
        </div>
        <div class="mobile-note">
          <span>💡</span>
          <span>কোনো অ্যাপ ডাউনলোড করতে হবে না। ব্রাউজার দিয়েই সব কাজ করুন।</span>
        </div>
      </div>
      <div class="phones-group">
        <div class="phone-mock">
          <div class="phone-mock-screen">
            <div class="pm-header">📦 স্টক তালিকা</div>
            <div class="pm-row"><span class="r-name">চাল (কেজি)</span><span class="r-amt">৪৮ কেজি</span></div>
            <div class="pm-row"><span class="r-name">ডাল (কেজি)</span><span class="r-amt">২২ কেজি</span></div>
            <div class="pm-row" style="background:#FFF5F5"><span class="r-name" style="color:#E53E3E">🔴 সরিষার তেল</span><span class="r-amt" style="color:#E53E3E">৩ লিটার</span></div>
          </div>
        </div>
        <div class="phone-mock main">
          <div class="phone-mock-screen">
            <div class="pm-header">📒 ড্যাশবোর্ড</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;margin-bottom:8px">
              <div class="pm-card"><div class="pm-card-label">আজ বিক্রয়</div><div class="pm-card-val">৳ ৮,৪৫০</div></div>
              <div class="pm-card"><div class="pm-card-label">লাভ</div><div class="pm-card-val">৳ ২,১২০</div></div>
            </div>
            <div class="pm-row"><span class="r-name">সাবান ৫পিস</span><span class="r-amt">৳ ৩০০</span></div>
            <div class="pm-row"><span class="r-name">শ্যাম্পু</span><span class="r-amt">৳ ৩৫০</span></div>
            <div class="pm-row"><span class="r-name">চাল ১০কেজি</span><span class="r-amt">৳ ৮৪০</span></div>
            <div class="pm-sale-btn">+ নতুন বিক্রয়</div>
          </div>
        </div>
        <div class="phone-mock">
          <div class="phone-mock-screen">
            <div class="pm-header">👤 বকেয়া তালিকা</div>
            <div class="pm-row"><span class="r-name">রহিম সাহেব</span><span class="r-amt" style="color:#E53E3E">৳ ১,২০০</span></div>
            <div class="pm-row"><span class="r-name">করিম ভাই</span><span class="r-amt" style="color:#E53E3E">৳ ৬৮০</span></div>
            <div class="pm-row"><span class="r-name">নাসরিন আপা</span><span class="r-amt" style="color:#E53E3E">৳ ৩৪০</span></div>
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
      <div class="section-tag">🔒 নিরাপত্তা ও বিশ্বাস</div>
      <h2 class="section-title">আপনার ব্যবসার তথ্য<br>সম্পূর্ণ নিরাপদ</h2>
      <div class="divider center"></div>
      <p class="section-sub" style="margin-top:14px">আমরা আপনার ব্যবসার তথ্যকে আমাদের নিজের মতো সুরক্ষিত রাখি</p>
    </div>
    <div class="security-grid">
      <div class="sec-card">
        <div class="sec-icon">☁️</div>
        <h4>ক্লাউড ব্যাকআপ</h4>
        <p>ডেটা স্বয়ংক্রিয়ভাবে ক্লাউডে সংরক্ষিত। ফোন হারালেও ডেটা থাকবে।</p>
      </div>
      <div class="sec-card">
        <div class="sec-icon">🔐</div>
        <h4>নিরাপদ লগইন</h4>
        <p>পাসওয়ার্ড সুরক্ষিত অ্যাকাউন্ট। শুধু আপনিই আপনার ডেটা দেখতে পারবেন।</p>
      </div>
      <div class="sec-card">
        <div class="sec-icon">🛡️</div>
        <h4>ডেটা সুরক্ষা</h4>
        <p>SSL এনক্রিপশন প্রযুক্তিতে ডেটা ট্রান্সফার সম্পূর্ণ নিরাপদ।</p>
      </div>
      <div class="sec-card">
        <div class="sec-icon">🏢</div>
        <h4>ব্যবসার ডেটা আলাদা</h4>
        <p>প্রতিটি ব্যবসার তথ্য আলাদাভাবে সংরক্ষিত। কেউ অন্যের তথ্য দেখতে পাবে না।</p>
      </div>
      <div class="sec-card">
        <div class="sec-icon">👥</div>
        <h4>মাল্টি-টেন্যান্ট সিকিউরিটি</h4>
        <p>আধুনিক প্রযুক্তিতে তৈরি, প্রতিটি অ্যাকাউন্ট সম্পূর্ণ আলাদা ও নিরাপদ।</p>
      </div>
      <div class="sec-card">
        <div class="sec-icon">🔄</div>
        <h4>অটো ব্যাকআপ</h4>
        <p>প্রতিদিন স্বয়ংক্রিয়ভাবে ডেটার ব্যাকআপ নেওয়া হয়। কোনো ডেটা হারাবে না।</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ FAQ ═══════════════════════════════ -->
<section class="section-bg" id="faq">
  <div class="section-inner">
    <div class="text-center">
      <div class="section-tag">❓ প্রশ্ন ও উত্তর</div>
      <h2 class="section-title">সাধারণ প্রশ্নসমূহ</h2>
      <div class="divider center"></div>
    </div>
    <div class="faq-list">
      <div class="faq-item open">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>কি টেকনিক্যাল জ্ঞান লাগবে?</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">না, একদমই না। হিসাবের খাতা সাধারণ দোকানদারদের কথা মাথায় রেখে তৈরি। মোবাইল চালাতে পারলেই ব্যবহার করতে পারবেন। আমাদের সহজ ইন্টারফেস যে কেউ শিখে নিতে পারবে।</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>মোবাইল থেকে ব্যবহার করা যাবে?</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">হ্যাঁ, সম্পূর্ণভাবে। Android, iPhone, Tablet সব ডিভাইসে কাজ করে। আলাদা কোনো অ্যাপ ডাউনলোড করতে হবে না — ব্রাউজার থেকেই ব্যবহার করুন।</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>স্টক ট্র্যাক করা যাবে কি?</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">অবশ্যই। প্রতিটি বিক্রয় ও কেনাকাটায় স্বয়ংক্রিয়ভাবে স্টক আপডেট হয়। কোনো পণ্যের স্টক কমে গেলে আপনাকে এলার্ট দেওয়া হবে।</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>কাস্টমারের বাকির হিসাব রাখা যাবে?</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">হ্যাঁ। প্রতিটি কাস্টমারের বাকির সম্পূর্ণ ইতিহাস, পেমেন্টের তারিখ ও বকেয়া পরিমাণ — সব কিছু ট্র্যাক করা যাবে।</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>পরে কি আপগ্রেড করা যাবে?</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">হ্যাঁ, যেকোনো সময় যেকোনো প্ল্যানে আপগ্রেড বা ডাউনগ্রেড করতে পারবেন। বিনামূল্যে শুরু করুন, প্রয়োজন হলে আপগ্রেড করুন।</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>আমার ডেটা কি নিরাপদ?</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">সম্পূর্ণ নিরাপদ। আপনার ব্যবসার তথ্য এনক্রিপ্টেড এবং ক্লাউডে সংরক্ষিত। শুধু আপনিই আপনার ডেটা দেখতে পারবেন। আমরা কখনো তৃতীয় পক্ষের সাথে ডেটা শেয়ার করি না।</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>ইন্টারনেট না থাকলে কি কাজ করবে?</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">মূল ফিচারগুলো ব্যবহারের জন্য ইন্টারনেট সংযোগ প্রয়োজন। তবে বাংলাদেশে এখন প্রায় সর্বত্র মোবাইল ইন্টারনেট পাওয়া যায়, তাই এটি সমস্যা হওয়ার কথা নয়।</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span>সাহায্য দরকার হলে কোথায় যাবো?</span>
          <span class="material-icons">add</span>
        </div>
        <div class="faq-a">আমাদের সাপোর্ট টিম বাংলায় সাহায্য করতে সবসময় প্রস্তুত। WhatsApp, ফোন বা ইমেইলে যোগাযোগ করুন। আমরা সপ্তাহে ৬ দিন সকাল ৯টা থেকে রাত ৯টা পর্যন্ত সাহায্য করি।</div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ FINAL CTA ═══════════════════════════════ -->
<section class="cta-section">
  <div class="section-inner">
    <div class="section-tag" style="margin-bottom:20px;display:inline-flex">🚀 আজই শুরু করুন</div>
    <h2>আজ থেকেই আপনার ব্যবসা<br>স্মার্টভাবে পরিচালনা করুন</h2>
    <p>বিনামূল্যে শুরু করুন। কোনো ক্রেডিট কার্ড লাগবে না। কোনো ঝামেলা নেই।</p>
    <div class="cta-btns">
      <a href="{{ route('register') }}" class="btn-cta-white">
        <span>📒</span> বিনামূল্যে অ্যাকাউন্ট খুলুন
      </a>
      <a href="{{ route('login') }}" class="btn-cta-outline">
        <span>🔑</span> লগইন করুন
      </a>
    </div>
    <p class="cta-note">✅ ১৪ দিন ফ্রি ট্রায়াল &nbsp;·&nbsp; ✅ ক্রেডিট কার্ড লাগবে না &nbsp;·&nbsp; ✅ যেকোনো সময় বাতিল করুন</p>
  </div>
</section>

<!-- ═══════════════════════════════ FOOTER ═══════════════════════════════ -->
<footer>
  <div class="footer-inner">
    <div class="footer-brand">
      <a href="{{ route('home') }}" class="logo" style="text-decoration:none">
        <div class="logo-icon"><img src="{{ asset('assets/img/project/logo.png') }}" alt="হিসাবের খাতা"></div>
        <span class="logo-text">হিসাবের <span>খাতা</span></span>
      </a>
      <p>ছোট ব্যবসার জন্য ডিজিটাল হিসাব খাতা। বাংলাদেশের দোকানদারদের জন্য তৈরি।</p>
    </div>
    <div class="footer-col">
      <h5>ফিচার</h5>
      <a href="#features">বিক্রয় ব্যবস্থাপনা</a>
      <a href="#features">স্টক ব্যবস্থাপনা</a>
      <a href="#features">কাস্টমার ব্যবস্থাপনা</a>
      <a href="#features">রিপোর্ট</a>
      <a href="#features">ইনভয়েস</a>
    </div>
    <div class="footer-col">
      <h5>প্ল্যান</h5>
      <a href="#plans">ফ্রি</a>
      <a href="#plans">স্টার্টার</a>
      <a href="#plans">ড্রিমার</a>
      <a href="#plans">এন্টারপ্রাইজ</a>
    </div>
    <div class="footer-col">
      <h5>সাহায্য</h5>
      <a href="#faq">FAQ</a>
      <a href="#">সাপোর্ট সেন্টার</a>
      <a href="#">যোগাযোগ করুন</a>
      <a href="#">গোপনীয়তা নীতি</a>
      <a href="#">ব্যবহারের শর্তাবলী</a>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© ২০২৪ হিসাবের খাতা। সর্বস্বত্ব সংরক্ষিত।</span>
    <span><a href="#">গোপনীয়তা</a> · <a href="#">শর্তাবলী</a></span>
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

document.querySelectorAll('.feature-card, .benefit-card, .sec-card, .plan-card, .step-card, .problem-card').forEach(el => {
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