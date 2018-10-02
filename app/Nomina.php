<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'NOMINA';
    public $timestamps = false;
    public $primaryKey  = 'TIPONO';    
}
