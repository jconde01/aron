<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Auth;
use App\User;
use App\Option;
use App\ProfileOption;

class OptionXRef extends Model
{

	public function option()
	{
		//return $this->hasOne(Option::class,'id');
        //return DB::table('options')->join('option_x_refs','options.id','=','option_x_refs.option_id')->where('option_x_refs.option_id', '=', $this->option_id)->select('options.*','option_x_refs.parent_id as parent')->first();
        //return DB::table('options')->where('options.id', '=', $this->option_id)->select('options.*')->first();
        $option = Option::find($this->option_id);
        return $option;
	}


    public function options($parent)
    {
        // esta funcion no se si será util <<TODO>>
        //return $this->hasMany('App\Option');
        return  DB::table('options')->join('option_x_refs','options.id','=','option_x_refs.option_id')->where('option_x_refs.parent_id', '=', $parent)->select('options.*','option_x_refs.parent_id')->paginate(100);
    }


    public function profiles()
    {
        return $this->hasMany(ProfileOption::class,'option_id');
    }
    

    public static function getOptionsTree($tree, $parent = 0)
    {
        // Obtiene los hijos del nodo padre
    	$xRefs = self::where('parent_id','=',$parent)->get();
    	// Puede que no encuentre ninguno, pero si encuentra, obtiene los hijos recursivamente
    	foreach ($xRefs as $x) {
    		$tree = $tree->concat([$x]);
    		$tree = self::getOptionsTree($tree, $x->id);
    	}
    	return $tree;
    }
}
