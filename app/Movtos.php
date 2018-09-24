<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movtos extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'dbo.MOVTOS';
    public $timestamps = false;
}
