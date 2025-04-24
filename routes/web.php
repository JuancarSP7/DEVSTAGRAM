<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class)->name('home'); //muestra la página principal, 
//como "HomeController solo tiene un metodo "__invoke" (que hace como un constructor) no hace falta nombrar el método ni el array

Route::get('/register', [RegisterController::class,'index'])->name('register'); //muestra el formulario de registro
Route::post('/register', [RegisterController::class,'store'])->name('register.store'); //envia el registro

Route::get('/login', [LoginController::class,'index'])->name('login'); //muestra el formulario de login
Route::post('/login', [LoginController::class,'store']); //envia el login
Route::post('/logout', [LogoutController::class,'store'])->name('logout'); //cierra la sesion

//rutas para el perfil
Route::get('/editar-perfil', [PerfilController::class,'index'])->name('perfil.index'); //muestra el formulario de editar perfil
Route::post('/editar-perfil', [PerfilController::class,'store'])->name('perfil.store');  //envia el formulario de editar perfil


Route::get('/posts/create', [PostController::class,'create'])->name('posts.create'); //muestra el formulario para crear un post
Route::post('/posts', [PostController::class,'store'])->name('posts.store'); //envia el post de la vista posts.create de un usuario
Route::get('/{user:username}/posts/{post}', [PostController::class,'show'])->name('posts.show'); //muestra el post con route model binding

Route::delete('/posts/{post}', [PostController::class,'destroy'])->name('posts.destroy'); //elimina el post de la vista posts.show de un usuario

Route::post('/{user:username}/posts/{post}', [ComentarioController::class,'store'])->name('comentarios.store'); //envia el comentario de la vista posts.show de un usuario


Route::post('/imagenes', [ImagenController::class,'store'])->name('imagenes.store'); //envia la imagen de la vista posts.create

//like a las fotos
Route::post('/posts/{post}/likes', [LikeController::class,'store'])->name('posts.likes.store'); 

//eliminar like a las fotos
Route::delete('/posts/{post}/likes', [LikeController::class,'destroy'])->name('posts.likes.destroy'); 



//siguiendo a un usuario
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow'); //envia el usuario a seguir
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow'); //elimina el usuario a seguir



Route::get('/buscar-usuarios', function (Request $request) {
    $query = $request->query('q');

    if (!$query) {
        return response()->json([]);
    }

    $usuarios = User::where('username', 'like', $query . '%')
                    ->where('id', '!=', auth()->id()) // Excluir usuario actual
                    ->limit(10)
                    ->get(['id', 'username', 'imagen']);

    return response()->json($usuarios);
})->middleware('auth')->name('buscar.usuarios');

Route::get('/{user:username}', [PostController::class,'index'])->name('post.index'); //muestra el muro con route model binding


