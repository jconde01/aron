<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use FPDF;
use setasign\Fpdi\Fpdi;
use QRcode;

class TimbradoController extends Controller
{
    
    public function index()
    {

		$perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
       
    	return view('consultas.timbrado.index')->with(compact('navbar'));
    }

    public function firmar()
    {
    	
    	
		$perfil = auth()->user()->name;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        require_once "./phpqrcode/qrlib.php";
        $fecha= getdate();
        //dd($fecha['mday'], $fecha['mon']);
        QRcode::png("VTS180306SV9|NOMINA CATORCENAL|33867.83|41251.02|".$fecha['mday'] . $fecha['mon']. $fecha['year'] . $perfil."","./firma/qr.png",'H',5,3);
        
        require_once('./fpdf/fpdf.php'); 
		require_once('./fpdi/Fpdi.php');
		require_once('./fpdi/src/autoload.php');
		
		$pdf = new FPDI();
		$pdf->AddPage();
		$pdf->setSourceFile("./timbrado/Reporte_servicio_vally.pdf");
		
		$template = $pdf->importPage(1);
		$pdf->useTemplate($template);
		$pdf->Image('./firma/qr.png', 170, 265, 30, 30);

		$pdf->Output("./timbrado/Reporte_servicio_vally.pdf", "F");
		
    	return back()->with('flash','Confirmacion exitosa');
    }
}
