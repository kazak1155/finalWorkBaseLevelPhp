<?php

use App\Application;
use App\Router;
use App\Controllers\MainController;
use App\Controllers\AdminController;

session_start();
error_reporting(E_ALL);
ini_set('display_errors', true);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$router = new Router();

$router->get('', [MainController::class, 'mainPage']);

$router->get('user', [AdminController::class, 'getAllUsers']);
$router->delete('user', [AdminController::class, 'deleteUser']);

$application = new Application($router);

$application->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
