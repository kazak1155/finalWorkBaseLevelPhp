<?php

namespace App;

session_start();
error_reporting(E_ALL);
ini_set('display_errors', true);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$router = new Router();

$urlList = [
    'admin/user' => [
        'get' => [
            'App\Controllers\AdminController' => 'showAllUser'
        ],
        'put' => [
            'App\Controllers\AdminController' => 'editUser'
        ],
    ],
    'admin/user/*' => [
        'delete' =>  [
            'App\Controllers\AdminController' => 'deleteUser'
        ],
        'get' => [
            'App\Controllers\AdminController' => 'showUserById'
        ]
    ],
    'user' => [
        'get' => [
            'App\Controllers\UserController' => 'showAllUser'
        ],
        'post' => [
            'App\Controllers\UserController' => 'createUser'
        ],
        'put' => [
            'App\Controllers\UserController' => 'updateUser'
        ]
    ],
    'user/*' => [
        'get' => [
            'App\Controllers\UserController' => 'showUserById'
        ],
        'delete' => [
            'App\Controllers\UserController' => 'deleteUser'
        ]
    ],
    'login' => [
        'get' => [
            'App\Controllers\AuthorizationController' => 'login'
        ]
    ],
    'logout' => [
        'get' => [
            'App\Controllers\AuthorizationController' => 'logout'
        ]
    ],
    'passwordReset' => [
        'get' => [
            'App\Controllers\AuthorizationController' => 'passwordResetGet'
        ],
    ],
    '' => [
        'get' => [
            'App\Controllers\MainController' => 'mainPage'
        ]
    ],
    'file' => [
        'get' => [
            'App\Controllers\FileController' => 'showAllFiles'
        ],
        'post' => [
            'App\Controllers\FileController' => 'addFile'
        ],
        'put' => [
            'App\Controllers\FileController' => 'editFile'
        ]
    ],
    'file/*' => [
        'get' => [
            'App\Controllers\FileController' => 'showFileById'
        ],
        'delete' => [
            'App\Controllers\FileController' => 'deleteFile'
        ],
        'put' => [
            'App\Controllers\FileController' => 'editFile'
        ]
    ],
    'directory' => [
        'post' => [
            'App\Controllers\DirectoryController' => 'addDirectory'
        ],
        'put' => [
            'App\Controllers\DirectoryController' => 'editDirectory'
        ]
    ],
    'directory/*' => [
        'get' => [
            'App\Controllers\DirectoryController' => 'showFilesInDirectory'
        ],
        'delete' => [
            'App\Controllers\DirectoryController' => 'deleteDirectory'
        ]
    ],
    'files/share/*' => [
        'get' => [
            'App\Controllers\FileController' => 'showUsersAvailableToFile'
        ]
    ],
    'files/share/*/*' => [
        'put' => [
            'App\Controllers\FileController' => 'shareAvailableToFile'
        ]
    ],
    'files/share/*/*' => [
        'delete' => [
            'App\Controllers\FileController' => 'deleteAvailableToFile'
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
