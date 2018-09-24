<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function users() {
    	return $this->belongsToMany('App\User')->withTimestamps();

    }

    public function files() {
    	return $this->hasMany('App\CompanyFile');
    }
}
