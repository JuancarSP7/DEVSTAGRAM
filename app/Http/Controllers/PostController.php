<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPostFromFollowingMail;

class PostController extends Controller
{
    public function __construct()
    {
        // El middleware 'auth' protege todas las rutas excepto 'show' e 'index'
        $this->middleware('auth')->except(['show', 'index']);
    }

    public function index(User $user)
    {
        // Obtiene los posts del usuario (para el muro)
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Validar datos del formulario
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required',
        ]);

        // Crea el post para el usuario autenticado
        $post = $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        // --- NOTIFICACIÓN A SEGUIDORES DEL USUARIO ---
        // Obtenemos la colección de seguidores del usuario autenticado (el que publica)
        $author = auth()->user();
        $seguidores = $author->followers;

        foreach ($seguidores as $follower) {
            // Solo enviamos email si el seguidor tiene email válido, no es el propio autor,
            // y no es un correo inventado tipo "@correo.com"
            if (
                $follower->email &&
                $follower->id !== $author->id &&
                filter_var($follower->email, FILTER_VALIDATE_EMAIL) &&
                !str_contains($follower->email, 'correo.com') // <--- Cambia aquí si usas otro dominio de prueba
            ) {
                // Envía el correo a cada follower válido usando el Mailable personalizado
                Mail::to($follower->email)->send(new NewPostFromFollowingMail($author, $post));
            }
        }
        // --- FIN NOTIFICACIÓN ---

        return redirect()->route('post.index', $author->username);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post); // Verifica si el usuario puede eliminar el post

        $post->delete();

        $imagen_path = public_path('uploads') . '/' . $post->imagen;
        if (File::exists($imagen_path)) {
            unlink($imagen_path);
        }

        return redirect()->route('post.index', auth()->user()->username);
    }
}
