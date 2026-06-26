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
 * instead the native camera overlay is launched directly.
 *
 * The scanner starts on 'shown.bs.modal' and stops on 'hidden.bs.modal'.
 * Zoom (2.5×) is applied after the camera stream is running so it never
 * interferes with getUserMedia permission.
 * Thank you
 */

/**
 * Detect whether we are running inside a Median (GoNative) native app.
 * The JS bridge injects the `median` or `gonative` global object.
 */
function isMedianApp() {
    return (typeof median !== 'undefined' && median && typeof median.barcode !== 'undefined') ||
           (typeof gonative !== 'undefined' && gonative && typeof gonative.barcode !== 'undefined');
}

/**
 * Launch the Median native barcode scanner.
 * Works with both `median` (current) and `gonative` (legacy) namespaces.
 * Returns a Promise that resolves with the scanned code string, or rejects on cancel/failure.
 */
function medianBarcodeScan() {
    return new Promise(function (resolve, reject) {
        var bridge = (typeof median !== 'undefined' && median && median.barcode)
            ? median.barcode
            : (typeof gonative !== 'undefined' && gonative && gonative.barcode)
                ? gonative.barcode
                : null;

        if (!bridge) {
            reject(new Error('Median barcode bridge not available'));
            return;
        }

        // Try Promise-based API first (newer Median SDK), fall back to callback
        try {
            var result = bridge.scan({ callback: function (data) {
                if (data && data.success) {
                    resolve(String(data.code).trim());
                } else {
                    reject(new Error('Scan cancelled or failed'));
                }
            }});

            // If bridge.scan returns a Promise (newer SDK), handle it too
            if (result && typeof result.then === 'function') {
                result.then(function (data) {
                    if (data && data.success) {
                        resolve(String(data.code).trim());
                    } else {
                        reject(new Error('Scan cancelled or failed'));
                    }
                }).catch(reject);
            }
        } catch (e) {
            reject(e);
        }
    });
}

function initBarcodeScanner(modalEl, onScan, errorMsg) {
    if (!modalEl) { return; }

    // ─── Median Native App Path ───────────────────────────────────────
    // When inside Median, intercept the scan button clicks to launch the
    // native scanner instead of opening the Bootstrap modal.
    if (isMedianApp()) {
        // Find all buttons that would open the barcode scan modal
        var scanTriggers = document.querySelectorAll('[data-bs-target="#barcodeScanModal"]');
        scanTriggers.forEach(function (btn) {
            // Remove the Bootstrap modal trigger so the modal doesn't open
            btn.removeAttribute('data-bs-toggle');
            btn.removeAttribute('data-bs-target');

            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Fire the 'show.bs.modal' event manually so scanTarget gets set
                // (some pages rely on this to determine where to put the result)
                var showEvent = new Event('show.bs.modal', { bubbles: true });
                showEvent.relatedTarget = btn;
                modalEl.dispatchEvent(showEvent);

                medianBarcodeScan().then(function (code) {
                    onScan(code);
                }).catch(function () {
                    // User cancelled or scan failed – do nothing
                });
            });
        });

        return; // Don't set up the HTML5 camera scanner at all
    }

    // ─── Browser / Web Path (existing behaviour) ─────────────────────
    var html5Qr = null;

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
