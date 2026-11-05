<?php

use App\Domains\Common\Services\TranslationService;

if (! function_exists('t')) {
    /**
     * Translate a key into the current user's language.
     *
     * Returns the key itself when it has no translation entry.
     */
    function t(string $key): string
    {
        return app(TranslationService::class)->get($key);
    }
}

if (! function_exists('brand_logo')) {
    /**
     * URL of the brand logo for the given (or current) language:
     * brand-logo-bn.svg for Bangla, brand-logo.svg otherwise.
     */
    function brand_logo(?string $lang = null): string
    {
        $lang ??= app(TranslationService::class)->currentLanguage();

        return asset('assets/img/project/' . ($lang === 'bn' ? 'brand-logo-bn.svg' : 'brand-logo.svg'));
    }
}
