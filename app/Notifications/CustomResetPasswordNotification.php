<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Restablecimiento de contraseña')
            ->greeting('¡Hola!')
            ->line('Has recibido este correo porque se solicitó un restablecimiento de contraseña para tu cuenta.')
            ->action('Restablecer Contraseña', url(route('password.reset', $this->token, false)))
            ->line('Este enlace de restablecimiento de contraseña expirará en 30 minutos.')
            ->line('Si no solicitaste un restablecimiento de contraseña, no se requiere realizar ninguna acción.')
            ->salutation('Saludos, Préstamos El Amanecer');
    }
}
