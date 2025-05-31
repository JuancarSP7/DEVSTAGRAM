<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo {{ $type }} en tu publicación</title>
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
            ¡Tienes un nuevo {{ $type === 'comentario' ? 'comentario' : 'código' }} en una de tus publicaciones!
        </h2>

        <p style="font-size: 1.09rem; margin-bottom: 1.7rem; text-align:center;">
            <span style="font-weight: bold; color:#2563eb;">{{ $author->username }}</span>
            <span style="color:#222; font-weight:500;">
                ha añadido un {{ $type === 'comentario' ? 'comentario' : 'fragmento de código' }} en tu post:
                <b>"{{ $post->titulo ?? 'Publicación' }}"</b>
            </span>
        </p>

        <div style="margin: 2.3rem 0 1.7rem 0; text-align: center;">
            <a href="{{ url('/' . $post->user->username . '/posts/' . $post->id) }}"
               style="background:#2563eb; color:#fff; text-decoration:none; padding:15px 30px; border-radius:8px; font-weight: bold; font-size:1.07rem; display:inline-block;">
                Ver publicación
            </a>
            <p style="font-size: 0.97rem; color: #666; margin-top:15px;">
                Si no tienes la sesión iniciada, inicia sesión para acceder.
            </p>
        </div>
        <hr style="margin:2.2rem 0 1.1rem 0; border: none; border-top: 1.5px solid #e5e7eb;">
        <p style="font-size: 0.93rem; color: #888; text-align: center;">
            Este mensaje es automático, por favor no respondas a este correo.
        </p>
    </div>
</body>
</html>
