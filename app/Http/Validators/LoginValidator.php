<?php

declare(strict_types=1);

namespace App\Http\Validators;

use App\Core\Request;

class LoginValidator
{

    public static function validate(Request $request): void
    {
        $errors = [];

        $email = $request->email ?? '';
        $password = $request->password ?? '';

        $email_valido = filter_var($email, FILTER_VALIDATE_EMAIL);
        $password_valido = strlen($password) > 7 &&
            preg_match('/[a-z]/', $password) &&
            preg_match('/[A-Z]/', $password) &&
            preg_match('/[\W]/', $password);

        if (!$email_valido) {
            $errors['email'] = 'Debe introducir un email válido';
        }

        if (!$password_valido) {
            $errors['password'] = 'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un carácter especial.';
        }

        if ($errors) {
            back()->withErrors($errors)->withInput([
                'email' => $request->email,
            ])->send();
        }
    }
}
