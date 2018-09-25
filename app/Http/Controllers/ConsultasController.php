<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Empleado;
use FPDF;
use setasign\Fpdi\Fpdi;
use QRcode;


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

     public function consulta($id)
    {
        
       $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('consultas.recibos.consulta')->with(compact('navbar')); 
    }

    public function indexContrato()
    {
    	$selProceso = Session::get('selProceso');
    	$emps = Empleado::where('TIPONO', $selProceso)->get();
		$perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('consultas.contratos.index')->with(compact('emps', 'navbar'));
    }

     public function consultaContrato($id)
    {
        
       $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('consultas.contratos.consulta')->with(compact('navbar')); 
    }
}
