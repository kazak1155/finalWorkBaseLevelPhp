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

    public function editUser()
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
}
