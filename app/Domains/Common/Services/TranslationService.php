<?php

namespace App\Domains\Common\Services;

use Illuminate\Support\Facades\Auth;

class TranslationService
{
    /**
     * Supported languages.
     *
     * @var array<int, string>
     */
    public const LANGUAGES = ['bn', 'en'];

    /**
     * Default language used when no user/preference is available.
     */
    public const FALLBACK = 'bn';

    /**
     * Name of the (unencrypted) cookie that remembers the chosen language.
     */
    public const COOKIE = 'app_lang';

    /**
     * In-memory cache of the loaded translation map for this request.
     *
     * @var array<string, array<string, string>>|null
     */
    protected ?array $translations = null;

    /**
     * Translate a key into the current language.
     *
     * Supports dot-notation for grouped keys (e.g. "nav.dashboard"). Returns
     * the key itself when the key (or its value for the current language)
     * does not exist.
     */
    public function get(string $key): string
    {
        $entry = data_get($this->all(), $key);

        if (! is_array($entry)) {
            return $key;
        }

        $lang = $this->currentLanguage();

        return $entry[$lang]
            ?? $entry[self::FALLBACK]
            ?? $key;
    }

    /**
     * Resolve the active language.
     *
     * Prefers the authenticated user's preference, then falls back to the
     * language cookie (used on error pages such as 404/500/503 that render
     * without the authenticated user), then the default language.
     */
    public function currentLanguage(): string
    {
        $routeLocale = request()->route('locale');

        $lang = in_array($routeLocale, self::LANGUAGES, true)
            ? $routeLocale
            : (Auth::user()->language
            ?? request()->cookie(self::COOKIE)
            ?? self::FALLBACK);

        return in_array($lang, self::LANGUAGES, true) ? $lang : self::FALLBACK;
    }

    /**
     * Load (and memoise) the translation map for the current request.
     *
     * @return array<string, array<string, string>>
     */
    public function all(): array
    {
        if ($this->translations === null) {
            $this->translations = (array) config('translations', []);
        }

        return $this->translations;
    }
}
