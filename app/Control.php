<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'dbo.CONTROL';
    public $timestamps = false;
}
