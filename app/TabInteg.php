<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TabInteg extends Model
{

    protected $connection = 'sqlsrv2';
    protected $table = 'dbo.TABINTEG';
}
