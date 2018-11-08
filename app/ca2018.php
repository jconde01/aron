<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ca2018 extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'dbo.CA2018';
    public $timestamps = false;
    public $primaryKey  = 'TIPONO';
    protected $casts = [ 'TIPONO' => 'string' ];
   
}
