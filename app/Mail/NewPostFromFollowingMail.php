<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Post;

class NewPostFromFollowingMail extends Mailable
{
    use Queueable, SerializesModels;

    // Variables públicas para acceder a ellas desde la vista del correo
    public $author; // Usuario que publicó el nuevo post
    public $post;   // El nuevo post publicado
    public $url;    // URL para acceder al nuevo post

    /**
     * Crea una nueva instancia del mensaje.
     * 
     * @param User $author El usuario que ha publicado el post
     * @param Post $post   El nuevo post publicado
     */
    public function __construct(User $author, Post $post)
    {
        $this->author = $author;
        $this->post = $post;
        // Creamos la URL que lleva directamente al nuevo post publicado
        // Ejemplo: http://tu-dominio.com/toni/posts/123
        $this->url = url('/' . $author->username . '/posts/' . $post->id);
    }

    /**
     * Configura el correo: asunto y vista con datos.
     */
    public function build()
    {
        return $this->subject('¡Nueva publicación de ' . $this->author->username . ' en DevStagram!')
            ->view('emails.new_post_from_following')
            ->with([
                'author' => $this->author,
                'post'   => $this->post,
                'url'    => $this->url, // Pasamos la URL a la vista
            ]);
    }
}
