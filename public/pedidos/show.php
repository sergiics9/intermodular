<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/PedidoController.php';
require_once __DIR__ . '/../../app/Models/Pedido.php';
require_once __DIR__ . '/../../app/Models/DetallePedido.php';
require_once __DIR__ . '/../../app/Models/Producto.php';

use App\Core\Auth;
use App\Core\Request;
use App\Core\ErrorHandler;
use App\Http\Controllers\PedidoController;
use App\Http\Middlewares\Middleware;

try {
    // Verificar que el usuario esté autenticado
    Middleware::auth();

    // Obtener el ID del pedido
    $id = (int)(new Request())->id;

    // Mostrar los detalles del pedido
    (new PedidoController())->show($id);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
