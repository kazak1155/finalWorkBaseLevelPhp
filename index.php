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
    '/auth/' => 'Auth::auth()'
];

//var_dump($_SERVER['DOCUMENT_ROOT']);