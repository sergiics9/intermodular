<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\Usuario;

class Auth
{
    public static function attempt(array $credentials): bool
    {
        $email = $credentials['email'] ?? '';
        $password = $credentials['password'] ?? '';
        $u = Usuario::where('email', $email)->first();

        if ($u && password_verify($password, $u->contraseña)) {
            session()->set('user', [
                'id' => $u->id,
                'nombre' => $u->nombre,
                'email' => $u->email,
                'telefono' => $u->telefono,
                'role' => $u->role,
            ]);
            return true;
        }
        return false;
    }

    public static function user(): ?array
    {
        return session()->get('user');
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function id(): ?int
    {
        $user = self::user(); // Obtener el usuario una vez
        return $user ? $user['id'] : null; // Verificar si no es null
    }

    public static function role(): ?int
    {
        $user = self::user(); // Obtener el usuario una vez

        // Depuración para verificar el valor del rol
        if ($user) {
            $role = (int)$user['role'];
            return $role;
        }
        return null;
    }

    public static function logout(): void
    {
        session()->invalidate();
    }
}
