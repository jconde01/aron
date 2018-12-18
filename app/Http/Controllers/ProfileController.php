<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Option;
use App\OptionXRef;  
use App\Profile;
use App\ProfileOption;

class ProfileController extends Controller
{
    public function index()
    {
    	$perfiles = Profile::paginate(5);
        //$perfil = auth()->user()->profile_id;        
        //$navbar = $this::getNavBar('',0,$perfil);
        return view('admin.perfiles.index')->with(compact('perfiles'));
    }

    public function create() 
    {
        return view('admin.perfiles.create');    // forma para insertar nuevo perfil
    }


    public function edit($id) 
    {

        $perfil = Profile::find($id);
        $opcionesHTML = '<div class="panel-group" id="accordion">' . $this->getAccordion('',0,$id) . '</div>';
        return view('admin.perfiles.edit')->with(compact(['perfil','opcionesHTML']));    // forma para editar Perfil
    }


    public static function getAccordion($HTML,$parent,$id)
    {
        static $menuId = 0;
        $xRefs = OptionXRef::where('parent_id','=',$parent)->orderBy('id')->get();
        foreach ($xRefs as $x) {
            $opcion = $x->option();
            $checked = $opcion->profileEnabled($id)? 'checked':'';
            if ($opcion->padre == 1) {            
                $HTML .= '<div class="panel panel-default">';
                $HTML .= '  <div class="panel-heading">';
                $HTML .= '      <h4 class="panel-title">';
                $HTML .= '          <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.++$menuId.'">'.$opcion->nombre.'<span class="caret"></span></a>';
                $HTML .= '          <div class="input-group pull-right">
                                        <span>
                                            <input type="checkbox" aria-label="..." name="Enabled'.$opcion->uuid.'" '.$checked.'>
                                        </span>
                                        <h6>&nbspActivo</h6>
                                    </div>
                                </h4>
                            </div>';
                $HTML .= '  <div id="collapse'.$menuId.'" class="panel-collapse collapse">';
                $HTML .= '      <ul class="list-group">';
                $HTML = self::getAccordion($HTML, $x->id,$id);
                $HTML .= '      </ul>';
                $HTML .= '  </div>';
                $HTML .= '</div>';
            } else {
                $HTML .= '      <li class="list-group-item">'.$opcion->nombre;
                $HTML .= '          <div class="input-group pull-right">
                                        <span>
                                            <input type="checkbox" aria-label="..." name="Enabled'.$opcion->uuid.'" '.$checked.'> 
                                        </span>
                                        <h6>&nbspActivo</h6>
                                    </div>
                                </li>';                
            }
        }
        return $HTML;
    }

    public static function getNavBar($nav,$parent,$profile)
    {
        return '<nav id="main-nav">' . self::getMenu($nav,$parent,$profile) . '</nav>'; 
    }

    public static function getMenu($nav,$parent,$profile)
    {
        $xRefs = OptionXRef::where('parent_id',$parent)->orderBy('id')->get();
        if ($xRefs->count() != 0) {
            foreach ($xRefs as $x) {
                $opcion = $x->option();
                if ($opcion != null) {
                    if ($opcion->activo == 1) {
                        if ($opcion->profileEnabled($profile)) {
                            if ($opcion->padre == 1) {
                                if ($parent != 0) {
                                    $nav .= '<li><a>'.$opcion->nombre.'</a>';
                                } else {
                                    $nav .= '<ul class="dropdown"><li>';                                    
                                }

                                if ($parent == 0) {
                                    $nav .= '  <a>'.$opcion->nombre.'</a>';
                                }
                                $nav .= '    <ul>';
                                $nav = self::getMenu($nav, $x->id,$profile);
                                $nav .= '    </ul>';

                                if ($parent != 0) {
                                    $nav .= '</li>';
                                } else {
                                    $nav .= '</li></ul>';                                    
                                }
                            } else {
                                $nav .= '       <li><a href="'.$opcion->ruta.'">'.$opcion->nombre.'</a></li>';
                            }
                        } 
                    } 
                } else  {
                    $msg = "No existe una OPCION en la tabla de 'options' para el registro en 'option_x_refs':".$x->option_id;
                    dd($msg);                    
                }

            }            
        }
        return $nav;
    }

    public static function getNavBarOld($nav,$parent,$profile)
    {
        $xRefs = OptionXRef::where('parent_id',$parent)->get();
        if ($xRefs->count() != 0) {
            foreach ($xRefs as $x) {
                $opcion = $x->option();
                if ($opcion != null) {
                    if ($opcion->activo == 1) {
                        if ($opcion->profileEnabled($profile)) {
                            if ($opcion->padre == 1) {
                                $nav .= '<li class="dropdown">';
                                $nav .= '  <a class="dropdown-toggle" data-toggle="dropdown" href="#">'.$opcion->nombre.'<span class="caret"></span></a>';
                                $nav .= '    <ul class="dropdown-menu">';
                                $nav = self::getNavBarOld($nav, $x->id,$profile);
                                $nav .= '    </ul>';
                                $nav .= '</li>';
                            } else {
                                $nav .= '       <li><a href="'.$opcion->ruta.'">'.$opcion->nombre.'</a></li>';
                            }
                        }
                    }
                } else  {
                    $msg = "No existe una OPCION en la tabla de 'options' para el registro en 'option_x_refs':".$x->option_id;
                    var_dump($msg);
                    die();                    
                }

            }            
        }
        return $nav;
    }

    public function store(Request $request) 
    {
        // guarda en la BD
        $perfil = new Profile();
        $perfil->nombre = $request->Nombre;
        $perfil->activo = $request->Activo == 'on' ? 1:0; 
        $perfil->save();
        $options = Option::all();
        // guarda TODAS las opciones disponibles al nuevo perfil
        foreach ($options as $option) {
            $PerfilOptions = new ProfileOption();
            $PerfilOptions->profile_id = $perfil->id;
            $PerfilOptions->option_id = $option->id;
            $PerfilOptions->uuid = $option->uuid;
            $PerfilOptions->save();
        }
        return redirect('/admin/perfiles'); 
    }

    public function update(Request $request, $id) 
    {
    	// guarda en la BD
    	//dd($request);
        $perfil = Profile::find($id);
    	$perfil->nombre = $request->Nombre;
        $perfil->activo = $request->Activo == 'on' ? 1:0; 
    	$perfil->save();
        // elimina TODAS las opciones del perfil actual
        $deleted = ProfileOption::where('profile_id',$id)->delete();
        // Obtiene TODAS las opciones existentes
        $options = Option::all(); 
        // Las guarda TODAS como 'INACTIVAS'
        foreach ($options as $option) {
            $profileOption = new ProfileOption();
            $profileOption->profile_id = $id;
            $profileOption->option_id = $option->id;
            $profileOption->uuid = $option->uuid;
            $profileOption->enabled = 0;
            $profileOption->save();
        }        
        // Y por ultimo, pone 'enabled' solo a las seleccionadas
        foreach ($request as $key => $value) {
            if ($key == 'request') {
                foreach ($value as $key => $value) {
                    if (substr($key,0,7) == 'Enabled') {
                        $profileOptionId = substr($key,7);
                        $profileOption = ProfileOption::where([['profile_id', '=', $id],['uuid', '=', $profileOptionId]])->first();
                        $profileOption->enabled = 1;
                        $profileOption->save();
                    }
                }
            }
        }
    	return redirect('/admin/perfiles'); 

    }

}
