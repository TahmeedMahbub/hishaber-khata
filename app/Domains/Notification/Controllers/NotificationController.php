<?php

namespace App\Domains\Notification\Controllers;

use App\Domains\Notification\Models\Notification;
use App\Domains\Notification\Services\NotificationService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $service)
    {
    }

    public function index(Request $request): View
    {
        return view('contents.notifications.index', [
            'notifications' => $this->service->paginateForUser($request->user()),
        ]);
    }

    public function markRead(Request $request, Notification $notification): RedirectResponse
    {
        abort_unless($this->service->isVisibleTo($notification, $request->user()), 403);

        $this->service->markRead($notification);

        return $this->backTarget($notification);
    }

    public function markAllRead(Request $request): RedirectResponse
    {
        $this->service->markAllRead($request->user());

        return redirect()->back()->with('success', t('msg.notifications_all_read'));
    }

    /**
     * Redirect to the notification's target url when set, otherwise go back.
     */
    protected function backTarget(Notification $notification): RedirectResponse
    {
        if (! empty($notification->url)) {
            return redirect()->to($notification->url);
        }

        return redirect()->back();
    }
}
