<?php

namespace App;

use App\Controllers\AuthorizationController;
use App\Controllers\MainController;
use App\Controllers\AdminController;
use App\Controllers\UserController;

session_start();
error_reporting(E_ALL);
ini_set('display_errors', true);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$router = new Router();

$router->get('', [MainController::class, 'mainPage']);

$router->get('user', [AdminController::class, 'getAllUsers']);
$router->get('editUser/*', [AdminController::class, 'editUserForm']);
$router->get('createUser', [AdminController::class, 'createUserForm']);
$router->delete('user/*', [AdminController::class, 'deleteUser']);
$router->put('user/*', [AdminController::class, 'editUser']);
$router->post('user/*', [AdminController::class, 'createUser']);

$router->get('login', [AuthorizationController::class, 'login']);
$router->post('login', [AuthorizationController::class, 'login']);
$router->get('logout', [AuthorizationController::class, 'logout']);

$router->get('user/*', [UserController::class, 'PersonalAreaUser']);

$application = new Application($router);

$application->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
