<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompleteRegister extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $url)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Completa tu registro en :app_name', ['app_name' => config('app.name')]))
            ->line(__('Haz clic en el enlace a continuación para completar el proceso de registro en :app_name y automáticamente iniciarás sesión.', ['app_name' => config('app.name')]))
            ->action(__('Confirmar registro', ['app_name' => config('app.name')]), $this->url)
            ->line(__('Por tu seguridad, el enlace expirará en 24 horas.'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
