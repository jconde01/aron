<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatosAfoAsimi extends Model
{
    protected $connection = 'sqlsrv3';
    	protected $table = 'DETAFO';
    	public $timestamps = false;
    	protected $dateFormat = 'M j Y h:i:s';
    	 public $primaryKey  = 'EMP';
    	protected $casts = [ 'EMP' => 'string' ];
}