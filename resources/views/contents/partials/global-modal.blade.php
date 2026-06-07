{{-- Global reusable modal. Trigger via JS: GlobalModal.show({ ... }) --}}
<style>
    #globalModalIcon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 75px;
        height: 75px;
        border-radius: 50%;
    }

    #globalModalIcon i,
    #globalModalIcon i::before {
        font-size: 2rem !important;
        line-height: 1;
    }
</style>
<div class="modal fade" id="globalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                style="z-index: 10;" data-bs-dismiss="modal" aria-label="বন্ধ করুন" id="globalModalClose"></button>

            <div class="modal-body text-center p-4 p-md-5">
                {{-- Image / Icon --}}
                <div class="global-modal-media mb-3">
                    <img src="" alt="" id="globalModalImage" class="img-fluid mb-2 d-none" style="max-height: 120px;">
                    <span id="globalModalIcon" class="d-none"></span>
                </div>

                {{-- Title --}}
                <h4 class="mb-2 fw-bold" id="globalModalTitle"></h4>

                {{-- Text --}}
                <p class="mb-4" id="globalModalText"></p>

                {{-- Action buttons --}}
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        id="globalModalCancel">বাতিল</button>
                    <button type="button" class="btn btn-primary" id="globalModalProcess">
                        <span class="spinner-border spinner-border-sm me-1 d-none" id="globalModalSpinner"
                            role="status" aria-hidden="true"></span>
                        <span id="globalModalProcessText">নিশ্চিত করুন</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
