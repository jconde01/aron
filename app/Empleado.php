<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Nomina;

class Empleado extends Model
{
	public const Rutas = Array('Imagenes' => '/admon/empleados/empresas/','Documentos'=>'/admon/empleados/docs/','Timbres'=>'/admon/empleados/timbres/');
    protected $connection = 'sqlsrv2';
    protected $table = 'dbo.EMPLEADO';
    public $timestamps = false;
    public $primaryKey  = 'EMP';
    protected $casts = [ 'EMP' => 'string' ];
    
    public function tipoNo() {
    	return $this->belongsTo(Nomina::class,'TIPONO');
    }    
}
 