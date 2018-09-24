<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;

class EmployeeController extends Controller
{
    //
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $selProceso = \Cache::get('selProceso');
    //     if (isset($selProceso)) {
    //         $empleados = Empleado::where('TIPONO',$selProceso)->paginate(10);
    //     } else {
    //         $empleados = Empleado::paginate(10);
    //     }
    //     $perfil = auth()->user()->profile->id; 
    //     $navbar = ProfileController::getNavBar('',0,0);        
    //     return view('catalogos.empleados.index')->with(compact('empleados','navbar'));
    // }

}
