/**
 * Pull-to-Refresh – Facebook / Android Material-style
 * ----------------------------------------------------
 * A circular pill drops from behind the navbar as the user swipes down.
 * The page content translates down to reveal it. Uses the project's
 * loader.gif for the refreshing animation.
 *
 * Touch-only (passive listeners). Included once from end-section.blade.php.
 */
(function () {
    'use strict';

    var THRESHOLD = 70;
    var MAX_PULL  = 120;
    var DAMPING   = 0.4;
    var SIZE      = 40;

    var LOADER_GIF = '/assets/img/project/loader.gif';

    var startY     = 0;
    var pulling    = false;
    var animating  = false;
    var el         = null;
    var content    = null;
    var img        = null;

    /* ── inject CSS ──────────────────────────────────────────────── */
    var css = document.createElement('style');
    css.textContent = [
        '#ptr{position:fixed;left:50%;z-index:1079;',
            'width:' + SIZE + 'px;height:' + SIZE + 'px;',
            'margin-left:-' + (SIZE / 2) + 'px;',
            'border-radius:50%;',
            'background:#fff;',
            'box-shadow:0 1px 6px rgba(0,0,0,.2);',
            'display:flex;align-items:center;justify-content:center;',
            'opacity:0;pointer-events:none;',
            'transform:scale(.4);',
            'overflow:hidden;',
            'will-change:transform,opacity,top;}',

        '#ptr.tracking{transition:none !important;}',

        '#ptr.ease{transition:transform .25s cubic-bezier(.4,0,.2,1),',
            'opacity .25s ease,top .25s cubic-bezier(.4,0,.2,1);}',

        '#ptr.refreshing{opacity:1 !important;transform:scale(1) !important;}',

        '#ptr img{width:' + (SIZE - 4) + 'px;height:' + (SIZE - 4) + 'px;',
            'object-fit:contain;display:block;}',

        '.layout-page{transition:transform .25s cubic-bezier(.4,0,.2,1);will-change:transform;}',
        '.layout-page.ptr-no-transition{transition:none !important;}',
    ].join('\n');
    document.head.appendChild(css);

    /* ── build DOM ───────────────────────────────────────────────── */
    function build() {
        if (el) return;
        el = document.createElement('div');
        el.id = 'ptr';

        img = document.createElement('img');
        img.src = LOADER_GIF;
        img.alt = '';
        el.appendChild(img);

        document.body.appendChild(el);
        content = document.querySelector('.layout-page');
    }

    /* ── helpers ─────────────────────────────────────────────────── */
    function scrollTop() {
        return window.pageYOffset || document.documentElement.scrollTop || 0;
    }

    function applyPull(pull) {
        var t = pull / MAX_PULL;
        var top = 10 + t * 58;
        var scale = 0.4 + t * 0.6;
        var opacity = Math.min(t * 1.6, 1);

        el.style.top = top + 'px';
        el.style.transform = 'scale(' + scale.toFixed(3) + ')';
        el.style.opacity = opacity.toFixed(3);

        if (content) {
            content.style.transform = 'translateY(' + (pull * 0.5) + 'px)';
        }
    }

    function reset(animate) {
        if (animate) {
            el.classList.remove('tracking');
            el.classList.add('ease');
            if (content) content.classList.remove('ptr-no-transition');
        }
        el.style.top = '10px';
        el.style.transform = 'scale(.4)';
        el.style.opacity = '0';
        if (content) content.style.transform = '';

        if (animate) {
            setTimeout(function () {
                el.classList.remove('ease', 'refreshing');
                animating = false;
            }, 280);
        }
    }

    /* ── touch ───────────────────────────────────────────────────── */
    document.addEventListener('touchstart', function (e) {
        if (animating) return;
        if (scrollTop() > 2) return;
        startY = e.touches[0].clientY;
        pulling = true;
        build();
        el.classList.remove('ease', 'refreshing');
        el.classList.add('tracking');
        if (content) content.classList.add('ptr-no-transition');
    }, { passive: true });

    document.addEventListener('touchmove', function (e) {
        if (!pulling) return;

        var dy = (e.touches[0].clientY - startY) * DAMPING;
        if (dy <= 0 || scrollTop() > 2) {
            applyPull(0);
            return;
        }

        applyPull(Math.min(dy, MAX_PULL));
    }, { passive: true });

    document.addEventListener('touchend', function () {
        if (!pulling) return;
        pulling = false;
        if (!el) return;

        el.classList.remove('tracking');
        el.classList.add('ease');
        if (content) content.classList.remove('ptr-no-transition');

        var currentOpacity = parseFloat(el.style.opacity) || 0;
        var pull = ((parseFloat(el.style.top) || 10) - 10) / 58 * MAX_PULL;

        if (pull >= THRESHOLD) {
            animating = true;
            el.classList.add('refreshing');
            el.style.top = '68px';
            el.style.transform = 'scale(1)';
            el.style.opacity = '1';
            // Force reload the gif so animation restarts
            img.src = LOADER_GIF + '?t=' + Date.now();
            if (content) content.style.transform = 'translateY(42px)';

            setTimeout(function () { window.location.reload(); }, 500);
        } else {
            animating = true;
            reset(true);
        }
    }, { passive: true });
})();
