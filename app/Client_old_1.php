<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\CiasNo;

class Client extends Model
{

    public static function getRutaBase($celula, $rfc)
    {
        $sucursal = CiasNo::first()->Agrupador;
        // dd($sucursal);
        if ($sucursal == null) {

            return '../utilerias/Nominas/Celula'.$celula.'/'.trim($rfc);
        }else{
            
            return '../utilerias/Nominas/Celula'.$celula.'/'.trim($rfc).'/'.$sucursal;
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
