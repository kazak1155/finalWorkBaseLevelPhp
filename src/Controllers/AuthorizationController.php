<?php

namespace App\Controllers;

use App\Models\User;
use App\View\Json;
use App\View\View;

/**
 * Class AuthorizationController for authorization, registration and logout user
 * @package App\Controllers
 */
class AuthorizationController
{
    public function login()
    {
        $user = '';
        $title = 'авторизация';
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

        return new View('authorization.authorization',
            [
                'title' => $title,
                'user' => $user,
            ]);
    }

    public function logout()
    {
        $result = 'вы успешно вышли с сайта';
        session_destroy();

        return new Json(
            [
                'result' => $result
            ]);
    }

    public function registration()
    {
        $title = 'регистрация пользователя';
        $_SESSION['error'] = '';
        var_dump($_POST);
        if (isset($_POST['send']) && $_POST['send'] != '') {
            $_SESSION['registration'] = '1';
            $newUser = new User();
            $userEmail = User::where('email', $_POST['email'])->first();
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
        }

    return new View('authorization.registration',
        [
            'title' => $title,
        ]);
    }

    public function passwordResetGet()
    {
        $user = '';
        $title = 'passwordReset';

        return new View('authorization.passwordReset',
            [
                'title' => $title,
                'user' => $user,
            ]);
    }

    public function passwordResetPost()
    {
        $email = $_REQUEST['email'];
        if (isset($_REQUEST['passwordReset'])) {
            $user = User::where('email', $email)->first();
            if (isset($user)) {
                $user->password = password_hash('12345', PASSWORD_DEFAULT);
                $user->save();
                // Сообщение
                $message = 'пароль установлен на 12345';
                // Отправляем
                mail($email, 'пароль сброшен', $message);
                $message = 'пароль для пользователя с email ' . $email . ' установлен на 12345';
            } else {
                $message = 'такого email нет в БД';
            }
        } else {
            $message = 'кнопка "сброс пароля не нажата';
        }

        return new Json(
            [
                'message' => $message,
            ]);
    }
}
