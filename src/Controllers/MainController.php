<?php

namespace App\Controllers;

use App\View\View;

/**
 * Class MainController
 * @package App\Controllers
 */
class MainController
{
    public function homepage()
    {
        return new View('mainPage.mainPage',
            [
            ]);
    }
}
