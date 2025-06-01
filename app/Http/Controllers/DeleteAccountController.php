<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\AccountDeletedMail;
use Illuminate\Support\Facades\Mail;

class DeleteAccountController extends Controller
{
    /**
     * Muestra la página de confirmación de baja.
     */
    public function show()
    {
        // Retorna la vista de confirmación para eliminar la cuenta
        return view('perfil.delete_account');
    }

    /**
     * Procesa la baja de usuario: elimina todos los datos asociados,
     * envía el correo de confirmación y cierra la sesión.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();         // Usuario autenticado actual
        $email = $user->email;        // Guardamos el email antes de borrar el usuario

        // Ejecuta la eliminación en una transacción para máxima seguridad
        DB::transaction(function () use ($user) {
            // 1. Elimina todos los comentarios hechos por el usuario en cualquier post
            $user->comentarios()->delete();

            // 2. Elimina los posts del usuario y los comentarios asociados a cada post
            foreach ($user->posts as $post) {
                $post->comentarios()->delete();
                $post->delete();
            }

            // 3. Elimina los fragmentos de código del usuario si existe la relación
            if (method_exists($user, 'codigos')) {
                $user->codigos()->delete();
            }

            // 4. Puedes limpiar otras relaciones si es necesario (likes, seguidores, etc.)

            // 5. Elimina el usuario (siempre lo último)
            $user->delete();
        });

        // Envía correo de confirmación de baja solo si la transacción fue exitosa
        Mail::to($email)->send(new AccountDeletedMail());

        // Cierra sesión y redirige al login con mensaje
        Auth::logout();
        return redirect('/login')->with('mensaje', 'Tu cuenta ha sido eliminada correctamente.');
    }
}
