<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/PeliculaController.php';

use App\Http\Middlewares\Middleware;
use App\Core\Request;
use App\Http\Controllers\ProductoController;
use App\Core\ErrorHandler;

try {
    Middleware::role(['admin']);
    $id = (new Request())->id;
    (new ProductoController())->edit($id);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
