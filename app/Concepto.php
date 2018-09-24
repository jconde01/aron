<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'dbo.CONCEPTOS';

    const CAPUNI = "1";
    const CAPIMP = "2";
    const CAPSALAUTO = "3";
    
}
