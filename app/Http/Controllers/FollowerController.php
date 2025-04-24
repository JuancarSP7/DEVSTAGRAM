<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(User $user){

        //agregamos el id del usuario autenticado a la tabla followers
        $user->followers()->attach( auth()->user()->id ); 
        
        //redireccionamos al muro del usuario y le enviamos un mensaje
        return back(); 
    }

    public function destroy(User $user){

        //agregamos el id del usuario autenticado a la tabla followers
        $user->followers()->detach( auth()->user()->id ); 
        
        //redireccionamos al muro del usuario y le enviamos un mensaje
        return back(); 
    }

}
