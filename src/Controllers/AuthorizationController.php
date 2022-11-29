<?php

namespace App\Controllers;

use App\Models\User;
use App\View\Json;
use App\View\View;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

/**
 * Class AuthorizationController for authorization, registration and logout user
 * @package App\Controllers
 */
class AuthorizationController
{
    public function login()
    {
        $title = 'авторизация';
        $user = '';
        if (isset($_GET['email'])) {
            $email = $_GET['email'] ?? '';
            $password = $_GET['password'] ?? '';
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

    public function passwordResetGet()
    {
        if (isset($_GET['code'])) {
            $email = $_GET['email'];
            $user = User::where('email', $email)->first();
            $user->password = password_hash('12345', PASSWORD_DEFAULT);
            $user->save();
            $message = 'пароль для пользователя с email ' . $email . ' установлен на "12345"';

            return new Json(
                [
                    'message' => $message,
                ]);
        }

        if (isset($_GET['email'])) {
            $email = $_GET['email'];
            $user = User::where('email', $email)->first();
            if (isset($user)) {
                $code = rand(1, 1000);
                $letterBody = 'Для восстановления пароля перейдите по <a href="http://' . $_SERVER['SERVER_NAME'] . ':8000' . '/passwordReset?code=' . $code . '&email=' . $email . '">' . 'ссылке</a>.';
                $mail = new PHPMailer(true);
                $mail->SMTPDebug = 2;         /*Оставляем как есть*/
                $mail->isSMTP();              /*Запускаем настройку SMTP*/
                $mail->Host = 'app.debugmail.io'; /*Выбираем сервер SMTP*/
                $mail->SMTPAuth = true;        /*Активируем авторизацию на своей почте*/
                $mail->Username = '2e6f2a3c-3a66-4bae-95fe-7e1dbc7b6df5';   /*Имя(логин) от аккаунта почты отправителя */
                $mail->Password = '6e3c8573-3410-43b6-a900-463581444a7c';        /*Пароль от аккаунта  почты отправителя */
                $mail->SMTPSecure = 'false';            /*Указываем протокол*/
                $mail->Port = 25;            /*Указываем порт*/
                $mail->CharSet = 'UTF-8';/*Выставляем кодировку*/

                $mail->setFrom('admin@mail.ru');/*Указываем адрес почты отправителя */
                /*Указываем перечень адресов почты куда отсылаем сообщение*/
                $mail->addAddress($email, $user->name . ' ' . $user->surname);

                $mail->isHTML(true);      /*формируем html сообщение*/
                $mail->Subject = 'сброс пароля'; /*Заголовок сообщения*/
                $mail->Body = $letterBody;/* Текст сообщения */
                $mail->AltBody = 'сообщение о сбросе пароля входа на сайт';/*Описание сообщения */
                $mail->send();
                //                sendEmail($email, 'Восстановление пароля', $letterBody);
                $message = 'На почту  с ' . $email . ' отправлено письмо со ссылкой на восстановление пароля';
                return new Json(
                    [
                        'message' => $message,
                    ]);
            } else {
                $message = 'такого пользователя нет в БД';

                return new Json(
                    [
                        'message' => $message,
                    ]);
            }
        } else {
            $message = 'email не введен';

            return new Json(
                [
                    'message' => $message,
                ]);
        }
    }
}
