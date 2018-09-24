<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
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


    public function create($value='')
    {
    	$users = User::where('id','!=',auth()->id())->get();
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
		return view('messages.create')->with(compact('users', 'navbar'));    // forma para insertar nuevo mensaje
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
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        return view('messages.show')->with(compact('message', 'navbar'));
    }
}
