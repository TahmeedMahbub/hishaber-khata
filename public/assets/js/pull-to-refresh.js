/**
 * Pull-to-Refresh – Facebook-style circular spinner
 * ---------------------------------------------------
 * A polished pull-to-refresh that shows a circular spinner dropping down
 * from the top centre of the screen, just like Facebook / Instagram.
 *
 * Touch-only. Included once from end-section.blade.php.
 */
(function () {
    'use strict';

    // ── Tuning ───────────────────────────────────────────────────────
    var THRESHOLD   = 80;   // px pull to trigger refresh
    var MAX_PULL    = 130;  // visual cap
    var DAMPING     = 0.4;  // rubber-band resistance
    var SPINNER_SIZE = 40;  // px diameter of the spinner circle

    var startY      = 0;
    var currentY    = 0;
    var pulling     = false;
    var refreshing  = false;
    var indicator   = null;
    var spinner     = null;
    var arrow       = null;
    var circle      = null;

    // ── Inject styles once ───────────────────────────────────────────
    var style = document.createElement('style');
    style.textContent = [
        /* Container: fixed pill that drops from top-centre */
        '#ptr-pill{',
            'position:fixed;top:-60px;left:50%;transform:translateX(-50%);',
            'z-index:10000;',
            'width:' + SPINNER_SIZE + 'px;height:' + SPINNER_SIZE + 'px;',
            'border-radius:50%;',
            'background:var(--bs-body-bg,#fff);',
            'box-shadow:0 2px 12px rgba(0,0,0,.18);',
            'display:flex;align-items:center;justify-content:center;',
            'transition:top .25s cubic-bezier(.4,0,.2,1), box-shadow .25s ease;',
            'will-change:top;',
            'pointer-events:none;',
        '}',

        /* When pulling, disable the CSS transition so it tracks the finger */
        '#ptr-pill.ptr-tracking{transition:none;}',

        /* SVG spinner circle (progress arc) */
        '#ptr-pill .ptr-circle{',
            'position:absolute;',
            'width:' + SPINNER_SIZE + 'px;height:' + SPINNER_SIZE + 'px;',
            'transform:rotate(-90deg);', /* start at 12 o'clock */
        '}',
        '#ptr-pill .ptr-circle circle{',
            'fill:none;stroke-width:2.5;',
        '}',
        '#ptr-pill .ptr-circle .ptr-bg{',
            'stroke:var(--bs-border-color,#e0e0e0);',
        '}',
        '#ptr-pill .ptr-circle .ptr-fg{',
            'stroke:var(--bs-primary,#696cff);',
            'stroke-linecap:round;',
            'transition:stroke-dashoffset .1s ease;',
        '}',

        /* Arrow icon in the centre */
        '#ptr-pill .ptr-arrow{',
            'position:absolute;',
            'width:18px;height:18px;',
            'color:var(--bs-primary,#696cff);',
            'transition:transform .2s ease, opacity .2s ease;',
        '}',

        /* Refreshing state: continuous spin */
        '#ptr-pill.ptr-refreshing .ptr-circle{',
            'animation:ptr-spin .8s linear infinite;',
        '}',
        '#ptr-pill.ptr-refreshing .ptr-arrow{',
            'opacity:0;transform:scale(.3);',
        '}',

        /* Snap-back state */
        '#ptr-pill.ptr-hiding{',
            'transition:top .3s cubic-bezier(.4,0,.2,1) !important;',
        '}',

        '@keyframes ptr-spin{to{transform:rotate(270deg)}}',
    ].join('\n');
    document.head.appendChild(style);

    // ── Build the indicator DOM ──────────────────────────────────────
    function ensureIndicator() {
        if (indicator) { return; }

        indicator = document.createElement('div');
        indicator.id = 'ptr-pill';

        // SVG circular progress
        var r = (SPINNER_SIZE / 2) - 3; // radius with room for stroke
        var C = 2 * Math.PI * r;        // circumference

        indicator.innerHTML =
            '<svg class="ptr-circle" viewBox="0 0 ' + SPINNER_SIZE + ' ' + SPINNER_SIZE + '">' +
                '<circle class="ptr-bg" cx="' + SPINNER_SIZE/2 + '" cy="' + SPINNER_SIZE/2 + '" r="' + r + '"/>' +
                '<circle class="ptr-fg" cx="' + SPINNER_SIZE/2 + '" cy="' + SPINNER_SIZE/2 + '" r="' + r + '"' +
                    ' stroke-dasharray="' + C + '" stroke-dashoffset="' + C + '"/>' +
            '</svg>' +
            '<svg class="ptr-arrow" viewBox="0 0 24 24">' +
                '<path fill="currentColor" d="M20 12a8 8 0 0 1-8 8 8 8 0 0 1-8-8 8 8 0 0 1 8-8V1l5 4-5 4V6a6 6 0 0 0-6 6 6 6 0 0 0 6 6 6 6 0 0 0 6-6h2z"/>' +
            '</svg>';

        document.body.appendChild(indicator);

        circle = indicator.querySelector('.ptr-fg');
        arrow  = indicator.querySelector('.ptr-arrow');
        spinner = indicator;

        // Store circumference on the element for later use
        circle._C = C;
    }

    // ── Helpers ──────────────────────────────────────────────────────
    function getScrollTop() {
        var cw = document.querySelector('.content-wrapper');
        if (cw && cw.scrollTop !== undefined) { return cw.scrollTop; }
        return window.pageYOffset || document.documentElement.scrollTop || 0;
    }

    function setProgress(ratio) {
        // ratio 0‥1 → stroke-dashoffset C‥0
        var offset = circle._C * (1 - ratio);
        circle.setAttribute('stroke-dashoffset', offset);
    }

    function positionPill(pull) {
        // pull 0..MAX_PULL → top: -60px .. 16px
        var top = -60 + (pull / MAX_PULL) * 76;
        indicator.style.top = Math.min(top, 16) + 'px';
    }

    // ── Touch lifecycle ─────────────────────────────────────────────
    document.addEventListener('touchstart', function (e) {
        if (refreshing) { return; }
        if (getScrollTop() > 5) { return; }
        startY  = e.touches[0].clientY;
        pulling = true;
        ensureIndicator();
        indicator.classList.remove('ptr-refreshing', 'ptr-hiding');
        indicator.classList.add('ptr-tracking');
    }, { passive: true });

    document.addEventListener('touchmove', function (e) {
        if (!pulling || refreshing) { return; }

        currentY = e.touches[0].clientY;
        var dy = (currentY - startY) * DAMPING;

        if (dy <= 0 || getScrollTop() > 5) {
            positionPill(0);
            setProgress(0);
            if (arrow) { arrow.style.transform = 'rotate(0deg)'; }
            return;
        }

        var pull  = Math.min(dy, MAX_PULL);
        var ratio = Math.min(pull / THRESHOLD, 1);

        positionPill(pull);
        setProgress(ratio);

        // Rotate arrow proportionally: 0° → 540° (1.5 full turns)
        if (arrow) {
            arrow.style.transform = 'rotate(' + (ratio * 540) + 'deg)';
        }
    }, { passive: true });

    document.addEventListener('touchend', function () {
        if (!pulling || refreshing) { return; }
        pulling = false;

        if (!indicator) { return; }
        indicator.classList.remove('ptr-tracking');

        var dy   = (currentY - startY) * DAMPING;
        var pull = Math.min(dy, MAX_PULL);

        if (pull >= THRESHOLD) {
            // ── Trigger refresh ──────────────────────────────────
            refreshing = true;
            indicator.style.top = '16px';
            setProgress(0.75); // partial arc for spinning look
            indicator.classList.add('ptr-refreshing');

            setTimeout(function () {
                window.location.reload();
            }, 400);
        } else {
            // ── Snap back ────────────────────────────────────────
            indicator.classList.add('ptr-hiding');
            indicator.style.top = '-60px';
            setProgress(0);
            if (arrow) { arrow.style.transform = 'rotate(0deg)'; }
        }
    }, { passive: true });
})();
