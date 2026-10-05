<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (\App\Domains\Tenant\Exceptions\SubscriptionLimitException $e, $request) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'error'            => $e->getMessage(),
                    'requires_upgrade' => true,
                ], 403);
            }

            return redirect()->back()
                ->with('subscription_error', $e->getMessage())
                ->with('requires_upgrade', true);
        });

        $this->renderable(function (\App\Domains\Tenant\Exceptions\FeatureRestrictedException $e, $request) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'error'            => $e->getMessage(),
                    'requires_upgrade' => true,
                ], 403);
            }

            return redirect()->back()
                ->with('subscription_error', $e->getMessage())
                ->with('requires_upgrade', true);
        });
    }
}
