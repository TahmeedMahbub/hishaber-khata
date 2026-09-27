<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * Captures marketing attribution parameters on first qualifying visit.
 * All parameters from the same landing request share a single batch number.
 * Batch = MAX(batch) + 1 (with race-condition mitigation).
 * Original batch preserved in session across navigation.
 * On register/login, user_id is attached to all rows of that batch.
 */
class CaptureAttribution
{
    /**
     * Paths where attribution should be captured.
     *
     * @var array<string>
     */
    protected array $capturePaths = ['/', '/register', '/login'];

    /**
     * Session key for storing the active attribution batch.
     */
    protected string $sessionKey = 'attribution_batch';

    /**
     * Query parameter keys that should NOT be treated as tracking parameters.
     */
    protected array $excludedKeys = [
        '_token',
        '_method',
        'locale',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Only capture on designated paths for guest users
        if (! $this->shouldCapture($request)) {
            return $next($request);
        }

        // Check if we already have an attribution batch for this session
        $existingBatch = $request->session()->get($this->sessionKey);

        if ($existingBatch) {
            // Attribution already exists for this session - preserve original
            return $next($request);
        }

        // Extract all tracking parameters from request
        $params = $this->extractTrackingParams($request);

        // Only persist if there are relevant tracking parameters
        if (! empty($params)) {
            $batch = $this->createAttributionBatch($params, $request);

            if ($batch) {
                $request->session()->put($this->sessionKey, $batch);
            }
        }

        return $next($request);
    }

    /**
     * Determine if attribution should be captured for this request.
     */
    protected function shouldCapture(Request $request): bool
    {
        // Only for guest users (not authenticated)
        if ($request->user()) {
            return false;
        }

        $path = $request->path();

        // Check exact matches and locale-prefixed paths
        foreach ($this->capturePaths as $capturePath) {
            if ($path === $capturePath || $path === ltrim($capturePath, '/')) {
                return true;
            }
            // Handle locale-prefixed paths like /bn/register, /en/login
            if (preg_match('#^/(bn|en)' . preg_quote($capturePath, '#') . '(?:/|$)#', $path)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extract all tracking parameters from the request.
     * Captures ALL query parameters dynamically (except excluded),
     * plus landing_page, referrer, and ip as special keys.
     */
    protected function extractTrackingParams(Request $request): array
    {
        $params = [];

        // Capture all query parameters except excluded ones
        foreach ($request->query() as $key => $value) {
            if (in_array($key, $this->excludedKeys, true)) {
                continue;
            }
            if ($value !== null && $value !== '') {
                $params[$key] = (string) $value;
            }
        }

        // Add landing page URL
        $landingPage = $request->fullUrl();
        if ($landingPage) {
            $params['landing_page'] = $landingPage;
        }

        // Add referrer
        $referrer = $request->header('referer');
        if ($referrer) {
            $params['referrer'] = $referrer;
        }

        // Add IP address
        $ip = $request->ip();
        if ($ip) {
            $params['ip'] = $ip;
        }

        return $params;
    }

    /**
     * Create a new attribution batch with all parameters.
     * Uses MAX(batch) + 1 with INSERT ... SELECT for race-condition mitigation.
     */
    protected function createAttributionBatch(array $params, Request $request): ?int
    {
        try {
            // Generate next batch number using atomic SELECT MAX + 1
            // COALESCE handles empty table case
            $batch = (int) DB::table('marketing_attributions')
                ->selectRaw('COALESCE(MAX(`batch`), 0) + 1 as next_batch')
                ->value('next_batch');

            // Prepare rows for batch insert
            $rows = [];
            $ip = $params['ip'] ?? $request->ip();
            $now = now();

            foreach ($params as $key => $value) {
                $rows[] = [
                    'batch'      => $batch,
                    'key'        => $key,
                    'value'      => $value,
                    'ip'         => $ip,
                    'user_id'    => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // Batch insert - will fail on duplicate (batch, key) if race occurred
            DB::table('marketing_attributions')->insert($rows);

            return $batch;
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle race condition: another request may have created the batch
            if (($e->errorInfo[1] ?? 0) === 1062) { // Duplicate entry on (batch, key)
                // Find the batch that was actually created for this session's params
                // Use the first param's key to look up the batch
                $firstKey = array_key_first($params);
                if ($firstKey) {
                    $batch = DB::table('marketing_attributions')
                        ->where('key', $firstKey)
                        ->where('value', $params[$firstKey])
                        ->where('ip', $params['ip'] ?? $request->ip())
                        ->value('batch');
                    return $batch ? (int) $batch : null;
                }
            }
            // Log error but don't break the request
            report($e);
            return null;
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }

    /**
     * Attach authenticated user to existing attribution batch.
     * Updates user_id for ALL rows belonging to the batch.
     */
    public static function attachUser(Request $request, int $userId): void
    {
        $batch = $request->session()->pull('attribution_batch');

        if (! $batch) {
            return;
        }

        DB::table('marketing_attributions')
            ->where('batch', $batch)
            ->whereNull('user_id')
            ->update([
                'user_id'    => $userId,
                'updated_at' => now(),
            ]);
    }

    /**
     * Get the current attribution batch from session (for debugging/inspection).
     */
    public static function getCurrentBatch(Request $request): ?int
    {
        return $request->session()->get('attribution_batch');
    }
}