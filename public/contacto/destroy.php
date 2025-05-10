<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/ContactoController.php';

use App\Core\Request;
use App\Http\Controllers\ContactoController;
use App\Core\ErrorHandler;
use App\Core\Auth;

try {
    // Verificar permisos de administrador
    if (!Auth::check() || Auth::role() !== 1) {
        http_response_code(403);
        view('errors.403');
        exit;
    }

    $request = new Request();
    (new ContactoController())->destroy($request);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
