<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordBase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends ResetPasswordBase
{
    use Queueable;

    // Puedes ajustar los minutos de expiración aquí si quieres
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Personaliza el correo de restablecimiento de contraseña.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Solicitud para restablecer contraseña') // Asunto personalizado
            ->greeting('Hola,')
            ->line('Recibimos una solicitud para restablecer la contraseña de tu cuenta en DevStagram.')
            ->action('Restablecer contraseña', url('/reset-password/'.$this->token.'?email='.$notifiable->getEmailForPasswordReset()))
            ->line('Este enlace caduca en 60 minutos.')
            ->line('Si no has solicitado este cambio, ignora este correo.')
            ->salutation('Este mensaje es automático, por favor no respondas a este correo.');
    }
}
