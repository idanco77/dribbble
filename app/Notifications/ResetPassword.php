<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as Notification;


class ResetPassword extends Notification
{
    public function toMail($notifiable)
    {
        $appUrl = config('app.client_url');
        $url =  url('/password/reset/' . $this->token .
        '?email=' . urlencode($notifiable->email));

        return (new MailMessage)
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', str_replace(url(''), $appUrl, $url))
            ->line('If you did not request a password reset, no further action is required.');
    }
}
