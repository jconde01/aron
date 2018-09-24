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
<<<<<<< HEAD
        $cliente = Client::where('id',auth()->user()->client_id)->first();
        return view('sistema.chooseTipoYProceso')->with(compact('cliente'));
        // return view('sistema.chooseTipoYProceso');
=======
        //return view('sistema.chooseClienteYNomina')->with(compact('clientes'));
        $cliente = Client::where('company_id',auth()->user()->company_id)->first();
        return view('sistema.chooseTipoYProceso')->with(compact('cliente'));
>>>>>>> b5b41dbe96be2895ab4276d8f0741bab86e4f8ec
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
<<<<<<< HEAD
            "driver" => 'sqlsrv',
            "host" => Config::get("database.connections.sqlsrv")["host"],
            "port" => Config::get("database.connections.sqlsrv")["port"],                       
=======
            "driver" => 'sqlsrv',            
            "host" => $empresaTisanom->SERVER,
            "port" => env('DB_PORT_3', '55929'),
>>>>>>> b5b41dbe96be2895ab4276d8f0741bab86e4f8ec
            "database" => $empresaTisanom->DBNAME,
            "username" => $empresaTisanom->USERID,
            "password" => $empresaTisanom->PASS
            ]);
        session(['sqlsrv2' => Config::get("database.connections.sqlsrv2")]);
        // $path_to_file = config_path() . "/database.php";
        // $file_contents = file_get_contents($path_to_file);
        // $file_contents = str_replace("255.255.255.255",Config::get("database.connections.sqlsrv")["host"],$file_contents);
        // $file_contents = str_replace("99999",Config::get("database.connections.sqlsrv")["port"],$file_contents);
        // $file_contents = str_replace("DB3",$empresaTisanom->DBNAME,$file_contents);
        // $file_contents = str_replace("USR3",$empresaTisanom->USERID,$file_contents);
        // $file_contents = str_replace("PWD3",$empresaTisanom->PASS,$file_contents);
        // file_put_contents($path_to_file,$file_contents);        
        $procesos = Nomina::select('TIPONO','NOMBRE')->get();
        return response($procesos);
    }

<<<<<<< HEAD
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
=======
    public function testProcesos($tipo)
    {
        $selCliente = \Cache::get('selCliente');
        $tipoBDA = $tipo;
        if ($tipo == 'fiscal') {
           $cia = $selCliente->fiscal_bda;     
        } else {
           $cia = $selCliente->asimilado_bda;
        }
        // var_dump($selCliente);
        // var_dump($tipoBDA);
        // var_dump($cia);        
        $empresaTisanom = Empresa::where('CIA',$cia)->first();
        // var_dump($empresaTisanom);
        // die();
        Config::set("database.connections.sqlsrv2", [
            "driver" => 'sqlsrv',            
            "host" => $empresaTisanom->SERVER,
            "database" => $empresaTisanom->DBNAME,
            "username" => $empresaTisanom->USERID,
            "password" => $empresaTisanom->PASS
            ]);      
        $procesos = Nomina::select('NOMBRE','TIPONO')->get();

        var_dump($procesos);
        die();
        return response($procesos);
>>>>>>> b5b41dbe96be2895ab4276d8f0741bab86e4f8ec
    }


}
