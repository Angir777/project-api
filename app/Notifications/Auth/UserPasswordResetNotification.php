<?php

namespace App\Notifications\Auth;

use App\Models\Auth\PasswordReset;
use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserPasswordResetNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $passwordReset;
    protected $resetPasswordLink;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @param PasswordReset $passwordReset
     * @param $redirectUrl
     */
    public function __construct(User $user, PasswordReset $passwordReset, $redirectUrl)
    {
        $this->user = $user;
        $this->passwordReset = $passwordReset;

        if ($redirectUrl != null) {
            $this->resetPasswordLink = $redirectUrl . '/' . $this->passwordReset->token;
        } else {
            if (config('app.gateway_use_hash')) {
                $this->resetPasswordLink = config('app.gateway_url') . '/#/finish-reset-password/' . $this->passwordReset->token;
            } else {
                $this->resetPasswordLink = config('app.gateway_url') . '/finish-reset-password/' . $this->passwordReset->token;
            }
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting(__('auth.email.password_reset.greeting'))
            ->subject(config('app.name') . ': '.__('auth.email.password_reset.subject'))
            ->line(__('auth.email.password_reset.line_one'))
            ->action(__('auth.email.password_reset.action'), $this->resetPasswordLink)
            ->line(__('auth.email.password_reset.line_two'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
