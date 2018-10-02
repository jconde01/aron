<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Graph extends Model
{
    protected $connection = 'mysql';
    protected $table = 'graphs';
}
