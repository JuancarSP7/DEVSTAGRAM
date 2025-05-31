<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
// Importación añadida para enviar correo de bienvenida
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller {
    public function index() {   //creamos el método llamado index
        return view('auth.register');   //hace referencia a resources/views/auth/register.blade.php (donde creamos la cuenta)
    }

    public function store(Request $request) { //creamos el método llamado store

        //MODIFICAR EL request
        $request->request->add(['username' => Str::slug($request->username)]); //convertimos el nombre de usuario a slug
        
        //validar los datos del formulario
        $this->validate($request, [
            'name' => 'required|string|min:3|max:30',
            'username' => 'required|string|min:3|max:30|unique:users',
            'email' => 'required|string|email|max:60|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        
        //si la validación es correcta, se crea el usuario
        //el método create() se encarga de crear el usuario en la base de datos
        //el método bcrypt() se encarga de encriptar la contraseña
        //el método unique() se encarga de verificar que el usuario y el email no existan en la base de datos
        //el método confirmed() se encarga de verificar que la contraseña y la confirmación de la contraseña sean iguales
        //el método validate() se encarga de validar los datos del formulario
        //el método request() se encarga de obtener los datos del formulario
        $user = User::create([
            'name' => $request->name,   //guardamos el campo nombre del archivo register.blade.php
            'username' => $request->username,   //guardamos el campo usuario del archivo register.blade.php
            'email' => $request->email, //guardamos el campo email del archivo register.blade.php
            'password' => bcrypt($request->password) //encriptamos el campo password del archivo register.blade.php
        ]);

        // ENVIAR CORREO DE BIENVENIDA AL USUARIO (mejora solicitada)
        // Usamos el Mailable WelcomeMail y enviamos el nombre de usuario
        Mail::to($user->email)->send(new WelcomeMail($user->username));

        //AUTENTICAR AL USUARIO
        //auth()->attempt([ //intentamos autenticar al usuario
        //    'email' => $request->email, //guardamos el campo email del archivo register.blade.php
        //   'password' => $request->password, //guardamos el campo password del archivo register.blade.php
        // ]);
        

        //OTRA FORMA DE AUTENTICAR AL USUARIO
        auth()->attempt($request->only('email', 'password')); //intentamos autenticar al usuario
        //auth()->attempt() se encarga de autenticar al usuario
        



        //REDIRECCIONAR AL USUARIO
        //si la autenticación es correcta, se redirige al usuario a la ruta post.index (muro)
        //el método route() se encarga de redirigir al usuario a la ruta especificada
        //el método redirect() se encarga de redirigir al usuario a la ruta especificada
        //return redirect()->route('post.index'); //redireccionamos a la ruta post.index (muro)
        return redirect()->route('post.index', auth()->user()->username);
            


    }
}
