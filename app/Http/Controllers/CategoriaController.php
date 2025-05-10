<?php

declare(strict_types=1);

namespace App\Http\Controllers;

require_once __DIR__ . '/../../Models/Categoria.php';
require_once __DIR__ . '/../../Models/Producto.php';

use App\Core\Request;
use App\Core\Auth;
use App\Models\Categoria;
use App\Models\Producto;

class CategoriaController
{
    public function index()
    {
        $categorias = Categoria::all();

        // Para cada categoría, obtener la cantidad de productos
        foreach ($categorias as $categoria) {
            $categoria->cantidad_productos = Producto::where('categoria_id', $categoria->id)->count();
        }

        view('categorias.index', compact('categorias'));
    }

    public function show(int $id)
    {
        $categoria = Categoria::findOrFail($id);
        $productos = Producto::where('categoria_id', $id)->get();

        view('categorias.show', compact('categoria', 'productos'));
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

        // Validar datos
        if (empty(trim($request->nombre))) {
            back()->withErrors(['nombre' => 'El nombre de la categoría es obligatorio'])
                ->withInput(['nombre' => $request->nombre])
                ->send();
        }

        // Verificar si ya existe una categoría con ese nombre
        if (Categoria::where('nombre', trim($request->nombre))->first()) {
            back()->withErrors(['nombre' => 'Ya existe una categoría con ese nombre'])
                ->withInput(['nombre' => $request->nombre])
                ->send();
        }

        // Crear y guardar la categoría
        $categoria = new Categoria();
        $categoria->nombre = trim($request->nombre);
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

        // Validar datos
        if (empty(trim($request->nombre))) {
            back()->withErrors(['nombre' => 'El nombre de la categoría es obligatorio'])
                ->withInput(['nombre' => $request->nombre])
                ->send();
        }

        $categoria = Categoria::findOrFail((int)$request->id);

        // Verificar si ya existe otra categoría con ese nombre
        $existente = Categoria::where('nombre', trim($request->nombre))->first();
        if ($existente && $existente->id !== $categoria->id) {
            back()->withErrors(['nombre' => 'Ya existe otra categoría con ese nombre'])
                ->withInput(['nombre' => $request->nombre])
                ->send();
        }

        // Actualizar y guardar la categoría
        $categoria->nombre = trim($request->nombre);
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

        // Verificar si hay productos asociados a esta categoría
        $productos = Producto::where('categoria_id', $id)->get();
        if (count($productos) > 0) {
            back()->with('error', 'No se puede eliminar la categoría porque tiene productos asociados')->send();
        }

        // Eliminar la categoría
        $categoria->delete();

        redirect('/categorias/index.php')->with('success', 'Categoría eliminada con éxito')->send();
    }
}
