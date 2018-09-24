<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'DEPTOS';
	public $timestamps = false;    
}
