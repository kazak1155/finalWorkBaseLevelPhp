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
        $menu = MenuAdmin::where(null)
            ->get();
        $menu = MenuUser::where(null)
            ->get();
        if (isset($_SESSION['status_user'])) {
            var_dump($_SESSION['status_user']); exit;
        }
        $title = 'Главная страница';

        return new View('mainPage.mainPage',
            [
                'title' => $title
            ]);
    }
}
