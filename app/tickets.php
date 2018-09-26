<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tickets extends Model
{
     protected $connection = 'mysql';
    protected $table = 'tickets';
    public $timestamps = false;
     public $primaryKey  = 'folio';
    protected $casts = [ 'folio' => 'string' ];
}
