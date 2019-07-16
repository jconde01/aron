<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conceptos_Asimilados extends Model
{
   protected $connection = 'sqlsrv2';
    protected $table = 'dbo.CONCEPTOS_ASIMILADOS';
    public $timestamps = false;
}
