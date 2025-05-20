<?php


namespace App\Http\Controllers;

require_once __DIR__ . '/../../Models/Usuario.php';

use App\Models\Usuario;
use App\Core\Auth;

class UsuarioController
{
    // Mostrar perfil
    public function perfil()
    {
        $usuario = Auth::user();
        view('usuarios.perfil', compact('usuario'));
    }

    // Actualizar perfil
    public function actualizarPerfil($request)
    {
        $usuario = Usuario::find(Auth::id());
        $errores = [];

        // Validaciones básicas
        if (empty(trim($request->nombre))) $errores['nombre'] = 'El nombre es obligatorio.';
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) $errores['email'] = 'Email inválido.';
        if (empty(trim($request->telefono))) $errores['telefono'] = 'El teléfono es obligatorio.';

        if ($errores) {
            back()->withErrors($errores)->withInput([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'telefono' => $request->telefono
            ])->send();
        }

        // Actualizar datos
        $usuario->nombre = trim($request->nombre);
        $usuario->email = trim($request->email);
        $usuario->telefono = trim($request->telefono);

        // Cambiar contraseña si se indica
        if (!empty($request->password)) {
            if (strlen($request->password) < 8) {
                back()->withErrors(['password' => 'La contraseña debe tener al menos 8 caracteres.'])->send();
            }
            $usuario->contraseña = password_hash($request->password, PASSWORD_DEFAULT);
        }

        // Subida de foto
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            // Asegurar que la carpeta existe
            $carpeta = __DIR__ . '/../../../public/images/perfiles/';
            if (!is_dir($carpeta)) {
                mkdir($carpeta, 0777, true);
            }

            // Usar el ID del usuario como nombre de archivo
            $filename = $usuario->id . '.webp';
            $destino = $carpeta . $filename;

            // Mover el archivo subido
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                $usuario->foto = '/images/perfiles/' . $filename;
            }
        }

        $usuario->save();

        // Obtener el usuario actualizado de la base de datos
        $usuarioActualizado = Usuario::find($usuario->id);

        // Actualizar sesión con todos los datos, incluida la foto
        session()->set('user', [
            'id' => $usuarioActualizado->id,
            'nombre' => $usuarioActualizado->nombre,
            'email' => $usuarioActualizado->email,
            'telefono' => $usuarioActualizado->telefono,
            'role' => $usuarioActualizado->role,
            'foto' => $usuarioActualizado->foto ?? null,
        ]);

        redirect('/usuarios/perfil.php')->with('success', 'Perfil actualizado correctamente')->send();
    }
}
