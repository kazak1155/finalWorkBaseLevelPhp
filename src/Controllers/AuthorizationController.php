<?php

namespace App\Controllers;

use App\Models\User;
use App\View\View;
use MongoDB\Driver\Session;

/**
 * Class AuthorizationController for authorization user
 * @package App\Controllers
 */
class AuthorizationController
{
    public function auth()
    {
//        var_dump($_POST);
        if (!isset($_POST['logout'])) {
            $user = '';
            $title = 'аторизация';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            if (isset($_POST['send'])) {
                $user = User::where('email', $email)->first();
                if (isset($user)) {
                    if ($user->email == $email && password_verify($password, $user->password )) {
                        $_SESSION['userId'] = $user->id ;
                        if (isset($user->status)) {
                            $_SESSION['status_user'] = $user->status;
                            $_SESSION['auth'] = 'auth';
                            $_SESSION['userId'] = $user->id;
                            $_SESSION['success'] = 'вы авторизированы';
                        }
                        header('Location: /');
                    } else {
                        $_SESSION['error'] = 'неправильно введен пароль';
                    }
                } else {
                    $_SESSION['error'] = 'такого пользователя нет в БД';
                }
            }
        } else {
            $user = '';
            $title = 'выйти с сайта';
            session_destroy();
        }

        return new View('authorization.authorization',
            [
                'title' => $title,
                'user' => $user,
            ]);
    }
}
