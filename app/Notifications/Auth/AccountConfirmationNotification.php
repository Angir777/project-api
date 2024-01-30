<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountConfirmationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $confirmationCode;
    private $password;

    /**
     * Create a new notification instance.
     *
     * @param $confirmationCode
     */
    public function __construct($confirmationCode, $password)
    {
        $this->confirmationCode = $confirmationCode;
        $this->password = $password;
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
        $mailMessage = (new MailMessage)
            ->greeting(__('auth.email.account_activate.greeting'))
            ->subject(config('app.name') . ': '.__('auth.email.account_activate.subject'))
            ->line(__('auth.email.account_activate.line_hello'))
            ->line(__('auth.email.account_activate.line_password_info') . $this->password);

        if ($this->confirmationCode !== null)
        {
            $mailMessage->line(__('auth.email.account_activate.line_activation_required'));
            $mailMessage->action(__('auth.email.account_activate.action'), url(config('app.gateway_url') . '/account-confirmation/' . $this->confirmationCode));
        }

        return $mailMessage;
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
