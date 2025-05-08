<?php

declare(strict_types=1);

namespace App\Http\Controllers;

require_once __DIR__ . '/../../Models/Producto.php';
require_once __DIR__ . '/../../Models/Talla.php';
require_once __DIR__ . '/../../Models/Categoria.php';

use App\Core\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Talla;
use App\Core\DB;

class ProductoController
{
    public function index()
    {
        $productos = Producto::all();
        view('productos.index', compact('productos'));
    }

    public function show(int $id)
    {
        $producto = Producto::findOrFail($id);

        // Obtener tallas directamente de la base de datos
        $sql = "SELECT * FROM tallas WHERE id_producto = ?";
        $tallas = DB::selectAssoc($sql, [$producto->id]);

        // Obtener categoría directamente de la base de datos si existe
        $categoria = null;
        if ($producto->categoria_id) {
            $sql = "SELECT * FROM categorias WHERE id = ?";
            $categorias = DB::selectAssoc($sql, [$producto->categoria_id]);
            if (!empty($categorias)) {
                $categoria = (object) $categorias[0];
            }
        }

        view('productos.show', compact('producto', 'tallas', 'categoria'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->save();

        // Guardar tallas si existen
        if ($request->tallas && is_array($request->tallas)) {
            foreach ($request->tallas as $tallaValor) {
                $talla = new Talla();
                $talla->id_producto = $producto->id;
                $talla->tallas = $tallaValor;
                $talla->save();
            }
        }

        redirect('/productos/index.php')->with('success', 'Producto creado con éxito')->send();
    }

    public function edit(int $id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request)
    {
        $producto = Producto::findOrFail($request->id);
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->save();

        // Actualizar tallas (primero eliminar las existentes)
        $tallasActuales = Talla::where('id_producto', $producto->id)->get();
        foreach ($tallasActuales as $talla) {
            $talla->delete();
        }

        // Guardar nuevas tallas
        if ($request->tallas && is_array($request->tallas)) {
            foreach ($request->tallas as $tallaValor) {
                $talla = new Talla();
                $talla->id_producto = $producto->id;
                $talla->tallas = $tallaValor;
                $talla->save();
            }
        }

        redirect('/productos/index.php')->with('success', 'Producto actualizado con éxito')->send();
    }

    public function destroy(int $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        redirect('/productos/index.php')->with('success', 'Producto eliminado con éxito')->send();
    }
}
