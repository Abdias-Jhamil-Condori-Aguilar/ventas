<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session; // Cambia el uso de Illuminate\Contracts\Session\Session a Illuminate\Support\Facades\Session
use Illuminate\Support\Facades\Auth;

class logoutController extends Controller
{
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('login');
    }
}
