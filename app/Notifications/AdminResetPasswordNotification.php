<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = route('admin.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        return (new MailMessage)
            ->subject('Reset Password Admin - Pivot Caffe')
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Anda menerima email ini karena kami menerima permintaan reset password untuk akun admin Anda.')
            ->action('Reset Password', $url)
            ->line('Tautan reset password ini akan kadaluarsa dalam 60 menit.')
            ->line('Jika Anda tidak meminta reset password, silakan abaikan email ini.')
            ->salutation('Salam, Tim Pivot Caffe');
    }
}
