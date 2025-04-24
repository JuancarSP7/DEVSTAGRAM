<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class PostController extends Controller{

    public function __construct(){ //el constructor se ejecuta al crear la instancia de la clase
        //el middleware se encarga de verificar si el usuario está autenticado
        $this->middleware('auth')->except(['show', 'index']);
        //except(['show', 'index']) indica que el middleware no se aplicará a los métodos show e index
        //el middleware auth se encarga de verificar si el usuario está autenticado
        //si el usuario no está autenticado, lo redirige a la ruta login
        //si no está autenticado, lo redirige a la ruta login
        //si está autenticado, lo deja pasar
    }

    public function index(User $user){

        $posts= Post::where('user_id', $user->id)->latest()->paginate(20); //obtiene todos los posts del usuario autenticado
        //el id del usuario autenticado se obtiene con auth()->user()->id
        //el id del usuario autenticado se guarda en la columna user_id de la tabla posts


        return view('dashboard', [   //muestra el muro, recordar que no hace falta poner la ruta completa porque ya estamos en la carpeta resources/views
            'user'=>$user,
            'posts'=>$posts //envia los posts a la vista dashboard
        ]);

    //en el archivo dashboard.blade.php
    //en el archivo web.php se define la ruta
    }

    public function create(){
        
        return view('posts.create');
    }

    public function store(Request $request){
        
        $this->validate($request,[
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required', //validar que el campo imagen sea una imagen y que no pese más de 2MB
        ]);
        //validar que el campo imagen sea requerido
        //el campo imagen es el nombre del input en el formulario
        //el campo titulo y descripcion son los nombres de los inputs en el formulario


        //1ª FORMA DE CREAR REGISTROS
        //permite crear registros en la base de datos son los "posts" de la tabla posts
        //el id del usuario autenticado se obtiene con auth()->user()->id
        //el id del usuario autenticado se guarda en la tabla posts
        //el id del usuario autenticado se guarda en la columna user_id de la tabla posts
        //Post::create([
        //  'titulo' => $request->titulo,
        //  'descripcion' => $request->descripcion,
        //  'imagen' => $request->imagen,
        //  'user_id' => auth()->user()->id //el id del usuario autenticado
        //]);


        //2ª FORMA DE CREAR REGISTROS
        //$post = new Post(); //crea una nueva instancia del modelo Post
        //el modelo Post es el que se encarga de interactuar con la tabla posts
        //$post->titulo = $request->titulo;   //asigna el valor del campo titulo del formulario al campo titulo de la tabla posts
        //$post->descripcion = $request->descripcion; //asigna el valor del campo descripcion del formulario al campo descripcion de la tabla posts
        //$post->imagen = $request->imagen;   //asigna el valor del campo imagen del formulario al campo imagen de la tabla posts
        //$post->user_id = auth()->user()->id; //asigna el id del usuario autenticado al campo user_id de la tabla posts
        //$post->save(); //guarda el registro en la base de datos


        //3ª FORMA DE CREAR REGISTROS
        $request->User()->posts()->create([ //crea un nuevo registro en la tabla posts
            'titulo' => $request->titulo, //asigna el valor del campo titulo del formulario al campo titulo de la tabla posts
            'descripcion' => $request->descripcion, //asigna el valor del campo descripcion del formulario al campo descripcion de la tabla posts
            'imagen' => $request->imagen,   //asigna el valor del campo imagen del formulario al campo imagen de la tabla posts
            'user_id' => auth()->User()->id //asigna el id del usuario autenticado al campo user_id de la tabla posts
        ]);


        return redirect()->route('post.index', auth()->user()->username); //redirecciona al muro del usuario autenticado
    }

    public function show(User $user, Post $post){

        return view('posts.show', [ //muestra el post
            'post'=> $post, //envia el post a la vista posts.show
            'user'=> $user //envia el usuario a la vista posts.show
        ]);  
    }

    public function destroy(Post $post){

        $this->authorize('delete', $post); //verifica si el usuario tiene permiso para eliminar el post
        //el permiso se verifica en la clase PostPolicy
        //la clase PostPolicy se encarga de verificar los permisos de los usuarios
        //la clase PostPolicy se encuentra en la carpeta app/Policies

        $post->delete(); //elimina el post

        $imagen_path = public_path('uploads').'/'.$post->imagen; //obtiene la ruta de la imagen

        if(File::exists($imagen_path)){ //verifica si la imagen existe
            unlink($imagen_path); //elimina la imagen
        }

        return redirect()->route('post.index', auth()->user()->username); //redirecciona al muro del usuario autenticado
    }

}
