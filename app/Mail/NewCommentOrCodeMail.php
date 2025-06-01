<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewCommentOrCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    public $author;
    public $type; // 'comentario' o 'código'

    /**
     * @param $post  Post relacionado
     * @param $author  Usuario que hace la acción
     * @param $type  String: 'comentario' o 'código'
     */
    public function __construct($post, $author, $type)
    {
        $this->post = $post;
        $this->author = $author;
        $this->type = $type;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Nuevo ' . $this->type . ' en tu publicación de DevStagram',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.new_comment_or_code',
            with: [
                'post'   => $this->post,
                'author' => $this->author,
                'type'   => $this->type,
            ],
        );
    }

    public function attachments()
    {
        return [];
    }
}
