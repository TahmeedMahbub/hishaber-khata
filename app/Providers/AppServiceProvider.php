<?php

namespace App\Providers;

use App\Domains\Common\Services\TranslationService;
use App\Domains\Notification\Services\NotificationService;
use App\Domains\Tenant\Services\TenantManager;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TenantManager::class);
        $this->app->singleton(TranslationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Feed the navbar bell with the current user's notifications.
        View::composer('contents.navbar', function ($view): void {
            $user = Auth::user();

            if ($user === null) {
                $view->with(['navUnreadCount' => 0, 'navNotifications' => collect()]);

                return;
            }

            $service = app(NotificationService::class);

            $view->with([
                'navUnreadCount'   => $service->unreadCount($user),
                'navNotifications' => $service->recentForUser($user),
            ]);
        });
    }
}
