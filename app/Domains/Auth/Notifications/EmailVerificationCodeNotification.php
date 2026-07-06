<?php

namespace App\Domains\Auth\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

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
        $codeBox = new HtmlString(
            '<div style="text-align:center;margin:28px 0;">'
            .'<span style="display:inline-block;font-size:38px;font-weight:800;'
            .'letter-spacing:14px;color:#1B8B5A;background:#effaef;'
            .'border:2px solid #1B8B5A;border-radius:14px;padding:18px 24px 18px 38px;'
            .'font-family:\'Courier New\',monospace;">'
            .e($this->code)
            .'</span></div>'
        );

        return (new MailMessage)
            ->subject(t('authpage.verify_code_subject'))
            ->greeting(t('authpage.verify_code_greeting').' '.$notifiable->name)
            ->line(t('authpage.verify_code_intro'))
            ->line($codeBox)
            ->line(t('authpage.verify_code_expiry'))
            ->line(t('authpage.verify_code_ignore'));
    }
}
