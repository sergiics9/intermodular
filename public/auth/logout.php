<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/AuthController.php';

use App\Core\Request;
use App\Http\Controllers\AuthController;

$request = new Request();
(new AuthController())->logout();
