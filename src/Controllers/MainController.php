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
        return new View('mainPage.mainPage',
            [
            ]);
    }
}
