<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VariacionEstra extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'dbo.VARIACIONESTRA';
}
