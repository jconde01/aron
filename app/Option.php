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
        $profileOption = ProfileOption::where([['profile_id',$profile],['uuid', $this->uuid]])
                ->select('enabled')
                ->first();
        if ($profileOption == null)  return false;
        return $profileOption->enabled == 1;
    }

}
