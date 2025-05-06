<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/AuthController.php';
require_once __DIR__ . '/../../app/Http/Validators/LoginValidator.php';

use App\Core\Request;
use App\Core\ErrorHandler;
use App\Http\Controllers\AuthController;
use App\Http\Validators\LoginValidator;

$request = new Request();
LoginValidator::validate($request);

try {
    (new AuthController())->login($request);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}
