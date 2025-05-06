<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/ProductoController.php';

use App\Core\Request;
use App\Http\Controllers\ProductoController;
use App\Core\ErrorHandler;

try {
    $request = new Request();
    (new ProductoController())->index($request);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
