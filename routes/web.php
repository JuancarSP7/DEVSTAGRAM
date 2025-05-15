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
use App\Http\Controllers\CodigoController; // ✅ Importamos el controlador de código
use Illuminate\Http\Request;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Aquí se registran todas las rutas accesibles desde el navegador.
| Cada ruta está asociada a un controlador o closure.
*/

// Página principal (controlador HomeController con método __invoke)
Route::get('/', HomeController::class)->name('home');

// Registro de usuario
Route::get('/register', [RegisterController::class,'index'])->name('register'); // Muestra formulario
Route::post('/register', [RegisterController::class,'store'])->name('register.store'); // Procesa datos

// Login y logout
Route::get('/login', [LoginController::class,'index'])->name('login'); // Formulario login
Route::post('/login', [LoginController::class,'store']);               // Procesa login
Route::post('/logout', [LogoutController::class,'store'])->name('logout'); // Cierra sesión

// Editar perfil
Route::get('/editar-perfil', [PerfilController::class,'index'])->name('perfil.index'); // Formulario edición
Route::post('/editar-perfil', [PerfilController::class,'store'])->name('perfil.store'); // Guarda cambios

// Crear y ver posts
Route::get('/posts/create', [PostController::class,'create'])->name('posts.create'); // Formulario nuevo post
Route::post('/posts', [PostController::class,'store'])->name('posts.store');         // Guarda post
Route::get('/{user:username}/posts/{post}', [PostController::class,'show'])->name('posts.show'); // Ver detalle
Route::delete('/posts/{post}', [PostController::class,'destroy'])->name('posts.destroy');       // Eliminar post

// Comentar un post
Route::post('/{user:username}/posts/{post}', [ComentarioController::class,'store'])->name('comentarios.store'); // Añadir comentario

// 🔥 NUEVA RUTA: Eliminar comentario (requiere método destroy y política)
Route::delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');

// Subida de imágenes desde el editor de post (Dropzone)
Route::post('/imagenes', [ImagenController::class,'store'])->name('imagenes.store');

// Likes a los posts
Route::post('/posts/{post}/likes', [LikeController::class,'store'])->name('posts.likes.store');
Route::delete('/posts/{post}/likes', [LikeController::class,'destroy'])->name('posts.likes.destroy');

// Seguir y dejar de seguir a un usuario
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');

// 🔥 NUEVAS RUTAS: obtener seguidores y seguidos como JSON para modales
Route::get('/{user:username}/seguidores', [FollowerController::class, 'seguidores'])->name('users.seguidores');
Route::get('/{user:username}/seguidos', [FollowerController::class, 'seguidos'])->name('users.seguidos');

// Búsqueda de usuarios para el autocompletado en el header
Route::get('/buscar-usuarios', function (Request $request) {
    $query = $request->query('q');

    if (!$query) {
        return response()->json([]);
    }

    $usuarios = User::where('username', 'like', $query . '%')
                    ->where('id', '!=', auth()->id()) // Excluir al usuario actual
                    ->limit(10)
                    ->get(['id', 'username', 'imagen']);

    return response()->json($usuarios);
})->middleware('auth')->name('buscar.usuarios');

// ✅ NUEVAS RUTAS para compartir y eliminar fragmentos de código

// Almacenar código asociado a un post
Route::post('/posts/{post}/codigo', [CodigoController::class, 'store'])
    ->name('codigos.store')
    ->middleware('auth');

// Eliminar código compartido
Route::delete('/codigo/{codigo}', [CodigoController::class, 'destroy'])
    ->name('codigos.destroy')
    ->middleware('auth');

// Perfil del usuario con listado de sus publicaciones
Route::get('/{user:username}', [PostController::class,'index'])->name('post.index');
