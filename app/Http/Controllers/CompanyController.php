<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Company;
use App\Giro;
use App\CompanyGiro;

class CompanyController extends Controller
{

    public function index() 
    {
    	$empresas = Company::paginate(3);
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('admin.empresas.index')->with(compact('empresas', 'navbar'));		// listado de empresas
    }


    public function create() 
    {
        $giros = Giro::all();
    	return view('admin.empresas.create')->with(compact('giros'));	// forma para insertar nueva empresa
    }


    public function store(Request $request) 
    {
        $messages = [
            'Nombre.required' => 'El campo "Nombre de la empresa" es requerido',
            'Nombre.min'    => 'El campo "Nombre de la empresa" debe contener al menos 5 caracteres'
        ];

        $rules = [
            'Nombre' => 'required|min:5',
        ];
        // validar
        $this->validate($request,$rules,$messages);

    	// registra la nueva empresa en la BD
    	$company = new Company();
    	$company->Nombre = $request->Nombre;
    	$company->Representante = $request->Representante;
    	$company->Email = $request->Email;
    	$company->Activo = ($request->Activo == 'on')? 1 : 0;
        $company->save();        
        // guarda los giros seleccionados
        foreach ($request->giro as $giro) {
            $companyGiro = new CompanyGiro();
            $companyGiro->company_id = $company->id;
            $companyGiro->giro_id = $giro;
            $companyGiro->save();
        }
    	return redirect('/admin/empresas'); 
    }


    public function edit($id) 
    {
        $empresa = Company::find($id);
        $giros = Giro::all();
        $companyGiros = CompanyGiro::where('company_id',$id)->get();
        return view('admin.empresas.edit')->with(compact('empresa','giros','companyGiros'));
    }


    public function getByGiro(Request $data)
    {
        $empresas = DB::table('companies')
                    ->join('company_giros','companies.id','=','company_giros.company_id')
                    ->where('company_giros.giro_id','=',$data->giro)->get();
        return response($empresas);
    }


    public function update(Request $request, $id) 
    {
        $messages = [
            'Nombre.required' => 'El campo "Nombre de la empresa" es requerido',
            'Nombre.min'    => 'El campo "Nombre de la empresa" debe contener al menos 5 caracteres'
        ];

        $rules = [
            'Nombre' => 'required|min:5',
        ];
        // validar
        $this->validate($request,$rules,$messages);
        
        // registra la nueva empresa en la BD
        $company = Company::find($id);
        $company->Nombre = $request->Nombre;
        $company->Representante = $request->Representante;
        $company->Email = $request->Email;
        $company->Activo = ($request->Activo == 'on')? 1 : 0;
        $company->save();   // Update
        // elimina TODOS los giros de la empresa actual
        $deleted = CompanyGiro::where('company_id',$id)->delete();        
        // guarda los giros seleccionados
        foreach ($request->giro as $giro) {
            $companyGiro = new CompanyGiro();
            $companyGiro->company_id = $id;
            $companyGiro->giro_id = $giro;
            $companyGiro->save();
        }
        return redirect('/admin/empresas'); 
    }
}
