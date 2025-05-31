<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cuenta eliminada en DevStagram</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f8fafc; color: #222;">
    <div style="max-width: 540px; margin: 40px auto; background: #fff; border-radius: 14px; padding: 2.5rem 2.2rem; box-shadow: 0 2px 16px #0002;">
        <!-- Logo DevStagram: coherente con el resto de correos -->
        <div style="text-align: center; margin-bottom: 2.2rem;">
            <a href="{{ url('/') }}" style="text-decoration:none;">
                <span style="font-size: 2.2rem; font-weight: bold; color: #2563eb; letter-spacing:1px;">Dev</span>
                <span style="font-size: 2.2rem; font-weight: bold; color: #111;">Stagram</span>
            </a>
        </div>

        <!-- Título principal del correo -->
        <h2 style="color:#2563eb; font-size: 1.35rem; text-align:center; margin-bottom:1.8rem;">
            Tu cuenta ha sido eliminada
        </h2>

        <!-- Mensaje principal de confirmación -->
        <p style="font-size: 1.1rem; margin-bottom: 2.3rem; text-align:center;">
            Lamentamos que hayas decidido darte de baja de 
            <span style="font-weight: bold; color:#2563eb;">DevStagram</span>.<br>
            Tu cuenta y todos tus datos han sido eliminados de forma permanente.
        </p>

        <!-- Mensaje secundario y de bienvenida futura -->
        <p style="text-align: center; color:#555; font-size: 1.01rem;">
            Si esto fue un error o deseas regresar,<br>
            eres siempre bienvenido a volver a nuestra comunidad.
        </p>

        <!-- Separador y pie automático -->
        <hr style="margin:2.2rem 0 1.1rem 0; border: none; border-top: 1.5px solid #e5e7eb;">
        <p style="font-size: 0.93rem; color: #888; text-align: center;">
            Este mensaje es automático, por favor no respondas a este correo.
        </p>
    </div>
</body>
</html>
