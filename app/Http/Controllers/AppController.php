<?php

namespace App\Http\Controllers;

use Session;
use App\Client;
use App\Empresa;
use App\Nomina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class AppController extends Controller
{

	public function index()
	{
        $cliente = Client::where('id',auth()->user()->client_id)->first();
        return view('sistema.chooseTipoYProceso')->with(compact('cliente'));
	}


    public function getProcesos(Request $data) 
    {
        $selCliente = auth()->user()->client;
        if ($data->tipo == 'fiscal') {
            $cia = $selCliente->fiscal_bda;     
        } else {
            $cia = $selCliente->asimilado_bda;
        }
        try {
            $empresaTisanom = Empresa::where('CIA',$cia)->first();
        } catch (\Exception $e) {
            return response('Error');
        }
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

}
