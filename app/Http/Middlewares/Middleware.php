<?php

namespace App\Http\Middlewares;

use App\Core\Auth;

class Middleware
{
    public static function auth(): void
    {
        if (!Auth::check()) {
            redirect('/auth/show-login.php')->with('error', 'Acceso no autorizado.')->send();
        }
    }

    public static function role(array $roles): void
    {
        self::auth();

        // Depuración para verificar el rol del usuario
        $userRole = Auth::role();

        if (!in_array($userRole, $roles)) {
            http_response_code(403);
            view('errors.403');
            exit;
        }
    }
}
