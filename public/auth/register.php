<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/AuthController.php';
require_once __DIR__ . '/../../app/Http/Validators/RegisterValidator.php';

use App\Core\Request;
use App\Core\ErrorHandler;
use App\Http\Controllers\AuthController;
use App\Http\Validators\RegisterValidator;

$request = new Request();
RegisterValidator::validate($request);

try {
    (new AuthController())->register($request);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
