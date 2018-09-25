<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tickets;
use session;
use Auth;
use App\Conocimiento;
use App\HistorialT;

class ticketsController extends Controller
{
    public function index()
    {
    	$a= Auth::user()->name;
		$perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        $tickets = tickets::where('emisor', $a)->get();
		
    	return view('tickets.usuarios.index')->with(compact('navbar', 'tickets'));
    }

    public function create()
    {
		$perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
       
		
    	return view('tickets.usuarios.create')->with(compact('navbar'));
    }

    public function store(Request $request)
    {
		
		$f= getdate();
		//dd($f);
		$fecha = $f['mday'].'-'.$f['mon'].'-'.$f['year'].' '.$f['hours'].':'.$f['minutes'].'Hrs';
		//dd($f);
		$cli = session('selCliente');
		$a= Auth::user()->name;
		//dd($a);       
        $ticket = new tickets;
       $ticket->clasificacion = $request->input('clasificacion');
       $ticket->motivo = $request->input('motivo');
       $ticket->estado = 'Pendiente';
       $ticket->cliente = $cli->Nombre;
       $ticket->emisor = $a;
       $ticket->fechale = $fecha;
		$ticket->save();

		//Historial
		$folio = tickets::all()->last()->folio;
		//dd($folio);
		$historial = new HistorialT;
		$historial->folio = $folio;
		$historial->clasificacion = $request->input('clasificacion');
		$historial->motivo = $request->input('motivo');
		$historial->estado = 'Pendiente';
		$historial->cliente = $cli->Nombre;
		$historial->emisor = $a;
		$historial->fechale = $fecha;
		$historial->save();
		//dd($historial);

    	return back()->with('flash','Ticket Generado con éxito');
    }

    public function cancel(Request $folio)
    {
    	
    	$ticket = tickets::where('folio', $folio->folio)->get()->first();
    	$f= getdate();
    	$fecha = $f['mday'].'-'.$f['mon'].'-'.$f['year'].' '.$f['hours'].':'.$f['minutes'].'Hrs';
    	$ticket->estado = 'Cancelado';
    	$ticket->fechafina = $fecha;
    	$ticket->solucion = 'Cancelado por el usuario';
    	$ticket->save();

    	$historial = new HistorialT;
		$historial->folio = $folio->folio;
		
		$historial->clasificacion = $ticket->clasificacion;
		$historial->motivo = $ticket->motivo;
		$historial->estado = 'Cancelado';
		$historial->cliente = $ticket->cliente;
		$historial->emisor = $ticket->emisor;
		$historial->fechale = $ticket->fechale;
		$historial->fechafina = $fecha;
		$historial->solucion = 'Cancelado por el usuario';
		$historial->save();
		//dd($historial);
		return back()->with('flash','Ticket Cancelado con éxito');
    }

     public function tickets()
    {
		$perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        $tickets = tickets::where('estado', 'Pendiente')->get();
		
    	return view('tickets.sistema.index')->with(compact('navbar', 'tickets'));
    }

     public function atender(Request $folio)
    {
    	$f= getdate();
    	$fecha = $f['mday'].'-'.$f['mon'].'-'.$f['year'].' '.$f['hours'].':'.$f['minutes'].'Hrs';
    	$ticket = tickets::where('folio', $folio->folio)->get()->first();
    	$ticket->estado = 'En Proceso';
    	$a= Auth::user()->name;
    	$ticket->receptor = $a;
    	$ticket->fechaacep = $fecha;
    	$ticket->save();

    	
    	$historial = new HistorialT;
		$historial->folio = $folio->folio;
		$historial->receptor = $a;
		$historial->clasificacion = $ticket->clasificacion;
		$historial->motivo = $ticket->motivo;
		$historial->estado = 'En Proceso';
		$historial->cliente = $ticket->cliente;
		$historial->emisor = $ticket->emisor;
		$historial->fechale = $ticket->fechale;
		$historial->fechaacep = $fecha;
		$historial->save();
		//dd($historial);
		return back()->with('flash','Ticket asignado con éxito');
    }

    public function aceptado()
    {
    	$a= Auth::user()->name;
		$perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        $tickets = tickets::where('receptor', $a)->where('estado', 'En Proceso')->get();
		
    	return view('tickets.sistema.aceptado')->with(compact('navbar', 'tickets'));
    }

    public function seguimiento(Request $folio)
    {
    	$ticket = tickets::where('folio', $folio->folio)->get()->first();
    	//dd($ticket);
		$perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        
		
    	return view('tickets.sistema.edit')->with(compact('navbar', 'ticket'));
    }

    public function update(Request $folio)
    {

    	$ticket = tickets::where('folio', $folio->folio)->get()->first();
    	//dd($ticket->fechaacep);
    	$ticket->clasificacion = $folio->input('clasificacion');
    	$ticket->comentarios = $folio->input('comentarios');
    	$solucion = $folio->input('solucion');
    	$f= getdate();
    	$fecha = $f['mday'].'-'.$f['mon'].'-'.$f['year'].' '.$f['hours'].':'.$f['minutes'].'Hrs';
    	//dd($solucion);
    	if ($solucion!==null) {
    		//dd('cerrado');
    		
    		$ticket->estado = 'Finalizado';
    		$ticket->fechafina = $fecha;
    		$ticket->solucion = $solucion;

    		$conocimiento = new Conocimiento();
    		$conocimiento->fecha = $fecha;
    		$conocimiento->clasificacion = $folio->input('clasificacion');
    		$conocimiento->motivo = $folio->input('motivo');
    		$conocimiento->solucion = $solucion;
    		$conocimiento->save();


	    	$historial = new HistorialT;
			$historial->folio = $folio->folio;
			$historial->receptor = $ticket->receptor;
			$historial->clasificacion = $ticket->clasificacion;
			$historial->motivo = $ticket->motivo;
			$historial->estado = 'Finalizado';
			$historial->cliente = $ticket->cliente;
			$historial->emisor = $ticket->emisor;
			$historial->comentarios = $folio->input('comentarios');
			$historial->fechale = $ticket->fechale;
			$historial->fechaacep = $ticket->fechaacep;
			$historial->solucion = $solucion;
			$historial->fechafina = $fecha;
			$historial->save();
			//dd($historial);
    	}
    	else{
    		$historial = new HistorialT;
			$historial->folio = $folio->folio;
			$historial->receptor = $ticket->receptor;
			$historial->clasificacion = $ticket->clasificacion;
			$historial->estado = 'En Proceso';
			$historial->motivo = $ticket->motivo;
			$historial->cliente = $ticket->cliente;
			$historial->emisor = $ticket->emisor;
			$historial->comentarios = $folio->input('comentarios');
			$historial->fechale = $ticket->fechale;
			$historial->fechaacep = $ticket->fechaacep;
			$historial->fechaactua = $fecha;
			$historial->save();
    	}
    	
    	$ticket->save();
		$perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        
		
    	return redirect('tickets/sistema/aceptado');
    }

     public function consultar()
    {
    	
		$perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        $tickets = tickets::all();
		
    	return view('tickets.sistema.historial')->with(compact('navbar', 'tickets'));
    }

    public function ver(Request $folio)
    {
    	$ticket = tickets::where('folio', $folio->folio)->get()->first();
    	//dd($ticket);
		$perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        
		
    	return view('tickets.sistema.ver')->with(compact('navbar', 'ticket'));
    }
}
