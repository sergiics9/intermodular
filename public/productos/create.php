<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/ProductoController.php';

use App\Http\Middlewares\Middleware;
use App\Http\Controllers\ProductoController;
use App\Core\ErrorHandler;

try {
    Middleware::role(['admin']);
    (new ProductoController())->create();
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
