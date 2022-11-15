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

        $user = User::find($id);
        $user -> delete();
        $_SESSION['success'] = 'пользователь с именем: ' .  $user->name . ' удален';

        return new Json(
            [
                'message' => 'пользователь с именем: ' .  $user->name . ' удален',
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


    public function editUser($id)
    {

        $user = User::find($id);
        $_SESSION['success'] = 'пользователь с именем: ' .  $user->name . ' изменен';

        return new Json(
            [
                'message' => 'пользователь с именем: ' .  $user->name . ' изменен',
                'result' => true
            ]
        );
    }


    public function createUser()
    {

        $_SESSION['success'] = 'новый подьзователь создан';

        return new Json(
            [
                'message' => 'новый подьзователь создан',
                'result' => true
            ]
        );
    }
}
