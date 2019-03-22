<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControlAsimi extends Model
{
    protected $connection = 'sqlsrv3';
    protected $table = 'dbo.CONTROL';
    public $timestamps = false;
}
