<?php

namespace App\Http\Controllers;

use Session;
use App\User;
use App\Client;
use App\Message;
use Illuminate\Http\Request;
use App\Notifications\MessageSent;
Use Illuminate\Notifications\DatabaseNotification;

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


    public function create($id)
    {
        $selCliente = Session::get('selCliente');
        
        if ($selCliente != null) {
            $cell_id = $selCliente->cell_id;
    	   $users = User::where('cell_id','=',$cell_id)
                        ->whereIn('profile_id', [env("CELL_DIRECTOR_ID",4), env("CELL_QC_ID",6)])->get();  // ->where('id','!=',auth()->id())
        } else {
            $clientes = Client::where('cell_id',auth()->user()->cell_id)->select('id')->get();
            $users = User::whereIn('client_id',$clientes)->get();
        }

        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
		return view('messages.create')->with(compact('selCliente','users', 'navbar','id'));    // forma para insertar nuevo mensaje
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

    	return redirect('/notificaciones')->with('flash','Tu mensaje ha sido enviado');
    }

    public function show($id,$id_read)
    {
        $message = Message::findOrFail($id);
        DatabaseNotification::find($id_read)->markAsRead();
        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        return view('messages.show')->with(compact('message', 'navbar'));
    }
}
