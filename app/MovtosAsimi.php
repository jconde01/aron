<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovtosAsimi extends Model
{
    protected $connection = 'sqlsrv3';
    protected $table = 'dbo.MOVTOS';
    public $timestamps = false;
}
