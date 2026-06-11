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
     * In-memory cache of the loaded translation map for this request.
     *
     * @var array<string, array<string, string>>|null
     */
    protected ?array $translations = null;

    /**
     * Translate a key into the current language.
     *
     * Returns the key itself when the key (or its value for the current
     * language) does not exist.
     */
    public function get(string $key): string
    {
        $translations = $this->all();

        if (! isset($translations[$key])) {
            return $key;
        }

        $lang = $this->currentLanguage();

        return $translations[$key][$lang]
            ?? $translations[$key][self::FALLBACK]
            ?? $key;
    }

    /**
     * Resolve the active language from the authenticated user.
     */
    public function currentLanguage(): string
    {
        $lang = Auth::user()->language ?? self::FALLBACK;

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
