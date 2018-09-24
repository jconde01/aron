<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Option;
use App\OptionXRef;
use App\Http\Controllers\ProfileController;


class OptionController extends Controller
{
    //protected $navbar;

    public function __construct()
    {
        $this->middleware('auth');
        //$navbar = ProfileController::getNavBar('',0,0);        
    }


    public static function getAccordion($HTML,$parent)
    {
        static $menuId = 0;
        $xRefs = OptionXRef::where('parent_id','=',$parent)->get();
        foreach ($xRefs as $x) {
            $opcion = $x->option();
            $checked = $opcion->activo? 'checked':'';
            if ($opcion->padre == 1) {
                $HTML .= '<div class="panel panel-default">';
                $HTML .= '  <div class="panel-heading">';
                $HTML .= '      <h4 class="panel-title">';
                $HTML .= '          <a  style="text-decoration:none;" data-toggle="collapse" data-parent="#accordion" href="#collapse'.++$menuId.'">'.$opcion->nombre.'<span class="caret"></span></a>';
                $HTML .= '          <form class="pull-right" method="post" action="/admin/opciones/'.$opcion->id.'">
                                        <?php csrf_field() ?>
                                        <?php method_field(\'DELETE\') ?>
                                        <span class="input-group">
                                            <h6>Activo&nbsp&nbsp</h6>
                                            <input type="checkbox" aria-label="..." disabled name="opcion'.$opcion->id.'" '.$checked.'>
                                        </span>
                                        <a href="/admin/opciones/create/'.$opcion->id.'" rel="tooltip" title="Agregar" class="btn btn-info btn-simple btn-xs">
                                            <i class="fa fa-plus"></i>
                                        </a>                                        
                                        <a href="/admin/opciones/'.$opcion->id.'/edit" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="submit" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </h4>
                            </div>';
                $HTML .= '  <div id="collapse'.$menuId.'" class="panel-collapse collapse">';
                $HTML .= '      <ul class="list-group">';
                $HTML = self::getAccordion($HTML, $x->id);
                $HTML .= '      </ul>';
                $HTML .= '  </div>';
                $HTML .= '</div>';
            } else {
                $HTML .= '      <li class="list-group-item">'.$opcion->nombre;
                $HTML .= '          <form class="pull-right" method="post" action="/admin/opciones/'.$opcion->id.'">
                                        <?php csrf_field() ?>
                                        <?php method_field(\'DELETE\') ?>
                                        <span class="input-group">
                                            <h6>Activo&nbsp&nbsp</h6>
                                            <input type="checkbox" aria-label="..." disabled name="opcion'.$opcion->id.'" '.$checked.'>
                                        </span>                                        
                                        <a href="/admin/opciones/'.$opcion->id.'/edit" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="submit" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </li>';                
            } 
        }
        return $HTML;
    }


    public function index($nivel)
    {
    	// $xRef = new OptionXRef();
    	// $opciones = $xRef->options($nivel);
     //    return view('admin.opciones.index')->with(compact('opciones'));
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        $opcionesHTML = '<div class="panel-group" id="accordion">' . $this->getAccordion('',0) . '</div>';
        return view('admin.opciones.index')->with(compact('opcionesHTML', 'navbar'));    // forma para editar Opciones

    }


    public function create($parent = 0) 
    {
    	$option = new Option();
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	if (!$parent == 0) $option = Option::find($parent);
        return view('admin.opciones.create')->with(compact('option','parent', 'navbar'));    // forma para insertar nueva opción     
    }


    public function destroy($id)
    {
        return view('admin.opciones.delete');
    }


    public function edit($id) 
    {
        //$opcionesHTML = '<div class="panel-group" id="accordion">' . $this->getAccordion('',0,$id) . '</div>';
        $option = Option::find($id);
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        return view('admin.opciones.edit')->with(compact('option', 'navbar'));    // forma para editar Opcion
    }


    public function store(Request $request, $parent) 
    {
    	// guarda en options y option_x_refs
    	$option = new Option();
    	$optionXRef = new OptionXRef();
    	$option->nombre = $request->Nombre;
    	$option->padre = ($request->Padre)? 1: 0;
    	$option->activo = ($request->Activo)? 1 : 0;
        $option->ruta = $request->Ruta;
    	$option->save();
    	$optionXRef->option_id = $option->id;
    	$optionXRef->parent_id = $parent;
    	$optionXRef->save();
    	return redirect('/admin/opciones/'.$parent); 
    }


    public function update(Request $request, $id) 
    {
        // guarda en la BD
        // dd($request);
        $option = Option::find($id);
        //$optionXRef = OptionXRef::find($option->xref->parent_id);
        $option->nombre = $request->Nombre;
        $option->padre = ($request->Padre)? 1: 0;
        $option->activo = ($request->Activo)? 1 : 0;
        $option->ruta = $request->Ruta;
        $option->save();
        // $optionXRef->option_id = $option->id;
        // $optionXRef->parent_id = $parent;
        // $optionXRef->save();
        return redirect('/admin/opciones/0'); 
    }    

}
