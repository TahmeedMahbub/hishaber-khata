{{--
    Shared site head partial.
    Included in every page (landing, auth/login, dashboard).
    Set the favicon and Google Analytics ID here in one place.
--}}

@php($gaId = config('services.google_analytics.id', 'G-4DFZS3SYH6'))

{{-- Favicon --}}
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" sizes="any" />

{{-- Google Analytics --}}
@if (!empty($gaId))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '{{ $gaId }}');
</script>
@endif
