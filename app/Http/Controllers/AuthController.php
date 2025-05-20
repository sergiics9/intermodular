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

        // Procesar la foto de perfil si se ha subido
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $carpeta = __DIR__ . '/../../../public/images/perfiles/';
            if (!is_dir($carpeta)) {
                mkdir($carpeta, 0777, true);
            }

            // Primero guardamos el usuario para obtener su ID
            $u->save();

            // Usar el ID del usuario como nombre de archivo
            $filename = $u->id . '.webp';
            $destino = $carpeta . $filename;

            // Mover el archivo subido
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                $u->foto = '/images/perfiles/' . $filename;
                // Guardar nuevamente para actualizar la foto
                $u->save();
            }
        } else {
            // Si no hay foto, simplemente guardamos el usuario
            $u->save();
        }

        // Obtener el usuario completo de la base de datos para asegurarnos de tener todos los datos
        $usuario = Usuario::find($u->id);

        session()->set('user', [
            'id' => $usuario->id,
            'nombre' => $usuario->nombre,
            'email' => $usuario->email,
            'telefono' => $usuario->telefono,
            'role' => $usuario->role,
            'foto' => $usuario->foto ?? null,
        ]);

        redirect('/productos/index.php')->with('success', "¡Bienvenido, $usuario->nombre!")->send();
    }

    public function logout()
    {
        Auth::logout();
        redirect('/auth/show-login.php')->send();
    }
}
