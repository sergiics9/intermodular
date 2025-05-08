<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/ProductoController.php';

use App\Core\Request;
use App\Http\Controllers\ProductoController;
use App\Core\ErrorHandler;

try {
    $id = (int)(new Request())->id;
    (new ProductoController())->show($id);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
