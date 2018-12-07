<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imss extends Model
{
     protected $connection = 'sqlsrv2';
    	protected $table = 'dbo.IMSS';
    	public $timestamps = false;
}
