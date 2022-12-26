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
    static function showAllUser()
    {
        if (isset($_SESSION['success'])) {
            if ($_SESSION['status_user'] == 'administrator') {
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
                $users = json_encode($objectsJsonUser);
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

    public function showUserById($id)
    {
        if (isset($_SESSION['success'])) {
            if ($_SESSION['status_user'] == 'administrator') {
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

    public function deleteUser($id)
    {
        if (isset($_SESSION['success'])) {
            if ($_SESSION['status_user'] == 'administrator') {
                $user = User::find($id);
                if (isset($user)) {
                    $result = 'true';
                    $user -> delete();
                    $message = 'пользователь с ид: ' .  $user->id . ' удален';
                } else {
                    $result = 'false';
                    $message = 'пользователя в таким ид нет в БД';
                }
            } else {
                $result = false;
                $message = 'авторизированный пользователь не администратор';
            }
        } else {
            $result = false;
            $message = 'нет авторизированных пользователей';
        }

        return new Json(
            [
                'message' => $message,
                'result' => $result
            ]);
    }

    public function editUser()
    {
        $jsonInput = file_get_contents('php://input');
        $body = json_decode($jsonInput, true);
        if (isset($_SESSION['success'])) {
            if ($_SESSION['status_user'] == 'administrator') {
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
                    }
                } else {
                    $message = 'ничего не передано в запросе';
                    $result = false;
                }
            } else {
                $result = false;
                $message = 'авторизированный пользователь не администратор';
            }
        } else {
            $result = false;
            $message = 'нет авторизированных пользователей';
        }

            return new Json(
                [
                    'message' => $message,
                    'result' => $result
                ]);
        }
}
