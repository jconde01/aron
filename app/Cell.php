<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cell extends Model
{
    protected $connection = 'mysql';
    protected $table = 'cells';
}
