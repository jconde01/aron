<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Client extends Model
{
	public const Rutas = Array('PorTimbrar' => '../utilerias/Nominas','Timbrados'=>'../utilerias/Nominas','Contratos'=>'../utilerias/Nominas');

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
