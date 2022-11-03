<?php

namespace App\Controllers\Admin;

use App\View\View;
use App\Models\User;


/**
 * Class AdminUserController
 * @package App\Controllers\Admin
 */
class AdminUserController
{
    public function getAllUsers()
    {
        $title = 'Все пользователи';
        $users = User::where(null)
            ->get();

        return new View('admin.allUser',
            [
                'users' => $users,
                'title' => $title
            ]);
    }
}
