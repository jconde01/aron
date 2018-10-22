<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Client;

class Message extends Model
{
    protected $guarded = ['id'];

    public function sender()
    {
    	return $this->belongsTo(User::class,'sender_id');
    }

    public function client()
    {
    	return $this->sender->belongsTo(Client::class,'client_id');
    }
}
