<?php

namespace App\Domains\Auth\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Sends a 4-digit verification code to the user's email so they can confirm
 * their address by entering the code on the verification page.
 */
class EmailVerificationCodeNotification extends Notification
{
    public function __construct(protected string $code)
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
        return (new MailMessage)
            ->subject(t('authpage.verify_code_subject'))
            ->greeting(t('authpage.verify_code_greeting').' '.$notifiable->name)
            ->line(t('authpage.verify_code_intro'))
            ->line('**'.$this->code.'**')
            ->line(t('authpage.verify_code_expiry'))
            ->line(t('authpage.verify_code_ignore'));
    }
}
