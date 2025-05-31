<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Líneas de idioma para autenticación
    |--------------------------------------------------------------------------
    |
    | Aquí puedes definir todos los mensajes que se mostrarán relacionados
    | con la autenticación (login, logout, errores, etc.) en tu aplicación.
    | Personalízalos según el tono y estilo de tu proyecto.
    |
    */

    'failed'   => 'Las credenciales introducidas son incorrectas.', // Cuando los datos de acceso no coinciden
    'password' => 'La contraseña es incorrecta.',                   // Contraseña incorrecta
    'throttle' => 'Demasiados intentos de acceso. Inténtalo de nuevo en :seconds segundos.', // Protección contra fuerza bruta

    // Mensajes adicionales recomendados
    'login'    => 'Iniciar sesión',
    'logout'   => 'Cerrar sesión',
    'register' => 'Registrarse',
    'email'    => 'Correo electrónico',
    'remember' => 'Recordarme',
    'forgot_password' => '¿Olvidaste tu contraseña?',
    'reset_password'  => 'Restablecer contraseña',
    'send_reset_link' => 'Enviar enlace de restablecimiento',
    'confirm_password' => 'Confirmar contraseña',
    'name'     => 'Nombre de usuario',

    // Para mensajes personalizados o botones en vistas
    'verify_email'     => 'Verifica tu correo electrónico',
    'verification_link_sent' => 'Se ha enviado un nuevo enlace de verificación a tu correo electrónico.',
    'check_email_verification' => 'Antes de continuar, revisa tu correo electrónico para el enlace de verificación.',
    'not_receive_email' => 'Si no recibiste el correo,',
    'request_another'   => 'haz clic aquí para solicitar otro',

    //para reestablecer contraseña ("email.blade.php")
    'recover_password_page_title' => 'Recuperar contraseña',
    'recover_password_title' => 'Recupera tu contraseña',
    'email' => 'Correo electrónico',
    'email_placeholder' => 'Tu correo registrado',
    'send_reset_link' => 'Enviar enlace de recuperación',
];
