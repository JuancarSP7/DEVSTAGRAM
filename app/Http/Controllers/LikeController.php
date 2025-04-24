<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //guardar un like
    public function store(Request $request, Post $post){
        
        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);

        return back()->with('success','Has dado like a la publicacion');
        //return back() redirige a la pagina anterior
    }

    //eliminar un like
    public function destroy(Request $request, Post $post){

        
        //$request es el objeto que contiene la peticion del usuario
        //user() es el modelo de usuario que se esta logueando
        //likes() es la relacion que tiene el modelo de usuario con el modelo de like ("esta dentro de user")
        //where('post_id', $post->id) es la condicion que se le pasa a la consulta para eliminar el like a la base de datos
        //delete() elimina el like de la base de datos
        $request->user()->likes()->where('post_id', $post->id)->delete();

        return back();  //redirige a la pagina anterior


    }
    



}
