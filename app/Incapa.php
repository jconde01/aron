<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incapa extends Model
{
     protected $connection = 'sqlsrv2';
    	protected $table = 'INCAPA';
    	public $timestamps = false;
}
