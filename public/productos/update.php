<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Validators/PeliculaValidator.php';
require_once __DIR__ . '/../../app/Http/Controllers/PeliculaController.php';

use App\Core\Request;
use App\Http\Middlewares\Middleware;
use App\Http\Validators\PeliculaValidator;
use App\Http\Controllers\PeliculaController;
use App\Core\ErrorHandler;

try {
    Middleware::role(['admin']);
    $request = new Request();
    PeliculaValidator::validate($request);
    (new PeliculaController())->update($request);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
