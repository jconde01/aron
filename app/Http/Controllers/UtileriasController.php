<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Globals;

class UtileriasController extends Controller
{
    public function leerXls()
    {
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        $cli = session('Cliente');
        $X = session('X');
		return view('utilerias.leerXls')->with(compact('navbar','cli','X'));
    }


    public function getData(Request $request) 
    {
    	
    	$rules = [
        	'archivo' => 'required'
    	];

        $messages = [
            'archivo.required' => 'No ha ingresado el nombre del archivo excel'
        ];

        //$validator = Validator::make(Input::all(), $rules);
        $this->validate($request,$rules,$messages);	    
	    // process the form
        try {
			$inputFileName = $request->file('archivo')->getRealPath();
			//$helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory to identify the format');
			$spreadsheet = IOFactory::load($inputFileName);
			$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            \Session::flash('success', 'Archivo leido exitósamente.');
            return view('utilerias.viewXls')->with(compact('sheetData'));
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return redirect('/utilerias/viewXls');
        }     	 
    }


}
