<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompleteLogin extends Notification
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
            ->subject(__('Enlace seguro de inicio de sesión para :app_name', ['app_name' => config('app.name')]))
            ->line(__('¡Bienvenido de nuevo! Usa este enlace para iniciar sesión de forma segura en tu cuenta en :app_name.', ['app_name' => config('app.name')]))
            ->action(__('Iniciar sesión en :app_name', ['app_name' => config('app.name')]), $this->url)
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
