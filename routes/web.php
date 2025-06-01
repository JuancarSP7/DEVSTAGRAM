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
use App\Http\Controllers\CodigoController;
use Illuminate\Http\Request;
use App\Models\User;
// 👉 Añade el controlador para la baja:
use App\Http\Controllers\DeleteAccountController;

// 👉 Añade los controladores de recuperación de contraseña:
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

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

// 👉 RUTAS DARSE DE BAJA (nueva funcionalidad)
Route::get('/perfil/baja', [DeleteAccountController::class, 'show'])
    ->middleware('auth')->name('perfil.baja'); // Mostrar confirmación de baja
Route::delete('/perfil/baja', [DeleteAccountController::class, 'destroy'])
    ->middleware('auth')->name('perfil.baja.destroy'); // Procesar baja y borrar cuenta

// 👉 RECUPERACIÓN DE CONTRASEÑA (Password Reset)
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->middleware('guest')->name('password.request'); // Formulario de email
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->middleware('guest')->name('password.email'); // Envía el email
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->middleware('guest')->name('password.reset'); // Formulario para nueva password
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->middleware('guest')->name('password.update'); // Actualiza la password

// Crear y ver posts
Route::get('/posts/create', [PostController::class,'create'])->middleware('auth')->name('posts.create'); // Formulario nuevo post
Route::post('/posts', [PostController::class,'store'])->middleware('auth')->name('posts.store');         // Guarda post

// Protege la ruta de detalle del post
Route::get('/{user:username}/posts/{post}', [PostController::class,'show'])->middleware('auth')->name('posts.show'); // Ver detalle
Route::delete('/posts/{post}', [PostController::class,'destroy'])->middleware('auth')->name('posts.destroy');       // Eliminar post

// Comentar un post
Route::post('/{user:username}/posts/{post}', [ComentarioController::class,'store'])->middleware('auth')->name('comentarios.store'); // Añadir comentario

// 🔥 NUEVA RUTA: Eliminar comentario (requiere método destroy y política)
Route::delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])->middleware('auth')->name('comentarios.destroy');

// Subida de imágenes desde el editor de post (Dropzone)
Route::post('/imagenes', [ImagenController::class,'store'])->middleware('auth')->name('imagenes.store');

// Likes a los posts
Route::post('/posts/{post}/likes', [LikeController::class,'store'])->middleware('auth')->name('posts.likes.store');
Route::delete('/posts/{post}/likes', [LikeController::class,'destroy'])->middleware('auth')->name('posts.likes.destroy');

// Seguir y dejar de seguir a un usuario
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->middleware('auth')->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->middleware('auth')->name('users.unfollow');

// 🔥 NUEVAS RUTAS: obtener seguidores y seguidos como JSON para modales
Route::get('/{user:username}/seguidores', [FollowerController::class, 'seguidores'])->middleware('auth')->name('users.seguidores');
Route::get('/{user:username}/seguidos', [FollowerController::class, 'seguidos'])->middleware('auth')->name('users.seguidos');

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

// NUEVAS RUTAS para compartir y eliminar fragmentos de código

// Almacenar código asociado a un post
Route::post('/posts/{post}/codigo', [CodigoController::class, 'store'])
    ->name('codigos.store')
    ->middleware('auth');

// Eliminar código compartido
Route::delete('/codigo/{codigo}', [CodigoController::class, 'destroy'])
    ->name('codigos.destroy')
    ->middleware('auth');

// Perfil del usuario con listado de sus publicaciones
Route::get('/{user:username}', [PostController::class,'index'])->middleware('auth')->name('post.index');

/*
|--------------------------------------------------------------------------
| RUTA PARA CAMBIAR EL IDIOMA (Mejorada)
|--------------------------------------------------------------------------
| Permite cambiar entre 'es' (español) y 'en' (inglés).
| Guarda el idioma en la sesión y redirige SIN caché a la página anterior
| para asegurar que las vistas y los textos JS usan el idioma correcto.
*/
Route::get('/lang/{locale}', function ($locale) {
    // Validar idiomas permitidos
    if (!in_array($locale, ['es', 'en'])) {
        abort(400); // Idioma no permitido, error 400
    }

    // Guardar el idioma en la sesión
    session(['locale' => $locale]);

    // Tomar la URL de donde viene el usuario
    $referer = url()->previous();

    // Redirigir a esa URL pero forzando que NO se use caché (importante para traducción instantánea JS)
    return redirect($referer)->withHeaders([
        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        'Pragma'        => 'no-cache',
    ]);
})->name('lang.switch');
