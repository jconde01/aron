<?php
 
namespace App\Http\Controllers;

use App\Cell;
use App\CiasNo;
use App\Company;
use App\Client;
use App\Empresa;
use App\Giro;
use App\User;
use App\Graph;
use App\CellClient;
use App\DocsRequeridos;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;


class ClientController extends Controller
{

    public function index() 
    {
        try {
            $empresas = Company::all();
            $clientes = Client::paginate(5);
            $BDA = Empresa::all(); // compañias en TISANOM            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    	return view('admin.clientes.index')->with(compact('clientes','empresas','BDA'));	// clientes, facturadoras, Cias.TISANOM
    }

    public function create() 
    {
    	$empresas = Company::all();
        $tisanom_cias = Empresa::orderBy('NOMCIA')->get();
        $giros = Giro::all();
        $celulas = Cell::all();
    	return view('admin.clientes.create')->with(compact('tisanom_cias','empresas','giros', 'celulas'));	// insertar nuevo cliente
    }

    // registra el nuevo cliente y sus usuarios en la BD.
    // crea su directorio de trabajo y genera los certificados correspondientes 
    public function store(Request $request) 
    {

        $messages = [
            'Nombre.required' => 'El campo "Nombre del cliente" es requerido',
            'Nombre.min'    => 'El campo "Nombre del cliente" debe contener al menos 5 caracteres',
            'Nombre.unique' => 'YA EXISTE un cliente con ese mismo Nombre. Verifique...',
            'Giro.required' => 'Debe seleccionar el GIRO de la empresa',
            'key_pwd.required' => 'El campo "Contraseña" es requerido',
            'key_pwd.min'    => 'El campo "Contraseña" debe contener al menos 6 caracteres',            
            'Nominista.unique' => 'El correo del Nominista YA EXISTE en la base de datos',
            'Fiscalista.unique' => 'El correo del Fiscalista YA EXISTE en la base de datos',
            'Administrador.unique' => 'El correo del Administrador YA EXISTE en la base de datos'
        ];

        $rules = [
            'Nombre' => 'required|min:5|unique:clients,Nombre',
            'Giro' => 'required',
            'key_pwd' => 'required|min:6',
            'Nominista' => 'unique:users,email',
            'Fiscalista' => 'unique:users,email',
            'Administrador' => 'unique:users,email'
        ];
        if ($request->Fiscal == 'on') {
            $rules['Fiscal_BDA'] = 'unique:clients,Fiscal_BDA';
            $messages['Fiscal_BDA'] = 'La BD asociada en TISANOM ya ha sido seleccionada previamente para el proceso de NÓMINA FISCAL'; 
        }
        if ($request->Asimilado == 'on') {
            $rules['Asimilado_BDA'] = 'unique:clients,Asimilado_BDA';
            $messages['Asimilado_BDA'] = 'La BD asociada en TISANOM ya ha sido seleccionada previamente para el proceso de ASIMILADOS'; 
        }        
        // validar
        $this->validate($request,$rules,$messages);

        DB::transaction(function () use($request) {
            // $cliente1 = Client::all()->last();
            // if (!$cliente1) {
            //     $cli = 1;
            // } else {
            //     $cli = $cliente1->id + 1;
            // }
            
        	//dd($request->all());
    	    $cliente = new Client();
    	    $cliente->Nombre = $request->Nombre;
    	    $cliente->Representante = $request->Representante;
            $cliente->cell_id = $request->celula;
    	    $cliente->Email = $request->Email;
            $cliente->giro_id = $request->Giro;
    	    $cliente->Activo = ($request->Activo == 'on')? 1 : 0;
            $cliente->fiscal = ($request->Fiscal == 'on')? 1 : 0;
            $cliente->asimilado = ($request->Asimilado == 'on')? 1 : 0;
            if ($request->Fiscal == 'on') {
                $cliente->fiscal_company_id = $request->Fiscal_Company_id;
                $cliente->fiscal_BDA = $request->Fiscal_BDA;
            }
            if ($request->Asimilado == 'on') {
                $cliente->asimilado_company_id = $request->Asimilado_Company_id;
                $cliente->asimilado_BDA = $request->Asimilado_BDA;
            }
            $cliente->pkey_passwd = bcrypt($request->key_pwd);
            $cliente->save();

            $admin = new User();
            $admin->name = 'Administrador';
            $admin->email = 'administrador' . $request->Administrador;
            $admin->password =  bcrypt('12345');
            $admin->activo = 1;
            $admin->profile_id = 1;
            $admin->client_id = $cliente->id;
            $admin->save();

            //$user = User::all()->last();
            $grafica = new Graph();
            $grafica->usuario_id = $admin->id;
            $grafica->mensaje = 1;
            $grafica->grafica1 = 0;
            $grafica->grafica2 = 0;
            $grafica->grafica3 = 0;
            $grafica->grafica4 = 0;
            $grafica->grafica5 = 0;
            $grafica->grafica6 = 0;
            $grafica->grafica7 = 0;
            $grafica->grafica8 = 0;
            $grafica->grafica9 = 0;
            $grafica->grafica10 = 0;
            $grafica->save();

            $nominista = new User();
            $nominista->name = 'Nominista';
            $nominista->email = 'nominista' . $request->Nominista;
            $nominista->password =  bcrypt('12345');
            $nominista->activo = 1;
            $nominista->profile_id = 3;
            $nominista->client_id = $cliente->id;
            $nominista->save();
            //$user2 = User::all()->last();
            $grafica2 = new Graph();
            $grafica2->usuario_id = $nominista->id;
            $grafica2->mensaje = 1;
            $grafica2->grafica1 = 0;
            $grafica2->grafica2 = 0;
            $grafica2->grafica3 = 0;
            $grafica2->grafica4 = 0;
            $grafica2->grafica5 = 0;
            $grafica2->grafica6 = 0;
            $grafica2->grafica7 = 0;
            $grafica2->grafica8 = 0;
            $grafica2->grafica9 = 0;
            $grafica2->grafica10 = 0;
            $grafica2->save();

            $fiscalista = new User();
            $fiscalista->name = 'Fiscalista';
            $fiscalista->email = 'fiscalista' . $request->Fiscalista;
            $fiscalista->password =  bcrypt('12345');
            $fiscalista->activo = 1;
            $fiscalista->profile_id = 2;
            $fiscalista->client_id = $cliente->id;
            $fiscalista->save();
            //$user3 = User::all()->last();
            $grafica3 = new Graph();
            $grafica3->usuario_id = $fiscalista->id;
            $grafica3->mensaje = 1;
            $grafica3->grafica1 = 0;
            $grafica3->grafica2 = 0;
            $grafica3->grafica3 = 0;
            $grafica3->grafica4 = 0;
            $grafica3->grafica5 = 0;
            $grafica3->grafica6 = 0;
            $grafica3->grafica7 = 0;
            $grafica3->grafica8 = 0;
            $grafica3->grafica9 = 0;
            $grafica3->grafica10 = 0;
            $grafica3->save();

        });

        // Crea los directorios para cada una de las empresas asociadas (FISCAL y ASIMILADOS)
        if ($request->Fiscal_BDA > 0) {
            $empresaTISANOM = Empresa::where('CIA',$request->Fiscal_BDA)->first();
            Config::set("database.connections.sqlsrv2", [
                "driver" => 'sqlsrv',
                "host" => Config::get("database.connections.sqlsrv")["host"],
                "port" => Config::get("database.connections.sqlsrv")["port"],                       
                "database" => $empresaTISANOM->DBNAME,
                "username" => $empresaTISANOM->USERID,
                "password" => $empresaTISANOM->PASS
                ]);
            session(['sqlsrv2' => Config::get("database.connections.sqlsrv2")]);
            $ciaFiscal = CiasNo::first();
            $rutaCertFiscal = Client::getRutaCertificado($request->celula, $ciaFiscal->RFCCTE);
            $rutaPorAutorizar = Client::getRutaPorAutorizar($request->celula, $ciaFiscal->RFCCTE);
            $rutaAutorizados = Client::getRutaAutorizados($request->celula, $ciaFiscal->RFCCTE);
            $rutaEmpleados = Client::getRutaEmpleados($request->celula, $ciaFiscal->RFCCTE);
            $rutaDocumentos = Client::getRutaDocumentos($request->celula, $ciaFiscal->RFCCTE);

            try {
                mkdir($rutaCertFiscal,0755,true);
                mkdir($rutaPorAutorizar,0755,true);
                mkdir($rutaAutorizados,0755,true);
                mkdir($rutaEmpleados,0755,true);
                mkdir($rutaDocumentos,0755,true);
            } catch (\Exception $e) {
                \Session::flash('error', "No pude crear los directorios de FISCAL para el nuevo cliente... verifique  -  ".$e->getMessage());
            }
        }

        if ($request->Asimilado_BDA > 0) {
            $empresaTISANOM = Empresa::where('CIA',$request->Asimilado_BDA)->first();
            DB::disconnect('sqlsrv2');            
            Config::set("database.connections.sqlsrv2", [
                "driver" => 'sqlsrv',
                "host" => Config::get("database.connections.sqlsrv")["host"],
                "port" => Config::get("database.connections.sqlsrv")["port"],                       
                "database" => $empresaTISANOM->DBNAME,
                "username" => $empresaTISANOM->USERID,
                "password" => $empresaTISANOM->PASS
                ]);
            session(['sqlsrv2' => Config::get("database.connections.sqlsrv2")]);
            $ciaAsim = CiasNo::first();
            $rutaCertAsim = Client::getRutaCertificado($request->celula, $ciaAsim->RFCCTE);
            $rutaPorAutorizar = Client::getRutaPorAutorizar($request->celula, $ciaAsim->RFCCTE);
            $rutaAutorizados = Client::getRutaAutorizados($request->celula, $ciaAsim->RFCCTE);
            $rutaEmpleados = Client::getRutaEmpleados($request->celula, $ciaAsim->RFCCTE);        
            $rutaDocumentos = Client::getRutaDocumentos($request->celula, $ciaAsim->RFCCTE);
            try {
                mkdir($rutaCertAsim, 0755, true);
                mkdir($rutaPorAutorizar,0755,true);
                mkdir($rutaAutorizados,0755,true);
                mkdir($rutaEmpleados,0755,true);
                mkdir($rutaDocumentos,0755,true);
            } catch (\Exception $e) {
                \Session::flash('error', "No pude crear los directorios de ASIMILADOS para el nuevo cliente... verifique  -  ".$e->getMessage());
            }
        }

        $docsRequeridosEmp = new DocsRequeridos();
        $docsRequeridosEmp->REQUERIDO1 = 1;
        $docsRequeridosEmp->REQUERIDO2 = 1;
        $docsRequeridosEmp->REQUERIDO3 = 1;
        $docsRequeridosEmp->REQUERIDO4 = 1;
        $docsRequeridosEmp->REQUERIDO5 = 1;
        $docsRequeridosEmp->save();

        // Crea y almacena las llaves y certificado
        if ($request->Fiscal_BDA > 0) {
            $email = 'administrador' . $request->Administrador;
            $this::makeCert($request->Nombre, $ciaFiscal->RFCCTE, $rutaCertFiscal, $request->passwd,$email);
        }
        if ($request->Asimilado_BDA > 0) {
            $email = 'administrador' . $request->Administrador;
            $this::makeCert($request->Nombre, $ciaAsim->RFCCTE, $rutaCertAsim, $request->passwd, $email);
        }

        

    	return redirect('/admin/clientes'); 
    }

    public function edit($id) 
    {
        $cliente = Client::find($id);
        $usuarios = User::where('client_id',$cliente->id)->get();
        $giros = Giro::all();
    	$empresas = Company::all();
        $tisanom_cias = Empresa::all();
        $celulas = Cell::all();
        return view('admin.clientes.edit')->with(compact(['cliente','usuarios','giros','empresas','tisanom_cias', 'celulas']));
    }

    public function update(Request $request, $id) 
    {
        $messages = [
            'Nombre.required' => 'El campo "Nombre del cliente" es requerido',
            'Nombre.min'    => 'El campo "Nombre del cliente" debe contener al menos 5 caracteres',
        ];

        $rules = [
            'Nombre' => 'required|min:5',
        ];
        // validar
        $this->validate($request,$rules,$messages);
        
        $cliente = Client::find($id);
        $cliente->Nombre = $request->Nombre;
        $cliente->Representante = $request->Representante;
        $cliente->cell_id = $request->celula;
        $cliente->Email = $request->Email;
        $cliente->giro_id = $request->Giro;
        $cliente->Activo = ($request->Activo == 'on')? 1 : 0;
        $cliente->fiscal = ($request->Fiscal == 'on')? 1 : 0;
        $cliente->asimilado = ($request->Asimilado == 'on')? 1 : 0;
        if ($request->Fiscal == 'on') {
            $cliente->fiscal_company_id = $request->Fiscal_Company_id;
            $cliente->fiscal_BDA = $request->Fiscal_BDA;
        }
        if ($request->Asimilado == 'on') {
            $cliente->asimilado_company_id = $request->Asimilado_Company_id;
            $cliente->asimilado_BDA = $request->Asimilado_BDA;
        }
        //$cliente->pkey_passwd = bcrypt($request->key_pwd);
        $cliente->save();   // Update

        return redirect('/admin/clientes'); 
    }    


    public function generaCert(Request $request) {

        $cliente = Client::find($request->Id);
       // $hashedPassword = $cliente->pkey_passwd;
       // if (!Hash::check($request->pkey_pwd, $hashedPassword)) {
       //     // The passwords does not match...
       //     return back()->with('error','La contraseña introducida no coincide con la registrada!');
       //}
        if ($request->new_pwd != $request->conf_pwd) {
            // The passwords does not match...
            return back()->with('error','La nueva contraseña no coincide con la confirmada!');
        }
        $cliente->pkey_passwd = bcrypt($request->new_pwd);
        $cliente->save();

        if ($cliente->fiscal_bda > 0) {
            // Crea archivo de certificado y llave privada
            $empresaTISANOM = Empresa::where('CIA',$cliente->fiscal_bda)->first();
            Config::set("database.connections.sqlsrv2", [
                "driver" => 'sqlsrv',
                "host" => Config::get("database.connections.sqlsrv")["host"],
                "port" => Config::get("database.connections.sqlsrv")["port"],                       
                "database" => $empresaTISANOM->DBNAME,
                "username" => $empresaTISANOM->USERID,
                "password" => $empresaTISANOM->PASS
                ]);
            session(['sqlsrv2' => Config::get("database.connections.sqlsrv2")]);
            $ciaFiscal = CiasNo::first();
            $rutaCertFiscal = Client::getRutaCertificado($cliente->cell_id, $ciaFiscal->RFCCTE);
            $admin = User::where('name','Administrador')->where('client_id',$cliente->id)->first();
            $email = $admin->email;
            $this::makeCert($cliente->Nombre, $ciaFiscal->RFCCTE, $rutaCertFiscal, $request->new_pwd, $email);
        }

        if ($cliente->asimilado_bda > 0) {
            $empresaTISANOM = Empresa::where('CIA',$cliente->asimilado_bda)->first();
            DB::disconnect('sqlsrv2');            
            Config::set("database.connections.sqlsrv2", [
                "driver" => 'sqlsrv',
                "host" => Config::get("database.connections.sqlsrv")["host"],
                "port" => Config::get("database.connections.sqlsrv")["port"],                       
                "database" => $empresaTISANOM->DBNAME,
                "username" => $empresaTISANOM->USERID,
                "password" => $empresaTISANOM->PASS
                ]);
            session(['sqlsrv2' => Config::get("database.connections.sqlsrv2")]);
            $ciaAsim = CiasNo::first();
            $rutaCertAsim = Client::getRutaCertificado($cliente->cell_id, $ciaAsim->RFCCTE);
            $admin = User::where('name','Administrador')->where('client_id',$cliente->id)->first();
            $email = $admin->email;
            $this::makeCert($cliente->Nombre, $ciaAsim->RFCCTE, $rutaCertAsim, $request->new_pwd, $email);
        }
        return back()->with('flash','Firma generada');
    }


    public static function makeCert($nomCia, $rfcCia, $rutaCert, $passphrase, $email)
    {
        // for SSL server certificates the commonName is the domain name to be secured
        // for S/MIME email certificates the commonName is the owner of the email address
        // location and identification fields refer to the owner of domain or email subject to be secured
        // $dn = array(
        //     "countryName" => "MX",
        //     "stateOrProvinceName" => "Somerset",
        //     "localityName" => "Glastonbury",
        //     "organizationName" => "The Brain Room Limited",
        //     "organizationalUnitName" => "PHP Documentation Team",
        //     "commonName" => "Wez Furlong",
        //     "emailAddress" => "wez@example.com"
        // );

        $dn = array(
            "countryName" => "MX",
            "organizationName" => $nomCia,
            "commonName" => $rfcCia,
            "emailAddress" => $email
        );

        // Generate a new private (and public) key pair
        $privkey = openssl_pkey_new(array(
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ));

        // Generate a certificate signing request (CSR)
        $csr = openssl_csr_new($dn, $privkey, array('digest_alg' => 'sha256'));

        // Generate a self-signed cert, valid for 3 years
        $x509 = openssl_csr_sign($csr, null, $privkey, $days=365*3, array('digest_alg' => 'sha256'));

        // Save your private key, CSR and self-signed cert for later use
        //openssl_csr_export($csr, $csrout) and var_dump($csrout);
        //openssl_x509_export($x509, $certout) and var_dump($certout);
        // openssl_pkey_export($privkey, $pkeyout, "mypassword") and var_dump($pkeyout);
        //openssl_pkey_export($privkey, $pkeyout) and var_dump($pkeyout);        
        //echo "</br>Errores</br>";
        // Show any errors that occurred here
        // while (($e = openssl_error_string()) !== false) {
        //     echo $e . "<br />\n";
        // }

        // save files
        openssl_pkey_export_to_file($privkey, $rutaCert.'/'.$rfcCia.'-priv.key', $passphrase);
        // Along with the subject, the CSR contains the public key corresponding to the private key
        openssl_csr_export_to_file($csr, $rutaCert.'/'.$rfcCia.'-csr.pem');
        openssl_x509_export_to_file ($x509 , $rutaCert.'/'.$rfcCia.'-cert.pem');       

    }

}
