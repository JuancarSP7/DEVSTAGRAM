<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
// 👇 Importa el Mailable y Mail
use App\Mail\NewFollowerMail;
use Illuminate\Support\Facades\Mail;

class FollowerController extends Controller
{
    /**
     * Permite al usuario autenticado seguir a otro usuario.
     */
    public function store(User $user)
    {
        // Añade al usuario autenticado como seguidor del usuario recibido
        $user->followers()->attach(auth()->user()->id);

        // ENVIAR CORREO AL USUARIO QUE GANA UN NUEVO SEGUIDOR
        // $follower es el usuario autenticado (quien sigue)
        // $user es el usuario que recibe el seguimiento
        Mail::to($user->email)->send(new NewFollowerMail(auth()->user()));

        return back(); // Redirecciona a la vista anterior (perfil, por ejemplo)
    }

    /**
     * Permite al usuario autenticado dejar de seguir a otro usuario.
     */
    public function destroy(User $user)
    {
        // Elimina al usuario autenticado como seguidor del usuario recibido
        $user->followers()->detach(auth()->user()->id);

        return back(); // Redirecciona a la vista anterior
    }

    /**
     * Devuelve en formato JSON la lista de seguidores de un usuario.
     * Usado para mostrar en el modal al hacer clic en "Seguidores".
     */
    public function seguidores(User $user)
    {
        // Especificamos "users." para evitar ambigüedad en la consulta SQL
        $seguidores = $user->followers()->select('users.id', 'users.username', 'users.imagen')->get();

        return response()->json($seguidores);
    }

    /**
     * Devuelve en formato JSON la lista de usuarios que este usuario sigue.
     * Usado para mostrar en el modal al hacer clic en "Siguiendo".
     */
    public function seguidos(User $user)
    {
        // También usamos "users." para evitar conflictos al hacer joins
        $seguidos = $user->followings()->select('users.id', 'users.username', 'users.imagen')->get();

        return response()->json($seguidos);
    }
}
