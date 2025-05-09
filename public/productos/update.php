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

    // Verificar si tallas existe en la solicitud antes de intentar acceder a ella
    if (isset($_POST['tallas']) && is_array($_POST['tallas'])) {
        // No es necesario hacer nada, los datos ya están en el formato correcto
    } elseif (isset($_POST['tallas']) && is_string($_POST['tallas'])) {
        // Convertir string a array si viene como string
        $_POST['tallas'] = explode(',', $_POST['tallas']);
        // Limpiar espacios
        $_POST['tallas'] = array_map('trim', $_POST['tallas']);
    } else {
        // Si no hay tallas, establecer un array vacío para evitar errores
        $_POST['tallas'] = [];
    }

    ProductoValidator::validate($request);
    (new ProductoController())->update($request);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
