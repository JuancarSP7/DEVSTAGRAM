<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Bienvenido a DevStagram!</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f8fafc; color: #222;">
    <div style="max-width: 540px; margin: 40px auto; background: #fff; border-radius: 14px; padding: 2.5rem 2.2rem; box-shadow: 0 2px 16px #0002;">
        <!-- Logo DevStagram -->
        <div style="text-align: center; margin-bottom: 2.2rem;">
            <a href="{{ url('/') }}" style="text-decoration:none;">
                <span style="font-size: 2.2rem; font-weight: bold; color: #2563eb; letter-spacing:1px;">Dev</span><span style="font-size: 2.2rem; font-weight: bold; color: #111;">Stagram</span>
            </a>
        </div>

        <h2 style="color:#2563eb; font-size: 1.35rem; text-align:center; margin-bottom:1.8rem;">
            ¡Bienvenido, <span style="font-weight:bold; color:#2563eb;">{{ $username }}</span>!
        </h2>

        <p style="font-size: 1.1rem; margin-bottom: 2.3rem; text-align:center;">
            Gracias por registrarte en <strong>DevStagram</strong>, la comunidad de desarrolladores.<br>
            Ya puedes compartir tus posts, conectar con otros usuarios y mostrar tu talento.
        </p>

        <div style="margin: 2.3rem 0 1.7rem 0; text-align: center;">
            <a href="{{ url('/login') }}"
               style="background:#2563eb; color:#fff; text-decoration:none; padding:15px 30px; border-radius:8px; font-weight: bold; font-size:1.07rem; display:inline-block;">
                Accede a la app
            </a>
            <p style="font-size: 0.97rem; color: #666; margin-top:15px;">
                Si ya tienes sesión iniciada, irás directo a tu perfil.
            </p>
        </div>
        <hr style="margin:2.2rem 0 1.1rem 0; border: none; border-top: 1.5px solid #e5e7eb;">
        <p style="font-size: 0.93rem; color: #888; text-align: center;">
            Este mensaje es automático, por favor no respondas a este correo.
        </p>
    </div>
</body>
</html>
