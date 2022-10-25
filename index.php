<?php

use App\Application;
use App\Router;
use App\Controllers\MainController;
use App\Controllers\Admin\AdminUserController;

session_start();
error_reporting(E_ALL);
ini_set('display_errors', true);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$router = new Router();

$router->get('', [MainController::class, 'mainPage']);

$router->get('/user', [AdminUserController::class, 'getAllUsers']);

$application = new Application($router);

$application->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
