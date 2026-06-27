/**
 * Global Barcode Scanner
 * ---------------------
 * Initialises the camera barcode scanner on the shared #barcodeScanModal / #scanReader
 * elements that every page is expected to include in its HTML.
 *
 * Usage:
 *   initBarcodeScanner(modalElement, onScanCallback, cameraFailedMessage);
 *
 * Parameters:
 *   modalEl  – the HTMLElement for the Bootstrap modal (#barcodeScanModal)
 *   onScan   – function(decodedText) called once per successful scan; the modal is
 *              hidden automatically before the callback fires.
 *   errorMsg – string shown inside #scanReader when the camera cannot be opened.
 *
 * Always uses Html5Qrcode with facingMode: 'environment'.
 * Zoom (2.5×) and continuous autofocus are applied after the camera stream is
 * running so they never interfere with getUserMedia permission.
 *
 * The scanner starts on 'shown.bs.modal' and stops on 'hidden.bs.modal'.
 */

function initBarcodeScanner(modalEl, onScan, errorMsg) {
    if (!modalEl) { return; }

    var html5Qr = null;

    // ─── Intercept ALL scan-trigger buttons ───────────────────────────
    // Open the Bootstrap modal for Html5Qrcode scanning.
    var scanTriggers = document.querySelectorAll('[data-bs-target="#barcodeScanModal"]');

    scanTriggers.forEach(function (btn) {
        // Remove Bootstrap auto-toggle so we control the flow
        btn.removeAttribute('data-bs-toggle');
        btn.removeAttribute('data-bs-target');

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            // Fire show.bs.modal so page-level scanTarget logic still works
            var showEvent = new Event('show.bs.modal', { bubbles: true });
            showEvent.relatedTarget = btn;
            modalEl.dispatchEvent(showEvent);

            // Open the Bootstrap modal for browser-based scan
            var bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
            bsModal.show();
        });
    });

    // ─── Scanner helpers ─────────────────────────────────────────────
    function stopScanner() {
        if (html5Qr) {
            html5Qr.stop()
                .then(function () { html5Qr.clear(); html5Qr = null; })
                .catch(function () { html5Qr = null; });
        }
    }

    function applyCameraEnhancements() {
        try {
            console.log('[BarcodeScanner] navigator.userAgent:', navigator.userAgent);

            var video = modalEl.querySelector('#scanReader video');
            if (video && video.srcObject) {
                var track = video.srcObject.getVideoTracks()[0];
                if (track) {
                    var caps = track.getCapabilities ? track.getCapabilities() : {};
                    var settings = track.getSettings ? track.getSettings() : {};

                    console.log('[BarcodeScanner] track.getCapabilities():', JSON.stringify(caps, null, 2));
                    console.log('[BarcodeScanner] track.getSettings():', JSON.stringify(settings, null, 2));

                    var advancedConstraints = [];

                    // Apply 2.5× zoom if supported
                    var hasZoom = !!(caps.zoom);
                    console.log('[BarcodeScanner] Zoom capability exists:', hasZoom);
                    if (hasZoom) {
                        console.log('[BarcodeScanner] zoom.min:', caps.zoom.min);
                        console.log('[BarcodeScanner] zoom.max:', caps.zoom.max);
                        var zoomVal = Math.min(2.5, caps.zoom.max);
                        console.log('[BarcodeScanner] Applied zoom value:', zoomVal);
                        advancedConstraints.push({ zoom: zoomVal });
                    }

                    // Enable continuous autofocus if supported
                    var hasAutofocus = !!(caps.focusMode && caps.focusMode.indexOf('continuous') !== -1);
                    console.log('[BarcodeScanner] Continuous autofocus capability:', hasAutofocus);
                    if (hasAutofocus) {
                        advancedConstraints.push({ focusMode: 'continuous' });
                    }

                    if (advancedConstraints.length > 0) {
                        track.applyConstraints({ advanced: advancedConstraints }).catch(function (err) {
                            console.warn('[BarcodeScanner] applyConstraints failed:', err);
                        });
                    }
                }
            }
        } catch (e) {
            console.error('[BarcodeScanner] applyCameraEnhancements error:', e);
        }
    }

    // ─── Modal lifecycle ─────────────────────────────────────────────
    modalEl.addEventListener('shown.bs.modal', function () {
        if (typeof Html5Qrcode === 'undefined') { return; }
        html5Qr = new Html5Qrcode('scanReader');
        html5Qr.start(
            { facingMode: 'environment' },
            { fps: 10, qrbox: { width: 250, height: 150 } },
            function (decodedText) {
                var modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) { modal.hide(); }
                onScan(String(decodedText).trim());
            },
            function () {}
        ).then(function () {
            setTimeout(applyCameraEnhancements, 1500);
        }).catch(function () {
            var reader = document.getElementById('scanReader');
            if (reader) {
                reader.innerHTML = '<p class="text-danger text-center mb-0">' + (errorMsg || 'Camera failed.') + '</p>';
            }
        });
    });

    modalEl.addEventListener('hidden.bs.modal', stopScanner);
}
