<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * Muestra el formulario para restablecer la contraseña (tras hacer clic en el enlace del correo).
     * El token llega desde el enlace enviado por correo.
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email // El email lo recoge de la URL
        ]);
    }

    /**
     * Actualiza la contraseña del usuario en la base de datos.
     */
    public function reset(Request $request)
    {
        // Validación de los campos del formulario
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email|exists:users,email',
            // Min:6 → Coincide con el registro. Confirmed → debe coincidir el campo de confirmación.
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        // Intenta resetear la contraseña usando el broker de Password de Laravel
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Cambia la contraseña y la guarda hasheada
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        // Dependiendo del resultado, redirige con mensaje de éxito o error
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
