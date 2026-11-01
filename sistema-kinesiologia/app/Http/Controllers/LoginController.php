<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function formulario()
    {
        return view('auth.login');
    }

    public function ingresar(Request $request)
    {
        $datos = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $clave = Str::lower($datos['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($clave, 5)) {
            $segundos = RateLimiter::availableIn($clave);
            throw ValidationException::withMessages(['email' => "Demasiados intentos. Intente nuevamente en {$segundos} segundos."]);
        }

        if (Auth::attempt(['email' => $datos['email'], 'password' => $datos['password'], 'activo' => true], $request->boolean('recordar'))) {
            RateLimiter::clear($clave);
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($clave, 300);

        throw ValidationException::withMessages(['email' => 'Las credenciales no son correctas o el usuario está inactivo.']);
    }

    public function salir(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio');
    }
}
