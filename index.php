<?php

require_once 'autoload.php';;
//phpinfo ();

/**
* create array routs
*/
$urlList = [ '/main/' => [
        'GET' => 'Main::list()',
        'POST' => 'Main::add()',
        'DELETE' => 'Main::delete($id)'
    ],
    '/auth/' => 'Auth::auth()',
    '/user/' => [
        'GET' => 'User::show()',
        'POST' => 'User::addUser()',
        'PUT' => 'User::updateUser()'
    ],
    '/user/{id}' => [
        'GET' => 'User::showUser($id)',
        'DELETE' => 'Main::delete($id)'
    ],
];
$title = substr($_SERVER['REQUEST_URI'], 1);
if ($title == 'user') {
    $pageName = 'пользователи';
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <meta charset="utf-8" />
        <title><?= $pageName ?></title>
    </head>
    <body>
    <p>пользователи</p>
    <?php
//    $users = new User();
//    $allUser = $users->showAllUser();
//    foreach ($allUser as $user) {
//        echo $user['name'];
//    }
    ?>
    <table class="table">
        <thead>
        <tr>
            <th class="text-center" scope="col">#</th>
            <th class="text-center" scope="col">name</th>
            <th class="text-center" scope="col">surname</th>
            <th class="text-center" scope="col">email</th>
            <th class="text-center" scope="col">data of creation</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th class="text-center" scope="row">1</th>
            <td class="text-center">1</td>
            <td class="text-center">11</td>
            <td class="text-center">111</td>
            <td class="text-center">1111</td>
        </tr>
        <tr>
            <th class="text-center" scope="row">2</th>
            <td class="text-center">1</td>
            <td class="text-center">22</td>
            <td class="text-center">222</td>
            <td class="text-center">2222</td>
        </tr>
        <tr>
            <th class="text-center" scope="row">3</th>
            <td class="text-center">3</td>
            <td class="text-center">33</td>
            <td class="text-center">333</td>
            <td class="text-center">3333</td>
        </tr>
        </tbody>
    </table>
    <br>
    <a href="/">главная</a>
    </body>
    </html>
    <?php
} elseif ($title == 'file') {
    $pageName = 'файлы';
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <meta charset="utf-8" />
        <title><?= $pageName ?></title>
    </head>
    <body>
    <p>файлы</p>    <table class="table">
        <thead>
        <tr>
            <th class="text-center" scope="col">#</th>
            <th class="text-center" scope="col">name</th>
            <th class="text-center" scope="col">user uploup</th>
            <th class="text-center" scope="col">data of creation</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th class="text-center" scope="row">1</th>
            <td class="text-center">11</td>
            <td class="text-center">1</td>
            <td class="text-center">1111</td>
        </tr>
        <tr>
            <th class="text-center" scope="row">2</th>
            <td class="text-center">22</td>
            <td class="text-center">2</td>
            <td class="text-center">2222</td>
        </tr>
        <tr>
            <th class="text-center" scope="row">3</th>
            <td class="text-center">33</td>
            <td class="text-center">3</td>
            <td class="text-center">3333</td>
        </tr>
        </tbody>
    </table>
    <br>
    <a href="/">главная</a>
    </body>
    </html>
    <?php
} else {
    $pageName = 'главная';
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <meta charset="utf-8" />
        <title><?= $pageName ?></title>
    </head>
    <body>
    <a href="/user">пользователи</a>
    <br>
    <a href="/file">файлы</a>
    </body>
    </html>
    <?php
}
?>
