<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\OptionXRef;
use App\Option;

class OptController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {      
        return view('admin.menuItems.index');
    }


    public function getMenuItems()
    {
        $opcionesJSON = '[' . $this::getOpcionesJSON('',0) . ']';
        return json_decode($opcionesJSON,TRUE);
    }

    public static function getOpcionesJSON($JSON,$parent)
    {
        static $menuId = 0;
        $xRefs = OptionXRef::where('parent_id','=',$parent)->orderBy('id')->get();
        foreach ($xRefs as $x) {
            $opcion = $x->option();
            $checked = $opcion->activo? 'checked':'';
            if ($opcion->padre == 1) {
                $JSON .= '{"text": "'.$opcion->nombre.'", "href": "#", "title": "", "uuid": "'.$opcion->uuid.'", "children": [' . 
                			self::getOpcionesJSON('', $x->id) . ']},';
            } else {
            	$JSON .= '{"text": "'.$opcion->nombre.'", "href": "' . $opcion->ruta . '", "title": "", "uuid": "'.$opcion->uuid.'"},';
            } 
        }
        return substr($JSON,0,-1);
    }


    private function saveOptions($options,$parentId)
    {
    	foreach ($options as $opt) {
    		# code...
	     	$option = new Option();
	     	$parent = isset($opt->children)? 1: 0;
	     	$option->padre = $parent;
	     	$option->nombre = $opt->text;
	     	$option->activo = 1; //($request->Activo)? 1 : 0;
	        $option->ruta = $opt->href;
            if ($option->uuid == "") {
                $option->uuid = $this::uuid();
            }
	    	$option->save();
	     	$optionXRef = new OptionXRef();
		    $optionXRef->option_id = $option->id;
		    $optionXRef->parent_id = $parentId;
		    $optionXRef->save();
		    //var_dump($option);
		    if ($parent == 1) {
		    	$this->saveOptions($opt->children,$option->id);
		    }
    	}
    }


    public function store(Request $data) 
    {

		$options = json_decode($data->txtOptions);
		DB::transaction(function () use($options) {
	    	// elimina TODOS los Menu items
	        OptionXRef::where('id','<>',0)->delete();
	     	Option::where('id','<>',0)->delete();
			$this->saveOptions($options,0);
		});
  		session()->flash('message', 'Opciones guardadas exitósamente!');
		//return redirect('/admin/opciones/'.$parent); 			
    	return redirect()->back();    	
    }    


    private static function uuid($lenght = 13) {
        // uniqid gives 13 chars, but you could adjust it to your needs.
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    } 

}


