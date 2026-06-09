/**
 * Mobile Bottom Navigation — "More" bottom sheet controller
 * Hishaber Khata
 */

'use strict';

(function () {
  const moreBtn = document.querySelector('[data-hk-sheet-open]');
  const sheet = document.getElementById('hk-more-sheet');
  const backdrop = document.getElementById('hk-sheet-backdrop');

  if (!sheet || !backdrop) return;

  const closeEls = document.querySelectorAll('[data-hk-sheet-close]');

  function openSheet() {
    backdrop.classList.add('is-open');
    sheet.classList.add('is-open');
    document.body.classList.add('hk-sheet-lock');
    if (moreBtn) {
      moreBtn.classList.add('active');
      moreBtn.setAttribute('aria-expanded', 'true');
    }
  }

  function closeSheet() {
    backdrop.classList.remove('is-open');
    sheet.classList.remove('is-open');
    document.body.classList.remove('hk-sheet-lock');
    if (moreBtn) {
      moreBtn.setAttribute('aria-expanded', 'false');
      // Keep "More" highlighted only if the current page belongs to that group
      if (moreBtn.dataset.active !== 'true') {
        moreBtn.classList.remove('active');
      }
    }
  }

  if (moreBtn) {
    moreBtn.addEventListener('click', function (e) {
      e.preventDefault();
      sheet.classList.contains('is-open') ? closeSheet() : openSheet();
    });
  }

  backdrop.addEventListener('click', closeSheet);
  closeEls.forEach(function (el) {
    el.addEventListener('click', closeSheet);
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && sheet.classList.contains('is-open')) {
      closeSheet();
    }
  });
})();
