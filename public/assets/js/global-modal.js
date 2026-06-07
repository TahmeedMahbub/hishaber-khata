/**
 * GlobalModal — a reusable Bootstrap 5 modal.
 *
 * Usage:
 *   GlobalModal.show({
 *     image: '/assets/img/illustrations/warning.png', // optional image URL
 *     icon: 'bx bx-trash text-danger',                // optional icon classes (alt to image)
 *     title: 'আপনি কি নিশ্চিত?',
 *     text: 'এই কাজটি আর ফিরিয়ে আনা যাবে না।',
 *     processText: 'মুছে ফেলুন',                       // optional, default 'নিশ্চিত করুন'
 *     cancelText: 'বাতিল',                             // optional, default 'বাতিল'
 *     processClass: 'btn-danger',                      // optional process button style
 *     showCancel: true,                                // optional, default true
 *     onProcess: function (modal) { ... },             // called when process clicked
 *     onCancel: function () { ... }                    // optional
 *   });
 */
window.GlobalModal = (function () {
    let bsModal = null;
    let currentOnProcess = null;
    let currentOnCancel = null;

    function el(id) {
        return document.getElementById(id);
    }

    function getInstance() {
        const node = el('globalModal');
        if (!node) {
            console.error('GlobalModal: #globalModal element not found. Include the global-modal partial.');
            return null;
        }
        if (!bsModal) {
            bsModal = bootstrap.Modal.getOrCreateInstance(node);

            // Run cancel handler when dismissed without processing.
            node.addEventListener('hidden.bs.modal', function () {
                setLoading(false);
            });
        }
        return bsModal;
    }

    function setLoading(state) {
        const spinner = el('globalModalSpinner');
        const processBtn = el('globalModalProcess');
        if (!spinner || !processBtn) return;
        spinner.classList.toggle('d-none', !state);
        processBtn.disabled = state;
    }

    function show(options) {
        const opts = options || {};
        const modal = getInstance();
        if (!modal) return;

        // Image
        const image = el('globalModalImage');
        if (opts.image) {
            image.src = opts.image;
            image.alt = opts.title || '';
            image.classList.remove('d-none');
        } else {
            image.classList.add('d-none');
            image.src = '';
        }

        // Icon
        const icon = el('globalModalIcon');
        if (opts.icon) {
            icon.innerHTML = '<i class="' + opts.icon + '" style="font-size: 4rem;"></i>';
            icon.classList.remove('d-none');
        } else {
            icon.classList.add('d-none');
            icon.innerHTML = '';
        }

        // Title & text
        el('globalModalTitle').textContent = opts.title || '';
        el('globalModalText').innerHTML = opts.text || '';

        // Process button
        const processBtn = el('globalModalProcess');
        el('globalModalProcessText').textContent = opts.processText || 'নিশ্চিত করুন';
        processBtn.className = 'btn ' + (opts.processClass || 'btn-primary');

        // Cancel button
        const cancelBtn = el('globalModalCancel');
        cancelBtn.textContent = opts.cancelText || 'বাতিল';
        cancelBtn.classList.toggle('d-none', opts.showCancel === false);

        // Handlers
        currentOnProcess = typeof opts.onProcess === 'function' ? opts.onProcess : null;
        currentOnCancel = typeof opts.onCancel === 'function' ? opts.onCancel : null;

        setLoading(false);
        modal.show();
    }

    function hide() {
        if (bsModal) bsModal.hide();
    }

    // Wire up buttons once on load.
    document.addEventListener('DOMContentLoaded', function () {
        const processBtn = el('globalModalProcess');
        const cancelBtn = el('globalModalCancel');

        if (processBtn) {
            processBtn.addEventListener('click', function () {
                if (currentOnProcess) {
                    currentOnProcess({ hide: hide, setLoading: setLoading });
                } else {
                    hide();
                }
            });
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', function () {
                if (currentOnCancel) currentOnCancel();
            });
        }
    });

    return { show: show, hide: hide, setLoading: setLoading };
})();
