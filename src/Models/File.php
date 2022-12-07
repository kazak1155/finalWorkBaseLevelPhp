<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class File
 * @package App\Models
 */
class File extends Model
{
    protected $table = 'files';

    public function folder()
    {
        return $this->belongsTo(Directory::class, 'directory_id', 'id');
    }
}
