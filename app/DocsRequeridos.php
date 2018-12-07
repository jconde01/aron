<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocsRequeridos extends Model
{
      protected $connection = 'sqlsrv2';
    protected $table = 'DOCSREQUERIDOS';
    public $timestamps = false;
    public $primaryKey  = 'id';
    	protected $casts = [ 'id' => 'string' ]; 
}
