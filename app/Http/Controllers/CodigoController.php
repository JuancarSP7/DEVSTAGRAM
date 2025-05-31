<?php

namespace App\Http\Controllers;

use App\Models\Codigo;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// 👇 Importa el Mailable y Mail
use App\Mail\NewCommentOrCodeMail;
use Illuminate\Support\Facades\Mail;

class CodigoController extends Controller
{
    /**
     * Guarda un nuevo código asociado a un post.
     */
    public function store(Request $request, Post $post)
    {
        // Validamos los datos del formulario
        $request->validate([
            'lenguaje' => 'required|string|max:50',
            'codigo' => 'required|string|max:1000',
        ]);

        // Guardamos el código en la base de datos
        $codigo = Codigo::create([
            'user_id' => Auth::id(),            // Usuario autenticado actual
            'post_id' => $post->id,             // ID del post asociado
            'lenguaje' => $request->lenguaje,   // Lenguaje seleccionado
            'codigo' => $request->codigo,       // Fragmento de código
        ]);

        // ENVIAR CORREO AL AUTOR DEL POST NOTIFICANDO EL NUEVO CÓDIGO
        // Solo se envía si el autor del post NO es el mismo usuario que añade el código
        if ($post->user_id !== Auth::id()) {
            Mail::to($post->user->email)
                ->send(new NewCommentOrCodeMail($post, Auth::user(), 'código'));
        }

        // Redireccionamos con mensaje de éxito
        return back()->with('mensaje', 'Código compartido correctamente.');
    }

    /**
     * Elimina un código si pertenece al usuario autenticado.
     */
    public function destroy(Codigo $codigo)
    {
        // Verificamos que el usuario sea el autor del código
        if ($codigo->user_id !== Auth::id()) {
            abort(403); // Acceso no autorizado
        }

        // Eliminamos el código
        $codigo->delete();

        // Redireccionamos con mensaje de confirmación
        return back()->with('mensaje', 'Código eliminado correctamente.');
    }
}
