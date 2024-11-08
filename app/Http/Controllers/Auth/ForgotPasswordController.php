<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        App::setLocale('es'); // Forzar el idioma español

        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('status', 'success');
            session()->flash('message', 'El enlace para restablecer tu contraseña ha sido enviado a tu correo.');
        } else {
            session()->flash('status', 'error');
            session()->flash('message', 'Hubo un problema al enviar el enlace. Verifica tu correo electrónico.');
        }

        return back();
    }
}
