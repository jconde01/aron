<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    public const check = Array('CHECK1' => 'Gen. Nómina Ciega','CHECK2' => 'IMSS, Al,Ba,CS','CHECK3' => 'Mov. INFONAVIT','CHECK4' => 'Al,Ba,Ca de Deptos','CHECK5' => 'Al,Ba,Ca de Puestos','CHECK6' => 'Alta Empleados','CHECK7' => 'Baja Empleados','CHECK8' => 'Mod Sueldo y Camb Puesto','CHECK9' => 'Ausentismo e Incapa','CHECK10' => 'Horas Extras','CHECK11' => 'Vales Despensa','CHECK12' => 'O. Percepciones Gen.','CHECK13' => 'O. Percepciones Ind.','CHECK14' => 'Créditos Infonavit','CHECK15' => 'O. Deducciones Gen.','CHECK16' => 'O. Deducciones Ind. C y S Saldos','CHECK17' => 'Aguinaldo','CHECK18' => 'PTU','CHECK19' => 'IMSS Mensual','CHECK20' => 'Infonavit Bimestral','CHECK21' => 'CHECK21','CHECK22' => 'CHECK22','CHECK23' => 'CHECK23','CHECK24' => 'CHECK24','CHECK25' => 'CHECK25','CHECK26' => 'CHECK26','CHECK27' => 'CHECK27','CHECK28' => 'CHECK28','CHECK29' => 'CHECK29','CHECK30' => 'CHECK30','CHECK31' => 'CHECK31','CHECK32' => 'CHECK32','CHECK33' => 'CHECK33','CHECK34' => 'CHECK34','CHECK35' => 'CHECK35');
    protected $connection = 'sqlsrv';
    protected $table = 'dbo.CHECKLISTS';
    public $timestamps = false;
    public $primaryKey  = 'id';
    protected $casts = [ 'id' => 'string' ];
}
