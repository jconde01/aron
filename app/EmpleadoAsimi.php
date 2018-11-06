<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpleadoAsimi extends Model
{
    protected $connection = 'sqlsrv3';
    protected $table = 'dbo.EMPLEADO';
    public $timestamps = false;
    public $primaryKey  = 'EMP';
    protected $casts = [ 'EMP' => 'string' ];
}
