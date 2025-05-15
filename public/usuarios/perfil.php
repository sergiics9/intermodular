<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/UsuarioController.php';

use App\Http\Middlewares\Middleware;
use App\Http\Controllers\UsuarioController;

Middleware::auth();
(new UsuarioController())->perfil();
