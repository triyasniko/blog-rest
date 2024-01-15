<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
        /**
     * @var string
     */
    protected $table = 'articles';

    /**
     * @var array
     */
    protected $guarded=[];
}
