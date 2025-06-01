<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recupera tu contraseña - DevStagram</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f8fafc; color: #222;">

    {{-- Asegura que $count SIEMPRE está definido, así nunca falla la plantilla --}}
    @php
        if (!isset($count)) {
            $count = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');
        }
    @endphp

    <div style="max-width: 520px; margin: 40px auto; background: #fff; border-radius: 14px; padding: 2.5rem 2rem; box-shadow: 0 2px 16px #0002;">
        <!-- Logo DevStagram -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <a href="{{ url('/') }}" style="text-decoration:none;">
                <span style="font-size: 2.2rem; font-weight: bold; color: #2563eb;">Dev</span>
                <span style="font-size: 2.2rem; font-weight: bold; color: #111;">Stagram</span>
            </a>
        </div>

        <h2 style="color:#2563eb; font-size: 1.4rem; text-align:center; margin-bottom:1.5rem;">
            Solicitud para restablecer contraseña
        </h2>

        <p style="font-size: 1.1rem; text-align: center;">
            Hola,<br>
            Recibimos una solicitud para restablecer la contraseña de tu cuenta en <strong>DevStagram</strong>.
        </p>

        <div style="margin: 2.1rem 0; text-align: center;">
            {{-- Botón de restablecer contraseña, usa actionUrl y actionText --}}
            <a href="{{ $actionUrl }}"
               style="background:#2563eb; color:#fff; text-decoration:none; padding:13px 26px; border-radius:7px; font-weight:bold; font-size:1.07rem; display:inline-block;">
                {{ $actionText ?? 'Restablecer contraseña' }}
            </a>
            <p style="font-size: 0.95rem; color: #666; margin-top:13px;">
                Este enlace caduca en {{ $count }} minutos.
            </p>
        </div>

        <p style="text-align: center; color:#555; font-size: 1.01rem; margin-bottom:1.7rem;">
            Si no has solicitado este cambio, ignora este correo.
        </p>

        <hr style="margin:2.2rem 0 1.1rem 0; border: none; border-top: 1.5px solid #e5e7eb;">
        <p style="font-size: 0.93rem; color: #888; text-align: center;">
            Este mensaje es automático, por favor no respondas a este correo.
        </p>
    </div>
</body>
</html>
