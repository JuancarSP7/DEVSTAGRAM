<?php

namespace App\Http\Controllers;

use App\Models\Codigo;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        Codigo::create([
            'user_id' => Auth::id(),            // Usuario autenticado actual
            'post_id' => $post->id,             // ID del post asociado
            'lenguaje' => $request->lenguaje,   // Lenguaje seleccionado
            'codigo' => $request->codigo,       // Fragmento de código
        ]);

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
