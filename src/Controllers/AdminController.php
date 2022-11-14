<?php

namespace App\Controllers;

use App\Models\User;
use App\View\Json;
use App\View\View;


/**
 * Class AdminController
 * @package App\Controllers
 */
class AdminController
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

    public function deleteUser($id)
    {
//        $user = User::find($id);

        return new Json(
            [
                'message' => 'пользователь удален',
                'result' => true
            ]
        );
    }

    public function editUserForm($id)
    {
        $user = User::find($id);
        $title = 'редактирование пользователя';

        return new View('admin.editCreateUser',
            [
                'user' => $user,
                'title' => $title
            ]);
    }

    public function createUserForm()
    {
        $title = 'создание нового пользователя пользователя';

        return new View('admin.editCreateUser',
            [
                'title' => $title
            ]);
    }
}
