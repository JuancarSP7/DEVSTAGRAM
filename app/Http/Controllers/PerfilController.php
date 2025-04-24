<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    


    public function index(){
        
        return view('perfil.index');
    }

    public function store(Request $request){

        //Modificar el Request para que solo se pueda modificar el username
        $request->request->add(['username' => Str::slug($request->username)]); //agrega el username al request'

        //esto es para validar el username
        $this->validate($request, [
            'username' => ['required', 'unique:users,username,' .auth()->user()->id, 'min:3', 'max:20', 'not_in:editar-perfil'],
        ]);

        if($request->imagen) {
            $imagen = $request->file('imagen'); //obtenemos la imagen del formulario

            $nombreImagen = Str::uuid() . "." . $imagen->extension(); //creamos un nombre unico para la imagen
            //el nombre de la imagen es un uuid y la extension es la misma que la de la imagen original
            //ejemplo: 12345678-1234-1234-1234-123456789012.jpg
            //el uuid es un identificador unico universal
            //la extension es la misma que la de la imagen original

            $imagenServidor = Image::make($imagen); //creamos una instancia de la imagen
            $imagenServidor->fit(1000, 1000); //la imagen se redimensiona a 1000x1000 lo hace Intervention Image

            $imagenPath = public_path('perfiles') . '/' . $nombreImagen; //creamos la ruta que se encuentra en public/uploads y le añade / y el nombre de la imagen
            $imagenServidor->save($imagenPath); //guardamos la imagen en la ruta creada anteriormente en la ruta public/uploads
        }

        //Guardar cambios en el perfil del usuario
        $usuario = User::find(auth()->user()->id); //buscamos el usuario autenticado
        $usuario->username = $request->username; //asignamos el username al usuario
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null; //asignamos la imagen al usuario, si no hay imagen se asigna la imagen del usuario autenticado
        $usuario->save(); //guardamos el usuario

        //Redireccionar al usuario
        return redirect()->route('post.index', $usuario->username); //redireccionamos al muro del usuario




    }
}
