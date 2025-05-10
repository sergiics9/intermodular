<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/ContactoController.php';

use App\Core\Request;
use App\Http\Controllers\ContactoController;
use App\Core\ErrorHandler;

try {
    $request = new Request();
    (new ContactoController())->index();
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
