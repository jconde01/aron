<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImssAsimi extends Model
{
   protected $connection = 'sqlsrv3';
    	protected $table = 'IMSS';
    	public $timestamps = false;
}
