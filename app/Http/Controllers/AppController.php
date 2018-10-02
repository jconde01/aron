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

	public function index()
	{
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

}
