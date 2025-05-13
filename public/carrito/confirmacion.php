<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/PedidoController.php';
require_once __DIR__ . '/../../app/Models/Pedido.php';
require_once __DIR__ . '/../../app/Models/DetallePedido.php';
require_once __DIR__ . '/../../app/Models/Producto.php';

use App\Core\Request;
use App\Core\ErrorHandler;
use App\Http\Controllers\PedidoController;

try {
    $request = new Request();
    $id = (int)$request->id;
    (new PedidoController())->confirmacion($id);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
