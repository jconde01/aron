<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use FPDF;
use setasign\Fpdi\Fpdi;
use QRcode;
use App\Client;
use App\Ciasno;
use Session;
use App\Cell;
use Response;
use File;
 
class TimbradoController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('database');
    }
    
    public function index()
    {
    	$rfc_cliente = Ciasno::first()->RFCCIA;
        session(['rfc_cliente' => $rfc_cliente]);
        $ruta = Client::Rutas['PorTimbrar'] .'/';
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;

		$perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
       
		
    	return view('consultas.timbrado.index')->with(compact('navbar', 'ruta', 'rfc_cliente', 'celula_empresa'));
    }

    public function firmar($archivo)
    {
    	
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $rfc_cliente = Session::get('rfc_cliente');
        $ruta = Client::Rutas['PorTimbrar'] .'/';

		$perfil = auth()->user()->name;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        require_once "../utilerias/phpqrcode/qrlib.php";
        $fecha= getdate();
        //dd($fecha['mday'], $fecha['mon']);
        $archivo_autorizado = 'autorizado'.$archivo;
        $ruta_qr = $ruta.$celula_empresa.'/'.$rfc_cliente.'/qr/qr.png';
        
        QRcode::png("VTS180306SV9|NOMINA CATORCENAL|33867.83|41251.02|".$fecha['mday'] . $fecha['mon']. $fecha['year'] . $perfil."","$ruta_qr",'H',5,3);
        
        require_once('../utilerias/fpdf/fpdf.php'); 
		require_once('../utilerias/fpdi/Fpdi.php');
		require_once('../utilerias/fpdi/src/autoload.php');
		
		$pdf = new FPDI();
		$pdf->AddPage();
		$pdf->setSourceFile("$ruta$celula_empresa/$rfc_cliente/porautorizar/$archivo");
		
		$template = $pdf->importPage(1);
		$pdf->useTemplate($template);
		$pdf->Image("$ruta_qr", 170, 265, 30, 30);
        $archivo_autorizado = 'autorizado'.$archivo;
        $ruta_pdf = $ruta.$celula_empresa.'/'.$rfc_cliente.'/porautorizar/'.$archivo_autorizado;

		$pdf->Output("$ruta_pdf", "F");
        File::delete("$ruta$celula_empresa/$rfc_cliente/porautorizar/$archivo");
       
		
    	return back()->with('flash','Confirmacion exitosa');
    }


     public function descargaNo($archivo)
    {
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $rfc_cliente = Session::get('rfc_cliente');
        $ruta = Client::Rutas['PorTimbrar'] .'/';
        $file="$ruta$celula_empresa/$rfc_cliente/porautorizar/$archivo";
        return Response()->file($file);

        //return Response::download($file);
    }
}
