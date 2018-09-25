<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Client;
use App\Empresa;
use App\Nomina;
use Session;

class AppController extends Controller
{

    var $clientName = "";

	public function index()
	{
        // if (auth()->user()->profile_id == env('APP_ADMIN_PROFILE')) {
        //     $clientes = Client::all();
        // } else {
        //     $clientes = Client::where('company_id',auth()->user()->company_id)->get();
        // }
        $cliente = Client::where('id',auth()->user()->client_id)->first();
        return view('sistema.chooseTipoYProceso')->with(compact('cliente'));

	}


    public function getProcesos(Request $data)
    {
        $selCliente = auth()->user()->client;
        $tipoBDA = $data->tipo;
        if ($data->tipo == 'fiscal') {
            $cia = $selCliente->fiscal_bda;     
        } else {
            $cia = $selCliente->asimilado_bda;
        }
        $empresaTisanom = Empresa::where('CIA',$cia)->first();
        Config::set("database.connections.sqlsrv2", [

            "driver" => 'sqlsrv',
            "host" => Config::get("database.connections.sqlsrv")["host"],
            "port" => Config::get("database.connections.sqlsrv")["port"],                       
            "database" => $empresaTisanom->DBNAME,
            "username" => $empresaTisanom->USERID,
            "password" => $empresaTisanom->PASS
            ]);
        session(['sqlsrv2' => Config::get("database.connections.sqlsrv2")]);
        $procesos = Nomina::select('TIPONO','NOMBRE')->get();
        return response($procesos);
    }


    public function testProcesos()
    {
        dd(Config::get("database.connections.sqlsrv2"));      
        // $selCliente = auth()->user()->client;
        // $empresaTisanom = Empresa::where('CIA',1)->first();
        // Config::set("database.connections.sqlsrv2", [
        //     "driver" => 'sqlsrv',
        //     "host" => Config::get("database.connections.sqlsrv")["host"],
        //     "port" => Config::get("database.connections.sqlsrv")["port"],                       
        //     "database" => $empresaTisanom->DBNAME,
        //     "username" => $empresaTisanom->USERID,
        //     "password" => $empresaTisanom->PASS
        //     ]);
        // $procesos = Nomina::select('TIPONO','NOMBRE')->get();
        // dd(Config::get("database.connections.sqlsrv2"));      
        return redirect("home");

    }


}
