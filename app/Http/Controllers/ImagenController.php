<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller{

    public function store(Request $request){

        $imagen = $request->file('file'); //obtenemos la imagen del formulario

        $nombreImagen = Str::uuid() . "." . $imagen->extension(); //creamos un nombre unico para la imagen
        //el nombre de la imagen es un uuid y la extension es la misma que la de la imagen original
        //ejemplo: 12345678-1234-1234-1234-123456789012.jpg
        //el uuid es un identificador unico universal
        //la extension es la misma que la de la imagen original

        $imagenServidor = Image::make($imagen); //creamos una instancia de la imagen
        $imagenServidor->fit(1000, 1000); //la imagen se redimensiona a 1000x1000 lo hace Intervention Image

        $imagenPath = public_path('uploads') . '/' . $nombreImagen; //creamos la ruta que se encuentra en public/uploads y le añade / y el nombre de la imagen
        $imagenServidor->save($imagenPath); //guardamos la imagen en la ruta creada anteriormente en la ruta public/uploads


        return response()->json(['imagen' => "$nombreImagen" ]); //retornamos el nombre de la imagen en formato json con el uuid y la extension
        
    }
    
}
