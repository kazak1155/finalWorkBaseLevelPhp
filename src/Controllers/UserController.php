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
    public function showUserById($id)
    {
        if (isset($_SESSION['success'])) {
            if ($_SESSION['userId'] == $id || $_SESSION['status_user'] == 'administrator') {
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
                $users = json_encode($objectsJsonUser);
                $message ='';
            } else {
                $users ='';
                $message = 'авторизированный пользователь не может простматривать данные запрашиваемого пользователя';
            }
        } else {
            $users ='';
            $message = 'нет авторизированных пользователей';
        }

        return new Json(
            [
                'users' => $users,
                'message' => $message,
            ]);
    }

    public function showAllUser()
    {
        if (isset($_SESSION['success'])) {
            if ($_SESSION['status_user'] == 'administrator') {
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
                $users = json_encode($objectsJsonUsers);
                $message ='';
            } else {
                $users ='';
                $message = 'авторизированный пользователь не администратор';
            }
        } else {
            $users ='';
            $message = 'нет авторизированных пользователей';
        }

        return new Json(
            [
                'users' => $users,
                'message' => $message,
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
                                $path = getcwd()  . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $newUser->id;
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
        if (isset($_SESSION['success'])) {
            if ($_SESSION['userId'] == $body['id'] || $_SESSION['status_user'] == 'administrator') {
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
                }
            } else {
                $message = 'авторизированный пользователь не может изменить данные этого пользователя';
                $result = false;
            }
        } else {
            $message = 'нет авторизированных пользователей';
            $result = false;
        }


        return new Json(
            [
                'message' => $message,
                'result' => $result
            ]);
    }

    public function deleteUser($id)
    {
        if (isset($_SESSION['success'])) {
            if ($_SESSION['userId'] == $id || $_SESSION['status_user'] == 'administrator') {
                $user = User::find($id);
                if (isset($user)) {
                    $result = true;
                    $user->delete();
                    $message = 'пользователь с ид: ' .  $user->id . ' удален';
                } else {
                    $result = false;
                    $message = 'пользователя в таким ид нет в БД';
                }
            } else {
                $message = 'авторизированный пользователь не может удалить данного пользователя';
                $result = false;
            }
        } else {
            $message = 'нет авторизированных пользователей';
            $result = false;
        }


        return new Json(
            [
                'message' => $message,
                'result' => $result
            ]);
    }
}
