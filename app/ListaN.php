<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaN extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'dbo.LISTA_N';
    public $timestamps = false;
    public $primaryKey  = 'id';
    protected $casts = [ 'id' => 'string' ];
}
