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
        if (isset($_GET['code'])) {
            $email = $_SESSION['email'];
            $user = User::where('email', $email)->first();
            $user->password = password_hash('12345', PASSWORD_DEFAULT);
//            $user->save();
            $_SESSION['success'] = 'пароль для пользователя с email ' . $email . ' сброшен на 12345';
            $message = 'пароль для пользователя с email ' . $email . ' сброшен на 12345';
            return new Json(
                [
                    'message' => $message,
                ]);
        } else {
            $user = '';
            $title = 'passwordReset';

            return new View('authorization.passwordReset',
                [
                    'title' => $title,
                    'user' => $user,
                ]);
        }
    }

    public function passwordResetPost()
    {
        $email = $_REQUEST['email'];
        $_SESSION['email'] = $email;
        if (isset($_REQUEST['passwordReset'])) {
            $user = User::where('email', $email)->first();
            if (isset($user)) {
                $code = rand(1,1000);
                $letterBody = 'Для восстановления пароля перейдите по <a href="http://' . $_SERVER['SERVER_NAME'] . ':8000' . '/passwordReset?code=' . $code . '">' . 'ссылке</a>.';
//                echo $letterBody;
                $mail = new PHPMailer(true);
                $mail->SMTPDebug = 2;         /*Оставляем как есть*/
                $mail->isSMTP();              /*Запускаем настройку SMTP*/
                $mail->Host = 'smtp.mail.ru'; /*Выбираем сервер SMTP*/
                $mail->SMTPAuth = true;        /*Активируем авторизацию на своей почте*/
                $mail->Username = 'login';   /*Имя(логин) от аккаунта почты отправителя */
                $mail->Password = 'password';        /*Пароль от аккаунта  почты отправителя */
                $mail->SMTPSecure = 'ssl';            /*Указываем протокол*/
                $mail->Port = 465;			/*Указываем порт*/
                $mail->CharSet = 'UTF-8';/*Выставляем кодировку*/


                $mail->setFrom('example@mail.ru', 'Андрей Грибин');/*Указываем адрес почты отправителя */
                /*Указываем перечень адресов почты куда отсылаем сообщение*/
                $mail->addAddress($email, $user->name . ' ' . $user->surname);


                $mail->isHTML(true);      /*формируем html сообщение*/
                $mail->Subject = 'сброс пароля'; /*Заголовок сообщения*/
                $mail->Body    = $letterBody;/* Текст сообщения */
                $mail->AltBody = 'сообщение о сбросе пароля входа на сайт';/*Описание сообщения */
                $mail->send();
//                sendEmail($email, 'Восстановление пароля', $letterBody);
//                return 'На вашу почту отправлено письмо со ссылкой на восстановление пароля';
                $message = 'На почту  с '. $email.  ' отправлено письмо со ссылкой на восстановление пароля';
            } else {
                $message = 'такого email нет в БД';
            }
        } else {
            $message = 'кнопка "сброс пароля" не нажата';
        }

        return new Json(
            [
                'message' => $message,
            ]);
    }
}
