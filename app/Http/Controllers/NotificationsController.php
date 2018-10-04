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

        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('notifications.index',[
    		'unreadNotifications' => auth()->user()->unreadNotifications,
    		'readNotifications' => auth()->user()->readNotifications
    	])->with(compact('navbar'));
    }

    public function read($id)
    {
        DatabaseNotification::find($id)->markAsRead();
        return back()->with('flash','Mensaje marcado como leído');
    }
}
