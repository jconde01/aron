<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VarCostoActual extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'dbo.VARCOSTOACTUAL';
}
