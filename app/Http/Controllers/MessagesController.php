<?php

namespace App\Http\Controllers;

use Session;
use App\User;
use App\Client;
use App\Message;
use Illuminate\Http\Request;
use App\Notifications\MessageSent;

class MessagesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function create()
    {
        $selCliente = Session::get('selCliente');
        $cell_id = auth()->user()->cell_id;
        if ($selCliente != null) {
    	   $users = User::where('cell_id','=',$cell_id)
                        ->whereIn('profile_id', [env("CELL_DIRECTOR_ID",4), env("CELL_QC_ID",6)])->get();  // ->where('id','!=',auth()->id())
        } else {
            $clientes = Client::where('cell_id',auth()->user()->cell_id)->select('id')->get();
            $users = User::whereIn('client_id',$clientes)->get();
        }

        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
		return view('messages.create')->with(compact('selCliente','users', 'navbar'));    // forma para insertar nuevo mensaje
    }


    public function store(Request $request)
    {
    	//Validacion
        $messages = [
            'body.required' => 'El mensaje es un campo requerido',
            'recipient_id.required' => 'El destinatario es un campo requerido',
            'recipient_id.exists' => 'El destinatario NO es un usuario válido',
        ];

        $rules = [
            'recipient_id' => 'required|exists:users,id',
            'body' => 'required',
        ];
        $this->validate($request,$rules,$messages);

        // guarda el mensaje
    	$message = Message::create([
    		'sender_id' => auth()->id(),
    		'recipient_id' => $request->recipient_id,
    		'body' => $request->body
    	]);

    	// guarda la Notificacion
    	$recipient = User::find($request->recipient_id);

    	$recipient->notify(new MessageSent($message));

    	return back()->with('flash','Tu mensaje ha sido enviado');
    }

    public function show($id)
    {
        $message = Message::findOrFail($id);
        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        return view('messages.show')->with(compact('message', 'navbar'));
    }
}
