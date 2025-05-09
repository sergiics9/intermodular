<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\Models\Comentario;
use App\Models\Producto;

class ComentarioController
{
    public function store(Request $request)
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            redirect('/auth/show-login.php')->with('error', 'Debes iniciar sesión para comentar')->send();
        }

        // Validar datos
        if (empty(trim($request->texto))) {
            back()->with('error', 'El comentario no puede estar vacío')->send();
        }

        // Verificar que el producto existe
        $producto = Producto::find((int)$request->producto_id);
        if (!$producto) {
            back()->with('error', 'El producto no existe')->send();
        }

        // Crear y guardar el comentario
        $comentario = new Comentario();
        $comentario->producto_id = (int)$request->producto_id;
        $comentario->usuario_id = Auth::id();
        $comentario->texto = htmlspecialchars(trim($request->texto));
        $comentario->fecha = date('Y-m-d H:i:s'); // Añadir esta línea para establecer la fecha actual
        $comentario->save();

        // Redireccionar de vuelta a la página del producto
        redirect('/productos/show.php?id=' . $request->producto_id)
            ->with('success', 'Comentario añadido correctamente')
            ->send();
    }

    public function destroy(Request $request)
    {
        // Verificar que el usuario esté autenticado y sea administrador
        if (!Auth::check() || Auth::role() !== 1) {
            redirect('/productos/index.php')->with('error', 'No tienes permisos para realizar esta acción')->send();
        }

        // Obtener el comentario
        $comentario = Comentario::find((int)$request->id);
        if (!$comentario) {
            back()->with('error', 'El comentario no existe')->send();
        }

        // Guardar el ID del producto para redireccionar después
        $productoId = $comentario->producto_id;

        // Eliminar el comentario
        $comentario->delete();

        // Redireccionar de vuelta a la página del producto
        redirect('/productos/show.php?id=' . $productoId)
            ->with('success', 'Comentario eliminado correctamente')
            ->send();
    }
}
