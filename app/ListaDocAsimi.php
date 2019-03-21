<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaDocAsimi extends Model
{
	public const documentos = Array('1' => 'Acta de nacimiento','2' => 'RFC','3' => 'CURP','4' => 'Comprobante domiciliario','5' => 'Solicitud de Empleo','6' => 'IFE o INE','7' => 'Acta de boda','8' => 'Titulo','9' => 'Atecedentes no Penales','10' => 'Contrato','11' => 'Curriculum','12' => 'Cedula Profesional','13' => 'Diplomas Seminarios y Otros','14' => 'Certificaciones','15' => 'Licencia');
    protected $connection = 'sqlsrv3';
    	protected $table = 'LISTADOCUMENTOS';
    	public $timestamps = false;
    	 public $primaryKey  = 'id';
    	protected $casts = [ 'id' => 'string' ];
}
