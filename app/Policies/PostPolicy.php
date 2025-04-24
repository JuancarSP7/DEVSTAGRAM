<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id;
        //verifica si el id del usuario autenticado es igual al id del usuario que creó el post
        //si es igual, devuelve true y permite eliminar el post
        //si no es igual, devuelve false y no permite eliminar el post
        //el id del usuario autenticado se obtiene con auth()->user()->id
        //el id del usuario que creó el post se obtiene con $post->user_id
    }

    
}
