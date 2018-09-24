<?php 
 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
     	protected $connection = 'sqlsrv2';
    	protected $table = 'PUESTOS';
    	public $timestamps = false;
}
