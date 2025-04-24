<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    //$fillable van a ser los datos que esperamos que el usuario nos envíe y que se van a guardar en la base de datos(es una medida extr de seguridad)
    //en este caso son los datos que se envían desde el formulario de registro
    //en el archivo register.blade.php
    //en el archivo RegisterController.php se valida que los datos sean correctos
    //si los datos son correctos, se guardan en la base de datos
    //en el archivo User.php se definen los datos que se van a guardar en la base de datos
    protected $fillable = [
        'name',
        'username',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //relacion uno a muchos donde un usuario puede tener varios posts
    public function posts(){
        
        return $this->hasMany(Post::class); //le pasamos x parametros el modelo con el que se relaciona "Post"
    }

    public function likes(){
        
        return $this->hasMany(Like::class); //le pasamos x parametros el modelo con el que se relaciona "Like"
        //hasMany porque un usuario puede tener muchos likes
    }

    //metodo que almacena los seguidores de un usuario
    public function followers(){
        //le pasamos x parametros el modelo con el que se relaciona "User", la tabla intermedia "followers", el id del usuario y el id del seguidor
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id'); 
    }

    //Almacenar los usuarios a los que seguimos
    public function followings(){
        //le pasamos x parametros el modelo con el que se relaciona "User", la tabla intermedia "followers", el id del follower y el id del usuario
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id'); 
    }


    //Comprobar si un usuario ya sigue a otro usuario
    public function siguiendo(User $user){
        //si el id del usuario autenticado es igual al id del seguidor
        return $this->followers->contains($user->id); //devuelve true o false
    }


}
