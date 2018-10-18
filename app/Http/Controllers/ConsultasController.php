<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Empleado;
use FPDF;
use setasign\Fpdi\Fpdi;
use QRcode;
use Response;
use App\Ciasno;
use App\Cell;


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
        $ruta = Empleado::Rutas['Timbrados'] .'/';
        $rfc_empleado0 = $RFC;
        $rfc_empleado1=substr ($rfc_empleado0, 0,4);
        $rfc_empleado2=substr ($rfc_empleado0, 5,6);
        $rfc_empleado3=substr ($rfc_empleado0, 12,3);
        $rfc_empleado= $rfc_empleado1.$rfc_empleado2.$rfc_empleado3;
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;

       $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('consultas.recibos.consulta')->with(compact('navbar', 'ruta', 'rfc_cliente', 'rfc_empleado', 'celula_empresa')); 
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
        $ruta = Empleado::Rutas['Contratos'] .'/';
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
        $ruta = Empleado::Rutas['Timbrados'] .'/';
        $file="$ruta$celula_empresa/$rfc_cliente/timbrado/$archivo";
        return Response::download($file);
    }

    public function descargaCon($archivo)
    {
        
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $rfc_cliente = Session::get('rfc_cliente');
        $rfc_empleado = Session::get('rfc_empleado');
        $ruta = Empleado::Rutas['Contratos'] .'/';
        $file="$ruta$celula_empresa/$rfc_cliente/empleados/$rfc_empleado/contratos/$archivo";
        return Response()->file($file);
        //return Response::download($file);
    }
}
