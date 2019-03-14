<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncapaAsimi extends Model
{
     protected $connection = 'sqlsrv3';
    	protected $table = 'INCAPA';
    	public $timestamps = false;
}
