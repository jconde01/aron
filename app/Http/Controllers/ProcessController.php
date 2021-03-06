<?php

namespace App\Http\Controllers;
use Auth;
use Session;
use App\User;
use App\CiasNo;
use App\Client;
use App\Periodo;
use App\Message;
use PdfToText;
use Illuminate\Http\Request;
use App\Notifications\MessageSent;
use Illuminate\Support\Facades\Hash;
use webcoder31\ezxmldsig\XMLDSigToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class ProcessController extends Controller
{

    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('database');
    	
        
    }


	public function Nomina()
	{
		try {
		    $control =Schema::connection('sqlsrv2')->hasTable('PERIODO');
			} catch (\Exception $e) {
				return redirect('/home');
			    die("Could not connect to the database.  Please check your configuration. error:" . $e );
			}
		$selProceso = Session::get('selProceso');
		$periodo = Periodo::where('TIPONO',$selProceso)->where('SWCIERRE','0')->first();
		$perfil = auth()->user()->profile_id;
		$navbar = ProfileController::getNavBar('',0,$perfil);
		return view('procesos.nomina')->with(compact('periodo','navbar'));
	}


	// Envia notificación al GENERALISTA de la célula para el pre-proceso de la nómina
	public function requestNomina(Request $data)
	{
		
    	$selCliente = Session::get('selCliente');
    	$celula = $selCliente->cell_id;
  		$recipient = User::where('profile_id',User::PERFILES_CELULA['GENERALISTA'])->where('cell_id',$celula)->first();  

        // crea el mensaje
    	$message = Message::create([
    		'sender_id' => auth()->id(),
    		'recipient_id' => $recipient->id,
    		'body' => "El usuario " . auth()->user()->name . " ha solicitado el pre-proceso del período " . $data->periodo .  " del cliente " . $selCliente->Nombre
    	]);
    	$recipient->notify(new MessageSent($message));

    	return back()->with('flash','Notificación enviada');		
	}


	public function generaFirma($cadena, $celula, $rfc, $passphrase)
	{
		// Load required classes manualy.
		require(dirname(__DIR__) .'/../../vendor/robrichards/xmlseclibs/xmlseclibs.php');
		require(dirname(__DIR__) . '/../../vendor/webcoder31/ezxmldsig/ezxmldsig.php');

		// Autoload required classes.
		require dirname(__DIR__) . '/../../vendor/autoload.php';

		// Asymmetric cryptographic key pair for signing (in PEM format).
		$rutaCert = Client::getRutaCertificado($celula, $rfc);
		$signKey = $rutaCert.'/'.$rfc.'-priv.key';
        $signCert = $rutaCert.'/'.$rfc.'-cert.pem';
		$signKeyPassword = $passphrase;

		// User data.
		$values = explode("|",$cadena);
		foreach ($values as $key => $value) {
			$data['valor'.$key] = $value;
		}

		// Create token for user data.
		$token = XMLDSigToken::createXMLToken($data, $signKey, $signCert, $signKeyPassword);

		// Get the XML Digital Signature. 
		$sig = $token->getXML();
		return $sig;
		// Now, verify the token

		//$sig = base64_decode($sig);
		//var_dump(htmlentities($sig));
		//die();

		// Private key (and eventualy its passphrase) to be used 
		// to decrypt token (required if user data is encrypted).
		//$cryptKey = 'path/to/crypting/private/key';
		//$cryptKeyPassword = 'crypting-key-password'; // Use null if it is not needed.

		// The issuer information of the sender to which the certificate transmitted
		// in the XML digital signature should correspond to be declared valid.
		// $expectedIssuer = [
		//     'C'  => 'MERIDA',
		//     'ST' => 'YUCATAN',
		//     'O'  => 'VALLY TECNOLOGIES',
		//     'OU' => '',
		//     'CN' => '',
		//     'emailAddress' => ''
		// ];

		// CA intermediate certificate against which to verify origin of 
		// the signing certificate transmitted in the XML Digital Signature.
		//'path/to/ca/intermediate/certificate';
		//++$caCertPath = public_path() . '/keys/my-test.cert.pfx'; 

		// Create token object from the XML Digital Signature 
		//$token = XMLDSigToken::analyzeSecureXMLToken($sig, $cryptKey, $cryptKeyPassword);
		//++$token = XMLDSigToken::analyzeXMLToken($sig);


		// NOTE: The above instruction works even if user data is not encrypted.
		// However, if user data is not encrypted and you don't own a private key 
		// then use the following method:
		// $token = XMLDSigToken::analyzeXMLToken($sig);

		// Verify that:
		// - the XML digital signature meets the XMLDSIG specifications.
		// - the algorithms used to construct the XML digital signature are those 
		//   expected (here, the default ones).
		// - the token contained in the XML digital signature has not been altered.
		// - the token contained in the XML digital signature is correctly timestamped
		//   and contains user data.
		// if (!$token->isValid()) 
		// {
		//     echo "ERROR: Invalid XML Digital Signature!";
		//     exit();
		// }

		// ++Verify that the X.509 certificate included in 
		// ++the XML digital signature is not out of date.
		// ++if ($token->isCertOutOfDate()) 
		// ++{
		// ++    echo "ERROR: Signing certificate is out of date!";
		// ++    exit();
		// ++}

		// Verify that the issuer of the X.509 certificate included 
		// in the XML digital signature is indeed the one we expect.
		// if (!$token->checkCertIssuer($expectedIssuer)) 
		// {
		//     echo "ERROR: Issuer of signing certificate is not valid!";
		//     exit();
		// }

		// Verify that the X.509 certificate included in the XML
		// digital signature actualy comes from the CA we expect.
		// if (!$token->checkCertCA($caCertPath)) 
		// {
		//     echo "ERROR: Signing certificate not issued by the expected CA!";
		//     exit();
		// }

		// ++Verify that the XML token was issued less than 2 minutes ago.
		// ++if ($token->isOutOfDate(365)) 
		// ++{
		// ++    echo "ERROR: Token is out of date!";
		// ++    exit();
		// ++}

		// All is fine ! We can trust user data.
		//echo "\nToken data: \n";
		//var_dump($token->getData());
		//echo "\n";	
		//echo "\nsello: \n";
		//var_dump($sig); 
		//die();
		
	}


	public function getSignedData(Request $request) {

        $cliente = Session::get('selCliente');
        $celula = $cliente->cell_id;
        $rfc_cliente = CiasNo::first()->RFCCTE;
        $ruta = Client::getRutaAutorizados($celula,$rfc_cliente);
        $xmlFile = $ruta.'/'.$request->file;
        if (file_exists($xmlFile)) {
            //$xml = simplexml_load_file($xmlFile);
            $file = fopen($xmlFile,"r");
            $xmlString = fread($file, filesize($xmlFile));
        } else {
            return back()->with('error','No pude abrir el archivo: '.$xmlFile);
        }

        $token = XMLDSigToken::analyzeXMLToken($xmlString);
        if (!$token->isSignatureValid()) 
        {
            return back()->with('error','Firma digital inválida: '.$token->getError());
        }

        return response($token->getHTMLDump());

		// The issuer information of the sender to which the certificate transmitted
		// in the XML digital signature should correspond to be declared valid.
		// $expectedIssuer = [
		//     'C'  => 'MERIDA',
		//     'ST' => 'YUCATAN',
		//     'O'  => 'VALLY TECNOLOGIES',
		//     'OU' => '',
		//     'CN' => '',
		//     'emailAddress' => ''
		// ];

		// CA intermediate certificate against which to verify origin of 
		// the signing certificate transmitted in the XML Digital Signature.
		//'path/to/ca/intermediate/certificate';
		//++$caCertPath = public_path() . '/keys/my-test.cert.pfx'; 

		// Create token object from the XML Digital Signature 
		//$token = XMLDSigToken::analyzeSecureXMLToken($sig, $cryptKey, $cryptKeyPassword);
		//++$token = XMLDSigToken::analyzeXMLToken($sig);


		// NOTE: The above instruction works even if user data is not encrypted.
		// However, if user data is not encrypted and you don't own a private key 
		// then use the following method:
		// $token = XMLDSigToken::analyzeXMLToken($sig);

		// Verify that:
		// - the XML digital signature meets the XMLDSIG specifications.
		// - the algorithms used to construct the XML digital signature are those 
		//   expected (here, the default ones).
		// - the token contained in the XML digital signature has not been altered.
		// - the token contained in the XML digital signature is correctly timestamped
		//   and contains user data.
		// if (!$token->isValid()) 
		// {
		//     echo "ERROR: Invalid XML Digital Signature!";
		//     exit();
		// }

		// ++Verify that the X.509 certificate included in 
		// ++the XML digital signature is not out of date.
		// ++if ($token->isCertOutOfDate()) 
		// ++{
		// ++    echo "ERROR: Signing certificate is out of date!";
		// ++    exit();
		// ++}

		// Verify that the issuer of the X.509 certificate included 
		// in the XML digital signature is indeed the one we expect.
		// if (!$token->checkCertIssuer($expectedIssuer)) 
		// {
		//     echo "ERROR: Issuer of signing certificate is not valid!";
		//     exit();
		// }

		// Verify that the X.509 certificate included in the XML
		// digital signature actualy comes from the CA we expect.
		// if (!$token->checkCertCA($caCertPath)) 
		// {
		//     echo "ERROR: Signing certificate not issued by the expected CA!";
		//     exit();
		// }

		// ++Verify that the XML token was issued less than 2 minutes ago.
		// ++if ($token->isOutOfDate(365)) 
		// ++{
		// ++    echo "ERROR: Token is out of date!";
		// ++    exit();
		// ++}

		// All is fine ! We can trust user data.
		//echo "\nToken data: \n";
		//return response($token->getData());		
	}

	public function getPDFText($file)
	{

    	function output( $message ) { 
	        if ( php_sapi_name ( ) == 'cli' ) 
	            echo ( $message ) ; 
	        else 
	            echo ( nl2br ( $message ) ) ; 
	    }

	    function getLastLine($text) {
	    	$line = ''; $pos = strrpos($text,'|'); $veces =0;
	    	while ( $pos != 0 && $veces <= 4) {
	    		$line = substr($text,$pos);
	    		$npos = (strlen($text) - $pos) * -1;
	    		$pos = strrpos($text,'|',--$npos);
	    		$veces++;
	    	}
	    	return $line;
	    }

		require_once('./phpclasses/PdfToText.phpclass');

		// Autoload required classes.
		//require dirname(__DIR__) . '/../../vendor/autoload.php';

	    //$file = public_path() . '/files/Reporte_servicio_vally' ; 
	    $pdf = new PdfToText ( $file ) ; 

	    //output( "Original file contents :\n" ) ; 
	    //output( file_get_contents( "$file.pdf" ) ) ; 
	    //output( "-----------------------------------------------------------\n" ) ; 
	    //dd($pdf);
	    //output( "Contenido a sellar:\n" ) ;
	    $cadena = getLastLine($pdf -> Text); 
	    //output( $cadena . "\n" );
	    $cadena = substr($cadena,1);
	    //return explode("|",$cadena);
	    return $cadena;
	}
}
