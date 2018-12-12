<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movesp extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'dbo.MOVESP';
    public $timestamps = false;
}
