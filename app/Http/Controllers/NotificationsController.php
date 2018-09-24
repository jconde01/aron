<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
Use Illuminate\Notifications\DatabaseNotification;
use App\User;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	// $unreadNotifications = auth()->user()->unreadNotifications;
    	// $readNotifications = auth()->user()->readNotifications;
        $perfil = auth()->user()->profile->id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('notifications.index',[
    		'unreadNotifications' => auth()->user()->unreadNotifications,
    		'readNotifications' => auth()->user()->readNotifications
    	])->with(compact('navbar'));
    	// dd(auth()->user()->unreadNotifications[0]['data']['body']);
    	 // foreach ($unreadNotifications as $unreadNotification) {
    	 // 	var_dump($unreadNotification->data['body']);
    	 // }
    	//dd($unreadNotifications->first()->data['body']);
    }

    public function read($id)
    {
        DatabaseNotification::find($id)->markAsRead();
        return back()->with('flash','Mensaje marcado como leído');
    }
}
