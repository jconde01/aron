<?php
  
namespace App\Http\Controllers;

//use Symfony\Component\Console\Output as Output;

use DB;
use Auth;
use App\User;
use Session;
use App\Depto;
use App\Client;
use App\Empresa;
use App\Nomina;
use App\Graph;
use App\Message;
use App\Movtos;
use App\ca2018;
use App\ca2019;
use App\ca2019Asimi;
use App\Control;
use App\ControlAsimi;
use App\Empleado;
use App\DatosGe;
use App\Profilew;
use App\ListaDoc;
use App\Checklist;
//use Illuminate\Database\Schema;
use Illuminate\Http\Request;
use App\Notifications\MessageSent;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppController;
//use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


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
        $this->middleware('databaseAsimi');
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
                if ($perfil == env('APP_CLIENT_ADMIN',1) && Session::get('selProceso') == null) {
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

    //-------------------------------------inicio de graficas de departamentos ocupados----------------------------------------
                   
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
    //---------------------------------------------------fin de grafica de departamentos---------------------------------------


    //----------------------------------------------inicio de grafica de edades------------------------------------------------
                  $empleadoG = DB::connection('sqlsrv2')->table('EMPGEN')
                        ->join('EMPLEADO','EMPGEN.EMP','=','EMPLEADO.EMP')->where('ESTATUS','!=','B')
                        ->get();
                  //$empleadoG = DatosGe::select('BORN')->get();
                  //dd($empleadoG);
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
    //-------------------------------------------fin de grafica de edades------------------------------------------------------

    //-------------------------------------inicio grafica cosoto de nomina 2018------------------------------------------------
                    $ca2018table =Schema::connection('sqlsrv2')->hasTable('CA2018');
                    
                    if ($ca2018table == true) {
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
                    }else{
                      $data4=[0,0,0,0,0,0,0,0,0,0,0,0];
                    }
                    
    //----------------------------------------Fin de la grafica costo de nomina2018--------------------------------------------

    



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

    //---------------------------------------inicio grafica cosoto de nomina 2019----------------------------------------------
                                      $ca2019table =Schema::connection('sqlsrv2')->hasTable('CA2019');
                                      if ($ca2019table == true) {
                                       
                                      
                                        $l9control2 = Control::get();
                                        $l9ca18 = ca2019::where('CONCEPTO', '<', 500)->get();                                    
                                        $l9suma = 0;
                                        $l9total = 0;
                                        $l9peri = 0;
                                        $l9total1 = 0;
                                        $l9total2 = 0;
                                        $l9total3 = 0;
                                        $l9total4 = 0;
                                        $l9total5 = 0;
                                        $l9total6 = 0;
                                        $l9total7 = 0;
                                        $l9total8 = 0;
                                        $l9total9 = 0;
                                        $l9total10 = 0;
                                        $l9total11 = 0;
                                        $l9total12 = 0;
                                        foreach ($l9control2 as $l9conl) {                       
                                            $l9suma = 0;
                                            foreach ($l9ca18 as $l9ca) {                           
                                                   if ($l9ca->PERIODO == $l9conl->PERIODO) {                              
                                                       $l9suma = $l9suma + $l9ca->IMPORTE;
                                                       if ($l9conl->PERIANO== 201901) {
                                                           $l9total1=$l9total1 + $l9ca->IMPORTE;
                                                       }
                                                       if ($l9conl->PERIANO== 201902) {
                                                           $l9total2=$l9total2 + $l9ca->IMPORTE;
                                                       }
                                                       if ($l9conl->PERIANO== 201903) {
                                                           $l9total3=$l9total3 + $l9ca->IMPORTE;
                                                       }
                                                       if ($l9conl->PERIANO== 201904) {
                                                           $l9total4=$l9total4 + $l9ca->IMPORTE;
                                                       }
                                                       if ($l9conl->PERIANO== 201905) {
                                                           $l9total5=$l9total5 + $l9ca->IMPORTE;
                                                       }
                                                       if ($l9conl->PERIANO== 201906) {
                                                           $l9total6=$l9total6 + $l9ca->IMPORTE;
                                                       }
                                                       if ($l9conl->PERIANO== 201907) {
                                                           $l9total7=$l9total7 + $l9ca->IMPORTE;
                                                       }
                                                       if ($l9conl->PERIANO== 201908) {
                                                           $l9total8=$l9total8 + $l9ca->IMPORTE;
                                                       }
                                                       if ($l9conl->PERIANO== 201909) {
                                                           $l9total9=$l9total9 + $l9ca->IMPORTE;
                                                       }
                                                       if ($l9conl->PERIANO== 201910) {
                                                           $l9total10=$l9total10 + $l9ca->IMPORTE;
                                                       }
                                                       if ($l9conl->PERIANO== 201911) {
                                                           $l9total11=$l9total11 + $l9ca->IMPORTE;
                                                       }
                                                       if ($l9conl->PERIANO== 201912) {
                                                           $l9total12=$l9total12 + $l9ca->IMPORTE;
                                                       }
                                                   }                           
                                            }                     
                                        }
                                        
                                        $l9control = Control::get();
                                        $l9ca18 = ca2019::where('CONCEPTO', '>', 499)->get();
                                        $l9suma = 0;
                                        $l9total = 0;
                                        $l9peri = 0;
                                        $l9tota111 = 0;
                                        $l9total22 = 0;
                                        $l9total33 = 0;
                                        $l9total44 = 0;
                                        $l9total55 = 0;
                                        $l9total66 = 0;
                                        $l9total77 = 0;
                                        $l9total88 = 0;
                                        $l9total99 = 0;
                                        $l9total100 = 0;
                                        $l9total111 = 0;
                                        $l9total122 = 0;
                                        foreach ($l9control as $l9conl) {
                                            $l9suma = 0;
                                            if ($l9conl->PERIANO != $l9peri) {
                                                $l9total = 0;
                                            }                     
                                            foreach ($l9ca18 as $l9ca) {
                                                if ($l9ca->PERIODO== $l9conl->PERIODO) {
                                                   $l9suma=$l9suma +$l9ca->IMPORTE;
                                                   $l9total = $l9total+$l9ca->IMPORTE;
                                                   $l9peri=$l9conl->PERIANO;
                                                   if ($l9conl->PERIANO == 201901) {
                                                       $l9tota111 = $l9tota111+$l9ca->IMPORTE;
                                                   }
                                                   if ($l9conl->PERIANO == 201902) {
                                                       $l9total22 = $l9total22+$l9ca->IMPORTE;
                                                   }
                                                   if ($l9conl->PERIANO == 201903) {
                                                       $l9total33 = $l9total33+$l9ca->IMPORTE;
                                                   }
                                                   if ($l9conl->PERIANO == 201904) {
                                                       $l9total44 = $l9total44+$l9ca->IMPORTE;
                                                   }
                                                   if ($l9conl->PERIANO == 201905) {
                                                       $l9total55 = $l9total55+$l9ca->IMPORTE;
                                                   }
                                                   if ($l9conl->PERIANO == 201906) {
                                                       $l9total66 = $l9total66+$l9ca->IMPORTE;
                                                   }
                                                   if ($l9conl->PERIANO == 201907) {
                                                       $l9total77 = $l9total77+$l9ca->IMPORTE;
                                                   }
                                                   if ($l9conl->PERIANO == 201908) {
                                                       $l9total88 = $l9total88+$l9ca->IMPORTE;
                                                   }
                                                   if ($l9conl->PERIANO == 201909) {
                                                       $l9total99 = $l9total99+$l9ca->IMPORTE;
                                                   }
                                                   if ($l9conl->PERIANO == 201910) {
                                                       $l9total100 = $l9total100+$l9ca->IMPORTE;
                                                   }
                                                   if ($l9conl->PERIANO == 201911) {
                                                       $l9total111 = $l9total111+$l9ca->IMPORTE;
                                                   }
                                                   if ($l9conl->PERIANO == 201912) {
                                                       $l9total122 = $l9total122+$l9ca->IMPORTE;
                                                   }
                                                }                        
                                            }                       
                                        }

                                        $l9enero=$l9total1-$l9tota111;
                                        $l9febrero=$l9total2-$l9total22;
                                        $l9marzo=$l9total3-$l9total33;
                                        $l9abril=$l9total4-$l9total44;
                                        $l9mayo=$l9total5-$l9total55;
                                        $l9junio=$l9total6-$l9total66;
                                        $l9julio=$l9total7-$l9total77;
                                        $l9agosto=$l9total8-$l9total88;
                                        $l9septiembre=$l9total9-$l9total99;
                                        $l9octubre=$l9total10-$l9total100;
                                        $l9noviembre=$l9total11-$l9total111;
                                        $l9diciembre=$l9total12-$l9total122;
                                      }else{
                                        $l9enero=0;
                                        $l9febrero=0;
                                        $l9marzo=0;
                                        $l9abril=0;
                                        $l9mayo=0;
                                        $l9junio=0;
                                        $l9julio=0;
                                        $l9agosto=0;
                                        $l9septiembre=0;
                                        $l9octubre=0;
                                        $l9noviembre=0;
                                        $l9diciembre=0;
                                      }
                                        //---------------------consulta de costo de enomina 2019 asimlado----------------
                                        $cliente = auth()->user()->client;
                                        $AsimiFiscal = Session::get('tinom');
                                        if ($AsimiFiscal=='fiscal') {
                                          if ($cliente->asimilado==1) {
                                            $ca2019tableAsimi =Schema::connection('sqlsrv3')->hasTable('CA2019');
                                            if ($ca2019tableAsimi == true) {
                                              $l9control2Asimi = ControlAsimi::get();
                                              $l9ca18Asimi = ca2019Asimi::where('CONCEPTO', '<', 500)->get();                                    
                                              $l9sumaAsimi = 0;
                                              $l9totalAsimi = 0;
                                              $l9periAsimi = 0;
                                              $l9total1Asimi = 0;
                                              $l9total2Asimi = 0;
                                              $l9total3Asimi = 0;
                                              $l9total4Asimi = 0;
                                              $l9total5Asimi = 0;
                                              $l9total6Asimi = 0;
                                              $l9total7Asimi = 0;
                                              $l9total8Asimi = 0;
                                              $l9total9Asimi = 0;
                                              $l9total10Asimi = 0;
                                              $l9total11Asimi = 0;
                                              $l9total12Asimi = 0;
                                              foreach ($l9control2Asimi as $l9conlAsimi) {                       
                                                  $l9sumaAsimi = 0;
                                                  foreach ($l9ca18Asimi as $l9caAsimi) {                           
                                                         if ($l9caAsimi->PERIODO == $l9conlAsimi->PERIODO) {                              
                                                             $l9sumaAsimi = $l9sumaAsimi + $l9caAsimi->IMPORTE;
                                                             if ($l9conlAsimi->PERIANO== 201901) {
                                                                 $l9total1Asimi=$l9total1Asimi + $l9caAsimi->IMPORTE;
                                                             }
                                                             if ($l9conlAsimi->PERIANO== 201902) {
                                                                 $l9total2Asimi=$l9total2Asimi + $l9caAsimi->IMPORTE;
                                                             }
                                                             if ($l9conlAsimi->PERIANO== 201903) {
                                                                 $l9total3Asimi=$l9total3Asimi + $l9caAsimi->IMPORTE;
                                                             }
                                                             if ($l9conlAsimi->PERIANO== 201904) {
                                                                 $l9total4Asimi=$l9total4Asimi + $l9caAsimi->IMPORTE;
                                                             }
                                                             if ($l9conlAsimi->PERIANO== 201905) {
                                                                 $l9total5Asimi=$l9total5Asimi + $l9caAsimi->IMPORTE;
                                                             }
                                                             if ($l9conlAsimi->PERIANO== 201906) {
                                                                 $l9total6Asimi=$l9total6Asimi + $l9caAsimi->IMPORTE;
                                                             }
                                                             if ($l9conlAsimi->PERIANO== 201907) {
                                                                 $l9total7Asimi=$l9total7Asimi + $l9caAsimi->IMPORTE;
                                                             }
                                                             if ($l9conlAsimi->PERIANO== 201908) {
                                                                 $l9total8Asimi=$l9total8Asimi + $l9caAsimi->IMPORTE;
                                                             }
                                                             if ($l9conlAsimi->PERIANO== 201909) {
                                                                 $l9total9Asimi=$l9total9Asimi + $l9caAsimi->IMPORTE;
                                                             }
                                                             if ($l9conlAsimi->PERIANO== 201910) {
                                                                 $l9total10Asimi=$l9total10Asimi + $l9caAsimi->IMPORTE;
                                                             }
                                                             if ($l9conlAsimi->PERIANO== 201911) {
                                                                 $l9total11Asimi=$l9total11Asimi + $l9caAsimi->IMPORTE;
                                                             }
                                                             if ($l9conlAsimi->PERIANO== 201912) {
                                                                 $l9total12Asimi=$l9total12Asimi + $l9caAsimi->IMPORTE;
                                                             }
                                                         }                           
                                                  }                     
                                              }
                                              $l9controlAsimi = ControlAsimi::get();
                                              $l9ca18Asimi = ca2019Asimi::where('CONCEPTO', '>', 499)->get();
                                              $l9sumaAsimi = 0;
                                              $l9totalAsimi = 0;
                                              $l9periAsimi = 0;
                                              $l9tota111Asimi = 0;
                                              $l9total22Asimi = 0;
                                              $l9total33Asimi = 0;
                                              $l9total44Asimi = 0;
                                              $l9total55Asimi = 0;
                                              $l9total66Asimi = 0;
                                              $l9total77Asimi = 0;
                                              $l9total88Asimi = 0;
                                              $l9total99Asimi = 0;
                                              $l9total100Asimi = 0;
                                              $l9total111Asimi = 0;
                                              $l9total122Asimi = 0;
                                              foreach ($l9controlAsimi as $l9conlAsimi) {
                                                  $l9sumaAsimi = 0;
                                                  if ($l9conlAsimi->PERIANO != $l9periAsimi) {
                                                      $l9totalAsimi = 0;
                                                  }                     
                                                  foreach ($l9ca18Asimi as $l9caAsimi) {
                                                      if ($l9caAsimi->PERIODO== $l9conlAsimi->PERIODO) {
                                                         $l9sumaAsimi=$l9sumaAsimi +$l9caAsimi->IMPORTE;
                                                         $l9totalAsimi = $l9totalAsimi+$l9caAsimi->IMPORTE;
                                                         $l9periAsimi=$l9conlAsimi->PERIANO;
                                                         if ($l9conlAsimi->PERIANO == 201901) {
                                                             $l9tota111Asimi = $l9tota111Asimi+$l9caAsimi->IMPORTE;
                                                         }
                                                         if ($l9conlAsimi->PERIANO == 201902) {
                                                             $l9total22Asimi = $l9total22Asimi+$l9caAsimi->IMPORTE;
                                                         }
                                                         if ($l9conlAsimi->PERIANO == 201903) {
                                                             $l9total33Asimi = $l9total33Asimi+$l9caAsimi->IMPORTE;
                                                         }
                                                         if ($l9conlAsimi->PERIANO == 201904) {
                                                             $l9total44Asimi = $l9total44Asimi+$l9caAsimi->IMPORTE;
                                                         }
                                                         if ($l9conlAsimi->PERIANO == 201905) {
                                                             $l9total55Asimi = $l9total55Asimi+$l9caAsimi->IMPORTE;
                                                         }
                                                         if ($l9conlAsimi->PERIANO == 201906) {
                                                             $l9total66Asimi = $l9total66Asimi+$l9caAsimi->IMPORTE;
                                                         }
                                                         if ($l9conlAsimi->PERIANO == 201907) {
                                                             $l9total77Asimi = $l9total77Asimi+$l9caAsimi->IMPORTE;
                                                         }
                                                         if ($l9conlAsimi->PERIANO == 201908) {
                                                             $l9total88Asimi = $l9total88Asimi+$l9caAsimi->IMPORTE;
                                                         }
                                                         if ($l9conlAsimi->PERIANO == 201909) {
                                                             $l9total99Asimi = $l9total99Asimi+$l9caAsimi->IMPORTE;
                                                         }
                                                         if ($l9conlAsimi->PERIANO == 201910) {
                                                             $l9total100Asimi = $l9total100Asimi+$l9caAsimi->IMPORTE;
                                                         }
                                                         if ($l9conlAsimi->PERIANO == 201911) {
                                                             $l9total111Asimi = $l9total111Asimi+$l9caAsimi->IMPORTE;
                                                         }
                                                         if ($l9conlAsimi->PERIANO == 201912) {
                                                             $l9total122Asimi = $l9total122Asimi+$l9caAsimi->IMPORTE;
                                                         }
                                                      }                        
                                                  }                       
                                              }
                                              $l9eneroAsimi=$l9total1Asimi-$l9tota111Asimi;
                                              $l9febreroAsimi=$l9total2Asimi-$l9total22Asimi;
                                              $l9marzoAsimi=$l9total3Asimi-$l9total33Asimi;
                                              $l9abrilAsimi=$l9total4Asimi-$l9total44Asimi;
                                              $l9mayoAsimi=$l9total5Asimi-$l9total55Asimi;
                                              $l9junioAsimi=$l9total6Asimi-$l9total66Asimi;
                                              $l9julioAsimi=$l9total7Asimi-$l9total77Asimi;
                                              $l9agostoAsimi=$l9total8Asimi-$l9total88Asimi;
                                              $l9septiembreAsimi=$l9total9Asimi-$l9total99Asimi;
                                              $l9octubreAsimi=$l9total10Asimi-$l9total100Asimi;
                                              $l9noviembreAsimi=$l9total11Asimi-$l9total111Asimi;
                                              $l9diciembreAsimi=$l9total12Asimi-$l9total122Asimi;
                                          //---------------------fin consulta de costo de enomina 2019 asimlado----------------
                                              $l9enero = $l9enero +  $l9eneroAsimi;
                                              $l9febrero = $l9febrero + $l9febreroAsimi;
                                              $l9marzo = $l9marzo + $l9marzoAsimi;
                                              $l9abril = $l9abril + $l9abrilAsimi;
                                              $l9mayo = $l9mayo + $l9mayoAsimi;
                                              $l9junio = $l9junio + $l9junioAsimi;
                                              $l9julio = $l9julio + $l9julioAsimi;
                                              $l9agosto = $l9agosto + $l9agostoAsimi;
                                              $l9septiembre = $l9septiembre + $l9septiembreAsimi;
                                              $l9octubre = $l9octubre + $l9octubreAsimi;
                                              $l9noviembre = $l9noviembre + $l9noviembreAsimi;
                                              $l9diciembre = $l9diciembre + $l9diciembreAsimi;
                                            }else{
                                              $l9enero = $l9enero + 0;
                                              $l9febrero = $l9febrero + 0;
                                              $l9marzo = $l9marzo + 0;
                                              $l9abril = $l9abril + 0;
                                              $l9mayo = $l9mayo + 0;
                                              $l9junio = $l9junio + 0;
                                              $l9julio = $l9julio + 0;
                                              $l9agosto = $l9agosto + 0;
                                              $l9septiembre = $l9septiembre + 0;
                                              $l9octubre = $l9octubre + 0;
                                              $l9noviembre = $l9noviembre + 0;
                                              $l9diciembre = $l9diciembre + 0;
                                            }
                                          }
                                        }

                                        
                                       
                                        $l9data4=[$l9enero,$l9febrero,$l9marzo,$l9abril,$l9mayo,$l9junio,$l9julio,$l9agosto,$l9septiembre,$l9octubre,$l9noviembre,$l9diciembre];
                                        //dd($l9data4);
    //---------------------------------------Fin de la grafica costo de nomina2019---------------------------------------------

    //----------------------------------------------grafica de horas extra 2019------------------------------------------------
                    if ($ca2019table==true) {
                      $prueba = Control::get();
                      $ca2018 = ca2019::whereBetween('CONCEPTO', [200,201])->get();
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
                    }else{
                          $guardador2[2] = 0;
                          $guardador2[4] = 0;
                          $guardador2[6] = 0;
                          $guardador2[8] = 0;
                          $guardador2[10] = 0;
                          $guardador2[12] = 0;
                          $guardador2[14] = 0;
                          $guardador2[16] = 0;
                          $guardador2[18] = 0;
                          $guardador2[20] = 0;
                          $guardador2[22] = 0;
                          $guardador2[24] = 0;
                    }
                      
                      //-----------------Asimilados 2019 horas extra----------------
                      if ($AsimiFiscal=='fiscal') {
                          if ($cliente->asimilado==1) {
                            if ($ca2019tableAsimi==true) {
                              $pruebaAsimi = ControlAsimi::get();
                              $ca2018Asimi = ca2019Asimi::whereBetween('CONCEPTO', [200,201])->get();
                              $perianoAsimi = 0;
                              $periano2Asimi = 0;
                              $sumaunidades2Asimi=0;
                              $sumadesumaAsimi = 0;
                              $contadorAsimi = 0;
                              $guardador2Asimi = array();         
                                          foreach ($pruebaAsimi as $prueba2Asimi) {
                                              $contadorAsimi = $contadorAsimi+1;
                                              $perianoAsimi = $prueba2Asimi->PERIANO;
                                              $sumaunidadesAsimi=0;                    
                                              if ($perianoAsimi!=$periano2Asimi) {
                                                    $sumaunidades2Asimi=0;                                         
                                                }
                                              foreach ($ca2018Asimi as $caAsimi) {
                                                   if ($caAsimi->PERIODO==$prueba2Asimi->PERIODO) {
                                                       
                                                        $sumaunidadesAsimi = $sumaunidadesAsimi+$caAsimi->UNIDADES;
                                                        $sumaunidades2Asimi = $sumaunidades2Asimi+$caAsimi->UNIDADES;
                                                        $periano2Asimi = $prueba2Asimi->PERIANO;
                                                    }                                           
                                              }       
                                            $infoAsimi = array_push($guardador2Asimi,$sumaunidades2Asimi);                                
                                          }
                            $guardador2[2] = $guardador2[2] + $guardador2Asimi[2];
                            $guardador2[4] = $guardador2[4] + $guardador2Asimi[4];
                            $guardador2[6] = $guardador2[6] + $guardador2Asimi[6];
                            $guardador2[8] = $guardador2[8] + $guardador2Asimi[8];
                            $guardador2[10] = $guardador2[10] + $guardador2Asimi[10];
                            $guardador2[12] = $guardador2[12] + $guardador2Asimi[12];
                            $guardador2[14] = $guardador2[14] + $guardador2Asimi[14];
                            $guardador2[16] = $guardador2[16] + $guardador2Asimi[16];
                            $guardador2[18] = $guardador2[18] + $guardador2Asimi[18];
                            $guardador2[20] = $guardador2[20] + $guardador2Asimi[20];
                            $guardador2[22] = $guardador2[22] + $guardador2Asimi[22];
                            $guardador2[24] = $guardador2[24] + $guardador2Asimi[24];
                            }
                          }
                      }       
                      //-----------------Fin  Asimilados 2019 horas extra----------------

                      $data2= [$guardador2[2],$guardador2[4],$guardador2[6],$guardador2[8],$guardador2[10],$guardador2[12],$guardador2[14],$guardador2[16],$guardador2[18],$guardador2[20],$guardador2[22],$guardador2[24]];                   
    //--------------------------------------------------------Fin de grafica de horas extras 2019------------------------------

    //-------------------------------------------Inicio de graficas de faltas injustificadas 2019------------------------------
                  if ($ca2019table==true) {
                      $prueba = Control::get();
                      $ca2018 = ca2019::where('CONCEPTO', 408)->get();
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
                    }else{
                        $guardador[2] = 0;
                        $guardador[4] = 0;
                        $guardador[6] = 0;
                        $guardador[8] = 0;
                        $guardador[10] = 0;
                        $guardador[12] = 0;
                        $guardador[14] = 0;
                        $guardador[16] = 0;
                        $guardador[18] = 0;
                        $guardador[20] = 0;
                        $guardador[22] = 0;
                        $guardador[24] = 0;
                    }  
                    
                    //-------------Asimilados---------------------------------------------
                    if ($AsimiFiscal=='fiscal') {
                      if ($cliente->asimilado==1) {
                        if ($ca2019tableAsimi==true) {
                          $pruebaAsimi = ControlAsimi::get();
                          $ca2018Asimi = ca2019Asimi::where('CONCEPTO', 408)->get();
                          $perianoAsimi = 0;
                          $periano2Asimi = 0;
                          $sumaunidades2Asimi=0;
                          $sumadesumaAsimi = 0;
                          $contadorAsimi = 0;
                          $guardadorAsimi = array();  
                          foreach ($pruebaAsimi as $prueba2Asimi) {
                              $contadorAsimi = $contadorAsimi+1;
                              $perianoAsimi = $prueba2Asimi->PERIANO;
                              $sumaunidadesAsimi=0;
                              if ($perianoAsimi!=$periano2Asimi) {
                                    $sumaunidades2Asimi=0;                                         
                              }
                              foreach ($ca2018Asimi as $caAsimi) {
                                  if ($caAsimi->PERIODO==$prueba2Asimi->PERIODO) {
                                        $sumaunidadesAsimi = $sumaunidadesAsimi+($caAsimi->UNIDADES*-1);
                                        $sumaunidades2Asimi = $sumaunidades2Asimi+$caAsimi->UNIDADES;
                                        $periano2Asimi = $prueba2Asimi->PERIANO;
                                  }    
                              }       
                              $infoAsimi = array_push($guardadorAsimi,$sumaunidades2Asimi);                                
                          }
                          $guardador[2] = $guardador[2] + $guardadorAsimi[2];
                          $guardador[4] = $guardador[4] + $guardadorAsimi[4];
                          $guardador[6] = $guardador[6] + $guardadorAsimi[6];
                          $guardador[8] = $guardador[8] + $guardadorAsimi[8];
                          $guardador[10] = $guardador[10] + $guardadorAsimi[10];
                          $guardador[12] = $guardador[12] + $guardadorAsimi[12];
                          $guardador[14] = $guardador[14] + $guardadorAsimi[14];
                          $guardador[16] = $guardador[16] + $guardadorAsimi[16];
                          $guardador[18] = $guardador[18] + $guardadorAsimi[18];
                          $guardador[20] = $guardador[20] + $guardadorAsimi[20];
                          $guardador[22] = $guardador[22] + $guardadorAsimi[22];
                          $guardador[24] = $guardador[24] + $guardadorAsimi[24];
                        }
                      }
                    }
                    //-------------------------fin asimilados                                
                    $data= [$guardador[2]*-1,$guardador[4]*-1,$guardador[6]*-1,$guardador[8]*-1,$guardador[10]*-1,$guardador[12]*-1,$guardador[14]*-1,$guardador[16]*-1,$guardador[18]*-1,$guardador[20]*-1,$guardador[22]*-1,$guardador[24]*-1];
    //------------------------------------------------Fin de grafica de faltas injustificadas 2019-----------------------------
                       
                        $navbar = ProfileController::getNavBar('',0,$perfil);
                        $documentos = ListaDoc::get();
                        //dd($documentos);
                        return view('home')->with(compact('navbar', 'graficas','data','data2','data3','cont20','cont26','cont31', 'cont36','cont41','cont46','cont60','data4','l9data4'));
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

//--------------------------Notificaciones de documentos vencidos al administrador del cliente-----------------------------------
        $id = auth()->id();
        $usuario_mensaje = $id.'administrador'.$id;
         if (Cache::get( $usuario_mensaje)!==1) {
           
            Cache::put($usuario_mensaje, 1, 2880); //2880
           
            $notificado = '';
            $documentos = DB::connection('sqlsrv2')->table('LISTADOCUMENTOS')
                        ->join('EMPLEADO','LISTADOCUMENTOS.EMP','=','EMPLEADO.EMP')
                        ->get();
            $hoy = date_create();
            $pre2 = '';
            $pre3 = '';
            foreach ($documentos as $documento) 
            {
               
               $notificado = ' ';
              for ($i=1; $i <16 ; $i++) 
              { 
                $nombre = 'FECHAVENCI'.$i;
                $fecha = date_create($documento->$nombre);
                $tiempo = date_diff($fecha, $hoy);
                $lista = ListaDoc::documentos;
                if ($documento->$nombre !== null)
                {
                  if ($tiempo->m<=1) {           
                    $notificado = $notificado.'Documento '.$lista[$i].' &nbsp; '."\n".'<br>'.'<br/>';              
                  }
                }
                $pre = $notificado;
              }
              if ($pre !== ' ') {
                $pre2 = 'Los siguientes documentos del empleado: '. $documento->EMP.' estan por vencer.'."\n".$pre."\n".'<br>'.'<br/>';
              }

              $pre3 = $pre3.$pre2;
              $pre2 = '';
            }
            
            if ($pre3!=="") {
                  
                  $recipient = User::where('id',auth()->id())->first();          
                  $message = Message::create([
                  'sender_id' => auth()->id(),
                  'recipient_id' =>  auth()->id(),
                  'body' => $pre3
                  ]);
                  $recipient->notify(new MessageSent($message));
            }
            
              
         }
        
//--------------------------FIN Notificaciones de documentos vencidos al administrador del cliente-----------------------------------
          
        return true;
    }

}
