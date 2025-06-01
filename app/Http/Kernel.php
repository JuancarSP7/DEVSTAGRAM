<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Pila global de middlewares HTTP de la aplicación.
     *
     * Estos middlewares se ejecutan durante cada solicitud a tu aplicación.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * Grupos de middlewares de las rutas de la aplicación.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            // Middleware que cifra las cookies enviadas al cliente
            \App\Http\Middleware\EncryptCookies::class,
            // Middleware que añade cookies en cola a la respuesta
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            // Middleware que inicia la sesión
            \Illuminate\Session\Middleware\StartSession::class,
            // Comparte los errores de sesión con las vistas
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // Verifica el token CSRF en los formularios
            \App\Http\Middleware\VerifyCsrfToken::class,
            // Sustituye los enlaces de rutas por sus modelos correspondientes
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            // === Middleware de idioma ===
            // Este middleware aplica el idioma guardado en la sesión del usuario.
            \App\Http\Middleware\SetLocale::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            // Middleware que limita la cantidad de solicitudes a la API
            'throttle:api',
            // Sustituye los enlaces de rutas por sus modelos correspondientes
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Middlewares de ruta de la aplicación.
     *
     * Estos middlewares pueden asignarse a grupos o usarse individualmente.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        // Middleware de autenticación
        'auth' => \App\Http\Middleware\Authenticate::class,
        // Autenticación básica HTTP
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        // Autenticación de sesión
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        // Cabeceras de caché para las respuestas
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        // Autorización de acciones usando políticas
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        // Redirección si el usuario ya está autenticado
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        // Requiere confirmación de contraseña
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        // Valida la firma de la URL
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        // Limita la cantidad de solicitudes
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        // Verifica que el correo electrónico esté verificado
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
