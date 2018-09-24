<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    protected $connection = 'sqlsrv2';
    	protected $table = 'SATEDOS';
    	public $timestamps = false;
}
