<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 */
class User extends Model
{
    protected $table = 'users';

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_user');
    }
}
