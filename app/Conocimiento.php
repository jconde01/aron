<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conocimiento extends Model
{
     protected $connection = 'mysql';
    protected $table = 'conocimiento';
    public $timestamps = false;
     public $primaryKey  = 'clasificacion';
    protected $casts = [ 'clasificacion' => 'string' ];
}
