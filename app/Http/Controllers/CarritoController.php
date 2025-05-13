<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\Models\Producto;

class CarritoController
{
    /**
     * Muestra el contenido del carrito
     */
    public function index()
    {
        // Obtener el carrito de la sesión
        $carrito = session()->get('carrito', []);
        $productos = [];
        $total = 0;

        // Si hay productos en el carrito, obtener sus detalles
        if (!empty($carrito)) {
            foreach ($carrito as $item) {
                $producto = Producto::find($item['producto_id']);
                if ($producto) {
                    $subtotal = $producto->precio * $item['cantidad'];
                    $productos[] = [
                        'id' => $item['producto_id'],
                        'producto' => $producto,
                        'cantidad' => $item['cantidad'],
                        'talla' => $item['talla'],
                        'subtotal' => $subtotal
                    ];
                    $total += $subtotal;
                }
            }
        }

        view('carrito.index', compact('productos', 'total'));
    }

    /**
     * Añade un producto al carrito
     */
    public function add(Request $request)
    {
        $producto_id = (int)$request->producto_id;
        $cantidad = (int)($request->cantidad ?? 1);
        $talla = $request->talla;

        // Validar que se ha seleccionado una talla
        if (empty($talla)) {
            back()->with('error', 'Debes seleccionar una talla')->send();
            return;
        }

        // Validar que el producto existe
        $producto = Producto::find($producto_id);
        if (!$producto) {
            back()->with('error', 'El producto no existe')->send();
            return;
        }

        // Obtener el carrito actual
        $carrito = session()->get('carrito', []);

        // Verificar si el producto ya está en el carrito con la misma talla
        $encontrado = false;
        foreach ($carrito as $key => $item) {
            if ($item['producto_id'] == $producto_id && $item['talla'] == $talla) {
                $carrito[$key]['cantidad'] += $cantidad;
                $encontrado = true;
                break;
            }
        }

        // Si no se encontró, añadir como nuevo item
        if (!$encontrado) {
            $carrito[] = [
                'producto_id' => $producto_id,
                'cantidad' => $cantidad,
                'talla' => $talla
            ];
        }

        // Guardar el carrito actualizado en la sesión
        session()->set('carrito', $carrito);

        // Redireccionar con mensaje de éxito
        back()->with('success', 'Producto añadido al carrito')->send();
    }

    /**
     * Elimina un producto del carrito
     */
    public function remove(Request $request)
    {
        $index = (int)$request->index;
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$index])) {
            unset($carrito[$index]);
            // Reindexar el array
            $carrito = array_values($carrito);
            session()->set('carrito', $carrito);
            back()->with('success', 'Producto eliminado del carrito')->send();
        } else {
            back()->with('error', 'No se pudo eliminar el producto')->send();
        }
    }

    /**
     * Actualiza la cantidad de un producto en el carrito
     */
    public function update(Request $request)
    {
        $index = (int)$request->index;
        $cantidad = (int)$request->cantidad;

        if ($cantidad < 1) {
            back()->with('error', 'La cantidad debe ser al menos 1')->send();
            return;
        }

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$index])) {
            $carrito[$index]['cantidad'] = $cantidad;
            session()->set('carrito', $carrito);
            back()->with('success', 'Carrito actualizado')->send();
        } else {
            back()->with('error', 'No se pudo actualizar el carrito')->send();
        }
    }

    /**
     * Vacía el carrito
     */
    public function clear()
    {
        session()->remove('carrito');
        back()->with('success', 'Carrito vaciado')->send();
    }

    /**
     * Muestra la página de checkout
     */
    public function checkout()
    {
        // Obtener el carrito
        $carrito = session()->get('carrito', []);

        // Si el carrito está vacío, redirigir al carrito
        if (empty($carrito)) {
            redirect('/carrito/index.php')->with('error', 'El carrito está vacío')->send();
            return;
        }

        $productos = [];
        $total = 0;

        // Obtener detalles de los productos
        foreach ($carrito as $item) {
            $producto = Producto::find($item['producto_id']);
            if ($producto) {
                $subtotal = $producto->precio * $item['cantidad'];
                $productos[] = [
                    'id' => $item['producto_id'],
                    'producto' => $producto,
                    'cantidad' => $item['cantidad'],
                    'talla' => $item['talla'],
                    'subtotal' => $subtotal
                ];
                $total += $subtotal;
            }
        }

        // Si el usuario está autenticado, prellenar datos
        $usuario = null;
        if (Auth::check()) {
            $usuario = Auth::user();
        }

        view('carrito.checkout', compact('productos', 'total', 'usuario'));
    }
}
