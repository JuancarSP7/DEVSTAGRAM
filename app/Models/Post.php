<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    // Un post pertenece a un usuario (relación inversa)
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Un post tiene muchos comentarios
    public function comentarios() {
        return $this->hasMany(Comentario::class);
    }

    // Un post tiene muchos likes
    public function likes() {
        return $this->hasMany(Like::class);
    }

    // Verifica si el usuario ha dado like a este post
    public function checkLike(User $user) {
        return $this->likes->contains('user_id', $user->id);
    }

    // Un post tiene muchos códigos compartidos
    public function codigos() {
        return $this->hasMany(Codigo::class); // Relación con el modelo Codigo
    }
}
