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
        $jsonInput = file_get_contents('php://input');
        $body = json_decode($jsonInput, true);
        if (isset($body)) {
            $email = $body['email'];
            if (isset($body['name'])) {
                if (isset($body['surname'])) {
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
                                $path = getcwd()  . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'user_' . $newUser->id;
                                mkdir($path);
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
                    $message = 'фамилия  пользователя не введена';

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
        } else {
            $message = 'данных в запросе нет';

            return new Json(
                [
                    'message' => $message,
                ]);
        }
    }

    public function updateUser()
    {
        $jsonInput = file_get_contents('php://input');
        $body = json_decode($jsonInput, true);
        if (isset($body)) {
            $user = User::find($body['id']);
            if (isset($user)) {
                $user->name = $body['name'] ?? $user->name;
                $user->surname = $body['surname'] ?? $user->surname;
                if (isset($body['password'])) {
                    $user->password = password_hash($body['password'], PASSWORD_DEFAULT);
                }
                $user->email = $body['email'] ?? $user->email;
                $user->status = $body['status'] ?? $user->status;
                $user->save();
                $message = 'пользаватель с id ' . $body['id'] . ' изменен';
                $result = true;

                return new Json(
                    [
                        'message' => $message,
                        'result' => $result
                    ]);

            } else {
                $message = 'такого пользовател нет в БД';
                $result = false;

                return new Json(
                    [
                        'message' => $message,
                        'result' => $result
                    ]);
            }
        } else {
            $message = 'ничего не передано в запросе';
            $result = false;

            return new Json(
                [
                    'message' => $message,
                    'result' => $result
                ]);
        }
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if (isset($user)) {
            $result = true;
            $user->delete();
            $message = 'пользователь с ид: ' .  $user->id . ' удален';
        } else {
            $result = false;
            $message = 'пользователя в таким ид нет в БД';
        }

        return new Json(
            [
                'message' => $message,
                'result' => $result
            ]);
    }
}
