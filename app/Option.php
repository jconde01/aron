<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OptionXRef;

class Option extends Model
{

	public function xref()
	{
		return $this->hasOne(OptionXRef::class);
	}

	// public function getParentNameAttribute()
	// {
	// 	// $x = new OptionXRef();
	// 	// $p = $x->where('option_id',$this->id)->select('parent_id')->first();
	// 	return $this->xref->parent_id;
	// }

	public function parent()
	{
		return $this->xref->parent_id;
	}


    public function profileEnabled($profile = 0)
    {
        if ($profile == 0) $profile = auth()->user()->profile_id;
        $profileOption = ProfileOption::where([['profile_id',$profile],['option_id', $this->id]])
                ->select('enabled')
                ->first();
                // if ($profileOption == null) {
                //     var_dump('No existe un valor en `profile_options` para el perfil: '.$profile, 'y la opcion: '.$this->id);
                //     die();
                // }
        if ($profileOption == null)  return false;
        return $profileOption->enabled == 1;
    }

}
