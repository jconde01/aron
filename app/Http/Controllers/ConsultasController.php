<?php

namespace App\Http\Controllers;

use Session;
use FPDF;
use QRcode;
use Response;
use App\Cell;
use App\Client;
use App\Ciasno;
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
        // require_once "./phpqrcode/qrlib.php";
        // QRcode::png("prueba numero 1","./contratos/qr.png",'H',5,2);

  //       require_once('./fpdf/fpdf.php'); // Incluímos las librerías anteriormente mencionadas
		//  // Incluímos las librerías anteriormente mencionadas
		// require_once('./fpdi/Fpdi.php');
		// require_once('./fpdi/src/autoload.php');
		
		// $pdf = new FPDI();
		// $pdf->AddPage();
		// $pdf->setSourceFile("./contratos/QUMS.pdf"); // Sin extensión

		// $template = $pdf->importPage(1);
		// $pdf->useTemplate($template);
		// $pdf->Image('./img/qr.jpg', 10, 265, 30, 30);

		// $pdf->Output("./contratos/QUMS.pdf", "F");
		
    	return view('consultas.recibos.index')->with(compact('emps', 'navbar'));
    }

     public function consulta($RFC)
    {
        $rfc_cliente = Ciasno::first()->RFCCIA;
        session(['rfc_cliente' => $rfc_cliente]);
        $rfc_empleado0 = $RFC;
        $rfc_empleado1=substr ($rfc_empleado0, 0,4);
        $rfc_empleado2=substr ($rfc_empleado0, 5,6);
        $rfc_empleado3=substr ($rfc_empleado0, 12,3);
        $rfc_empleado= $rfc_empleado1.$rfc_empleado2.$rfc_empleado3;
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $ruta = Client::getRutaTimbrado($cliente->cell_id,$rfc_cliente);
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
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
        $rfc_cliente = Ciasno::first()->RFCCIA;
        $rfc_empleado0 = $RFC;
        $rfc_empleado1=substr ($rfc_empleado0, 0,4);
        $rfc_empleado2=substr ($rfc_empleado0, 5,6);
        $rfc_empleado3=substr ($rfc_empleado0, 12,3);
        $rfc_empleado= $rfc_empleado1.$rfc_empleado2.$rfc_empleado3;
        session(['rfc_empleado' => $rfc_empleado]);
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;

        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('consultas.contratos.consulta')->with(compact('navbar','ruta', 'rfc_empleado','rfc_cliente', 'celula_empresa')); 
    }

     public function descarga($archivo)
    {
        
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $rfc_cliente = Session::get('rfc_cliente');
        $file= Client::getRutaAutorizados($cliente->cell_id,$rfc_cliente) . '/'.$archivo;
        return Response::download($file);
    }

    public function descargaCon($archivo)
    {
        
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $rfc_cliente = Session::get('rfc_cliente');
        $rfc_empleado = Session::get('rfc_empleado');
        $file = Client::gerRutaEmpleados($cliente->cell_id,$rfc_cliente) .'/'.$rfc_empleado.'/contratos/'.$archivo;
        return Response()->file($file);
        //return Response::download($file);
    }

    public function documentos() 
    {
        $rfc_cliente = Ciasno::first()->RFCCIA;
        session(['rfc_cliente' => $rfc_cliente]);
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $ruta_documentos = Client::getRutaDocumentos($cliente->cell_id,$rfc_cliente);
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
       
        
        return view('consultas.documentos.index')->with(compact('navbar', 'ruta_documentos', 'rfc_cliente', 'celula_empresa'));
    }

     public function descargaDoc($archivo) 
    {
        
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $rfc_cliente = Session::get('rfc_cliente');
        $file = Client::getRutaDocumentos($cliente->cell_id,$rfc_cliente).'/'.$archivo;
        return Response()->file($file);
        //return Response::download($file);
    }    


    public function checklist()
    {
        $checks = Checklist::check;
        $lists = Checklist::where('CELULA',auth()->user()->cell_id)->get();
        $clientes = Client::get();
        //dd($clientes);

        return view('consultas.checklist.index')->with(compact('checks','lists','clientes'));
    }


    public function getDatosChecklist(Request $data) {
        
        $list = Checklist::where('id',$data->fldid)->first();   
        
       return response($list);
       
    }


    public function checklistUpdate(Request $request)
    {
        $list = Checklist::where('id',$request->id)->first();
        foreach ($request->CHECK as $valores) {
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
