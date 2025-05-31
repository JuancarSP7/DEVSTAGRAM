<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewFollowerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $follower;

    /**
     * Recibe el objeto $follower (usuario que sigue)
     */
    public function __construct($follower)
    {
        $this->follower = $follower;
    }

    public function envelope()
    {
        return new Envelope(
            subject: '¡Tienes un nuevo seguidor en DevStagram!',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.new_follower',
            with: [
                'follower' => $this->follower,
            ],
        );
    }

    public function attachments()
    {
        return [];
    }
}
