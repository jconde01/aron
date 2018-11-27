<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Client extends Model
{

    public static function getRutaBase($celula, $rfc)
    {
        return '../utilerias/Nominas/celula'.$celula.'/'.$rfc;
    }

    public static function getRutaCertificado($celula, $rfc)
    {
        return self::getRutaBase($celula,$rfc) . '/certificado';
    }


    public static function getRutaAutorizados($celula, $rfc)
    {
        return self::getRutaBase($celula,$rfc) . '/autorizados';
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
