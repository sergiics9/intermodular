<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/ComentarioController.php';
require_once __DIR__ . '/../../app/Models/Comentario.php';
require_once __DIR__ . '/../../app/Models/Producto.php'; // Añadir esta línea

use App\Core\Request;
use App\Core\ErrorHandler;
use App\Http\Controllers\ComentarioController;

try {
    $request = new Request();
    (new ComentarioController())->destroy($request);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
