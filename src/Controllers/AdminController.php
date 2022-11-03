<?php

namespace App\Controllers;

use App\Models\User;
use App\View\View;
use Illuminate\Http\Request;

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

    public function deleteUser(Request $request)
    {
        $title = 'удаление пользователя';
        $id = $request->id;
        $user = User::find($id);
        $user->delete();
        $_SESSION['message'] = 'пользователь удален';
        header('Location: /user');

    }
}