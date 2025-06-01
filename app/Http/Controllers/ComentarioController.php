<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;
// 👇 Importa el Mailable y Mail
use App\Mail\NewCommentOrCodeMail;
use Illuminate\Support\Facades\Mail;

class ComentarioController extends Controller
{
    /**
     * Almacena un nuevo comentario en la base de datos.
     */
    public function store(Request $request, User $user, Post $post)
    {
        // Validar que el comentario no esté vacío y tenga máximo 255 caracteres
        $this->validate($request, [
            'comentario' => 'required|max:255',
        ]);

        // Crear el comentario asociado al usuario autenticado y al post
        $comentario = Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario,
        ]);

        // ENVIAR CORREO AL AUTOR DEL POST NOTIFICANDO EL NUEVO COMENTARIO
        // Solo se envía si el autor del post NO es el mismo usuario que comenta (para evitar autocorreo)
        if ($post->user_id !== auth()->id()) {
            Mail::to($post->user->email)
                ->send(new NewCommentOrCodeMail($post, auth()->user(), 'comentario'));
        }

        // Redirigir de vuelta al post con un mensaje de éxito
        return back()->with('mensaje', 'Comentario enviado correctamente');
    }

    /**
     * Elimina un comentario si pertenece al usuario autenticado.
     */
    public function destroy(Comentario $comentario)
    {
        // Verificar que el usuario autenticado es el autor del comentario
        if (auth()->id() !== $comentario->user_id) {
            abort(403, 'No estás autorizado para eliminar este comentario.');
        }

        // Eliminar el comentario
        $comentario->delete();

        // Redirigir de vuelta con mensaje de confirmación
        return back()->with('mensaje', 'Comentario eliminado correctamente.');
    }
}
