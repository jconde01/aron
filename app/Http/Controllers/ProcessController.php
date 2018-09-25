<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\User;
use App\Periodo;
use App\Message;
use App\Notifications\MessageSent;
use webcoder31\ezxmldsig\XMLDSigToken;


class ProcessController extends Controller
{
	public function Nomina()
	{
		$selProceso = Session::get('selProceso');
		$periodo = Periodo::where('TIPONO',$selProceso)->where('SWCIERRE','0')->first();
		return view('procesos.nomina')->with(compact('periodo'));
	}

	public function requestNomina(Request $data)
	{
    	$recipient = User::find(1);		// Por ahora, lo manda al usuario 1
    	$selCliente = Session::get('selCliente');
        // crea el mensaje
    	$message = Message::create([
    		'sender_id' => auth()->id(),
    		'recipient_id' => $recipient->id,
    		'body' => "El usuario " . auth()->user()->name . " ha solicitado el pre-proceso del período " . $data->periodo .  " del cliente " . $selCliente->Nombre
    	]);
    	$recipient->notify(new MessageSent($message));

    	return back()->with('flash','Notificación enviada');		
	}


	public function generaFirma()
	{
		// Load required classes manualy.
		require(dirname(__DIR__) .'\..\..\vendor\robrichards\xmlseclibs\xmlseclibs.php');
		require(dirname(__DIR__) . '/../../vendor/webcoder31/ezxmldsig/ezxmldsig.php');

		// Autoload required classes.
		require dirname(__DIR__) . '/../../vendor/autoload.php';

		// Asymmetric cryptographic key pair for signing (in PEM format).
		$signKey = public_path() . '/keys/my-key.pem';
		$signCert = public_path() . '/keys/my-cert.pem';
		$signKeyPassword = '12345678'; // Use null if it is not needed.

		// User data.
		$data = [
		    'name' => 'Jorge Conde B.',
		    'role' => 'Admin',
		    'location' => 'Vally'
		];

		// Create token for user data.
		$token = XMLDSigToken::createXMLToken($data, $signKey, $signCert, $signKeyPassword);

		// Get the XML Digital Signature. 
		$sig = $token->getXML();

		// Display the XML Digital Signature.
		//return htmlentities($sig);		# code...

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
		$expectedIssuer = [
		    'C'  => 'MERIDA',
		    'ST' => 'YUCATAN',
		    'O'  => 'VALLY TECNOLOGIES',
		    'OU' => '',
		    'CN' => '',
		    'emailAddress' => ''
		];

		// CA intermediate certificate against which to verify origin of 
		// the signing certificate transmitted in the XML Digital Signature.
		//'path/to/ca/intermediate/certificate';
		$caCertPath = public_path() . '/keys/my-test.cert.pfx'; 

		// Create token object from the XML Digital Signature 
		//$token = XMLDSigToken::analyzeSecureXMLToken($sig, $cryptKey, $cryptKeyPassword);
		$token = XMLDSigToken::analyzeXMLToken($sig);


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

		// Verify that the X.509 certificate included in 
		// the XML digital signature is not out of date.
		if ($token->isCertOutOfDate()) 
		{
		    echo "ERROR: Signing certificate is out of date!";
		    exit();
		}

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

		// Verify that the XML token was issued less than 2 minutes ago.
		if ($token->isOutOfDate(365)) 
		{
		    echo "ERROR: Token is out of date!";
		    exit();
		}

		// All is fine ! We can trust user data.
		echo "Token data:";
		var_dump($token->getData());
		var_dump($token);
		die();		
	}

    function output ( $message ) 
       { 
        if ( php_sapi_name ( ) == 'cli' ) 
            echo ( $message ) ; 
        else 
            echo ( nl2br ( $message ) ) ; 
        } 

	public function getPDFText()
	{
		require(dirname(__DIR__) . '/../../vendor/phpclasses/PdfToText.phpclass');

		// Autoload required classes.
		require dirname(__DIR__) . '/../../vendor/autoload.php';

    $file = public_path() . '/files/Reporte_servicio_vally' ; 
    $pdf = new PdfToText ( "$file.pdf" ) ; 

    output ( "Original file contents :\n" ) ; 
    output ( file_get_contents ( "$file.txt" ) ) ; 
    output ( "-----------------------------------------------------------\n" ) ; 

    output ( "Extracted file contents :\n" ) ; 
    output ( $pdf -> Text ) ; 				
	}
}
