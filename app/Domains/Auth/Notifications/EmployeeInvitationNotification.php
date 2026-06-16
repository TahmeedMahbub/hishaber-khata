<?php

namespace App\Domains\Auth\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

/**
 * Sent to a newly invited employee. Contains a signed link (valid for a few
 * days) that lets the employee verify their email and set their own password.
 */
class EmployeeInvitationNotification extends Notification
{
    public function __construct(protected User $inviter)
    {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = URL::temporarySignedRoute(
            'employee.setup',
            Carbon::now()->addDays(7),
            [
                'id'   => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ],
        );

        $business = $this->inviter->tenant?->name ?? config('app.name');

        return (new MailMessage)
            ->subject(t('employee.invite_subject'))
            ->greeting(t('employee.invite_greeting').' '.$notifiable->name)
            ->line(t('employee.invite_intro').' '.$business.'.')
            ->line(t('employee.invite_action_line'))
            ->action(t('employee.invite_button'), $url)
            ->line(t('employee.invite_expiry'))
            ->line(t('employee.invite_ignore'));
    }
}
