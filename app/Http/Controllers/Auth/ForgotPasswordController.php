<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Muestra el formulario para solicitar un enlace de restablecimiento de contraseña.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email'); // La vista que te paso después
    }

    /**
     * Envía el enlace de restablecimiento de contraseña al correo indicado.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'No existe ningún usuario registrado con ese correo.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}
