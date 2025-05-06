<?php

declare(strict_types=1);

namespace App\Http\Validators;

use App\Core\Request;
use App\Models\Usuario;

class RegisterValidator
{
    public static function validate(Request $request): void
    {
        $errors = [];

        // Obtener datos
        $nombre = $request->nombre ?? '';
        $email = $request->email ?? '';
        $password = $request->password ?? '';
        $password_confirm = $request->password_confirm ?? '';
        $terms = $request->terms ?? false;  // Verificar si el checkbox está marcado

        // Validación de nombre
        if (trim($nombre) === '') {
            $errors['nombre'] = 'El nombre de usuario es obligatorio.';
        }

        // Validaciones de email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Debe introducir un email válido';
        }

        if (Usuario::where('email', $email)->first()) {
            $errors['email'] = 'Este correo ya está registrado.';
        }

        // Validaciones de contraseña
        $password_valido = strlen($password) > 7 &&
            preg_match('/[a-z]/', $password) &&
            preg_match('/[A-Z]/', $password) &&
            preg_match('/[\W]/', $password);

        if (!$password_valido) {
            $errors['password'] = 'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un carácter especial.';
        }

        // Confirmación de contraseña
        if ($password !== $password_confirm) {
            $errors['password_confirm'] = 'Las contraseñas no coinciden.';
        }

        // Validación de términos y condiciones
        if (!$terms) {
            $errors['terms'] = 'Debe aceptar los términos y condiciones.';
        }

        // Si hay errores, redirigir con los mensajes
        if ($errors) {
            back()->withErrors($errors)->withInput([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'terms' => $request->terms
            ])->send();
        }
    }
}
