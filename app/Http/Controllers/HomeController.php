<?php

namespace App\Http\Controllers;

//use Symfony\Component\Console\Output as Output;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Nwidart\Menus\Facades\Menu;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppController;
use App\Profilew;
use App\Client;
use App\Empresa;
use App\Nomina;
use App\Graph;
use Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('database');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfil = auth()->user()->profile_id;
        $id_usuario = auth()->user()->id;
        
        if ($perfil == env('APP_ADMIN_PROFILE')) {
            // Menu::create('navbar', function($menu) {
            //     //$menu->url('/', 'Home');
            //     $menu->dropdown('Account', function ($sub) {
            //         $sub->url('profile', 'Visit My Profile');
            //         $sub->dropdown('Settings', function ($sub) {
            //             $sub->url('settings/account', 'Account');
            //             $sub->url('settings/password', 'Password');
            //             $sub->url('settings/design', 'Design');
            //         });
            //         $sub->url('logout', 'Logout');
            //     });
            // });            
            return view('home');
        } else {
            // Es un usuario de una célula ?
            if (auth()->user()->client == null) {
                $navbar = ProfileController::getNavBar('',0,$perfil);
                return view('home')->with(compact('navbar'));
            } else {
                // Usuario normal de un cliente
                $cliente = auth()->user()->client;
                $graficas = Graph::where('usuario_id', $id_usuario)->first();

                if (Auth::check()){
                    session(['selCliente' => $cliente]);
                }
                // Checa si ya se seleccionó el Tipo y Proceso de Nomina
                $selProceso = Session::get('selProceso');
                if ($selProceso != '') {
                    $navbar = ProfileController::getNavBar('',0,$perfil);
                    return view('home')->with(compact('navbar', 'graficas'));
                } else {
                    return view('sistema.chooseTipoYProceso')->with(compact('cliente'));
                }
            }
        }
    }


    public function setSessionData(Request $request)
    {

        $selProceso = $request->proceso;
        $selProcessObj = Nomina::select('NOMBRE','MINIMODF')->where('TIPONO',$selProceso)->first();
        $clienteYProceso = auth()->user()->client->Nombre . " - " . $selProcessObj->NOMBRE;

        session(['selProceso' => $selProceso]);
        session(['minimoDF' => $selProcessObj->MINIMODF]);
        session(['clienteYProceso' => $clienteYProceso]);

        return redirect('home');
    }    

    public function graficas()
    {
        $id_usuario = auth()->user()->id;
        $graficas = Graph::where('usuario_id', $id_usuario)->first();

        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        return view('sistema.graficas')->with(compact('graficas', 'navbar'));
    }

    public function update(Request $request)
    {
        
        $id_usuario = auth()->user()->id;
        $grafica = Graph::where('usuario_id', $id_usuario)->first();
        $grafica->mensaje = $request->input('mensaje');
        $grafica->grafica1 = $request->input('grafica1');
        $grafica->grafica2 = $request->input('grafica2');
        $grafica->grafica3 = $request->input('grafica3');
        $grafica->grafica4 = $request->input('grafica4');
        $grafica->grafica5 = $request->input('grafica5');
        $grafica->grafica6 = $request->input('grafica6');
        $grafica->grafica7 = $request->input('grafica7');
        $grafica->grafica8 = $request->input('grafica8');
        $grafica->grafica9 = $request->input('grafica9');
        $grafica->grafica10 = $request->input('grafica10');
        //dd($grafica);
        $grafica->save();
        $graficas = Graph::where('usuario_id', $id_usuario)->first();

        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        return view('home')->with(compact('graficas', 'navbar'));
    }

}
