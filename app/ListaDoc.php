<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaDoc extends Model
{
    protected $connection = 'sqlsrv2';
    	protected $table = 'LISTADOCUMENTOS';
    	public $timestamps = false;
    	 public $primaryKey  = 'id';
    	protected $casts = [ 'id' => 'string' ];
}
