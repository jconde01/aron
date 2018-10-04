<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Client extends Model
{
	public const rutas = Array('Nominas' => 'Nominas','Empleados'=>'Empleados','Timbres'=>'Timbres');

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
