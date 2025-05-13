<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/CarritoController.php';

use App\Core\Request;
use App\Core\ErrorHandler;
use App\Http\Controllers\CarritoController;

try {
    $request = new Request();
    (new CarritoController())->update($request);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
