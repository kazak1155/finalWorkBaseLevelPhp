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
//
//$router->get('', [MainController::class, 'mainPage']);
//
//$router->get('admin/user', [AdminController::class, 'getAllUsers']);
//$router->get('admin/user/*', [AdminController::class, 'editUserForm']);
//$router->delete('admin/user/*', [AdminController::class, 'deleteUser']);
//$router->put('admin/user/*', [AdminController::class, 'editUser']);
//
//$router->get('login', [AuthorizationController::class, 'login']);
//$router->post('login', [AuthorizationController::class, 'login']);
//$router->get('logout', [AuthorizationController::class, 'logout']);
//
$router->get('user', [UserController::class, 'showAllUser']);
$router->get('user/*', [UserController::class, 'PersonalAreaUser']);
$router->post('user', [UserController::class, 'createUser']);
$router->put('user/*', [UserController::class, 'updateUser']);
$router->delete('user/*', [UserController::class, 'deleteUser']);

$urlList = [
    'admin/user' => [
        'get' => 'UserController::showAllUser'
    ],
    'admin/user/*' => [
        'delete' => 'AdminController::deleteUser',
        'put' => 'AdminController::editUser'
    ],
    'user' => [
        'get' => 'UserController::showAllUser'
    ],
    'user/*' => [
        'get' => 'UserController::PersonalAreaUser',
        'put' => 'UserController::updateUser',
        'delete' => 'UserController::deleteUser'
    ]
];
$addTextTostring = '::class';
foreach ($urlList as $key1 => $list1) {
    echo '<pre>';
    foreach ($list1 as $key2 => $list2){
//            var_dump($key2); var_dump($list2);
        $classFunction = explode("::", $list2);
//        echo 'path= ' . $key1 . ' method= ' . $key2 . ' class= ' . $classFunction[0].$addTextTostring . ' function= ' . $classFunction[1];
        $router->$key2($key1, [$classFunction[0].$addTextTostring, $classFunction[1]]);
        echo '$router->' . $key2 . '(' . $key1 . ', [' . $classFunction[0] . ', ' .  $classFunction[1] . ']';
    }
    echo '</pre>';
}

$application = new Application($router);

$application->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);


