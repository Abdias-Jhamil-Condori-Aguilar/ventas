<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('panel');
        }
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        // Intentar autenticar al usuario con las credenciales proporcionadas
        if (!Auth::attempt($request->only('email', 'password'))) {
            return redirect()->to('login')->withErrors('Credenciales incorrectas');
        }

        // Redirigir al panel con un mensaje de bienvenida
        return redirect()->route('panel')->with('success', 'Bienvenido ' . Auth::user()->name);
    }
}
