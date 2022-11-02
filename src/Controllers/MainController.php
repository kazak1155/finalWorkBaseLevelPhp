<?php

namespace App\Controllers;

use App\View\View;

/**
 * Class MainController
 * @package App\Controllers
 */
class MainController
{
    public function mainPage()
    {
        $title = 'Главная страница';

        return new View('mainPage.mainPage',
            [
                'title' => $title
            ]);
    }

    public function user()
    {
        return new View('mainPage.mainPage',
            [
            ]);
    }
}
