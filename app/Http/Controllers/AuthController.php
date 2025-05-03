<?php

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Auth;

class AuthController {


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

        back()->with('message', 'Credenciales incorrectas')->send();
    }

    public function logout(){
        Auth::logout();
        redirect('/auth/show-login.php')->send();
    }
}