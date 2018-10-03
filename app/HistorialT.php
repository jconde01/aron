<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialT extends Model
{
     protected $connection = 'mysql';
    protected $table = 'historialtick';
    public $timestamps = false;
     public $primaryKey  = 'folio';
    protected $casts = [ 'folio' => 'string' ];
}
