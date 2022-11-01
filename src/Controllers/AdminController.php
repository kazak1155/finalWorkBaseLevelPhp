<?php

namespace App\Controllers;

use App\View\View;

/**
 * Class AdminController
 * @package App\Controllers
 */
class AdminController
{
    public function getAllUsers()
    {
        return new View('admin.allUser',
            [
            ]);
    }
}
