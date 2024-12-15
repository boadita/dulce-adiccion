<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empleado;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');  // Crea esta vista para el formulario de login
    }

    public function login(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('nickname', 'password');

        if (Auth::attempt(['nickname' => $request->nickname, 'password' => $request->password])) {
            // Redirigir si la autenticación es exitosa
            return redirect()->intended('productos');
        }

        return back()->withErrors([
            'nickname' => 'Usuario incorrecto',
            'password' => 'Contraseña incorrecta',
        ]);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/login');
    }
}
