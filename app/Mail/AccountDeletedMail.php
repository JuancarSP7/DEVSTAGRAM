<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountDeletedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Constructor: Puedes pasar datos a la vista aquí si algún día lo necesitas.
     */
    public function __construct()
    {
        // En este caso, no pasamos datos adicionales
    }

    /**
     * Define el "sobre" (asunto) del correo.
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Confirmación de baja en DevStagram',
        );
    }

    /**
     * Define la vista que se usará para el cuerpo del mensaje.
     */
    public function content()
    {
        return new Content(
            view: 'emails.account_deleted', // La vista que crearemos después
        );
    }

    /**
     * Si necesitas adjuntos, puedes devolverlos aquí.
     */
    public function attachments()
    {
        return [];
    }
}
