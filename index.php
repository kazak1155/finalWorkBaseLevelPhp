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
$router->delete('user/*', [AdminController::class, 'deleteUser']);

$router->get('auth', [AuthorizationController::class, 'auth']);
$router->post('auth', [AuthorizationController::class, 'auth']);

$router->get('user/*', [UserController::class, 'PersonalAreaUser']);

$application = new Application($router);

$application->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$urlList = [
    '' => [
                'GET' => 'MainController::mainPage()'
          ],
    'user' => [
                'GET' => 'AdminController::getAllUsers()'
    ]
];
