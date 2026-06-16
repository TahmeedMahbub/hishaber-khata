<?php

namespace App\Http\Middleware;

use App\Domains\Common\Services\TranslationService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Persist the active language in a long-lived, unencrypted cookie so it
     * remains available on responses (such as 404/500/503 error pages) that
     * are rendered outside the normal "web" middleware stack — where the
     * authenticated user cannot be resolved.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = Auth::user()->language
            ?? $request->cookie(TranslationService::COOKIE)
            ?? TranslationService::FALLBACK;

        if (! in_array($lang, TranslationService::LANGUAGES, true)) {
            $lang = TranslationService::FALLBACK;
        }

        $response = $next($request);

        // Refresh the cookie for one year (kept unencrypted; see EncryptCookies).
        $response->headers->setCookie(
            cookie(TranslationService::COOKIE, $lang, 60 * 24 * 365)
        );

        return $response;
    }
}
