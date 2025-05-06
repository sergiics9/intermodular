<?php

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\Models\Usuario;

class AuthController
{


    public function showLoginForm(): void
    {
        view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            redirect('/peliculas/index.php')->send();
        }

        back()->with('error', 'Credenciales incorrectas')->send();
    }

    public function showRegisterForm(): void
    {
        view('auth.register');
    }

    public function register(Request $request)
    {
        $u = new Usuario();
        $u->nombre = trim($request->nombre);
        $u->email = trim($request->email);
        $u->password = password_hash($request->password, PASSWORD_DEFAULT);
        $u->role = 'user';
        $u->save();

        session()->set('user', [
            'id' => $u->id,
            'nombre' => $u->nombre,
            'email' => $u->email,
            'role' => $u->role,
        ]);

        redirect('/peliculas/index.php')->with('success', "¡Bienvenido, $u->nombre!")->send();
    }

    public function logout()
    {
        Auth::logout();
        redirect('/auth/show-login.php')->send();
    }
}
