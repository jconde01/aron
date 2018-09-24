<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\CompanyFile;
use File;

class CompanyFileController extends Controller
{
    public function index($id) {
    	$empresa = Company::find($id);
    	$files = $empresa->files;
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('admin.empresas.images.index')->with(compact('empresa','files', 'navbar'));
    	//return view('admin.empresas.images.index')->with(compact('empresa'));
    }

    public function store(Request $request, $id) {
    	
    	// guarda el archivo en el proyecto
    	$file = $request->file('archivo');
    	$path = public_path() . '/files/empresas';
    	$fileName = uniqid() . $file->getClientOriginalName();
     	$moved =  $file->move($path, $fileName);

     	if ($moved) {
	    	// guarda la liga en la BD
	    	$companyFile = new CompanyFile();
	    	$companyFile->file = $fileName;
	    	$companyFile->company_id = $id;
	    	$companyFile->save();
	    }

    	return back();
    }


    public function destroy(Request $request, $id) {
    	// eliminar el archivo del proyecto
    	$companyFile = CompanyFile::find($request->file_id);
    	$fullPathName = public_path() . '/files/empresas/'.$companyFile->file;
    	$deleted = File::delete($fullPathName);

    	// eliminar el registro en la BD
    	if ($deleted) {
    		$companyFile->delete();
    	}

    	return back();
    }

}
