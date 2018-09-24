<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Client;
use App\Empresa;
use App\Giro;
use App\User;

class ClientController extends Controller
{

    public function index() 
    {
    	$empresas = Company::all();
    	$clientes = Client::paginate(5);
        $BDA = Empresa::all(); // empresa asociada en TISANOM
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('admin.clientes.index')->with(compact('clientes','empresas','BDA', 'navbar'));		// listado de clientes
    }

    public function create() 
    {
    	$empresas = Company::all();
        $tisanom_cias = Empresa::all();
        $giros = Giro::all();
    	return view('admin.clientes.create')->with(compact('tisanom_cias','empresas','giros'));	// insertar nuevo cliente
    }

    public function store(Request $request) 
    {
        $messages = [
            'Nombre.required' => 'El campo "Nombre del cliente" es requerido',
            'Nombre.min'    => 'El campo "Nombre del cliente" debe contener al menos 5 caracteres',
            'Giro.required' => 'Debe seleccionar el GIRO de la empresa'
        ];

        $rules = [
            'Nombre' => 'required|min:5',
            'Giro' => 'required'
        ];
        // validar
        $this->validate($request,$rules,$messages);
        $cliente1 = Client::all()->last();
        //dd($cliente1->id);
        $cli=$cliente1->id + 1;
        //dd($cli);

    	// registra el nuevo cliente en la BD
    	//dd($request->all());
    	$cliente = new Client();
    	$cliente->Nombre = $request->Nombre;
    	$cliente->Representante = $request->Representante;
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
        $cliente->save();   // Update

        
        $admin = new User();
        $admin->name = 'Administrador';
        $admin->email = 'administrador' . $request->administrador;
        $admin->password =  bcrypt('12345');
        $admin->activo = 1;
        $admin->profile_id = 1;
        $admin->client_id = $cli;
        $admin->save();

        $nominista = new User();
        $nominista->name = 'Nominista';
        $nominista->email = 'nominista' . $request->nominista;
        $nominista->password =  bcrypt('12345');
        $nominista->activo = 1;
        $nominista->profile_id = 3;
        $nominista->client_id = $cli;
        $nominista->save();

        $fiscalista = new User();
        $fiscalista->name = 'Fiscalista';
        $fiscalista->email = 'fiscalista' . $request->fiscalista;
        $fiscalista->password =  bcrypt('12345');
        $fiscalista->activo = 1;
        $fiscalista->profile_id = 2;
        $fiscalista->client_id = $cli;
        $fiscalista->save();
        //dd($admin, $nominista, $fiscalista);
    	return redirect('/admin/clientes'); 
    }

    public function edit($id) 
    {
        $cliente = Client::find($id);
        $giros = Giro::all();
    	$empresas = Company::all();
        $tisanom_cias = Empresa::all();
        return view('admin.clientes.edit')->with(compact(['cliente','giros','empresas','tisanom_cias']));
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
        
        // registra la nueva empresa en la BD
        $cliente = Client::find($id);
        $cliente->Nombre = $request->Nombre;
        $cliente->Representante = $request->Representante;
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
        $cliente->save();   // Update
        return redirect('/admin/clientes'); 
    }    

}
