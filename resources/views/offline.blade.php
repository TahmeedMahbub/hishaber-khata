<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>No Internet Connection</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
  --green:       #1A8763;
  --green-dark:  #136642;
  --green-light: #E8F5EE;
  --text:        #1A202C;
  --text-2:      #4A5568;
  --text-3:      #718096;
  --border:      #E2E8F0;
  --white:       #FFFFFF;
}
* { margin:0; padding:0; box-sizing:border-box; }
html, body {
  height: 100%;
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(150deg, #EFFAF5 0%, #F0FDF8 55%, #E8F5EE 100%);
  color: var(--text);
  overflow: hidden; /* prevent any scroll */
}

/* ── Full-screen centered layout ── */
body {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 24px 20px;
  gap: 0;
  position: relative;
}

/* Decorative blobs */
body::before {
  content:'';
  position:fixed; top:-80px; right:-80px;
  width:360px; height:360px;
  background: radial-gradient(circle, rgba(26,135,99,0.09) 0%, transparent 70%);
  border-radius:50%; pointer-events:none;
}
body::after {
  content:'';
  position:fixed; bottom:-60px; left:-60px;
  width:280px; height:280px;
  background: radial-gradient(circle, rgba(26,135,99,0.07) 0%, transparent 70%);
  border-radius:50%; pointer-events:none;
}

/* ── Brand logo ── */
.brand-logo {
  margin-bottom: 28px;
  animation: fadeDown .5s ease both;
}
.brand-logo img {
  height: 70px;
  display: block;
}

/* ── No-internet icon + glow ── */
.icon-wrap {
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
  animation: fadeUp .55s ease .1s both;
}
.glow {
  position: absolute;
  width: 100px; height: 100px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(26,135,99,0.14) 0%, transparent 70%);
  animation: pulseRing 2.2s ease-in-out infinite;
}
.glow-2 {
  width: 140px; height: 140px;
  background: radial-gradient(circle, rgba(26,135,99,0.07) 0%, transparent 70%);
  animation: pulseRing 2.2s ease-in-out infinite .35s;
}
.icon-wrap img {
  width: 64px; height: 64px;
  position: relative; z-index: 1;
  animation: floatAnim 3s ease-in-out infinite;
  filter: drop-shadow(0 4px 12px rgba(26,135,99,0.18));
}

/* ── Text ── */
.offline-label {
  display: inline-flex; align-items: center; gap: 7px;
  background: #fff3f3;
  border: 1px solid #fcc;
  color: #c53030;
  padding: 4px 13px; border-radius: 50px;
  font-size: 0.75rem; font-weight: 600;
  margin-bottom: 12px;
  animation: fadeUp .55s ease .15s both;
}
.blink {
  width: 7px; height: 7px;
  background: #e53e3e; border-radius: 50%;
  animation: blink 1.2s ease-in-out infinite;
}

h1 {
  font-size: clamp(1.25rem, 5vw, 1.65rem);
  font-weight: 800;
  color: var(--text);
  line-height: 1.25;
  margin-bottom: 8px;
  animation: fadeUp .55s ease .2s both;
}
h1 span { color: var(--green); }

p {
  font-size: 0.88rem;
  color: var(--text-2);
  line-height: 1.6;
  max-width: 300px;
  text-align: center;
  margin-bottom: 24px;
  animation: fadeUp .55s ease .25s both;
}

/* ── Retry button ── */
.btn-retry {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--green); color: #fff;
  padding: 12px 28px; border-radius: 12px;
  font-size: 0.95rem; font-weight: 700;
  border: none; cursor: pointer;
  box-shadow: 0 4px 16px rgba(26,135,99,0.28);
  transition: background .22s, transform .22s, box-shadow .22s;
  font-family: inherit;
  animation: fadeUp .55s ease .3s both;
}
.btn-retry:hover {
  background: var(--green-dark);
  transform: translateY(-2px);
  box-shadow: 0 8px 22px rgba(26,135,99,0.32);
}
.btn-retry svg { width:16px; height:16px; flex-shrink:0; }
.btn-retry.spinning svg { animation: spin .7s linear infinite; }

/* ── Animations ── */
@keyframes fadeDown {
  from { opacity:0; transform:translateY(-16px); }
  to   { opacity:1; transform:translateY(0); }
}
@keyframes fadeUp {
  from { opacity:0; transform:translateY(16px); }
  to   { opacity:1; transform:translateY(0); }
}
@keyframes floatAnim {
  0%,100% { transform:translateY(0); }
  50%     { transform:translateY(-8px); }
}
@keyframes pulseRing {
  0%,100% { opacity:.9; transform:scale(1); }
  50%     { opacity:.3; transform:scale(1.1); }
}
@keyframes blink {
  0%,100% { opacity:1; }
  50%     { opacity:.25; }
}
@keyframes spin { to { transform:rotate(360deg); } }
</style>
</head>
<body>

  <!-- Brand Logo (centered, large) -->
  <div class="brand-logo">
    <img src="/assets/img/project/brand-logo.svg" alt="Brand">
  </div>

  <!-- No-internet icon (small) -->
  <div class="icon-wrap">
    <div class="glow glow-2"></div>
    <div class="glow"></div>
    <img src="/assets/img/project/no-internet.svg" alt="No Internet">
  </div>

  <!-- Offline badge -->
  <div class="offline-label">
    <span class="blink"></span>
    Offline
  </div>

  <!-- Heading -->
  <h1>No <span>Internet</span> Connection</h1>

  <!-- Description -->
  <p>Check your Wi-Fi or mobile data and try again. Your data is safe!</p>

  <!-- Retry -->
  <button class="btn-retry" id="retryBtn" onclick="retryConnection()">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="23 4 23 10 17 10"/>
      <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
    </svg>
    Try Again
  </button>

<script>
function retryConnection() {
  var btn = document.getElementById('retryBtn');
  btn.classList.add('spinning');
  btn.disabled = true;
  setTimeout(function () {
    if (navigator.onLine) {
      window.location.href = document.referrer || '/';
    } else {
      btn.classList.remove('spinning');
      btn.disabled = false;
    }
  }, 1200);
}
window.addEventListener('online', function () {
  window.location.href = document.referrer || '/';
});
</script>
</body>
</html>
