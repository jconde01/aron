<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciasno extends Model
{
     protected $connection = 'sqlsrv2';
    protected $table = 'CIASNO';
    public $timestamps = false;
    public $primaryKey  = 'NOMBRE'; 
}
