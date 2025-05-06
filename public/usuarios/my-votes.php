<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/UsuarioController.php';

use App\Http\Middlewares\Middleware;
use App\Core\Request;
use App\Http\Controllers\UsuarioController;
use App\Core\ErrorHandler;

try{
    Middleware::auth();
    $id = (new Request())->id;
    (new UsuarioController())->myVotes($id);
} catch (Throwable $e){
    ErrorHandler::handle($e);
}
