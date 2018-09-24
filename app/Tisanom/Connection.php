<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //

Config::set("database.connections.tisanom", [
    "host" => "127.0.0.1",
    "port" => "1433",
    "database" => "ADMINISTRADORES_FORDN",
    "username" => "sa",
    "password" => "condeb"
	]);    
}



