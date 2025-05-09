<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/ProductoController.php';
require_once __DIR__ . '/../../app/Http/Validators/ProductoValidator.php';

use App\Core\Request;
use App\Http\Middlewares\Middleware;
use App\Http\Validators\ProductoValidator;
use App\Http\Controllers\ProductoController;
use App\Core\ErrorHandler;
use App\Core\Auth;

try {
    // Verificar si el usuario está autenticado y es administrador
    if (!Auth::check() || Auth::role() !== 1) {
        http_response_code(403);
        view('errors.403');
        exit;
    }

    $request = new Request();
    ProductoValidator::validate($request);
    (new ProductoController())->store($request);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
