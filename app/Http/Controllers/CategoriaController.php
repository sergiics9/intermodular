<?php

declare(strict_types=1);

namespace App\Http\Controllers;

require_once __DIR__ . '/../../Models/Categoria.php';
require_once __DIR__ . '/../../Models/Producto.php';

use App\Core\Request;
use App\Core\Auth;
use App\Models\Categoria;
use App\Models\Producto;
use App\Core\DB;

class CategoriaController
{
    public function index()
    {
        // Obtener todas las categorías
        $categorias = Categoria::all();

        // Para cada categoría, obtener la cantidad de productos
        foreach ($categorias as $categoria) {
            $sql = "SELECT COUNT(*) as cantidad FROM productos WHERE categoria_id = ?";
            $result = DB::selectAssoc($sql, [$categoria->id]);
            $categoria->cantidad_productos = isset($result[0]['cantidad']) ? (int)$result[0]['cantidad'] : 0;
        }

        view('categorias.index', compact('categorias'));
    }

    public function show(int $id)
    {
        $categoria = Categoria::findOrFail($id);

        // Obtener parámetros de ordenación
        $sortBy = $_GET['sort'] ?? 'newest';

        // Construir la consulta SQL base
        $sql = "SELECT * FROM productos WHERE categoria_id = ?";
        $params = [$id];

        // Añadir cláusula ORDER BY según el criterio de ordenación
        switch ($sortBy) {
            case 'price_asc':
                $sql .= " ORDER BY precio ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY precio DESC";
                break;
            case 'name_asc':
                $sql .= " ORDER BY nombre ASC";
                break;
            case 'name_desc':
                $sql .= " ORDER BY nombre DESC";
                break;
            case 'newest':
            default:
                $sql .= " ORDER BY id DESC";
                break;
        }

        // Ejecutar la consulta
        $productos = DB::select(Producto::class, $sql, $params);

        view('categorias.show', compact('categoria', 'productos', 'sortBy'));
    }

    public function create()
    {
        // Verificar permisos de administrador
        if (!Auth::check() || Auth::role() !== 1) {
            http_response_code(403);
            view('errors.403');
            exit;
        }

        view('categorias.create');
    }

    public function store(Request $request)
    {
        // Verificar permisos de administrador
        if (!Auth::check() || Auth::role() !== 1) {
            http_response_code(403);
            view('errors.403');
            exit;
        }

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();

        redirect('/categorias/index.php')->with('success', 'Categoría creada con éxito')->send();
    }

    public function edit(int $id)
    {
        // Verificar permisos de administrador
        if (!Auth::check() || Auth::role() !== 1) {
            http_response_code(403);
            view('errors.403');
            exit;
        }

        $categoria = Categoria::findOrFail($id);
        view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request)
    {
        // Verificar permisos de administrador
        if (!Auth::check() || Auth::role() !== 1) {
            http_response_code(403);
            view('errors.403');
            exit;
        }

        $categoria = Categoria::findOrFail((int)$request->id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();

        redirect('/categorias/index.php')->with('success', 'Categoría actualizada con éxito')->send();
    }

    public function destroy(int $id)
    {
        // Verificar permisos de administrador
        if (!Auth::check() || Auth::role() !== 1) {
            http_response_code(403);
            view('errors.403');
            exit;
        }

        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        redirect('/categorias/index.php')->with('success', 'Categoría eliminada con éxito')->send();
    }
}
