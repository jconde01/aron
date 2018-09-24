<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Profile;

class ProfileOption extends Model
{
    public function options() {
    	// return $this->hasMany(Option::class);
        return  DB::table('profile_options')->join('options','options.id','=','profile_options.option_id')->where('profile_options.profile_id', '=', $this->profile_id)->select('options.*')->get();    	
    }


    public function profiles()
    {
    	return $this->hasMany(Profile::class);
    }

    public function option($id)
    {
        return  DB::table('profile_options')->join('options','options.id','=','profile_options.option_id')->where('profile_options.profile_id', '=', $this->profile_id)->where('profile_options.option_id','=', $id)->select('options.*')->first();
    }    

}
