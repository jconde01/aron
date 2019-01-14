<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Profile;
use App\Client;

class User extends Authenticatable
{
    use Notifiable;

    // Esto no me gusta... Deberia de consultarse los perfiles y buscar sus ID's
    public const PERFILES_CELULA = array('DIRECTOR' => 4, 'GENERALISTA' => 5, 'QC' => 6, 'FISCALISTA' => 7, 'SOPORTE' => 8);


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function client() {
        return $this->belongsTo(Client::class,'client_id');
    }    

    public function profile() {
        return $this->belongsTo(Profile::class);
    }    

}
