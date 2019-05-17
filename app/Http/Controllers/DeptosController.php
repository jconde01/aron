<?php  

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Depto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DeptosController extends Controller
{

    public function __construct()
    {
        $this->middleware('database');
    }
    
    public function index()
    {
        try {
            $control =Schema::connection('sqlsrv2')->hasTable('PERIODO');
            } catch (\Exception $e) {
                return redirect('/home');
                die("Could not connect to the database.  Please check your configuration. error:" . $e );
            }
        $deps = Depto::all();
        $deptos = Depto::all();
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('catalogos.deptos.index')->with(compact('deps','deptos', 'navbar'));
    }


    public function create()
    {
        try {
            $control =Schema::connection('sqlsrv2')->hasTable('PERIODO');
            } catch (\Exception $e) {
                return redirect('/home');
                die("Could not connect to the database.  Please check your configuration. error:" . $e );
            }
        $deps = Depto::all();
        $depto = Depto::all()->last();
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        $ultimo = $depto->DEPTO + 1;
        
    	return view('catalogos.deptos.create')->with(compact('deps', 'ultimo', 'navbar'));
    }


    public function store(Request $request)
    {
        
    	$depto = new Depto();
        $depto->DEPTO = $request->input('DEPTO');
        $depto->DESCRIP = $request->input('DESCRIP');
        $depto->NDEPTO = $request->input('NDEPTO');
        $depto->NAREA = $request->input('NAREA');
        $depto->save();
        return redirect('/catalogos/deptos');
    }


    public function edit($dep)
    {
        try {
            $control =Schema::connection('sqlsrv2')->hasTable('PERIODO');
            } catch (\Exception $e) {
                return redirect('/home');
                die("Could not connect to the database.  Please check your configuration. error:" . $e );
            }
        $depto = Depto::where('DEPTO', $dep)->get()->first();
        $deps = Depto::all();
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        return view('catalogos.deptos.edit')->with(compact('depto','deps', 'navbar')); 
    }


    public function update(Request $request, $dep)
    {

        $depto = Depto::where('DEPTO', $dep)->get()->first();
        //dd($depto);
        $depto->DEPTO = $request->input('DEPTO');
        $depto->DESCRIP = $request->input('DESCRIP');
        $depto->NDEPTO = $request->input('NDEPTO');
        $depto->NAREA = $request->input('NAREA');
        $depto->save();
        return redirect('/catalogos/deptos');
    }
}
