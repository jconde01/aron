<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'CONTROL';
}
