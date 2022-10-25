<?php

use App\Models\User;
?>
<html>
<head>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://bootstraptema.ru/plugins/2015/bootstrap3/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"/>
    <title>
        <?= $title ?>
    </title>
    <meta charset="UTF-8">
</head>
<body>
<?php if (isset($_SESSION['userId'])) { ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbar-example">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Главная страница</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile">Личный кабинет</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/outSession">Выйти с сайта</a>
                    </li>
                    <?php
                    $userId = $_SESSION['userId'];
                    $user = User::where('id', $userId)->first();
                    if (isset($user->status->name)) {
                        $status = $user->status->name;
                        if ($status == 'контент менеджер') { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/contentManager/menu">Меню контент менеджера</a>
                            </li>
                        <?php }
                    }?>
                    <?php
                    $userId = $_SESSION['userId'];
                    $user = User::where('id', $userId)->first();
                    if (isset($user->status->name)) {
                        $status = $user->status->name;
                        if ($status == 'Администратор') { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin">Админка</a>
                            </li>
                        <?php }
                    }?>
                    <li class="nav-item">
                        <a class="nav-link" href="/ruleSite">Правила сайта</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php } else { ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbar-example">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Главная страница</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/authorization">Авторизация</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/registration">Регистрация</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/staticPage">Статичная ссылка</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ruleSite">Правила сайта</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php } ?>
<div class="container">
