<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'PUESTOS';
}
