<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Cell;
use App\Graph;

class CellController extends Controller
{
    public function index()
    {
        $celulas = Cell::all();
    	return view('admin.celulas.index')->with(compact('celulas'));
    }

    public function create()
    {
        
    	return view('admin.celulas.create');
    }

    public function store(Request $request)
    {
    	$cel = new Cell();
    	$cel->nombre = $request->input('nombre');
    	$cel->save();
    	//dd($cel);

    	$celula = Cell::all()->last();
    	$director = new User();
        $director->name = 'Director General';
        $director->email = 'director_general' . $request->director_general;
        $director->password =  bcrypt('12345');
        $director->activo = 1;
        $director->profile_id = 4;
        $director->cell_id = $celula->id;
        $director->save();
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

    	$generalista = new User();
        $generalista->name = 'Generalista';
        $generalista->email = 'generalista' . $request->director_general;
        $generalista->password =  bcrypt('12345');
        $generalista->activo = 1;
        $generalista->profile_id = 5;
        $generalista->cell_id = $celula->id;
        $generalista->save();
        
        $grafica2 = new Graph();
        $grafica2->usuario_id = $user->id+1;
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

        $qc = new User();
        $qc->name = 'Q&C';
        $qc->email = 'qc' . $request->director_general;
        $qc->password =  bcrypt('12345');
        $qc->activo = 1;
        $qc->profile_id = 6;
        $qc->cell_id = $celula->id;
        $qc->save();
        
        $grafica3 = new Graph();
        $grafica3->usuario_id = $user->id+2;
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

        $fiscalista = new User();
        $fiscalista->name = 'Fiscalista';
        $fiscalista->email = 'fiscalista' . $request->director_general;
        $fiscalista->password =  bcrypt('12345');
        $fiscalista->activo = 1;
        $fiscalista->profile_id = 7;
        $fiscalista->cell_id = $celula->id;
        $fiscalista->save();
        
        $grafica4 = new Graph();
        $grafica4->usuario_id = $user->id+3;
        $grafica4->mensaje = 1;
        $grafica4->grafica1 = 0;
        $grafica4->grafica2 = 0;
        $grafica4->grafica3 = 0;
        $grafica4->grafica4 = 0;
        $grafica4->grafica5 = 0;
        $grafica4->grafica6 = 0;
        $grafica4->grafica7 = 0;
        $grafica4->grafica8 = 0;
        $grafica4->grafica9 = 0;
        $grafica4->grafica10 = 0;
        $grafica4->save();

        $soporte = new User();
        $soporte->name = 'Soporte Tecnico';
        $soporte->email = 'soporte_tecnico' . $request->director_general;
        $soporte->password =  bcrypt('12345');
        $soporte->activo = 1;
        $soporte->profile_id = 8;
        $soporte->cell_id = $celula->id;
        $soporte->save();
        
        $grafica5 = new Graph();
        $grafica5->usuario_id = $user->id+4;
        $grafica5->mensaje = 1;
        $grafica5->grafica1 = 0;
        $grafica5->grafica2 = 0;
        $grafica5->grafica3 = 0;
        $grafica5->grafica4 = 0;
        $grafica5->grafica5 = 0;
        $grafica5->grafica6 = 0;
        $grafica5->grafica7 = 0;
        $grafica5->grafica8 = 0;
        $grafica5->grafica9 = 0;
        $grafica5->grafica10 = 0;
        $grafica5->save();
        //dd($director, $generalista, $qc, $fiscalista, $soporte);
        return redirect('/admin/celulas');
    }

}
