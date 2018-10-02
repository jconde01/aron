<?php

namespace App\Http\Controllers;

//use Symfony\Component\Console\Output as Output;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppController;
use App\Profilew;
use App\Client;
use App\Empresa;
use App\Nomina;
use Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('database');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $perfil = auth()->user()->profile_id;
        if ($perfil == env('APP_ADMIN_PROFILE')) {
            return view('home');
        } else {
            // $clientes = Client::where('company_id',auth()->user()->company_id)->get();
            // $tipoNomina = Nomina::all();
            // return view('sistema.chooseClienteYNomina')->with(compact('clientes'));
            //return redirect('/sistema/chooseClienteYNomina');
            //$selCliente = auth()->user()->client->id;
            if (auth()->user()->client == NULL) {
                // Es un usuario de una célula
                $navbar = ProfileController::getNavBar('',0,$perfil);
                return view('home')->with(compact('navbar'));
            } else {
                // Usuario normal de un cliente
                $cliente = auth()->user()->client;
                if (Auth::check()){
                    session(['selCliente' => $cliente]);
                }
                // Checa si ya se seleccionó el Tipo y Proceso de Nomina
                $selProceso = Session::get('selProceso');
                if ($selProceso != '') {
                    $navbar = ProfileController::getNavBar('',0,$perfil);
                    return view('home')->with(compact('navbar'));
                } else {
                    //return redirect('/sistema/chooseTipoYProceso');
                    return view('sistema.chooseTipoYProceso')->with(compact('cliente'));
                }
            }
        }
    }


    public function setSessionData(Request $request)
    {
        //$selCliente = $request->Tisanom_cia;
        $selProceso = $request->proceso;
        //dd(Config::get("database.connections.sqlsrv2"));
        //$selProcessObj = DB::connection('sqlsrv2')->table('NOMINA')->where('TIPONO',$selProceso)->first();
        //Config::set("database.connections.sqlsrv2", Session::get('sqlsrv2'));
        $selProcessObj = Nomina::select('NOMBRE','MINIMODF')->where('TIPONO',$selProceso)->first();

        $clienteYProceso = auth()->user()->client->Nombre . " - " . $selProcessObj->NOMBRE;
        // Config::set('tisanom.selCliente',$selCliente);
        // Config::set('tisanom.selProceso',$selProceso);

        session(['selProceso' => $selProceso]);
        //\Cache::put('selProceso',$selProceso,1440);
        session(['minimoDF' => $selProcessObj->MINIMODF]);
        //\Cache::put('minimoDF',$selprocessObj->MINIMODF,1440);
        session(['clienteYProceso' => $clienteYProceso]);
        //\Cache::put('clienteYProceso',$clienteYProceso,1440);
        //dd(Config::get('tisanom.selCliente') . ' - ' . Config::get('tisanom.selProceso'));
        return redirect('home');
    }    

}
