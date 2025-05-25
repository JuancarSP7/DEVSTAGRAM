<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Maneja la solicitud entrante y establece el idioma de la aplicación.
     */
    public function handle($request, Closure $next)
    {
        // Obtiene el idioma de la sesión, o usa 'es' (español) por defecto
        $locale = Session::get('locale', 'es');
        // Establece el idioma de la app en tiempo de ejecución
        App::setLocale($locale);

        // Continúa con la solicitud
        return $next($request);
    }
}
