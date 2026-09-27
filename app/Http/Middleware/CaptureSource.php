<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Captures the referral/source from query parameters and stores it in the session
 * so it can be associated with the tenant when they register.
 *
 * Supported query params: source, utm_source, ref, referral
 * Priority: source > utm_source > ref > referral
 */
class CaptureSource
{
    /**
     * The query parameter names to check for source tracking.
     *
     * @var array<string>
     */
    protected array $sourceParams = ['source', 'utm_source', 'ref', 'referral'];

    /**
     * The session key used to store the captured source.
     */
    protected string $sessionKey = 'registration_source';

    public function handle(Request $request, Closure $next): Response
    {
        // Only capture source on landing and registration pages
        if (! $this->shouldCaptureSource($request)) {
            return $next($request);
        }

        $source = $this->extractSource($request);

        if ($source !== null) {
            // Store in session for later use during registration
            $request->session()->put($this->sessionKey, $source);
        }

        // Also preserve existing source if already in session (don't overwrite)
        elseif (! $request->session()->has($this->sessionKey)) {
            // Check for referer header as fallback
            $referer = $request->header('referer');
            if ($referer !== null) {
                $request->session()->put($this->sessionKey, $this->parseReferer($referer));
            }
        }

        return $next($request);
    }

    /**
     * Determine if we should capture source for this request.
     */
    protected function shouldCaptureSource(Request $request): bool
    {
        // Capture on landing page (home) and register page
        $path = $request->path();

        return in_array($path, ['', 'register'], true)
            || str_starts_with($path, 'register');
    }

    /**
     * Extract source from query parameters.
     */
    protected function extractSource(Request $request): ?string
    {
        foreach ($this->sourceParams as $param) {
            $value = $request->query($param);

            if ($value !== null && $value !== '') {
                return $this->sanitizeSource($value);
            }
        }

        return null;
    }

    /**
     * Sanitize the source value.
     */
    protected function sanitizeSource(string $source): string
    {
        // Limit length and allow only safe characters
        $source = trim($source);
        $source = strip_tags($source);
        $source = preg_replace('/[^a-zA-Z0-9_\-\.]/', '', $source);

        return mb_substr($source, 0, 50);
    }

    /**
     * Parse referer URL to extract a meaningful source name.
     */
    protected function parseReferer(string $referer): ?string
    {
        try {
            $url = parse_url($referer);
            $host = $url['host'] ?? null;

            if ($host === null) {
                return null;
            }

            // Remove www. prefix
            $host = preg_replace('/^www\./', '', $host);

            // Map known domains to friendly names
            $knownSources = [
                'facebook.com' => 'facebook',
                'fb.com' => 'facebook',
                'instagram.com' => 'instagram',
                'twitter.com' => 'twitter',
                'x.com' => 'twitter',
                'linkedin.com' => 'linkedin',
                'google.com' => 'google',
                'youtube.com' => 'youtube',
                'tiktok.com' => 'tiktok',
                'whatsapp.com' => 'whatsapp',
            ];

            return $knownSources[$host] ?? $host;
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * Get the captured source from session.
     */
    public static function getSource(Request $request): ?string
    {
        return $request->session()->get('registration_source');
    }

    /**
     * Pull and remove the captured source from session.
     */
    public static function pullSource(Request $request): ?string
    {
        return $request->session()->pull('registration_source');
    }
};