<?php

namespace App\Controllers;

use App\Models\User;
use App\View\Json;



/**
 * Class AdminController
 * @package App\Controllers
 */
class AdminController
{
    static function getAllUsers()
    {
//        var_dump($_REQUEST); exit;
        $users = User::where(null)
            ->get();
        $objectsJsonUser = [];
        foreach ($users as $user) {
            $objectsJsonUser[] = [
                [
                    'id' => $user->id,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'password' => $user->password,
                    'email' => $user->email,
                    'date_create' => $user->date_create,
                ]
            ];
        }

        return new Json(
            [
                'users' => json_encode($objectsJsonUser)
            ]);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if (isset($user)) {
            $result = 'true';
            $user -> delete();
            $message = 'пользователь с ид: ' .  $user->id . ' удален';
        } else {
            $result = 'false';
            $message = 'пользователя в таким ид нет в БД';
        }

        return new Json(
            [
                'message' => $message,
                'result' => $result
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
}
