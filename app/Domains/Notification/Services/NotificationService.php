<?php

namespace App\Domains\Notification\Services;

use App\Domains\Common\Services\BaseService;
use App\Domains\Notification\Models\Notification;
use App\Domains\Notification\Repositories\NotificationRepository;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class NotificationService extends BaseService
{
    public function __construct(protected NotificationRepository $notifications)
    {
    }

    public function unreadCount(User $user): int
    {
        return $this->notifications->unreadCount($user);
    }

    public function recentForUser(User $user, int $limit = 8): Collection
    {
        return $this->notifications->recentForUser($user, $limit);
    }

    public function paginateForUser(User $user): LengthAwarePaginator
    {
        return $this->notifications->paginateForUser($user);
    }

    /**
     * Create a notification.
     *
     * Rule: when no tenant is given the notification is personal and a
     * user_id is mandatory; when a tenant is given it is shown to every
     * user of that tenant.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Notification
    {
        $tenantId = $data['tenant_id'] ?? null;
        $userId   = $data['user_id'] ?? null;

        if ($tenantId === null && $userId === null) {
            throw new InvalidArgumentException('A personal notification (no tenant) requires a user_id.');
        }

        return $this->notifications->create([
            'tenant_id' => $tenantId,
            'user_id'   => $userId,
            'type'      => $data['type'] ?? 'info',
            'title'     => $data['title'],
            'message'   => $data['message'] ?? null,
            'url'       => $data['url'] ?? null,
            'read_at'   => $data['read_at'] ?? null,
        ]);
    }

    public function markRead(Notification $notification): Notification
    {
        return $this->notifications->markRead($notification);
    }

    public function markAllRead(User $user): int
    {
        return $this->notifications->markAllRead($user);
    }

    /**
     * Whether the given notification is visible to the given user.
     */
    public function isVisibleTo(Notification $notification, User $user): bool
    {
        if ($notification->tenant_id !== null) {
            return (int) $notification->tenant_id === (int) $user->tenant_id;
        }

        return (int) $notification->user_id === (int) $user->id;
    }
}
