<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\CiasNo;
use App\Nomina;
use Session;


class Client extends Model
{

    public static function getRutaBase($celula, $rfc)
    {
        $sucursal = CiasNo::first()->Agrupador;
        $selProceso = Session::get('selProceso');
        $NoNominas = Nomina::get();
        $NoNominas = count($NoNominas);
        
        if ($sucursal == null) {            
            if ($NoNominas>1) {
                $nomina = Nomina::where('TIPONO',$selProceso)->first();
                $nombre = explode(" ", $nomina->NOMBRE);
                return '../utilerias/Nominas/Celula'.$celula.'/'.trim($rfc).'/'.$nombre[1];
            }else{
               return '../utilerias/Nominas/Celula'.$celula.'/'.trim($rfc); 
            }            
        }else{
             if ($NoNominas>1) {
                $nomina = Nomina::where('TIPONO',$selProceso)->first();
                $nombre = explode(" ", $nomina->NOMBRE);
                return '../utilerias/Nominas/Celula'.$celula.'/'.trim($rfc).'/'.$sucursal.'/'.$nombre[1];
            }else{
               return '../utilerias/Nominas/Celula'.$celula.'/'.trim($rfc).'/'.$sucursal;
            }
        }
    }

    public static function getRutaCertificado($celula, $rfc)
    {
        return self::getRutaBase($celula,$rfc) . '/certificado';
    }


    public static function getRutaAutorizados($celula, $rfc)
    {
        return self::getRutaBase($celula,$rfc) . '/facturacion';
    }


    public static function getRutaPorAutorizar($celula, $rfc)
    {
        return self::getRutaBase($celula,$rfc) . '/porautorizar';
    }


    public static function getRutaDocumentos($celula, $rfc)
    {
        return self::getRutaBase($celula,$rfc) . '/documentos';
    }


    public static function getRutaEmpleados($celula, $rfc)
    {
        return self::getRutaBase($celula,$rfc) . '/empleados';
    }


    public static function getRutaTimbrado($celula, $rfc)
    {
        return self::getRutaBase($celula,$rfc) . '/timbrado';
    }


    public function users()
    {
        return $this->hasMany(User::class);
    }
}
