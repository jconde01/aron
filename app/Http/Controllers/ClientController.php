<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Client;
use App\Empresa;
use App\Giro;
use App\User;
use App\Graph;

class ClientController extends Controller
{

    public function index() 
    {
    	$empresas = Company::all();
    	$clientes = Client::paginate(5);
        $BDA = Empresa::all(); // empresa asociada en TISANOM
        $perfil = auth()->user()->profile_id;        
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
        $user = User::all()->last();
        $grafica = new Graph();
        $grafica->usuario_id = $user->id;
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
        $nominista->email = 'nominista' . $request->nominista;
        $nominista->password =  bcrypt('12345');
        $nominista->activo = 1;
        $nominista->profile_id = 3;
        $nominista->client_id = $cli;
        $nominista->save();
        $user2 = User::all()->last();
        $grafica2 = new Graph();
        $grafica2->usuario_id = $user->id;
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
        $fiscalista->email = 'fiscalista' . $request->fiscalista;
        $fiscalista->password =  bcrypt('12345');
        $fiscalista->activo = 1;
        $fiscalista->profile_id = 2;
        $fiscalista->client_id = $cli;
        $fiscalista->save();
        $user3 = User::all()->last();
        $grafica3 = new Graph();
        $grafica3->usuario_id = $user->id;
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
