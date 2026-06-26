

<script src="{{ asset('assets/vendor/libs/jquery/jquery.js')}} "></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js')}} "></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js')}} "></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}} "></script>
<script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js')}} "></script>

<script src="{{ asset('assets/vendor/libs/hammer/hammer.js')}} "></script>
<script src="{{ asset('assets/vendor/libs/i18n/i18n.js')}} "></script>
<script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js')}} "></script>

<script src="{{ asset('assets/vendor/js/menu.js')}} "></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js')}} "></script>
<script src="{{ asset('assets/vendor/libs/swiper/swiper.js')}} "></script>

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js')}} "></script>

<!-- Global Modal -->
<script src="{{ asset('assets/js/global-modal.js')}} "></script>

<!-- Mobile bottom navigation -->
<script src="{{ asset('assets/js/mobile-bottom-nav.js')}} "></script>

<!-- Password show/hide toggle -->
<script>
    (function () {
        function buildToggle(input) {
            if (input.dataset.pwToggleReady) {
                return;
            }
            input.dataset.pwToggleReady = '1';

            var wrapper = document.createElement('div');
            wrapper.className = 'input-group';
            input.parentNode.insertBefore(wrapper, input);
            wrapper.appendChild(input);

            var button = document.createElement('button');
            button.type = 'button';
            button.className = 'input-group-text';
            button.setAttribute('aria-label', 'Show password');
            button.style.cursor = 'pointer';
            button.innerHTML = '<i class="mdi mdi-eye-outline"></i>';
            wrapper.appendChild(button);

            button.addEventListener('click', function () {
                var icon = button.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    button.setAttribute('aria-label', 'Hide password');
                    if (icon) {
                        icon.className = 'mdi mdi-eye-off-outline';
                    }
                } else {
                    input.type = 'password';
                    button.setAttribute('aria-label', 'Show password');
                    if (icon) {
                        icon.className = 'mdi mdi-eye-outline';
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('input[type="password"]').forEach(buildToggle);
        });
    })();
</script>

<!-- Submit modal on Enter (avoid triggering the underlying page form) -->
<script>
    (function () {
        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Enter' || e.shiftKey || e.defaultPrevented) {
                return;
            }

            var target = e.target;
            if (!target || !target.matches('input')) {
                return;
            }

            // Skip inputs that intentionally use Enter (e.g. search/autocomplete fields)
            if (target.tagName === 'TEXTAREA' || target.type === 'search') {
                return;
            }

            var modal = target.closest('.modal.show');
            if (!modal) {
                return;
            }

            // Find the modal's primary action button.
            var btn = modal.querySelector('.modal-footer .btn-primary')
                || modal.querySelector('.btn-primary');
            if (!btn || btn.disabled) {
                return;
            }

            e.preventDefault();
            btn.click();
        });
    })();
</script>

<!-- Pull-to-Refresh (swipe down like Facebook) -->
<script src="{{ asset('assets/js/pull-to-refresh.js') }}"></script>

<!-- Page JS -->
@yield('page-script')
