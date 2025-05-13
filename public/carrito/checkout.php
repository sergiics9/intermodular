<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/CarritoController.php';

use App\Core\ErrorHandler;
use App\Http\Controllers\CarritoController;

try {
    (new CarritoController())->checkout();
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
