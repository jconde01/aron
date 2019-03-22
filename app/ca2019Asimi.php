<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ca2019Asimi extends Model
{
    protected $connection = 'sqlsrv3';
    protected $table = 'dbo.CA2019';
    public $timestamps = false;
    public $primaryKey  = 'TIPONO';
    protected $casts = [ 'TIPONO' => 'string' ];
}
