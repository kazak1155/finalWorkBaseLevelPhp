<?php

//phpinfo ();

/*
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

//var_dump($_SERVER['DOCUMENT_ROOT']);
echo '1';exit;