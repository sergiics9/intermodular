<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/CategoriaController.php';

use App\Core\Request;
use App\Http\Controllers\CategoriaController;
use App\Core\ErrorHandler;

try {
    $request = new Request();
    (new CategoriaController())->index();
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
