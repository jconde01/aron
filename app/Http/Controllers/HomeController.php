<?php

namespace App\Http\Controllers;

//use Symfony\Component\Console\Output as Output;

use DB;
use Auth;
use Session;
use App\Depto;
use App\Client;
use App\Empresa;
use App\Nomina;
use App\Graph;
use App\Movtos;
use App\ca2018;
use App\Control;
use App\Empleado;
use App\DatosGe;
use App\Profilew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppController;


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
        $graficas = Graph::where('usuario_id', $id_usuario)->first();
        
        if ($perfil == env('APP_ADMIN_PROFILE')) {
            $data= [1,2,3,4,5,6,7,8,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24];
            $data2= [1,2,3,4,5,6,7,8,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24];
            return view('home')->with(compact('graficas','data','data2'));
        } else {
            // Es un usuario de una célula ?
            if (auth()->user()->client == null) {
                $navbar = ProfileController::getNavBar('',0,$perfil);
                return view('home')->with(compact('navbar', 'graficas'));
            } else {
                $cliente = auth()->user()->client;
                // Es el usuario administrador del cliente?
                if ($perfil == env('APP_CLIENT_ADMIN',1)) {
                    $tipos = Client::select('fiscal','asimilado')->find($cliente->id);
                    If ($tipos->fiscal != 0) {
                        $this::setConn('fiscal');
                    } else {
                        $this::setConn('asimilado');
                    }
                }
                // Usuario normal de un cliente
                if (Auth::check()){
                    session(['selCliente' => $cliente]);
                }
                // Checa si ya se seleccionó el Tipo y Proceso de Nomina
                $selProceso = Session::get('selProceso');
                if ($selProceso != '') {
                    //inicia codigo agregado por Ricardo Cordero 28/10/2018----------------------------------------------------------------------
//-------------------------------------------Inicio de graficas de faltas injustificadas------------------------------------------------------------------------------------------------------------------------
                    $prueba = Control::get();
                    $ca2018 = ca2018::where('CONCEPTO', 408)->get();
                    $periano = 0;
                    $periano2 = 0;
                    $sumaunidades2=0;
                    $sumadesuma = 0;
                    $contador = 0;
                    $guardador = array();  
                    foreach ($prueba as $prueba2) {
                        $contador = $contador+1;
                        $periano = $prueba2->PERIANO;
                        $sumaunidades=0;
                        if ($periano!=$periano2) {
                              $sumaunidades2=0;                                         
                        }
                        foreach ($ca2018 as $ca) {
                            if ($ca->PERIODO==$prueba2->PERIODO) {
                                  $sumaunidades = $sumaunidades+($ca->UNIDADES*-1);
                                  $sumaunidades2 = $sumaunidades2+$ca->UNIDADES;
                                  $periano2 = $prueba2->PERIANO;
                            }    
                        }       
                        $info = array_push($guardador,$sumaunidades2);                                
                    }
                                
                    $data= [$guardador[2]*-1,$guardador[4]*-1,$guardador[6]*-1,$guardador[8]*-1,$guardador[10]*-1,$guardador[12]*-1,$guardador[14]*-1,$guardador[16]*-1,$guardador[18]*-1,$guardador[20]*-1,$guardador[22]*-1,$guardador[24]*-1];

//----------------------------------------------------------Fin de grafica de faltas injustificadas-------------------------------------------------------------------------------------------------------------
                    
//-------------------------------------------------------grafica de horas extra-----------------------------------------------------------------------------------------------------------------------------------
                    $prueba = Control::get();
                    $ca2018 = ca2018::whereBetween('CONCEPTO', [200,201])->get();
                    $periano = 0;
                    $periano2 = 0;
                    $sumaunidades2=0;
                    $sumadesuma = 0;
                    $contador = 0;
                    $guardador2 = array();  
       
                                foreach ($prueba as $prueba2) {
                                    $contador = $contador+1;
                                    $periano = $prueba2->PERIANO;
                                    $sumaunidades=0;
                                   // echo '-------------------------------------------------------------------<br>';
                                    if ($periano!=$periano2) {
                                          $sumaunidades2=0;                                         
                                      }
                                    foreach ($ca2018 as $ca) {
                                         if ($ca->PERIODO==$prueba2->PERIODO) {
                                             
                                              $sumaunidades = $sumaunidades+$ca->UNIDADES;
                                              $sumaunidades2 = $sumaunidades2+$ca->UNIDADES;
                                              $periano2 = $prueba2->PERIANO;
                                          }    
                                        
                                    }       

                                  $info = array_push($guardador2,$sumaunidades2);                                
                                }
                                // echo '<br><br><br>-------------------------------------------------------------------<br>';
                      $data2= [$guardador2[2],$guardador2[4],$guardador2[6],$guardador2[8],$guardador2[10],$guardador2[12],$guardador2[14],$guardador2[16],$guardador2[18],$guardador2[20],$guardador2[22],$guardador2[24]];
                    
//------------------------------------------------------------Fin de grafica de horas extras---------------------------------------------------------------------------------------------------------------------

//---------------------------------------------------------------inicio de graficas de departamentos ocupados----------------------------------------------------------------------------------------------------
                    $dep = Depto::get();
                    $deptos = Empleado::where('ESTATUS','!=','B')->get();
                    $contador = 0;
                    $guardador3 = array();
                    $depto = 0;
                    $igualador=0;
                    $igualador2=0;  
                    $cont=0;

                    foreach ($dep as $dep1) {
                        $igualador = $dep1->DEPTO;
                        if ( $igualador!=$igualador2) {
                           $contador=0;
                        }
                       foreach ($deptos as $depto1) {
                           if ($depto1->DEPTO== $dep1->DEPTO) {
                              $contador = $contador+1;
                            $igualador2 = $dep1->DEPTO;
                           }
                       }
                       $info = array_push($guardador3,$dep1->DESCRIP);
                       $info = array_push($guardador3,$contador);

                    }
                  foreach ($guardador3 as $guar3) {
                    $cont=$cont+1;
                     $data3[$cont]=$guar3;

                  }
                   
//-------------------------------------------------------fin de grafica de departamentos-------------------------------------------------------------------------------------------------------------------------


//----------------------------------------------------------inicio de grafica de edades--------------------------------------------------------------------------------------------------------------------------
                  $empleadoG = DatosGe::select('BORN')->get();
                  $hoy = date_create();
                  $cont20=0;
                  $cont26=0;
                  $cont31=0;
                  $cont36=0;
                  $cont41=0;
                  $cont46=0;
                  $cont60=0;
                  foreach ($empleadoG as $emple) {
                    $nacimiento = date_create($emple->BORN);
                     $anios = date_diff($hoy, $nacimiento)->y;
                     if ($anios>=20 && $anios<=25) {
                         $cont20=$cont20+1;
                     }
                     if ($anios>=26 && $anios<=30) {
                         $cont26=$cont26+1;
                     }
                     if ($anios>=31 && $anios<=35) {
                         $cont31=$cont31+1;
                     }
                     if ($anios>=36 && $anios<=40) {
                         $cont36=$cont36+1;
                     }
                     if ($anios>=41 && $anios<=45) {
                         $cont41=$cont41+1;
                     }
                     if ($anios>=46 && $anios<=60) {
                         $cont46=$cont46+1;
                     }
                     if ($anios>60) {
                         $cont60=$cont60+1;
                     }
                    
                  }

//---------------------------------------------------------fin de grafica de edades------------------------------------------------------------------------------------------------------------------------------

//---------------------------------------------------------inicio grafica cosoto de nomina-----------------------------------------------------------------------------------------------------------------------
                    $control2 = Control::get();
                    $ca18 = ca2018::where('CONCEPTO', '<', 500)->get();
                   
                    
                    $suma = 0;
                    $total = 0;
                    $peri = 0;
                    $total1 = 0;
                    $total2 = 0;
                    $total3 = 0;
                    $total4 = 0;
                    $total5 = 0;
                    $total6 = 0;
                    $total7 = 0;
                    $total8 = 0;
                    $total9 = 0;
                    $total10 = 0;
                    $total11 = 0;
                    $total12 = 0;
                    foreach ($control2 as $conl) {
                        
                        $suma = 0;
                        foreach ($ca18 as $ca) {
                            
                               if ($ca->PERIODO == $conl->PERIODO) {
                               
                                   $suma = $suma + $ca->IMPORTE;
                                   if ($conl->PERIANO== 201801) {
                                       $total1=$total1 + $ca->IMPORTE;
                                   }
                                   if ($conl->PERIANO== 201802) {
                                       $total2=$total2 + $ca->IMPORTE;
                                   }
                                   if ($conl->PERIANO== 201803) {
                                       $total3=$total3 + $ca->IMPORTE;
                                   }
                                   if ($conl->PERIANO== 201804) {
                                       $total4=$total4 + $ca->IMPORTE;
                                   }
                                   if ($conl->PERIANO== 201805) {
                                       $total5=$total5 + $ca->IMPORTE;
                                   }
                                   if ($conl->PERIANO== 201806) {
                                       $total6=$total6 + $ca->IMPORTE;
                                   }
                                   if ($conl->PERIANO== 201807) {
                                       $total7=$total7 + $ca->IMPORTE;
                                   }
                                   if ($conl->PERIANO== 201808) {
                                       $total8=$total8 + $ca->IMPORTE;
                                   }
                                   if ($conl->PERIANO== 201809) {
                                       $total9=$total9 + $ca->IMPORTE;
                                   }
                                   if ($conl->PERIANO== 201810) {
                                       $total10=$total10 + $ca->IMPORTE;
                                   }
                                   if ($conl->PERIANO== 201811) {
                                       $total11=$total11 + $ca->IMPORTE;
                                   }
                                   if ($conl->PERIANO== 201812) {
                                       $total12=$total12 + $ca->IMPORTE;
                                   }
                               }
                               
                            
                            
                        }
                       
                    }

                   

                    $control = Control::get();
                    $ca18 = ca2018::where('CONCEPTO', '>', 499)->get();
                    $suma = 0;
                    $total = 0;
                    $peri = 0;
                    $tota111 = 0;
                    $total22 = 0;
                    $total33 = 0;
                    $total44 = 0;
                    $total55 = 0;
                    $total66 = 0;
                    $total77 = 0;
                    $total88 = 0;
                    $total99 = 0;
                    $total100 = 0;
                    $total111 = 0;
                    $total122 = 0;
                    foreach ($control as $conl) {
                        $suma = 0;
                        if ($conl->PERIANO != $peri) {
                            $total = 0;
                        }
                       
                        foreach ($ca18 as $ca) {
                            if ($ca->PERIODO== $conl->PERIODO) {
                               $suma=$suma +$ca->IMPORTE;
                               $total = $total+$ca->IMPORTE;
                               $peri=$conl->PERIANO;
                               if ($conl->PERIANO == 201801) {
                                   $tota111 = $tota111+$ca->IMPORTE;
                               }
                               if ($conl->PERIANO == 201802) {
                                   $total22 = $total22+$ca->IMPORTE;
                               }
                               if ($conl->PERIANO == 201803) {
                                   $total33 = $total33+$ca->IMPORTE;
                               }
                               if ($conl->PERIANO == 201804) {
                                   $total44 = $total44+$ca->IMPORTE;
                               }
                               if ($conl->PERIANO == 201805) {
                                   $total55 = $total55+$ca->IMPORTE;
                               }
                               if ($conl->PERIANO == 201806) {
                                   $total66 = $total66+$ca->IMPORTE;
                               }
                               if ($conl->PERIANO == 201807) {
                                   $total77 = $total77+$ca->IMPORTE;
                               }
                               if ($conl->PERIANO == 201808) {
                                   $total88 = $total88+$ca->IMPORTE;
                               }
                               if ($conl->PERIANO == 201809) {
                                   $total99 = $total99+$ca->IMPORTE;
                               }
                               if ($conl->PERIANO == 201810) {
                                   $total100 = $total100+$ca->IMPORTE;
                               }
                               if ($conl->PERIANO == 201811) {
                                   $total111 = $total111+$ca->IMPORTE;
                               }
                               if ($conl->PERIANO == 201812) {
                                   $total122 = $total122+$ca->IMPORTE;
                               }
                            }
                            
                        }
                        
                    }

                    $enero=$total1-$tota111;
                    $febrero=$total2-$total22;
                    $marzo=$total3-$total33;
                    $abril=$total4-$total44;
                    $mayo=$total5-$total55;
                    $junio=$total6-$total66;
                    $julio=$total7-$total77;
                    $agosto=$total8-$total88;
                    $septiembre=$total9-$total99;
                    $octubre=$total10-$total100;
                    $noviembre=$total11-$total111;
                    $diciembre=$total12-$total122;
                   
                    $data4=[$enero,$febrero,$marzo,$abril,$mayo,$junio,$julio,$agosto,$septiembre,$octubre,$noviembre,$diciembre];



//---------------------------------------------------------Fin de la grafica costo de nomina---------------------------------------------------------------------------------------------------------------------



                        $cliente = auth()->user()->client;
                        if ($cliente->fiscal==1 && $cliente->asimilado==1){
                          $selCliente = auth()->user()->client;
                       
                          $cia = $selCliente->asimilado_bda; 
                          $empresaTisanom = Empresa::where('CIA',$cia)->first();
                          Config::set("database.connections.sqlsrv3", [
                              "driver" => 'sqlsrv',
                              "host" => Config::get("database.connections.sqlsrv")["host"],
                              "port" => Config::get("database.connections.sqlsrv")["port"],                       
                              "database" => $empresaTisanom->DBNAME,
                              "username" => $empresaTisanom->USERID,
                              "password" => $empresaTisanom->PASS
                              ]);
                          session(['sqlsrv3' => Config::get("database.connections.sqlsrv3")]);
                        }
                       
                        $navbar = ProfileController::getNavBar('',0,$perfil);
                        return view('home')->with(compact('navbar', 'graficas','data','data2','data3','cont20','cont26','cont31', 'cont36','cont41','cont46','cont60','data4'));
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
        session(['tinom' => $request->TipoNom]);
        session(['selProceso' => $selProceso]);
        session(['minimoDF' => $selProcessObj->MINIMODF]);
        session(['clienteYProceso' => $clienteYProceso]);

        return redirect('home');
    }    
    //inicia codigo escrito por Ricardo Cordero
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
        return back()->with('flash','Actualizacion exitosa');
    }
    //termina codigo escrito por Ricardo Cordero.

    private static function setConn($tipo) {
        $objCliente = auth()->user()->client;
        if ($tipo == 'fiscal') {
            $cia = $objCliente->fiscal_bda;     
        } else {
            $cia = $objCliente->asimilado_bda;
        }
        try {
            $empresaTisanom = Empresa::where('CIA',$cia)->first();
        } catch (\Exception $e) {
            return response('Error');
        }
        Config::set("database.connections.sqlsrv2", [
            "driver" => 'sqlsrv',
            "host" => Config::get("database.connections.sqlsrv")["host"],
            "port" => Config::get("database.connections.sqlsrv")["port"],                       
            "database" => $empresaTisanom->DBNAME,
            "username" => $empresaTisanom->USERID,
            "password" => $empresaTisanom->PASS
            ]);
        session(['sqlsrv2' => Config::get("database.connections.sqlsrv2")]);
        $procesos = Nomina::select('TIPONO','NOMBRE')->orderBy('TIPONO')->first();        
        $selProceso = $procesos->TIPONO;
        $selProcessObj = Nomina::select('NOMBRE','MINIMODF')->where('TIPONO',$selProceso)->first();
        $clienteYProceso = auth()->user()->client->Nombre . " - " . $selProcessObj->NOMBRE;
        session(['tinom' => $tipo]);
        session(['selProceso' => $selProceso]);
        session(['minimoDF' => $selProcessObj->MINIMODF]);
        session(['clienteYProceso' => $clienteYProceso]);        
        return true;
    }

}
