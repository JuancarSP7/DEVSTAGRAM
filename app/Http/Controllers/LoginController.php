<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login'); //muestra el formulario de login
        //en el archivo login.blade.php
        //en el archivo web.php se define la ruta
    }

    public function store(Request $request){

        //validar los datos del formulario
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        

        //AUTENTICAR AL USUARIO
        if(!auth()->attempt( $request->only('email', 'password'), $request->remember )){ //intentamos autenticar al usuario
            return back()->with('mensaje', 'Error, credenciales incorrectas'); //si no se puede autenticar, redirige a la vista anterior con un mensaje de error
        }

        //REDIRECCIONAR
        return redirect()->route('post.index', auth()->user()->username); //redireccionamos a la ruta post.index (muro)
        //en el archivo web.php se define la ruta
        //en el archivo dashboard.blade.php se muestra el muro
        //en el archivo post.index se muestra el muro
        
        
    }









}
