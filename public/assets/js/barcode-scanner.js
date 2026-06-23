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
 * The scanner starts on 'shown.bs.modal' and stops on 'hidden.bs.modal'.
 * Zoom (2.5×) is applied after the camera stream is running so it never
 * interferes with getUserMedia permission.
 */

function initBarcodeScanner(modalEl, onScan, errorMsg) {
    if (!modalEl) { return; }

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
