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
        $users = User::where(null)
            ->orderByDesc('id')
            ->get();

        return new View('admin.allUser',
            [
                'users' => $users,
            ]);
    }
}
