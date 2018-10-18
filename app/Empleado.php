<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Nomina;

class Empleado extends Model
{
	public const Rutas = Array('Imagenes' => '../utilerias/Nominas','Timbrados'=>'../utilerias/Nominas','Contratos'=>'../utilerias/Nominas');
    protected $connection = 'sqlsrv2';
    protected $table = 'dbo.EMPLEADO';
    public $timestamps = false;
    public $primaryKey  = 'EMP';
    protected $casts = [ 'EMP' => 'string' ];
    
    public function tipoNo() {
    	return $this->belongsTo(Nomina::class,'TIPONO');
    }    
}
 