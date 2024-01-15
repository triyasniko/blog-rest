<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * @var string
    */
    protected $table = 'tags';

    /**
     * @var array
     */
    protected $guarded=[];
}
