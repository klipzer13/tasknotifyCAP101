<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SendTwoFactorCode extends Notification
{
    protected $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function via($notifiable)
    {
        return ['mail']; // or 'sms', 'database', etc.
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Two-Factor Code')
            ->line('Your 2FA code is: ' . $this->code)
            ->line('It will expire in 10 minutes.');
    }
}
