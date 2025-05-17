<?php

if (!function_exists('formatear_urls')) {
    /**
     * Convierte URLs escritas en texto en enlaces clicables y seguros.
     */
    function formatear_urls($texto)
    {
        // Expresión regular para encontrar URLs completas y direcciones "www."
        $pattern = '~(https?://[^\s]+)|(www\.[^\s]+)~i';

        // Callback para reemplazo
        return preg_replace_callback($pattern, function ($matches) {
            $url = $matches[0];
            // Asegura el protocolo en enlaces tipo www.
            $href = (strpos($url, 'http') === 0) ? $url : "https://$url";
            // Clase para estilos azul y subrayado (Tailwind)
            return '<a href="' . $href . '" class="text-blue-600 underline hover:text-blue-800" target="_blank" rel="noopener noreferrer">' . $url . '</a>';
        }, e($texto));
    }
}
