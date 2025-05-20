<?php

namespace App\Core;

use App\Models\Usuario;

class Auth
{
    public static function attempt(array $credentials): bool
    {
        $email = $credentials['email'];
        $password = $credentials['password'];

        $user = Usuario::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->contraseña)) {
            return false;
        }

        // Guardar usuario en sesión con todos sus datos, incluida la foto
        session()->set('user', [
            'id' => $user->id,
            'nombre' => $user->nombre,
            'email' => $user->email,
            'telefono' => $user->telefono,
            'role' => $user->role,
            'foto' => $user->foto ?? null,
        ]);

        return true;
    }

    public static function check(): bool
    {
        return session()->has('user');
    }

    public static function user(): ?array
    {
        return session()->get('user');
    }

    public static function id(): ?int
    {
        return self::user()['id'] ?? null;
    }

    public static function role(): ?int
    {
        return self::user()['role'] ?? null;
    }

    public static function logout(): void
    {
        session()->remove('user');
    }
}
