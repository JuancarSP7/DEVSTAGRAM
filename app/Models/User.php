<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Importa los modelos necesarios
use App\Models\Post;
use App\Models\Like;
use App\Models\Comentario;
use App\Models\Codigo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Datos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'username',
        'email',
        'password'
    ];

    // Oculta estos campos en arrays/json
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casts de tipos
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Un usuario tiene muchos posts.
     */
    public function posts(){
        return $this->hasMany(Post::class);
    }

    /**
     * Un usuario tiene muchos likes.
     */
    public function likes(){
        return $this->hasMany(Like::class);
    }

    /**
     * Un usuario tiene muchos comentarios.
     */
    public function comentarios() {
        return $this->hasMany(Comentario::class);
    }

    /**
     * Un usuario tiene muchos fragmentos de código.
     */
    public function codigos() {
        return $this->hasMany(Codigo::class);
    }

    /**
     * Seguidores de este usuario.
     */
    public function followers(){
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    /**
     * Usuarios a los que sigue este usuario.
     */
    public function followings(){
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    /**
     * Comprobar si ya sigue a otro usuario.
     */
    public function siguiendo(User $user){
        return $this->followers->contains($user->id);
    }
}
