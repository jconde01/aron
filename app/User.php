<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Profile;
use App\Client;

class User extends Authenticatable
{
    use Notifiable;

    public const PERFILES_CELULA = array('NOMINISTA' => 6, 'FISCALISTA' => 7);
    public const NOMINISTA_CELULA = 6;
    public const FISCALISTA_CELULA = 7;

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
        return $this->belongsTo(Client::class);
    }    

    public function profile() {
        return $this->belongsTo(Profile::class);
    }    

}
