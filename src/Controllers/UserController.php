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

    public function registration()
    {
        $title = 'регистрация пользователя';
        $_SESSION['error'] = '';
        if (isset($_POST['send']) && $_POST['send'] != '') {
            $_SESSION['registration'] = '1';
            $newUser = new User();
            $userEmail = User::where('email', $_POST['email'])->first();
//            var_dump($userEmail); exit;
            if (isset($userEmail->email)) {
                $_SESSION['error'] = 'пользователь с таким  email уже есть в БД';
            } else {
                $newUser->name = $_POST['name'] ?? '';
                $newUser->surname = $_POST['surname'] ?? '';
                $newUser->password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
                $newUser->email = $_POST['email'] ?? '';
                $newUser->created_at = time();
                $newUser->status = 'user';
//                $newUser->save();
                $_SESSION['success'] = 'пользователь с email= ' . $newUser->email . ' создан';
                $_SESSION['registration'] = '555';
                header('Location: /login');
            }

            return new Json(
                [
                    'title' => $title,
                ]);
        }

        return new View('authorization.registration',
            [
                'title' => $title,
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
