{{-- Subscription Upgrade Modal --}}
<div class="modal fade" id="subscriptionUpgradeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-primary">
                    <i class="ti ti-crown text-warning me-2 fs-4"></i>প্ল্যান আপগ্রেড করুন
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="avatar avatar-xl bg-label-warning rounded-circle mx-auto mb-3">
                    <i class="ti ti-lock-open fs-2 text-warning"></i>
                </div>

                <h4 class="fw-bold text-dark mb-2" id="upgradeModalTitle">প্ল্যান সীমাবদ্ধতা</h4>
                <p class="text-muted fs-6 mb-4 px-md-4" id="upgradeModalMessage">
                    {{ session('subscription_error') ?? 'আপনার বর্তমান প্ল্যানের সীমা পূর্ণ হয়েছে বা ফিচারটি অ্যাক্সেস করতে আপগ্রেড প্রয়োজন।' }}
                </p>

                <div class="row g-3 text-start mb-4">
                    <div class="col-md-4">
                        <div class="card border shadow-none h-100">
                            <div class="card-body p-3 text-center">
                                <h6 class="fw-bold mb-1">বেসিক</h6>
                                <h4 class="text-primary fw-bold mb-2">৳২৯৯ <small class="fs-6 text-muted">/মাস</small></h4>
                                <ul class="list-unstyled text-start small mb-0">
                                    <li><i class="ti ti-check text-success me-1"></i> ১৫০টি পণ্য</li>
                                    <li><i class="ti ti-check text-success me-1"></i> সীমাহীন বিক্রয়</li>
                                    <li><i class="ti ti-check text-success me-1"></i> ইনভয়েস ও কাস্টমার</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border border-primary shadow-sm h-100 bg-label-primary">
                            <div class="card-body p-3 text-center">
                                <span class="badge bg-primary mb-1">জনপ্রিয়</span>
                                <h6 class="fw-bold mb-1">প্রফেশনাল</h6>
                                <h4 class="text-primary fw-bold mb-2">৳৫৯৯ <small class="fs-6 text-muted">/মাস</small></h4>
                                <ul class="list-unstyled text-start small mb-0">
                                    <li><i class="ti ti-check text-success me-1"></i> ৫০০টি পণ্য</li>
                                    <li><i class="ti ti-check text-success me-1"></i> প্রিমিয়াম রিপোর্ট</li>
                                    <li><i class="ti ti-check text-success me-1"></i> ৩ জন ব্যবহারকারী</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border shadow-none h-100">
                            <div class="card-body p-3 text-center">
                                <h6 class="fw-bold mb-1">বিজনেস</h6>
                                <h4 class="text-primary fw-bold mb-2">৳১,২৯৯ <small class="fs-6 text-muted">/মাস</small></h4>
                                <ul class="list-unstyled text-start small mb-0">
                                    <li><i class="ti ti-check text-success me-1"></i> সীমাহীন পণ্য</li>
                                    <li><i class="ti ti-check text-success me-1"></i> ১০ জন ব্যবহারকারী</li>
                                    <li><i class="ti ti-check text-success me-1"></i> মাল্টিপল শাখা</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-label-secondary px-4" data-bs-dismiss="modal">পরে দেখুন</button>
                    <a href="/#pricing" class="btn btn-primary px-4 fw-bold">
                        <i class="ti ti-arrow-up-circle me-1"></i>এখনই আপগ্রেড করুন
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session('subscription_error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modalEl = document.getElementById('subscriptionUpgradeModal');
        if (modalEl) {
            var modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    });
</script>
@endif
