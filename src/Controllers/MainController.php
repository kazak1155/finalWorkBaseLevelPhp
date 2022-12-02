<?php

namespace App\Controllers;

use App\Models\MenuAdmin;
use App\Models\MenuUser;
use App\View\View;

/**
 * Class MainController
 * @package App\Controllers
 */
class MainController
{
    public function mainPage()
    {
        $menu = MenuUser::where(null)
            ->get();
        if (isset($_SESSION['status_user']) && $_SESSION['status_user'] == 'administrator') {
            $menu = MenuAdmin::where(null)
                ->get();
            $title = 'Главная страница';
            $status = 'administrator';
            $personalData = '/admin/user/' . $_SESSION['userId'];

            return new View('mainPage.mainPage',
                [
                    'title' => $title,
                    'status' => $status,
                    'menu' => $menu,
                    'personalData' => $personalData
                ]);
        } elseif (isset($_SESSION['status_user']) && $_SESSION['status_user'] == 'user') {
            $menu = MenuUser::where(null)
                ->get();
            $title = 'Главная страница';
            $status = 'user';
            $personalData = '/user/' . $_SESSION['userId'];

            return new View('mainPage.mainPage',
                [
                    'title' => $title,
                    'status' => $status,
                    'menu' => $menu,
                    'personalData' => $personalData
                ]);
        } else {
            header('Location: /login');
        }
    }
}
