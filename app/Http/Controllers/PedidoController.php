<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;

class PedidoController
{
    public function index()
    {
        // Si es admin, muestra todos los pedidos
        if (Auth::check() && Auth::user()['role'] == 1) {
            $pedidos = Pedido::all();
        } else {
            // Si es usuario normal, muestra solo sus pedidos
            $pedidos = Pedido::where('UsuarioID', Auth::id())->get();
        }

        view('pedidos.index', compact('pedidos'));
    }

    public function show(string $id)
    {
        $pedido = Pedido::findOrFail($id);

        // Verificar que el usuario tenga acceso a este pedido
        if (Auth::user()['role'] != 1 && $pedido->UsuarioID != Auth::id()) {
            redirect('/pedidos/index.php')->with('error', 'No tienes permiso para ver este pedido')->send();
        }

        view('pedidos.show', compact('pedido'));
    }

    public function create()
    {
        // Obtener productos del carrito de la sesión
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            redirect('/productos/index.php')->with('error', 'El carrito está vacío')->send();
        }

        $productos = [];
        $total = 0;

        foreach ($carrito as $item) {
            $producto = Producto::find($item['id']);
            if ($producto) {
                $productos[] = [
                    'producto' => $producto,
                    'cantidad' => $item['cantidad'],
                    'talla' => $item['talla'],
                    'subtotal' => $producto->precio * $item['cantidad']
                ];
                $total += $producto->precio * $item['cantidad'];
            }
        }

        view('pedidos.create', compact('productos', 'total'));
    }

    public function store(Request $request)
    {
        // Obtener productos del carrito de la sesión
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            redirect('/productos/index.php')->with('error', 'El carrito está vacío')->send();
        }

        // Calcular total
        $total = 0;
        foreach ($carrito as $item) {
            $producto = Producto::find($item['id']);
            if ($producto) {
                $total += $producto->precio * $item['cantidad'];
            }
        }

        // Crear pedido
        $pedido = new Pedido();
        $pedido->UsuarioID = Auth::check() ? Auth::id() : null;
        $pedido->Nombre = $request->nombre;
        $pedido->Email = $request->email;
        $pedido->Direccion = $request->direccion;
        $pedido->Telefono = $request->telefono;
        $pedido->Total = $total;
        $pedido->save();

        // Crear detalles del pedido
        foreach ($carrito as $item) {
            $producto = Producto::find($item['id']);
            if ($producto) {
                $detalle = new DetallePedido();
                $detalle->PedidoID = $pedido->PedidoID;
                $detalle->ProductoID = $producto->id;
                $detalle->Cantidad = $item['cantidad'];
                $detalle->Precio = $producto->precio;
                $detalle->talla = $item['talla'];
                $detalle->save();
            }
        }

        // Limpiar carrito
        session()->remove('carrito');

        redirect('/pedidos/show.php?id=' . $pedido->PedidoID)->with('success', 'Pedido realizado con éxito')->send();
    }
}
