<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conceptos_Asimilados_A extends Model
{
     protected $connection = 'sqlsrv3';
    protected $table = 'dbo.CONCEPTOS_ASIMILADOS';
    public $timestamps = false;
}
