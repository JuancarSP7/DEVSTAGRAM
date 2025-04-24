<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [     
        //$fillable permite asignar valores a los campos de la tabla y proteger la base de datos (es la info que se va a introducir en la base de datos)
        //es la info que laravel tiene que leer y procesas para introducirla en la base de datos
        //en este caso son los campos de la tabla posts ------> la misma del "Post::create" de "PostController"
        //el nombre de la tabla es el plural del nombre del modelo
        //fillable es un array que contiene los nombres de los campos de la tabla
        //los campos que se pueden asignar masivamente
        //en este caso son los campos de la tabla posts

        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    //relacion uno a muchos inversa donde un post pertenece a un usuario
    public function user(){

        return $this->belongsTo(User::class);   //en los parametros le pasamos el modelo con el que se relaciona "User"
        //belongsTo porque un post pertenece a un usuario
        //select(['name', 'username']) para que solo traiga el nombre y el username del usuario
    }

    public function comentarios(){  //se le llama "comentarios porque es el nombre de la tabla en plural y en minusculas de la base de datos
        return $this->hasMany(Comentario::class);   //hasMany porque un post puede tener muchos comentarios
        //Comentario::class es el modelo con el que se relaciona
    }

    public function likes(){    //se le llama "likes" porque es el nombre de la tabla en plural y en minusculas de la base de datos
        return $this->hasMany(Like::class); //hasMany porque un post puede tener muchos likes
        //Like::class es el modelo con el que se relaciona
    }

    public function checkLike(User $user){
        return $this->likes->contains('user_id', $user->id); //esto es para comprobar si el usuario ya le dio like al post
        //contains('user_id', $user->id) comprueba si el id del usuario que le dio like al post es igual al id del usuario que esta logueado
        //si es igual devuelve true, si no es igual devuelve false
    }



}
