<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/CategoriaController.php';

use App\Core\Request;
use App\Http\Controllers\CategoriaController;
use App\Core\ErrorHandler;

try {
    $id = (int)(new Request())->id;
    (new CategoriaController())->show($id);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
