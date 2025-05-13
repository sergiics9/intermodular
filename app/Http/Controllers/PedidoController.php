<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;
use App\Core\DB;

class PedidoController
{
    /**
     * Muestra la lista de pedidos del usuario o todos los pedidos si es admin
     */
    public function index()
    {
        // Si es admin, muestra todos los pedidos
        if (Auth::check() && Auth::user()['role'] == 1) {
            $pedidos = Pedido::orderBy('Fecha', 'DESC')->get();
        } else {
            // Si es usuario normal, muestra solo sus pedidos
            $pedidos = Pedido::where('UsuarioID', Auth::id())->orderBy('Fecha', 'DESC')->get();
        }

        view('pedidos.index', compact('pedidos'));
    }

    /**
     * Muestra los detalles de un pedido específico
     */
    public function show(int $id)
    {
        $pedido = Pedido::findOrFail($id);

        // Verificar que el usuario tenga acceso a este pedido
        if (Auth::user()['role'] != 1 && $pedido->UsuarioID != Auth::id()) {
            redirect('/pedidos/index.php')->with('error', 'No tienes permiso para ver este pedido')->send();
        }

        // Obtener los detalles del pedido directamente de la base de datos
        $detalles = DB::selectAssoc("SELECT dp.*, p.nombre, p.id as producto_id 
                                FROM detalles_pedido dp 
                                LEFT JOIN productos p ON dp.ProductoID = p.id 
                                WHERE dp.PedidoID = ?", [$id]);

        view('pedidos.show', compact('pedido', 'detalles'));
    }

    /**
     * Procesa un nuevo pedido desde el checkout
     */
    public function store(Request $request)
    {
        // Validar datos del formulario
        $errors = [];

        if (empty(trim($request->nombre))) {
            $errors['nombre'] = 'El nombre es obligatorio';
        }

        if (empty(trim($request->email)) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'El email no es válido';
        }

        if (empty(trim($request->direccion))) {
            $errors['direccion'] = 'La dirección es obligatoria';
        }

        if (empty(trim($request->telefono)) || !preg_match('/^[0-9]{9}$/', $request->telefono)) {
            $errors['telefono'] = 'El teléfono debe tener 9 dígitos';
        }

        // Si hay errores, volver al formulario
        if (!empty($errors)) {
            back()->withErrors($errors)->withInput([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono
            ])->send();
            return;
        }

        // Obtener el carrito
        $carrito = session()->get('carrito', []);

        // Si el carrito está vacío, redirigir al carrito
        if (empty($carrito)) {
            redirect('/carrito/index.php')->with('error', 'El carrito está vacío')->send();
            return;
        }

        // Calcular el total
        $total = 0;
        $detalles = [];

        foreach ($carrito as $item) {
            $producto = Producto::find($item['producto_id']);
            if ($producto) {
                $subtotal = $producto->precio * $item['cantidad'];
                $total += $subtotal;
                $detalles[] = [
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio' => $producto->precio,
                    'talla' => $item['talla']
                ];
            }
        }

        // Crear el pedido
        $pedido = new Pedido();
        $pedido->UsuarioID = Auth::check() ? Auth::id() : null;
        $pedido->Nombre = $request->nombre;
        $pedido->Email = $request->email;
        $pedido->Direccion = $request->direccion;
        $pedido->Telefono = $request->telefono;
        $pedido->Total = $total;
        $pedido->save();

        // Crear los detalles del pedido
        foreach ($detalles as $detalle) {
            $detallePedido = new DetallePedido();
            $detallePedido->PedidoID = $pedido->id;
            $detallePedido->ProductoID = $detalle['producto_id'];
            $detallePedido->Cantidad = $detalle['cantidad'];
            $detallePedido->Precio = $detalle['precio'];
            $detallePedido->talla = $detalle['talla'];
            $detallePedido->save();
        }

        // Vaciar el carrito
        session()->remove('carrito');

        // Redirigir a la página de confirmación
        redirect('/carrito/confirmacion.php?id=' . $pedido->id)->with('success', 'Pedido realizado con éxito')->send();
    }

    /**
     * Muestra la página de confirmación de pedido
     */
    public function confirmacion(int $id)
    {
        $pedido = Pedido::findOrFail($id);

        // Verificar que el usuario tenga acceso a este pedido
        if (Auth::check() && Auth::user()['role'] != 1 && $pedido->UsuarioID != Auth::id()) {
            redirect('/pedidos/index.php')->with('error', 'No tienes permiso para ver este pedido')->send();
            return;
        }

        // Fetch order details with product information
        $detalles = DB::selectAssoc("SELECT dp.*, p.nombre, p.id as producto_id 
                                FROM detalles_pedido dp 
                                LEFT JOIN productos p ON dp.ProductoID = p.id 
                                WHERE dp.PedidoID = ?", [$id]);

        view('carrito.confirmacion', compact('pedido', 'detalles'));
    }
}
