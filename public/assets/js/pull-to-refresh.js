/**
 * Pull-to-Refresh (Facebook-style swipe-down reload)
 * ---------------------------------------------------
 * Attach to the main content area. When the user pulls down from the top
 * beyond a threshold, the page reloads.
 *
 * Works on touch devices only (mobile / tablet). Ignored on desktop.
 * Included once from end-section.blade.php so every page gets it.
 */
(function () {
    'use strict';

    var THRESHOLD   = 90;   // px the user must pull past to trigger refresh
    var MAX_PULL    = 140;  // px – visual cap so the indicator doesn't fly off
    var DAMPING     = 0.45; // resistance factor (< 1 makes it feel elastic)

    var startY      = 0;
    var pulling     = false;
    var indicator   = null;

    // The scrollable container – the one that actually scrolls to 0
    function getScrollTop() {
        // content-wrapper is the scrollable pane in this admin template
        var cw = document.querySelector('.content-wrapper');
        if (cw && cw.scrollTop !== undefined) { return cw.scrollTop; }
        return window.pageYOffset || document.documentElement.scrollTop || 0;
    }

    // ── Build the pull indicator element (hidden by default) ──────────
    function ensureIndicator() {
        if (indicator) { return; }
        indicator = document.createElement('div');
        indicator.id = 'ptr-indicator';
        indicator.innerHTML =
            '<div class="ptr-spinner">' +
                '<svg viewBox="0 0 24 24" width="28" height="28">' +
                    '<path fill="currentColor" d="M17.65 6.35A7.96 7.96 0 0 0 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08A5.99 5.99 0 0 1 12 18a6 6 0 1 1 0-12c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>' +
                '</svg>' +
            '</div>' +
            '<span class="ptr-text"></span>';

        // Styles are inlined so no extra CSS file is needed
        indicator.style.cssText =
            'position:fixed;top:0;left:0;right:0;z-index:9999;' +
            'display:flex;align-items:center;justify-content:center;gap:8px;' +
            'height:0;overflow:hidden;' +
            'background:var(--bs-body-bg, #fff);color:var(--bs-primary, #696cff);' +
            'font-size:13px;font-weight:500;' +
            'box-shadow:0 2px 8px rgba(0,0,0,.08);' +
            'transition:height .2s ease, opacity .2s ease;opacity:0;';

        var style = document.createElement('style');
        style.textContent =
            '@keyframes ptr-spin{to{transform:rotate(360deg)}}' +
            '#ptr-indicator.ptr-active{opacity:1}' +
            '#ptr-indicator.ptr-refreshing .ptr-spinner{animation:ptr-spin .7s linear infinite}';
        document.head.appendChild(style);

        document.body.appendChild(indicator);
    }

    // ── Touch handlers ───────────────────────────────────────────────
    document.addEventListener('touchstart', function (e) {
        if (getScrollTop() > 5) { return; } // not at top – ignore
        startY  = e.touches[0].clientY;
        pulling = true;
        ensureIndicator();
    }, { passive: true });

    document.addEventListener('touchmove', function (e) {
        if (!pulling) { return; }

        var dy = (e.touches[0].clientY - startY) * DAMPING;
        if (dy <= 0) {
            // scrolling up – reset
            indicator.style.height = '0';
            indicator.classList.remove('ptr-active');
            return;
        }

        // If the page is no longer at top (e.g. elastic overscroll), bail
        if (getScrollTop() > 5) { pulling = false; return; }

        var pull = Math.min(dy, MAX_PULL);
        indicator.style.height = pull + 'px';
        indicator.classList.add('ptr-active');

        var text = indicator.querySelector('.ptr-text');
        if (text) {
            text.textContent = pull >= THRESHOLD ? '↑ ছেড়ে দিন' : '↓ রিফ্রেশ করতে টানুন';
        }
    }, { passive: true });

    document.addEventListener('touchend', function () {
        if (!pulling) { return; }
        pulling = false;

        if (!indicator) { return; }

        var height = parseInt(indicator.style.height, 10) || 0;

        if (height >= THRESHOLD) {
            // Show refreshing state, then reload
            indicator.classList.add('ptr-refreshing');
            var text = indicator.querySelector('.ptr-text');
            if (text) { text.textContent = 'রিফ্রেশ হচ্ছে…'; }
            indicator.style.height = '48px';

            setTimeout(function () {
                window.location.reload();
            }, 350);
        } else {
            // Didn't pull far enough – snap back
            indicator.style.height = '0';
            indicator.classList.remove('ptr-active');
        }
    }, { passive: true });
})();
