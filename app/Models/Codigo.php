<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Codigo extends Model
{
    use HasFactory;

    /**
     * Lista de atributos que pueden asignarse de forma masiva.
     */
    protected $fillable = [
        'user_id',      // ID del usuario que comparte el código
        'post_id',      // ID del post relacionado
        'lenguaje',     // Lenguaje de programación elegido
        'codigo',       // Fragmento de código compartido
    ];

    /**
     * Relación: un código pertenece a un usuario.
     * Permite acceder al usuario que compartió el código.
     * Ej: $codigo->user->username
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: un código pertenece a un post.
     * Permite acceder al post donde se compartió el código.
     * Ej: $codigo->post->titulo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
