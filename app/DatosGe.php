<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatosGe extends Model
{
    protected $connection = 'sqlsrv2';
    	protected $table = 'EMPGEN';
    	public $timestamps = false;
    	protected $dateFormat = 'M j Y h:i:s';
    	 public $primaryKey  = 'EMP';
    	protected $casts = [ 'EMP' => 'string' ];
}
