<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use FPDF;
use setasign\Fpdi\Fpdi;
use QRcode;
use App\User;
use App\Client;
use App\Ciasno;
use Session;
use App\Cell;
use Response;
use File;
use App\Message;
use App\Notifications\MessageSent;
use App\Http\Controllers\ProcessController;
 
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
        $celula = $cliente->cell_id;
        $celula_empresa = Cell::where('id', $celula)->first()->nombre;
        $rfc_cliente = Session::get('rfc_cliente');
        $ruta = Client::Rutas['PorTimbrar'] .'/';

		$perfil = auth()->user()->name;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        require_once "../utilerias/phpqrcode/qrlib.php";
        $fecha= getdate();
        //dd($fecha['mday'], $fecha['mon']);
        $archivo_autorizado = 'autorizado'.$archivo;
        $ruta_qr = $ruta.$celula_empresa.'/'.$rfc_cliente.'/qr/qr.png';

        $sellado = New ProcessController();
        $cadena = $sellado->getPDFText("$ruta$celula_empresa/$rfc_cliente/porautorizar/$archivo");

        QRcode::png($cadena . $fecha['mday'] . $fecha['mon']. $fecha['year'] . $perfil."","$ruta_qr",'H',5,3);
        $sello = $sellado->generaFirma($cadena);

        $xml = new \SimpleXMLElement($sello);

        $sello = $xml->xpath('//ds:SignatureValue');

        require_once('../utilerias/fpdf/fpdf.php'); 
		require_once('../utilerias/fpdi/Fpdi.php');
		require_once('../utilerias/fpdi/src/autoload.php');
		
		$pdf = new FPDI();
		$pdf->AddPage();
		$pdf->setSourceFile("$ruta$celula_empresa/$rfc_cliente/porautorizar/$archivo");
        $pdf->SetFont('courier','',10);
		
		$template = $pdf->importPage(1);
		$pdf->useTemplate($template);
		$pdf->Image("$ruta_qr", 170, 232, 30, 30);
        $pdf->SetXY(7,230);
        $pdf->Multicell(50,5,'Firma digital');
        $pdf->SetXY(5, 235);
        $pdf->Multicell(160,5,$sello[0],1);
        $archivo_autorizado = 'autorizado'.$archivo;
        $ruta_pdf = $ruta.$celula_empresa.'/'.$rfc_cliente.'/porautorizar/'.$archivo_autorizado;

		$pdf->Output("$ruta_pdf", "F");
        File::delete("$ruta$celula_empresa/$rfc_cliente/porautorizar/$archivo");
       
        $recipient = User::where('profile_id',User::PERFILES_CELULA['FISCALISTA'])->where('cell_id',$celula)->first();  

        // crea el mensaje
        $message = Message::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $recipient->id,
            'body' => "El usuario " . auth()->user()->name . " ha autorizado el proceso de la nómina dell cliente " . $cliente->Nombre
        ]);
        $recipient->notify(new MessageSent($message));

    	return back()->with('flash','Confirmacion exitosa. Se ha enviado una notificacion a la célula para su proceso... gracias.');
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
