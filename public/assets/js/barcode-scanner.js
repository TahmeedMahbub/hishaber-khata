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
 * --- Median (GoNative) Native Support ---
 * When running inside a Median app, the scanner uses the native barcode scanner
 * via `median.barcode.scan()` instead of getUserMedia. The modal is NOT opened;
 * instead the native camera overlay is launched directly. Detection happens at
 * click-time so the async-injected Median bridge is available.
 *
 * The scanner starts on 'shown.bs.modal' and stops on 'hidden.bs.modal'.
 * Zoom (2.5×) is applied after the camera stream is running so it never
 * interferes with getUserMedia permission.
 * Thank you
 */

/**
 * Check whether the Median native barcode bridge is available RIGHT NOW.
 * Called at click-time, not at page-load, because Median injects the
 * bridge asynchronously after DOM-ready.
 */
function _hasMedianBarcode() {
    try {
        if (typeof median !== 'undefined' && median && median.barcode && typeof median.barcode.scan === 'function') {
            return true;
        }
        if (typeof gonative !== 'undefined' && gonative && gonative.barcode && typeof gonative.barcode.scan === 'function') {
            return true;
        }
    } catch (e) {}
    return false;
}

/**
 * Get the Median barcode bridge object (median or gonative namespace).
 */
function _getMedianBridge() {
    if (typeof median !== 'undefined' && median && median.barcode) { return median.barcode; }
    if (typeof gonative !== 'undefined' && gonative && gonative.barcode) { return gonative.barcode; }
    return null;
}

/**
 * Launch the Median native barcode scanner and return scanned text via callback.
 */
function _medianScan(onSuccess, onFail) {
    var bridge = _getMedianBridge();
    if (!bridge) { if (onFail) onFail(); return; }

    try {
        bridge.scan({ callback: function (data) {
            if (data && data.success) {
                onSuccess(String(data.code).trim());
            } else {
                if (onFail) onFail();
            }
        }});
    } catch (e) {
        if (onFail) onFail();
    }
}

function initBarcodeScanner(modalEl, onScan, errorMsg) {
    if (!modalEl) { return; }

    var html5Qr = null;

    // ─── Intercept ALL scan-trigger buttons ───────────────────────────
    // At click-time, decide: use Median native or open the Bootstrap modal.
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

            // ── Check at click-time if Median bridge is ready ──
            if (_hasMedianBarcode()) {
                _medianScan(
                    function (code) { onScan(code); },
                    function ()     { /* cancelled / failed – do nothing */ }
                );
                return;
            }

            // ── Fallback: open the Bootstrap modal for browser-based scan ──
            var bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
            bsModal.show();
        });
    });

    // ─── Browser / Web Path (existing behaviour) ─────────────────────
    function stopScanner() {
        if (html5Qr) {
            html5Qr.stop()
                .then(function () { html5Qr.clear(); html5Qr = null; })
                .catch(function () { html5Qr = null; });
        }
    }

    function applyZoom() {
        try {
            var video = modalEl.querySelector('#scanReader video');
            if (video && video.srcObject) {
                var track = video.srcObject.getVideoTracks()[0];
                if (track) {
                    var caps = track.getCapabilities ? track.getCapabilities() : {};
                    if (caps.zoom) {
                        var zoomVal = Math.min(2.5, caps.zoom.max);
                        track.applyConstraints({ advanced: [{ zoom: zoomVal }] }).catch(function () {});
                    }
                }
            }
        } catch (e) {}
    }

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
        ).then(applyZoom).catch(function () {
            var reader = document.getElementById('scanReader');
            if (reader) {
                reader.innerHTML = '<p class="text-danger text-center mb-0">' + (errorMsg || 'Camera failed.') + '</p>';
            }
        });
    });

    modalEl.addEventListener('hidden.bs.modal', stopScanner);
}
