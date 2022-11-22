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

$urlList = [
    'admin/user' => [
        'get' => [
            'App\Controllers\AdminController' => 'showAllUser'
        ]
    ],
    'admin/user/*' => [
        'delete' =>  [
            'App\Controllers\AdminController' => 'deleteUser'
        ],
        'put' => [
            'App\Controllers\AdminController' => 'editUser'
        ],
        'get' => [
            'App\Controllers\AdminController' => 'PersonalAreaUser'
        ]
    ],
    'user' => [
        'get' => [
            'App\Controllers\UserController' => 'showAllUser'
        ]
    ],
    'user/*' => [
        'get' => [
            'App\Controllers\UserController' => 'PersonalAreaUser'
        ],
        'put' => [
            'App\Controllers\UserController' => 'updateUser'
        ],
        'delete' => [
            'App\Controllers\UserController' => 'deleteUser'
        ]
    ],
    'login' => [
        'get' => [
            'App\Controllers\AuthorizationController' => 'login'
        ],
        'post' => [
            'App\Controllers\AuthorizationController' => 'login'
        ]
    ],
    'logout' => [
        'get' => [
            'App\Controllers\AuthorizationController' => 'logout'
        ]
    ],
    'registration' => [
        'post' => [
            'App\Controllers\AuthorizationController' => 'registration'
        ],
        'get' => [
            'App\Controllers\AuthorizationController' => 'registration'
        ]
    ],
    'passwordReset' => [
        'post' => [
            'App\Controllers\AuthorizationController' => 'passwordReset'
        ]
    ],
    '' => [
        'get' => [
            'App\Controllers\MainController' => 'mainPage'
        ]
    ]
];

foreach ($urlList as $key1 => $list1) {
    foreach ($list1 as $key2 => $list2){
        foreach ($list2 as $key3 => $list3) {
            $router->$key2($key1, [$key3, $list3]);
        }
    }
}

$application = new Application($router);

$application->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
