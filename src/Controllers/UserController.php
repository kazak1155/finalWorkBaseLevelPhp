<?php

namespace App\Controllers;

use App\Models\User;
use App\View\View;

/**
 * Class UserController
 * @package App\Controllers
 */
class UserController
{
    public function PersonalAreaUser($id)
    {
        $title = 'Личный кабинет';
        $user = User::find($id);

        return new View('user.lk',
            [
                'title' => $title,
                'user' =>$user
            ]);
    }

}
