<?php

namespace App\Controllers;

use App\Models\User;
use App\View\Json;


/**
 * Class UserController
 * @package App\Controllers
 */
class UserController
{
    public function PersonalAreaUser($id)
    {
        $user = User::find($id);
        $objectsJsonUser = [
            [
                'id' => $user->id,
                'name' => $user->name,
                'surname' => $user->surname,
                'password' => $user->password,
                'email' => $user->email,
                'date_create' => $user->date_create,
            ]
        ];

        return new Json(
            [
                'users' => json_encode($objectsJsonUser)
            ]);
    }

    public function showAllUser()
    {
    $users = User::where(null)
        ->get();
    $objectsJsonUsers = [];
    foreach ($users as $user) {
        $objectsJsonUsers[] = [
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
            'users' => json_encode($objectsJsonUsers)
        ]);
    }

    public function createUser()
    {
        echo 'request= ' ; var_dump($_REQUEST); exit;
        $objectsJsonUser = '';

    return new Json(
        [
            'users' => json_encode($objectsJsonUser)
        ]);
    }

    public function updateUser()
    {
        echo 'request= ' ; var_dump($_REQUEST); exit;
        $user = User::find($id);
        $objectsJsonUser = '';

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
}
