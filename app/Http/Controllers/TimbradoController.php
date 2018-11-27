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
        Session(['rfc_cliente' => $rfc_cliente]);
        $cliente = Session::get('selCliente');
        $ruta = Client::getRutaPorAutorizar($cliente->cell_id,$rfc_cliente);
		$perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('consultas.timbrado.index')->with(compact('navbar', 'ruta', 'rfc_cliente', 'celula_empresa'));
    }

    public function firmar($archivo)
    {
    	
        $cliente = Session::get('selCliente');
        $celula = $cliente->cell_id;
        $rfc_cliente = Ciasno::first()->RFCCIA;

		$usuario = auth()->user()->name;        
        //$navbar = ProfileController::getNavBar('',0,$perfil);
        require_once "../utilerias/phpqrcode/qrlib.php";
        $fecha= getdate();
        //dd($fecha['mday'], $fecha['mon']);
        $archivo_autorizado = 'autorizado_'.$archivo;

        // realiza el Timbrado (Firma digital) de la cadena
        $sellado = New ProcessController();
        $cadena = $sellado->getPDFText(Client::getRutaPorAutorizar($celula,$rfc_cliente).'/'.$archivo);
        $sello = $sellado->generaFirma($cadena,$celula,$rfc_cliente);

        // guarda el XML que contiene los datos de la cadena y la firma generada
        // este es el archivo que podrá ser utilizado para verificar los datos firmados
        $fileName  = pathinfo($archivo);
        $XMLfile = Client::getRutaAutorizados($celula,$rfc_cliente) . '/' . $fileName["filename"].'.xml';
        $myfile = fopen($XMLfile, "w") or die("Unable to open xml file for writing!");
        fwrite($myfile, $sello);
        fclose($myfile);

        // Obtiene del XML, solamente el sello para adjuntarlo al PDF
        $xml = new \SimpleXMLElement($sello);
        $sello = $xml->xpath('//ds:SignatureValue');

        // genera QRCode con los datos de la cadena
        $ruta_qr = Client::getRutaBase($celula,$rfc_cliente) .'/qr.png';
        QRcode::png($cadena . '|' . $fecha['mday'] . $fecha['mon']. $fecha['year'] . '|' . $usuario,"$ruta_qr",'H',5,3);

        // Abre el documento para agregarle el Sello y QR
        require_once('../utilerias/fpdf/fpdf.php'); 
		require_once('../utilerias/fpdi/Fpdi.php');
		require_once('../utilerias/fpdi/src/autoload.php');
		
		$pdf = new FPDI();
		$pdf->AddPage();
		$pdf->setSourceFile(Client::getRutaPorAutorizar($celula,$rfc_cliente).'/'.$archivo);
        $pdf->SetFont('courier','',10);
		
		$template = $pdf->importPage(1);
		$pdf->useTemplate($template);
		$pdf->Image("$ruta_qr", 170, 232, 30, 30);
        $pdf->SetXY(7,230);
        $pdf->Multicell(50,5,'Firma digital');
        $pdf->SetXY(5, 235);
        $pdf->Multicell(160,5,$sello[0],1);
        $archivo_autorizado = 'autorizado'.$archivo;
        $ruta_pdf = Client::getRutaAutorizados($celula,$rfc_cliente).'/'.$archivo_autorizado;
		$pdf->Output($ruta_pdf, "F");
        File::delete(Client::getRutaPorAutorizar($celula,$rfc_cliente).'/'.$archivo);
       
        // Envia Notificacion al FISCALISTA de que el proceso ha sido efectuado
        $recipient = User::where('profile_id',User::PERFILES_CELULA['FISCALISTA'])->where('cell_id',$celula)->first();  
        $message = Message::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $recipient->id,
            'body' => "El usuario " . auth()->user()->name . " ha autorizado el proceso de la nómina del cliente " . $cliente->Nombre . ". Archivo autorizado: " . $ruta_pdf
        ]);
        $recipient->notify(new MessageSent($message));
    	return back()->with('flash','Confirmacion exitosa. Se ha enviado una notificacion a la célula para su proceso... gracias.');
    }

    /*
        Muestra el archivo pasado como parámetro        
    */
    public function descargaNo($archivo)
    {
        $cliente = Session::get('selCliente');
        $rfc_cliente = Session::get('rfc_cliente');
        $ruta = Client::getRutaPorAutorizar($cliente->cell_id,$rfc_cliente);
        $file=$ruta.'/'.$archivo;
        return Response()->file($file);
    }
}
