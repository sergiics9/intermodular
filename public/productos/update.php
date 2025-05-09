<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/ProductoController.php';
require_once __DIR__ . '/../../app/Http/Validators/ProductoValidator.php';

use App\Core\Request;
use App\Http\Middlewares\Middleware;
use App\Http\Validators\ProductoValidator;
use App\Http\Controllers\ProductoController;
use App\Core\ErrorHandler;

try {
    Middleware::role(['admin']);
    $request = new Request();
    ProductoValidator::validate($request);
    (new ProductoController())->update($request);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
