<?php

namespace App\Controllers;

use App\Models\User;
use App\View\Json;
use App\View\View;


/**
 * Class UserController
 * @package App\Controllers
 */
class UserController
{
    public function showUserById($id)
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
        $test = file_get_contents('php://input');
        $body = json_decode($test, true);
        $email = $body['email'];
        if (isset($body['name'])) {
            if (isset($body['password'])) {
                if (isset($body['email'])) {
                    $user = User::where('email', $email)->first();
                    if (isset($user)) {
                        $message = 'такой email уже есть в БД';

                        return new Json(
                            [
                                'message' => $message,
                            ]);
                    } else {
                        $newUser = new User();
                        $newUser->name = $body['name'];
                        $newUser->surname = $body['surname'];
                        $newUser->password = password_hash($body['password'], PASSWORD_DEFAULT);
                        $newUser->email = $body['email'];
                        $newUser->created_at = date("Y-m-d");
                        $newUser->status = 'user';
                        $newUser->save();
                        $message = 'новый пользователь с email ' . $body['email'] . ' создан';

                        return new Json(
                            [
                                'message' => $message,
                            ]);
                    }
                } else {
                    $message = 'email пользователя не введен';

                    return new Json(
                        [
                            'message' => $message,
                        ]);
                }
            } else {
                $message = 'пароль пользователя не введен';

                return new Json(
                    [
                        'message' => $message,
                    ]);
            }
        } else {
            $message = 'имя пользователя не введено';

            return new Json(
                [
                    'message' => $message,
                ]);
        }
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
