<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Client;
use App\Profile;

class UserController extends Controller
{
    public function index() 
    {
        //$clientes = Client::all();
    	$usuarios = User::paginate(5);
    	//return view('admin.usuarios.index')->with(compact('usuarios','clientes'));		// listado de usuarios
        return view('admin.usuarios.index')->with(compact('usuarios'));      // listado de usuarios
    }

    public function create() 
    {
        $clientes = Client::all();
        $perfiles = Profile::all();        
    	return view('admin.usuarios.create')->with(compact('perfiles','clientes'));	// forma para insertar nuevo usuario
    }

    public function edit($id) 
    {
        $user = User::find($id);
        $clientes = Client::all();        
        $perfiles = Profile::all();
        return view('admin.usuarios.edit')->with(compact('user','clientes','perfiles'));    // forma para editar usuario
    }

    public function store(Request $request) 
    {

        $messages = [
            'name.required' => 'El campo "Nombre del usuario" es requerido',
            'name.min'  => 'El campo "Nombre del usuario" debe contener al menos 5 caracteres',
            'password.required' => 'El campo "Contraseña" es requerido',
            'email' => 'El campo "Email" no tiene el formato esperado',
            'client_id.required' => 'Debe seleccionar un cliente para este usuario'
        ];

        $rules = [
            'name' => 'required|min:5',
            'password' => 'required',
            'email' => 'email',
            'client_id' => 'required'
        ];
        // validar
        $this->validate($request,$rules,$messages);

    	// guarda en la BD
    	//dd($request->all());
    	$usuario = new User();
    	$usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password =  bcrypt($request->password);
        $usuario->activo = 1;
        $usuario->profile_id = $request->profile_id;
        $usuario->client_id = $request->client_id;
    	$usuario->save();
    	return redirect('/admin/usuarios'); 
    }

    public function update(Request $request, $id) 
    {

        $messages = [
            'name.required' => 'El campo "Nombre del usuario" es requerido',
            'name.min'  => 'El campo "Nombre del usuario" debe contener al menos 5 caracteres',
            'password.required' => 'El campo "Contraseña" es requerido',
            'email' => 'El campo "Email" no tiene el formato esperado'
        ];

        $rules = [
            'name' => 'required|min:5',
            'password' => 'required',
            'email' => 'email'
        ];
        // validar
        $this->validate($request,$rules,$messages);

        // guarda en la BD
        //dd($request->all());
        $usuario = User::find($id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password =  bcrypt($request->password);
        $usuario->activo = ($request->Activo == 'on')? 1:0;
        $usuario->profile_id = $request->profile_id;
        $usuario->client_id = $request->client_id;        
        $usuario->save();
        return redirect('/admin/usuarios'); 
    }

}
