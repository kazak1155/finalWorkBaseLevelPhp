<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Directory
 * @package App\Models
 */
class Directory extends Model
{
    protected $table = 'directory';

//    public function folder()
//    {
//        return $this->belongsTo(File::class, 'directory_id', 'id');
//    }
}
