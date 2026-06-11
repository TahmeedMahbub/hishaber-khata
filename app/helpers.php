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
