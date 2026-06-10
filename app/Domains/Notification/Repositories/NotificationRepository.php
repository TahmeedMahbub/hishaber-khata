<?php

namespace App\Domains\Notification\Repositories;

use App\Domains\Common\Repositories\BaseRepository;
use App\Domains\Notification\Models\Notification;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class NotificationRepository extends BaseRepository
{
    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    /**
     * Count unread notifications visible to the given user.
     */
    public function unreadCount(User $user): int
    {
        return $this->query()
            ->visibleTo($user)
            ->unread()
            ->count();
    }

    /**
     * The most recent notifications visible to the user (for the dropdown).
     */
    public function recentForUser(User $user, int $limit = 8): Collection
    {
        return $this->query()
            ->visibleTo($user)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    /**
     * Paginated notifications visible to the user (for the full page).
     */
    public function paginateForUser(User $user, int $perPage = 20): LengthAwarePaginator
    {
        return $this->query()
            ->visibleTo($user)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Mark a single notification as read.
     */
    public function markRead(Notification $notification): Notification
    {
        if ($notification->isUnread()) {
            $notification->forceFill(['read_at' => now()])->save();
        }

        return $notification;
    }

    /**
     * Mark every unread notification visible to the user as read.
     */
    public function markAllRead(User $user): int
    {
        return $this->query()
            ->visibleTo($user)
            ->unread()
            ->update(['read_at' => now()]);
    }
}
