<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Giro;

class GirosController extends Controller
{
    public function index()
    {
    	$giros = Giro::paginate(5);
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('admin.giros.index')->with(compact('giros', 'navbar'));		// listado de giros
    }


    public function create() 
    {
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        return view('admin.giros.create')->with(compact('navbar'));    // forma para insertar nuevo giro
    }


    public function edit($id) 
    {
        $giro = Giro::find($id);
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        return view('admin.giros.edit')->with(compact('giro', 'navbar'));    // forma para editar giro
    }

    public function store(Request $request) 
    {
        // guarda en la BD
        $giro = new Giro();
        $giro->nombre = $request->Nombre;
        $giro->descripcion = $request->Descripcion;
        $giro->save();
        return redirect('/admin/giros'); 
    }

    public function update(Request $request, $id) 
    {
    	// actualiza
        $giro = Giro::find($id);
    	$giro->nombre = $request->Nombre;
        $giro->descripcion = $request->Descripcion; 
    	$giro->save();
   		return redirect('/admin/giros'); 
    }

}
