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
//$router->get('user', [UserController::class, 'showAllUser']);
//$router->get('user/*', [UserController::class, 'PersonalAreaUser']);
//$router->post('user', [UserController::class, 'createUser']);
//$router->put('user/*', [UserController::class, 'updateUser']);
//$router->delete('user/*', [UserController::class, 'deleteUser']);

$urlList = [
    'admin/user' => [
        'get' => [
            'App\Controllers\UserController::class' => 'showAllUser'
        ]
    ],
    'admin/user/*' => [
        'delete' =>  [
            'App\Controllers\AdminController::class' => 'deleteUser'
        ],
        'put' => [
            'App\Controllers\AdminController::class' => 'editUser'
        ],
        'get' => [
            'App\Controllers\AdminController::class' => 'PersonalAreaUser'
        ]
    ],
    'user' => [
        'get' => [
            'App\Controllers\UserController::class' => 'showAllUser'
        ]
    ],
    'user/*' => [
        'get' => [
            'App\Controllers\UserController::class' => 'PersonalAreaUser'
        ],
        'put' => [
            'App\Controllers\UserController::class' => 'updateUser'
        ],
        'delete' => [
            'App\Controllers\UserController::class' => 'deleteUser'
        ]
    ],
    'login' => [
        'get' => [
            'App\Controllers\AuthorizationController::class' => 'login'
        ],
        'post' => [
            'App\Controllers\AuthorizationController::class' => 'login'
        ],
        'get' => [
            'App\Controllers\AuthorizationController::class' => 'logout'
            ]
    ],
    '' => [
        'get' => [
            'App\Controllers\MainController::class' => 'mainPage'
        ]
    ]
];

foreach ($urlList as $key1 => $list1) {
    echo '<pre>';
    foreach ($list1 as $key2 => $list2){
        foreach ($list2 as $key3 => $list3) {
            $router->$key2($key1, [$key3, $list3]);
        }
    }
    echo '</pre>';
}

$application = new Application($router);

$application->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);


