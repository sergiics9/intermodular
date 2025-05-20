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
use App\Core\Auth;

class ProductoController
{
    public function index()
    {
        // Obtener parámetros de ordenación
        $sortBy = $_GET['sort'] ?? 'newest';

        // Construir la consulta SQL base
        $sql = "SELECT * FROM productos";

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
        $productos = DB::select(Producto::class, $sql);

        view('productos.index', compact('productos', 'sortBy'));
    }

    public function search(Request $request)
    {
        $q = trim($request->q ?? '');
        $sortBy = $_GET['sort'] ?? 'newest';

        if (empty($q)) {
            redirect('/productos/index.php')->send();
        }

        // Construir la consulta SQL base para la búsqueda
        $sql = "SELECT * FROM productos WHERE nombre LIKE ? OR descripcion LIKE ?";
        $params = ["%$q%", "%$q%"];

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

        $productos = DB::select(Producto::class, $sql, $params);

        view('productos.search', compact('productos', 'q', 'sortBy'));
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
        // Verificar permisos de administrador
        if (!Auth::check() || Auth::role() !== 1) {
            http_response_code(403);
            view('errors.403');
            exit;
        }

        $categorias = Categoria::all();
        view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        // Verificar permisos de administrador
        if (!Auth::check() || Auth::role() !== 1) {
            http_response_code(403);
            view('errors.403');
            exit;
        }

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->save();

        // Guardar tallas si existen
        $tallas = $request->tallas;
        if (is_string($tallas) && !empty($tallas)) {
            // Convertir string a array
            $tallas = explode(',', $tallas);
            // Limpiar espacios
            $tallas = array_map('trim', $tallas);
        }

        if (is_array($tallas) && !empty($tallas)) {
            foreach ($tallas as $tallaValor) {
                if (!empty(trim($tallaValor))) {
                    $talla = new Talla();
                    $talla->id_producto = $producto->id;
                    $talla->tallas = trim($tallaValor);
                    $talla->save();
                }
            }
        }

        // Procesar imagen si se ha subido
        $this->processImage($request, $producto->id);

        redirect('/productos/index.php')->with('success', 'Producto creado con éxito')->send();
    }

    public function edit(int $id)
    {
        // Verificar permisos de administrador
        if (!Auth::check() || Auth::role() !== 1) {
            http_response_code(403);
            view('errors.403');
            exit;
        }

        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request)
    {
        // Verificar permisos de administrador
        if (!Auth::check() || Auth::role() !== 1) {
            http_response_code(403);
            view('errors.403');
            exit;
        }

        $producto = Producto::findOrFail((int)$request->id);
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

        // Guardar nuevas tallas - acceder directamente a $_POST para evitar problemas
        $tallas = $_POST['tallas'] ?? [];

        if (is_array($tallas) && !empty($tallas)) {
            foreach ($tallas as $tallaValor) {
                if (!empty(trim($tallaValor))) {
                    $talla = new Talla();
                    $talla->id_producto = $producto->id;
                    $talla->tallas = trim($tallaValor);
                    $talla->save();
                }
            }
        }

        // Procesar imagen si se ha subido
        $this->processImage($request, $producto->id);

        redirect('/productos/index.php')->with('success', 'Producto actualizado con éxito')->send();
    }

    public function destroy(int $id)
    {
        // Verificar permisos de administrador
        if (!Auth::check() || Auth::role() !== 1) {
            http_response_code(403);
            view('errors.403');
            exit;
        }

        $producto = Producto::findOrFail($id);

        // Eliminar imagen si existe
        $imagePath = __DIR__ . '/../../../public/images/' . $id . '.webp';
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $producto->delete();
        redirect('/productos/index.php')->with('success', 'Producto eliminado con éxito')->send();
    }

    /**
     * Procesa y guarda la imagen del producto
     */
    private function processImage(Request $request, int $productoId): void
    {
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['imagen']['tmp_name'];
            $targetPath = __DIR__ . '/../../../public/images/' . $productoId . '.webp';

            // Convertir la imagen a webp
            if (function_exists('imagecreatefromjpeg') && function_exists('imagewebp')) {
                // Determinar el tipo de imagen
                $imageInfo = getimagesize($tmpName);
                $mime = $imageInfo['mime'];

                switch ($mime) {
                    case 'image/jpeg':
                        $image = imagecreatefromjpeg($tmpName);
                        break;
                    case 'image/png':
                        $image = imagecreatefrompng($tmpName);
                        // Preservar transparencia
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                        break;
                    case 'image/webp':
                        $image = imagecreatefromwebp($tmpName);
                        break;
                    default:
                        // Si no es un formato soportado, mover el archivo sin convertir
                        move_uploaded_file($tmpName, $targetPath);
                        return;
                }

                // Guardar como webp
                imagewebp($image, $targetPath, 80); // 80 es la calidad (0-100)
                imagedestroy($image);
            } else {
                // Si las funciones GD no están disponibles, mover el archivo sin convertir
                move_uploaded_file($tmpName, $targetPath);
            }
        }
    }
}
