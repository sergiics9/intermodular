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
            $nombre = Auth::user()['nombre'];
            redirect('/productos/index.php')->with('success', "Bienvenido, $nombre")->send();
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
        $u->telefono = trim($request->telefono);
        $u->contraseña = password_hash($request->password, PASSWORD_DEFAULT);
        $u->role = 0; // Usuario regular por defecto
        $u->ip_registro = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $u->save();

        session()->set('user', [
            'id' => $u->id,
            'nombre' => $u->nombre,
            'email' => $u->email,
            'telefono' => $u->telefono,
            'role' => $u->role,
        ]);

        redirect('/productos/index.php')->with('success', "¡Bienvenido, $u->nombre!")->send();
    }

    public function logout()
    {
        Auth::logout();
        redirect('/auth/show-login.php')->send();
    }
}
