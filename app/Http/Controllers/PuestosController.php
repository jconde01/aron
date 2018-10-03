<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use Illuminate\Support\Facades\DB;

class PuestosController extends Controller
{

    public function __construct()
    {
        $this->middleware('database');
    }
        
    public function index()
    {
    	$jobs = Job::all();
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('catalogos.puestos.index')->with(compact('jobs', 'navbar'));
    }
    public function create()
    {
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        $puesto = Job::all()->last();
        $ultimo = $puesto->PUESTO + 1;
    	return view('catalogos.puestos.create')->with(compact('navbar', 'ultimo'));
    }
    public function store(Request $request) 
    {
    	$job = new Job();
        $job->PUESTO = $request->input('PUESTO');
    	$job->NOMBRE = $request->input('NOMBRE');
    	$job->NIVEL = $request->input('NIVEL');
    	$job->NPUESTO = $request->input('NPUESTO');
    	$job->AUTORIZADA = $request->input('AUTORIZADA');
    	$job->OCUPADAS = $request->input('OCUPADAS');
    	$job->SUELDO = $request->input('SUELDO');
    	$job->CATEGP = $request->input('CATEGP');
    	$job->save();
    	return redirect('/catalogos/puestos');
    }

    public function edit($puesto)
    {
        $jobs = Job::where('PUESTO', $puesto)->get();
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('catalogos.puestos.edit')->with(compact('jobs', 'navbar'));
    }
    public function update(Request $request, $PUESTO)
    {

        $pues = JOB::where('PUESTO', $PUESTO)->get()->first();
        $pues->PUESTO = $request->input('PUESTO');
    	$pues->NOMBRE = $request->input('NOMBRE');
    	$pues->NIVEL = $request->input('NIVEL');
    	$pues->NPUESTO = $request->input('NPUESTO');
    	$pues->AUTORIZADA = $request->input('AUTORIZADA');
    	$pues->OCUPADAS = $request->input('OCUPADAS');
    	$pues->SUELDO = $request->input('SUELDO');
    	$pues->CATEGP = $request->input('CATEGP');
        $pues->save();
        
    	return redirect('/catalogos/puestos');
    }
}
