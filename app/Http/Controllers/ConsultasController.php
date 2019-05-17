<?php

namespace App\Http\Controllers;

use Session;
use FPDF;
use QRcode;
use Response;
use App\Cell;
use App\Client;
use App\CiasNo;
use App\Empleado;
use App\Checklist;
use setasign\Fpdi\Fpdi;
use Illuminate\Http\Request;

class ConsultasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('database');
    }

    public function index()
    {
    	$selProceso = Session::get('selProceso');
    	$emps = Empleado::where('TIPONO', $selProceso)->get();
		$perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('consultas.recibos.index')->with(compact('emps', 'navbar'));
    }

     public function consulta($RFC)
     // -------------------Recibos de empleados---------------------------
    { 
        $rfc_cliente = CiasNo::first()->RFCCTE;
        session(['rfc_cliente' => $rfc_cliente]);
        $rfc_empleado0 = $RFC;
        $rfc_empleado1=substr ($rfc_empleado0, 0,4);
        $rfc_empleado2=substr ($rfc_empleado0, 5,6);
        $rfc_empleado3=substr ($rfc_empleado0, 12,3);
        $rfc_empleado= $rfc_empleado1.$rfc_empleado2.$rfc_empleado3;
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $ruta = Client::getRutaBase($cliente->cell_id,$rfc_cliente) . '/Recibos';
        if (is_dir($ruta)){
            
        }else{
            try {
            mkdir($ruta,0755,true);
            } catch (Exception $e) {
                echo "no se pudo crear los directorios para este empleado";
            }

        }
 
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        // dd('fin');
    	return view('consultas.recibos.consulta')->with(compact('navbar', 'ruta', 'rfc_empleado')); 
    }

    public function indexContrato()
    {

    	$selProceso = Session::get('selProceso');
    	$emps = Empleado::where('TIPONO', $selProceso)->get();
		$perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('consultas.contratos.index')->with(compact('emps', 'navbar'));
    }

     public function consultaContrato($RFC)
    {
        $rfc_cliente = CiasNo::first()->RFCCTE;
        $rfc_empleado0 = $RFC;
        $rfc_empleado1=substr ($rfc_empleado0, 0,4);
        $rfc_empleado2=substr ($rfc_empleado0, 5,6);
        $rfc_empleado3=substr ($rfc_empleado0, 12,3);
        $rfc_empleado= $rfc_empleado1.$rfc_empleado2.$rfc_empleado3;
        session(['rfc_empleado' => $rfc_empleado]);
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $ruta = Client::getRutaEmpleados($cliente->cell_id,$rfc_cliente). '/' . $rfc_empleado . '/contratos';
         if (is_dir($ruta)){
            echo "si se pudo";
        }else{
            try {
            mkdir($ruta,0755,true);
            } catch (Exception $e) {
                echo "no se pudo crear los directorios para este empleado";
            }

        }
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('consultas.contratos.consulta')->with(compact('navbar','ruta')); 
    }

     public function descarga($sub, $archivo)
    {
        
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $rfc_cliente = CiasNo::first()->RFCCTE;
        $file= Client::getRutaBase($cliente->cell_id,$rfc_cliente) . '/Recibos/'.$sub.'/'.$archivo;
        return Response::download($file);
    }

    public function descargaCon($archivo)
    {
        
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $rfc_cliente = CiasNo::first()->RFCCTE;
        $rfc_empleado = Session::get('rfc_empleado');
        $file = Client::getRutaEmpleados($cliente->cell_id,$rfc_cliente) .'/'.$rfc_empleado.'/contratos/'.$archivo;
        return Response()->file($file);
        //return Response::download($file);
    }

    public function documentos() 
    {
        $rfc_cliente = CiasNo::first()->RFCCTE;
        session(['rfc_cliente' => $rfc_cliente]);
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $ruta_documentos = Client::getRutaDocumentos($cliente->cell_id,$rfc_cliente);
         if (is_dir($ruta_documentos)){
            
        }else{
            try {
            mkdir($ruta_documentos,0755,true);
            } catch (Exception $e) {
                echo "no se pudo crear los directorios para este empleado";
            }

        }
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
       
        
        return view('consultas.documentos.index')->with(compact('navbar', 'ruta_documentos', 'rfc_cliente', 'celula_empresa'));
    }

    public function subCarpetas($subcarpeta) 
    {
        
        $rfc_cliente = CiasNo::first()->RFCCTE;
        session(['rfc_cliente' => $rfc_cliente]);
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $ruta_documentos = Client::getRutaDocumentos($cliente->cell_id,$rfc_cliente);
        $ruta_documentos = $ruta_documentos.'/'.$subcarpeta;
        
         if (is_dir($ruta_documentos)){
            
        }else{
            try {
            mkdir($ruta_documentos,0755,true);
            } catch (Exception $e) {
                echo "no se pudo crear los directorios para este empleado";
            }

        }
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
       
        
        return view('consultas.documentos.documentos')->with(compact('navbar', 'ruta_documentos', 'rfc_cliente', 'celula_empresa','subcarpeta'));
    }

     public function descargaDoc($subcarpeta,$archivo) 
    {
        
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $rfc_cliente = CiasNo::first()->RFCCTE;
        $file = Client::getRutaDocumentos($cliente->cell_id,$rfc_cliente).'/'.$subcarpeta.'/'.$archivo;
        return Response()->file($file);
        //return Response::download($file);
    }    


    public function checklist()
    {
        $checks = Checklist::check;
        $lists = Checklist::where('CELULA',auth()->user()->cell_id)->get();
        $clientes = Client::get();
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        //dd($clientes);

        return view('consultas.checklist.index')->with(compact('checks','lists','clientes','navbar'));
    }


    public function getDatosChecklist(Request $data) {
        
        $list = Checklist::where('id',$data->fldid)->first();   
        
       return response($list);
       
    }


    public function checklistUpdate(Request $request)
    {
        $list = Checklist::where('id',$request->id)->first();
        foreach ($request->CHECK as $valores) {
           //dd($request->CHECK);
           echo $valores.'<br>';
           $elemento = 'CHECK'.$valores;
           $list->$elemento = 1;
            $list->save();
        }
        $cont = 1;
        //dd($request->FECHA);
       foreach ($request->FECHA as $fecha) {
           echo $fecha.'<br>';
           $fe = 'FECHA'.$cont;
           $list->$fe = $fecha;
           $list->save();
           $cont++;
       }

        //dd('ya');

        return back();
    }       
}
