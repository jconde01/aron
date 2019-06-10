<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use App\ca2019;
use App\ca2019Asimi;
use App\Control;
use App\ControlAsimi;
use App\Empleado;
use App\VarCostoActual;
use App\VarCostoAnoA;
use App\VariacionEstra;
use Illuminate\Support\Facades\Schema;
use DB;
use App\Imss;
use App\Puesto;
// use Maatwebsite\Excel\Facades\Excel;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('database');
        $this->middleware('databaseAsimi');
    }



     public function index()
    { 
      try {
        $control =Schema::connection('sqlsrv2')->hasTable('PERIODO');
      } catch (\Exception $e) {
        return redirect('/home');
          die("Could not connect to the database.  Please check your configuration. error:" . $e );
      }

      $perfil = auth()->user()->profile_id;        
      $navbar = ProfileController::getNavBar('',0,$perfil);
      $control = Control::select('PERIANO')
                          ->where('PERIANO','>',201812)
                          ->groupBy('PERIANO')
                          ->get();
      $controlPeriodos = Control::select('PERIODO')
                          ->where('PERIODO','>',201854)
                          ->get();
     
      $NoEmp = Empleado::where('ESTATUS','!=','B')->get();;
      $NoEmp = count($NoEmp);
      $NoPues = Puesto::get();
      $NoPues = count($NoPues);
      
    	return view('/formato1')->with(compact('control','navbar','NoEmp','controlPeriodos','bandera','NoPues'));
    	
    }

  public function reporte(Request $periano)
    {
      
        $empleados = EMPLEADO::where('ESTATUS','!=','B')->get();;
        for ($i=0; $i <count($empleados) ; $i++) { 
          $array[$i][0] = $empleados[$i]->NOMBRE;
          $array[$i][1] = 0;
          $array[$i][2] = 0;
          $array[$i][3] = 0;
          $array[$i][4] = 0;
          $array[$i][5] = 0;
          $array[$i][6] = 0;
          $array[$i][7] = 0;
          $array[$i][8] = 0;
          $array[$i][9] = 0;
          $array[$i][10] = 0;
          $array[$i][10] = 0;
        }

        $PerNorms = $this::GetDatos(100,$periano->tipo);
        foreach ($PerNorms as $PerNorm) {
          for ($i=0; $i < count($array) ; $i++) { 
            if ($array[$i][0]==$PerNorm->NOMBRE) {
              $array[$i][1] = $PerNorm->total_unidades*1;
            
            }
          }
        }

        $IncMaters = $this::GetDatos(400,$periano->tipo);
        if ($IncMaters!==null) {
           foreach ($IncMaters as $IncMater) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$IncMater->NOMBRE) {
                $array[$i][2] = $IncMater->total_unidades*1;
                
              }
            }
          }
        }
        

        $IncTrans = $this::GetDatos(401,$periano->tipo);
        if ($IncTrans!==null) {
            foreach ($IncTrans as $IncTran) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$IncTran->NOMBRE) {
                $array[$i][3] = $IncTran->total_unidades*1;
                
              }
            }
          }
        }

        $IncProfs = $this::GetDatos(402,$periano->tipo);
        if ($IncProfs!==null) {
          foreach ($IncProfs as $IncProf) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$IncProf->NOMBRE) {
                $array[$i][4] = $IncProf->total_unidades*1;
                
              }
            }
          }
        }

        $IncTrabs = $this::GetDatos(403,$periano->tipo);
        if ($IncTrabs) {
          foreach ($IncTrabs as $IncTrab) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$IncTrab->NOMBRE) {
                $array[$i][5] = $IncTrab->total_unidades*1;
                
              }
            }
          }
        }

        $IncGenerals = $this::GetDatos(404,$periano->tipo);
        if ($IncGenerals!==null) {
          foreach ($IncGenerals as $IncGeneral) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$IncGeneral->NOMBRE) {
                $array[$i][6] = $IncGeneral->total_unidades*1;
                
              }
            }
          }
        }

        $Retardos = $this::GetDatos(405,$periano->tipo);
        if ($Retardos!==null) {
          foreach ($Retardos as $Retardo) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$Retardo->NOMBRE) {
                $array[$i][7] = $Retardo->total_unidades*1;
                
              }
            }
          }
        }

        $PerSinSuels = $this::GetDatos(406,$periano->tipo);
        if ($PerSinSuels!==null) {
          foreach ($PerSinSuels as $PerSinSuel) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$PerSinSuel->NOMBRE) {
                $array[$i][8] = $PerSinSuel->total_unidades*1;
                
              }
            }
          }
        }

        $suspenciones = $this::GetDatos(407,$periano->tipo);
        if ($suspenciones!==null) {
          foreach ($suspenciones as $suspencion) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$suspencion->NOMBRE) {
                $array[$i][9] = $suspencion->total_unidades*-1;
                
              }
            }
          }
        }

        $faltas = $this::GetDatos(408,$periano->tipo);
        if ($faltas!==null) {
          foreach ($faltas as $falta) {
            for ($i=0; $i < count($array) ; $i++) {
              if ($array[$i][0]==$falta->NOMBRE) {
                $array[$i][10] = $falta->total_unidades*-1;
                
              }
            }
          }
        }
        
        $despliega[] = 0;
        $despliega[] = '';
        for ($i=0; $i < count($array) ; $i++) {
          $totalF = $array[$i][2]+$array[$i][3]+$array[$i][4]+$array[$i][5]+$array[$i][6]+$array[$i][8]+$array[$i][9]+$array[$i][10];
          $array[$i][1] = $array[$i][1] - $totalF;
          $total = $array[$i][1]+$totalF;
          if ($array[$i][1]!==0) {
            $porcentaje = Round(($array[$i][1]/$total)*100, 2);
          }else{
            $porcentaje = 0;
          }
          $valores=0;
          $array[$i][11] = $porcentaje.'%';
          $nombres[$i] = $array[$i][0];
          $despliega[$i] = $porcentaje;
        }
      
       return response(array('tabla'=>$array,'grafica'=>$despliega,'nombres'=>$nombres));
      
    }

  public function GetDatos($concepto,$periano) { 
 
         $datos  = DB::connection('sqlsrv2')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ca2019','EMPLEADO.EMP','=','ca2019.EMP')
                        ->select('NOMBRE','ca2019.EMP',DB::raw('SUM(UNIDADES) as total_unidades'))
                        ->groupBy('NOMBRE','ca2019.EMP')
                        ->where('ca2019.CONCEPTO',$concepto)
                        ->join('CONTROL','ca2019.PERIODO','=','CONTROL.PERIODO')
                        ->select('NOMBRE','ca2019.EMP','PERIANO','CONCEPTO',DB::raw('SUM(UNIDADES) as total_unidades'))
                        ->groupBy('NOMBRE','ca2019.EMP','PERIANO','CONCEPTO')
                        ->where('PERIANO',$periano)
                        ->get();
      
      
    return $datos;
  } 

  public function reportePeriodo(Request $periodo)
    {
      
        $empleados = EMPLEADO::where('ESTATUS','!=','B')->get();
        for ($i=0; $i <count($empleados) ; $i++) { 
          $array[$i][0] = $empleados[$i]->NOMBRE;
          $array[$i][1] = 0;
          $array[$i][2] = 0;
          $array[$i][3] = 0;
          $array[$i][4] = 0;
          $array[$i][5] = 0;
          $array[$i][6] = 0;
          $array[$i][7] = 0;
          $array[$i][8] = 0;
          $array[$i][9] = 0;
          $array[$i][10] = 0;
          $array[$i][10] = 0;
        }

        $PerNorms = $this::GetDatosPeriodo(100,$periodo->tipo);
        foreach ($PerNorms as $PerNorm) {
          for ($i=0; $i < count($array) ; $i++) { 
            if ($array[$i][0]==$PerNorm->NOMBRE) {
              $array[$i][1] = $PerNorm->total_unidades*1;
            
            }
          }
        }

        $IncMaters = $this::GetDatosPeriodo(400,$periodo->tipo);
        if ($IncMaters!==null) {
           foreach ($IncMaters as $IncMater) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$IncMater->NOMBRE) {
                $array[$i][2] = $IncMater->total_unidades*1;
                
              }
            }
          }
        }
        

        $IncTrans = $this::GetDatosPeriodo(401,$periodo->tipo);
        if ($IncTrans!==null) {
            foreach ($IncTrans as $IncTran) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$IncTran->NOMBRE) {
                $array[$i][3] = $IncTran->total_unidades*1;
                
              }
            }
          }
        }

        $IncProfs = $this::GetDatosPeriodo(402,$periodo->tipo);
        if ($IncProfs!==null) {
          foreach ($IncProfs as $IncProf) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$IncProf->NOMBRE) {
                $array[$i][4] = $IncProf->total_unidades*1;
                
              }
            }
          }
        }

        $IncTrabs = $this::GetDatosPeriodo(403,$periodo->tipo);
        if ($IncTrabs) {
          foreach ($IncTrabs as $IncTrab) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$IncTrab->NOMBRE) {
                $array[$i][5] = $IncTrab->total_unidades*1;
                
              }
            }
          }
        }

        $IncGenerals = $this::GetDatosPeriodo(404,$periodo->tipo);
        if ($IncGenerals!==null) {
          foreach ($IncGenerals as $IncGeneral) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$IncGeneral->NOMBRE) {
                $array[$i][6] = $IncGeneral->total_unidades*1;
                
              }
            }
          }
        }

        $Retardos = $this::GetDatosPeriodo(405,$periodo->tipo);
        if ($Retardos!==null) {
          foreach ($Retardos as $Retardo) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$Retardo->NOMBRE) {
                $array[$i][7] = $Retardo->total_unidades*1;
                
              }
            }
          }
        }

        $PerSinSuels = $this::GetDatosPeriodo(406,$periodo->tipo);
        if ($PerSinSuels!==null) {
          foreach ($PerSinSuels as $PerSinSuel) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$PerSinSuel->NOMBRE) {
                $array[$i][8] = $PerSinSuel->total_unidades*1;
                
              }
            }
          }
        }

        $suspenciones = $this::GetDatosPeriodo(407,$periodo->tipo);
        if ($suspenciones!==null) {
          foreach ($suspenciones as $suspencion) {
            for ($i=0; $i < count($array) ; $i++) { 
              if ($array[$i][0]==$suspencion->NOMBRE) {
                $array[$i][9] = $suspencion->total_unidades*-1;
                
              }
            }
          }
        }

        $faltas = $this::GetDatosPeriodo(408,$periodo->tipo);
        if ($faltas!==null) {
          foreach ($faltas as $falta) {
            for ($i=0; $i < count($array) ; $i++) {
              if ($array[$i][0]==$falta->NOMBRE) {
                $array[$i][10] = $falta->total_unidades*-1;
                
              }
            }
          }
        }
        
        $despliega[] = 0;
        $despliega[] = '';
        for ($i=0; $i < count($array) ; $i++) {
          $totalF = $array[$i][2]+$array[$i][3]+$array[$i][4]+$array[$i][5]+$array[$i][6]+$array[$i][8]+$array[$i][9]+$array[$i][10];
          $array[$i][1] = $array[$i][1] - $totalF;
          $total = $array[$i][1]+$totalF;
          if ($array[$i][1]!==0) {
            $porcentaje = Round(($array[$i][1]/$total)*100, 2);
          }else{
            $porcentaje = 0;
          }
          $valores=0;
          $array[$i][11] = $porcentaje.'%';
          $nombres[$i] = $array[$i][0];
          $despliega[$i] = $porcentaje;
        }
      
       return response(array('tabla'=>$array,'grafica'=>$despliega,'nombres'=>$nombres));
      
    }

  public function GetDatosPeriodo($concepto,$periodo) { 
 
         $datos  = DB::connection('sqlsrv2')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ca2019','EMPLEADO.EMP','=','ca2019.EMP')
                        ->select('NOMBRE','ca2019.EMP',DB::raw('SUM(UNIDADES) as total_unidades'))
                        ->groupBy('NOMBRE','ca2019.EMP')
                        ->where('ca2019.CONCEPTO',$concepto)
                        ->join('CONTROL','ca2019.PERIODO','=','CONTROL.PERIODO')
                        ->select('NOMBRE','ca2019.EMP','CONTROL.PERIODO','CONCEPTO',DB::raw('SUM(UNIDADES) as total_unidades'))
                        ->groupBy('NOMBRE','ca2019.EMP','CONTROL.PERIODO','CONCEPTO')
                        ->where('CONTROL.PERIODO',$periodo)
                        ->get();
      
      
    return $datos;
  } 

  public function reporteTres(Request $periodo)
    {
      $fiscal = $this::fiscal($periodo->tipo);
      $asimilado = $this::asimilado($periodo->tipo);
      
      
        //termino de calcular los campos para la tabla
        for ($i=0; $i <count($fiscal) ; $i++) { 
          foreach ($asimilado as $percepcion) {
            if ($fiscal[$i]->NOMBRE==$percepcion->NOMBRE) {
              $fiscal[$i]->asimilado = $percepcion->total_importe;
               $fiscal[$i]->total_periodo_actual = $fiscal[$i]->asimilado + $fiscal[$i]->total_fiscal;
            }
          }
        }
      //preparo el arrelgo para regresar por ajax
        for ($i=0; $i <count($fiscal) ; $i++) { 
          $array[$i][0] = $fiscal[$i]->NOMBRE;
          // $array[$i][1] = $fiscal[$i]->EMP;
          // $array[$i][2] = $fiscal[$i]->PERIODO;
          $array[$i][1] = round($fiscal[$i]->total_importe,2);
          $array[$i][2] = round($fiscal[$i]->provision,2);
          $array[$i][3] = round($fiscal[$i]->total_fiscal,2);
          if (!isset($fiscal[$i]->asimilado)) {
            $fiscal[$i]->asimilado = 0;
            $fiscal[$i]->total_periodo_actual = $fiscal[$i]->total_fiscal;
          }
          $array[$i][4] = round($fiscal[$i]->asimilado,2); 
          $array[$i][5] = round($fiscal[$i]->total_periodo_actual,2);
          $array[$i][6] = 0;
          $array[$i][7] = 0;
          $array[$i][8] = 0;
          
        }
         $total[1]=0;
         $total[2]=0;
         $total[3]=0;
        //---------Periodo anterior--------------------
          $periodo->tipo = $periodo->tipo-1;
          $fiscal = $this::fiscal($periodo->tipo);
          $asimilado = $this::asimilado($periodo->tipo);
          
          
            //termino de calcular los campos para la tabla
            for ($i=0; $i <count($fiscal) ; $i++) { 
              foreach ($asimilado as $percepcion) {
                if ($fiscal[$i]->NOMBRE==$percepcion->NOMBRE) {
                  $fiscal[$i]->asimilado = $percepcion->total_importe;
                   $fiscal[$i]->total_periodo_actual = $fiscal[$i]->asimilado + $fiscal[$i]->total_fiscal;
                }
              }
            }
           // dd($fiscal);
        //agrego el total del periodo anterior al array
        for ($i=0; $i <count($array) ; $i++) { 
          foreach ($fiscal as $fisca) {

            if ($array[$i][0]==$fisca->NOMBRE) {
              if (!isset($fisca->asimilado)) {
            $fisca->asimilado = 0;
            $fisca->total_periodo_actual = $fisca->total_fiscal;
          }
            $array[$i][6] = round($fisca->total_periodo_actual,2);
            $variacionP = $array[$i][5]-$fisca->total_periodo_actual;
            $array[$i][7] = round(abs($variacionP),2);
            
            if ($array[$i][7]!==0.0) {
           $porcentaje = Round(($array[$i][7]/ $array[$i][5])*100, 2);
          }else{
            $porcentaje = 0;
          }
            
            $array[$i][8] = $porcentaje.'%';
            $nombres[$i] = $array[$i][0];
          $despliega[$i] = $array[$i][5];
          $despliega2[$i] = $array[$i][6];
          $total[1] = $total[1]+$array[$i][7];
          $total[2] = $total[2]+$array[$i][5];
          $total[3] = $total[3]+$array[$i][6];
            }
          }
        }
      
       return response(array('tabla'=>$array,'grafica'=>$despliega,'nombres'=>$nombres,'totales'=>$total,'anterior'=>$despliega2));
        // return response($periodo->tipo);
      
    }

  public function fiscal($periodo)
  {
    //consulta de las percepciones
        $percepciones  = DB::connection('sqlsrv2')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ca2019','EMPLEADO.EMP','=','ca2019.EMP')
                        ->select('NOMBRE','ca2019.EMP',DB::raw('SUM(IMPORTE) as total_importe'))
                        ->groupBy('NOMBRE','ca2019.EMP')
                        ->where('ca2019.CONCEPTO','<', 500)
                        ->join('CONTROL','ca2019.PERIODO','=','CONTROL.PERIODO')
                        ->select('NOMBRE','ca2019.EMP','CONTROL.PERIODO',DB::raw('SUM(IMPORTE) as total_importe'))
                        ->groupBy('NOMBRE','ca2019.EMP','CONTROL.PERIODO')
                        ->where('CONTROL.PERIODO',$periodo)
                        ->get();
      //consultas de las deducciones
        $deducciones  = DB::connection('sqlsrv2')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ca2019','EMPLEADO.EMP','=','ca2019.EMP')
                        ->select('NOMBRE','ca2019.EMP',DB::raw('SUM(IMPORTE) as total_import'))
                        ->groupBy('NOMBRE','ca2019.EMP')
                        ->where('ca2019.CONCEPTO','>', 499)
                        ->join('CONTROL','ca2019.PERIODO','=','CONTROL.PERIODO')
                        ->select('NOMBRE','ca2019.EMP','CONTROL.PERIODO',DB::raw('SUM(IMPORTE) as total_import'))
                        ->groupBy('NOMBRE','ca2019.EMP','CONTROL.PERIODO')
                        ->where('CONTROL.PERIODO',$periodo)
                        ->get();
        //percepciones - deducciones para obtener el sueldo neto
        for ($i=0; $i < count($percepciones) ; $i++) { 
          foreach ($deducciones as $deduccione) {
            if ($percepciones[$i]->NOMBRE == $deduccione->NOMBRE) {
              $percepciones[$i]->total_importe= $percepciones[$i]->total_importe-$deduccione->total_import;
            }
          }
        }
        $datos = $percepciones;
        $provisiones = DB::connection('sqlsrv2')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ProvisionAcumula','EMPLEADO.EMP','=','ProvisionAcumula.Empleado')
                        ->select('NOMBRE','ProvisionAcumula.Empleado','ProvisionAcumula.ImpEstatal','ProvisionAcumula.PImss','ProvisionAcumula.PSar','ProvisionAcumula.PInfonavit')
                        ->where('ProvisionAcumula.Periodo',$periodo)
                        ->get();

        // for ($i=0; $i <count($datos) ; $i++) { 
        //   foreach ($provisiones as $provision) {
        //     if ($datos[$i]->EMP==$provision->Empleado) {

        //      $datos[$i]->provision = $provision->ImpEstatal+$provision->PImss+$provision->PSar+$provision->PInfonavit;
        //      //sumamos el sueldo fiscal + las provisiones
        //      $datos[$i]->total_fiscal = $datos[$i]->total_importe+$datos[$i]->provision;

        //     }
        //   }
        // }

        if (!isset($provisiones[0])) {
          for ($i=0; $i <count($datos) ; $i++) { 
               $datos[$i]->total_fiscal = $datos[$i]->total_importe;
               $datos[$i]->provision = 0;
                   //sumamos el sueldo fiscal + las provisiones
                   $datos[$i]->total_fiscal = $datos[$i]->total_importe+$datos[$i]->provision;
               
              }
            }else{
              for ($i=0; $i <count($datos) ; $i++) { 
                foreach ($provisiones as $provision) {
                  if ($datos[$i]->EMP==$provision->Empleado) {

                   $datos[$i]->provision = $provision->ImpEstatal+$provision->PImss+$provision->PSar+$provision->PInfonavit;
                   //sumamos el sueldo fiscal + las provisiones
                   $datos[$i]->total_fiscal = $datos[$i]->total_importe+$datos[$i]->provision;
                   
                  }
                }
              }
            }

      return $datos;
  }

  public function asimilado($periodo)
  {
    //--------------parte de asimilado-----------------------------------------------
        //consulta de las percepciones
        $percepciones  = DB::connection('sqlsrv3')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ca2019','EMPLEADO.EMP','=','ca2019.EMP')
                        ->select('NOMBRE','ca2019.EMP',DB::raw('SUM(IMPORTE) as total_importe'))
                        ->groupBy('NOMBRE','ca2019.EMP')
                        ->where('ca2019.CONCEPTO','<', 500)
                        ->join('CONTROL','ca2019.PERIODO','=','CONTROL.PERIODO')
                        ->select('NOMBRE','ca2019.EMP','CONTROL.PERIODO',DB::raw('SUM(IMPORTE) as total_importe'))
                        ->groupBy('NOMBRE','ca2019.EMP','CONTROL.PERIODO')
                        ->where('CONTROL.PERIODO',$periodo)
                        ->get();
      //consultas de las deducciones
        $deducciones  = DB::connection('sqlsrv3')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ca2019','EMPLEADO.EMP','=','ca2019.EMP')
                        ->select('NOMBRE','ca2019.EMP',DB::raw('SUM(IMPORTE) as total_import'))
                        ->groupBy('NOMBRE','ca2019.EMP')
                        ->where('ca2019.CONCEPTO','>', 499)
                        ->join('CONTROL','ca2019.PERIODO','=','CONTROL.PERIODO')
                        ->select('NOMBRE','ca2019.EMP','CONTROL.PERIODO',DB::raw('SUM(IMPORTE) as total_import'))
                        ->groupBy('NOMBRE','ca2019.EMP','CONTROL.PERIODO')
                        ->where('CONTROL.PERIODO',$periodo)
                        ->get();
       
        //percepciones - deducciones para obtener el sueldo neto
        for ($i=0; $i < count($percepciones) ; $i++) { 
          foreach ($deducciones as $deduccione) {
            if ($percepciones[$i]->NOMBRE == $deduccione->NOMBRE) {
              $percepciones[$i]->total_importe= $percepciones[$i]->total_importe-$deduccione->total_import;
            }
          }
        }
    return $percepciones;
  }

  public function fiscalAnoA($periodo)
  {
    //consulta de las percepciones
        $percepciones  = DB::connection('sqlsrv2')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ca2018','EMPLEADO.EMP','=','ca2018.EMP')
                        ->select('NOMBRE','ca2018.EMP',DB::raw('SUM(IMPORTE) as total_importe'))
                        ->groupBy('NOMBRE','ca2018.EMP')
                        ->where('ca2018.CONCEPTO','<', 500)
                        ->join('CONTROL','ca2018.PERIODO','=','CONTROL.PERIODO')
                        ->select('NOMBRE','ca2018.EMP','CONTROL.PERIODO',DB::raw('SUM(IMPORTE) as total_importe'))
                        ->groupBy('NOMBRE','ca2018.EMP','CONTROL.PERIODO')
                        ->where('CONTROL.PERIODO',$periodo)
                        ->get();
                      
      //consultas de las deducciones
        $deducciones  = DB::connection('sqlsrv2')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ca2018','EMPLEADO.EMP','=','ca2018.EMP')
                        ->select('NOMBRE','ca2018.EMP',DB::raw('SUM(IMPORTE) as total_import'))
                        ->groupBy('NOMBRE','ca2018.EMP')
                        ->where('ca2018.CONCEPTO','>', 499)
                        ->join('CONTROL','ca2018.PERIODO','=','CONTROL.PERIODO')
                        ->select('NOMBRE','ca2018.EMP','CONTROL.PERIODO',DB::raw('SUM(IMPORTE) as total_import'))
                        ->groupBy('NOMBRE','ca2018.EMP','CONTROL.PERIODO')
                        ->where('CONTROL.PERIODO',$periodo)
                        ->get();

        //percepciones - deducciones para obtener el sueldo neto
        for ($i=0; $i < count($percepciones) ; $i++) { 
          foreach ($deducciones as $deduccione) {
            if ($percepciones[$i]->NOMBRE == $deduccione->NOMBRE) {
              $percepciones[$i]->total_importe= $percepciones[$i]->total_importe-$deduccione->total_import;
            }
          }
        }
        $datos = $percepciones;

        $provisiones = DB::connection('sqlsrv2')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ProvisionAcumula','EMPLEADO.EMP','=','ProvisionAcumula.Empleado')
                        ->select('NOMBRE','ProvisionAcumula.Empleado','ProvisionAcumula.ImpEstatal','ProvisionAcumula.PImss','ProvisionAcumula.PSar','ProvisionAcumula.PInfonavit')
                        ->where('ProvisionAcumula.Periodo',$periodo)
                        ->get();
        if (!isset($provisiones[0])) {
          for ($i=0; $i <count($datos) ; $i++) { 
               $datos[$i]->total_fiscal = $datos[$i]->total_importe;
               
              }
            }else{
              for ($i=0; $i <count($datos) ; $i++) { 
                foreach ($provisiones as $provision) {
                  if ($datos[$i]->EMP==$provision->Empleado) {

                   $datos[$i]->provision = $provision->ImpEstatal+$provision->PImss+$provision->PSar+$provision->PInfonavit;
                   //sumamos el sueldo fiscal + las provisiones
                   $datos[$i]->total_fiscal = $datos[$i]->total_importe+$datos[$i]->provision;
                   
                  }
                }
              }
            }
          
        
        
        

      return $datos;
  }

  public function asimiladoAnoA($periodo)
  {
    //--------------parte de asimilado-----------------------------------------------
        //consulta de las percepciones
        $percepciones  = DB::connection('sqlsrv3')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ca2018','EMPLEADO.EMP','=','ca2018.EMP')
                        ->select('NOMBRE','ca2018.EMP',DB::raw('SUM(IMPORTE) as total_importe'))
                        ->groupBy('NOMBRE','ca2018.EMP')
                        ->where('ca2018.CONCEPTO','<', 500)
                        ->join('CONTROL','ca2018.PERIODO','=','CONTROL.PERIODO')
                        ->select('NOMBRE','ca2018.EMP','CONTROL.PERIODO',DB::raw('SUM(IMPORTE) as total_importe'))
                        ->groupBy('NOMBRE','ca2018.EMP','CONTROL.PERIODO')
                        ->where('CONTROL.PERIODO',$periodo)
                        ->get();
      //consultas de las deducciones
        $deducciones  = DB::connection('sqlsrv3')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ca2018','EMPLEADO.EMP','=','ca2018.EMP')
                        ->select('NOMBRE','ca2018.EMP',DB::raw('SUM(IMPORTE) as total_import'))
                        ->groupBy('NOMBRE','ca2018.EMP')
                        ->where('ca2018.CONCEPTO','>', 499)
                        ->join('CONTROL','ca2018.PERIODO','=','CONTROL.PERIODO')
                        ->select('NOMBRE','ca2018.EMP','CONTROL.PERIODO',DB::raw('SUM(IMPORTE) as total_import'))
                        ->groupBy('NOMBRE','ca2018.EMP','CONTROL.PERIODO')
                        ->where('CONTROL.PERIODO',$periodo)
                        ->get();
       
        //percepciones - deducciones para obtener el sueldo neto
        for ($i=0; $i < count($percepciones) ; $i++) { 
          foreach ($deducciones as $deduccione) {
            if ($percepciones[$i]->NOMBRE == $deduccione->NOMBRE) {
              $percepciones[$i]->total_importe= $percepciones[$i]->total_importe-$deduccione->total_import;
            }
          }
        }
    return $percepciones;
  }

  public function reporteCuatro(Request $periodo)
  {
    $fiscal = $this::fiscal($periodo);
        $asimilado = $this::asimilado($periodo);
        
        
          //termino de calcular los campos para la tabla
          for ($i=0; $i <count($fiscal) ; $i++) { 
            foreach ($asimilado as $percepcion) {
              if ($fiscal[$i]->NOMBRE==$percepcion->NOMBRE) {
                $fiscal[$i]->asimilado = $percepcion->total_importe;
                 $fiscal[$i]->total_periodo_actual = $fiscal[$i]->asimilado + $fiscal[$i]->total_fiscal;
              }
            }
          }
        //preparo el arrelgo para regresar por ajax
          for ($i=0; $i <count($fiscal) ; $i++) { 
            $array[$i][0] = $fiscal[$i]->NOMBRE;
            // $array[$i][1] = $fiscal[$i]->EMP;
            // $array[$i][2] = $fiscal[$i]->PERIODO;
            $array[$i][1] = round($fiscal[$i]->total_importe,2);
            $array[$i][2] = round($fiscal[$i]->provision,2);
            $array[$i][3] = round($fiscal[$i]->total_fiscal,2);
            if (!isset($fiscal[$i]->asimilado)) {
              $fiscal[$i]->asimilado = 0;
              $fiscal[$i]->total_periodo_actual = $fiscal[$i]->total_fiscal;
            }
            $array[$i][4] = round($fiscal[$i]->asimilado,2); 
            $array[$i][5] = round($fiscal[$i]->total_periodo_actual,2);
            $array[$i][6] = 0;
            $array[$i][7] = 0;
            $array[$i][8] = 0;
            
          }
          
           $total[1]=0;
           $total[2]=0;
           $total[3]=0;
          //---------Periodo anterior año anterior--------------------
          $periodo = '2018'.substr($periodo, 4, 2);
            $fiscal1 = $this::fiscalAnoA($periodo);
            $asimilado1 = $this::asimiladoAnoA($periodo);
            
             
              //termino de calcular los campos para la tabla
              for ($i=0; $i <count($fiscal) ; $i++) { 
                foreach ($asimilado as $percepcion) {
                  if ($fiscal[$i]->NOMBRE==$percepcion->NOMBRE) {
                    $fiscal[$i]->asimilado = $percepcion->total_importe;
                    if (!isset($fiscal[$i]->total_fiscal)) {
                      $fiscal[$i]->total_fiscal = 0;
                    }
                     $fiscal[$i]->total_periodo_actual = $fiscal[$i]->asimilado + $fiscal[$i]->total_fiscal;
                  }
                }
              }
              
          //agrego el total del periodo anterior al array
          for ($i=0; $i <count($array) ; $i++) { 
            foreach ($fiscal as $fisca) {

              if ($array[$i][0]==$fisca->NOMBRE) {
                if (!isset($fisca->asimilado)) {
              $fisca->asimilado = 0;
              $fisca->total_periodo_actual = $fisca->total_fiscal;
            }
              $array[$i][6] = round($fisca->total_periodo_actual,2);
              $variacionP = $array[$i][5]-$fisca->total_periodo_actual;
              $array[$i][7] = round(abs($variacionP),2);
              
              if ($array[$i][7]!==0.0) {
             $porcentaje = Round(($array[$i][7]/ $array[$i][5])*100, 2);
            }else{
              $porcentaje = 0;
            }
              
              $array[$i][8] = $porcentaje.'%';
              $nombres[$i] = $array[$i][0];
            $despliega[$i] = $array[$i][5];
            $despliega2[$i] = $array[$i][6];
            $total[1] = $total[1]+$array[$i][7];
            $total[2] = $total[2]+$array[$i][5];
            $total[3] = $total[3]+$array[$i][6];
              }
            }
          }
      return response(array('tabla'=>$array,'grafica'=>$despliega,'nombres'=>$nombres,'totales'=>$total,'anterior'=>$despliega2));
  }

  public function fiscalNeto($periodo)
  {
    //consulta de las percepciones
        $percepciones  = DB::connection('sqlsrv2')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ca2019','EMPLEADO.EMP','=','ca2019.EMP')
                        ->select('NOMBRE','NetoMensual','ca2019.EMP',DB::raw('SUM(IMPORTE) as total_importe'))
                        ->groupBy('NOMBRE','ca2019.EMP')
                        ->where('ca2019.CONCEPTO','<', 500)
                        ->join('CONTROL','ca2019.PERIODO','=','CONTROL.PERIODO')
                        ->select('NOMBRE','NetoMensual','ca2019.EMP',DB::raw('SUM(IMPORTE) as total_importe'))
                        ->groupBy('NOMBRE','NetoMensual','ca2019.EMP')
                        ->where('CONTROL.PERIANO',$periodo)
                        ->select('NOMBRE','NetoMensual',DB::raw('SUM(IMPORTE) as total_importe'))
                        ->groupBy('NOMBRE','NetoMensual')
                        ->get();
      //consultas de las deducciones
        $deducciones  = DB::connection('sqlsrv2')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ca2019','EMPLEADO.EMP','=','ca2019.EMP')
                        ->select('NOMBRE','NetoMensual','ca2019.EMP',DB::raw('SUM(IMPORTE) as total_import'))
                        ->groupBy('NOMBRE','ca2019.EMP')
                        ->where('ca2019.CONCEPTO','>', 499)
                        ->join('CONTROL','ca2019.PERIODO','=','CONTROL.PERIODO')
                        ->select('NOMBRE','NetoMensual','ca2019.EMP',DB::raw('SUM(IMPORTE) as total_import'))
                        ->groupBy('NOMBRE','NetoMensual','ca2019.EMP')
                        ->where('CONTROL.PERIANO',$periodo)
                        ->select('NOMBRE','NetoMensual',DB::raw('SUM(IMPORTE) as total_import'))
                        ->groupBy('NOMBRE','NetoMensual')
                        ->get();

        // dd($percepciones,$deducciones);
        //percepciones - deducciones para obtener el sueldo neto
        for ($i=0; $i < count($percepciones) ; $i++) { 
          foreach ($deducciones as $deduccione) {
            if ($percepciones[$i]->NOMBRE == $deduccione->NOMBRE) {
              $percepciones[$i]->total_importe= $percepciones[$i]->total_importe-$deduccione->total_import;
            }
          }
        }

        $datos = $percepciones;

        $provisiones = DB::connection('sqlsrv2')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ProvisionAcumula','EMPLEADO.EMP','=','ProvisionAcumula.Empleado')
                        ->select('NOMBRE',DB::raw('SUM(ImpEstatal) as total_ImpEstatal'),DB::raw('SUM(PImss) as total_PImss'),DB::raw('SUM(PSar) as total_PSar'),DB::raw('SUM(PInfonavit) as total_PInfonavit'))
                        ->groupBy('NOMBRE')
                        // ->where('ca2019.CONCEPTO','<', 500)
                         ->join('CONTROL','ProvisionAcumula.Periodo','=','CONTROL.PERIODO')
                         ->select('NOMBRE',DB::raw('SUM(ImpEstatal) as total_ImpEstatal'),DB::raw('SUM(PImss) as total_PImss'),DB::raw('SUM(PSar) as total_PSar'),DB::raw('SUM(PInfonavit) as total_PInfonavit'))
                         ->groupBy('NOMBRE')
                        // ->groupBy('NOMBRE','NetoMensual','ca2019.EMP','CONTROL.PERIODO')
                         ->where('CONTROL.PERIANO',$periodo)
                        ->get();
            // dd($datos,$provisiones);
        if (!isset($provisiones[0])) {
          for ($i=0; $i <count($datos) ; $i++) { 
               $datos[$i]->total_fiscal = $datos[$i]->total_importe;
               $datos[$i]->provision = 0;
                   //sumamos el sueldo fiscal + las provisiones
                   $datos[$i]->total_fiscal = $datos[$i]->total_importe+$datos[$i]->provision;
               
              }
            }else{
              for ($i=0; $i <count($datos) ; $i++) { 
                foreach ($provisiones as $provision) {
                  if ($datos[$i]->NOMBRE==$provision->NOMBRE) {

                   $datos[$i]->provision = $provision->total_ImpEstatal+$provision->total_PImss+$provision->total_PSar+$provision->total_PInfonavit;
                   //sumamos el sueldo fiscal + las provisiones
                   $datos[$i]->total_fiscal = $datos[$i]->total_importe+$datos[$i]->provision;
                   
                  }
                }
              }
            }
// dd($datos);
      return $datos;
  }

  public function asimiladoNeto($periodo)
  {
    //--------------parte de asimilado-----------------------------------------------
        //consulta de las percepciones
        $percepciones  = DB::connection('sqlsrv2')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ca2019','EMPLEADO.EMP','=','ca2019.EMP')
                        ->select('NOMBRE','NetoMensual','ca2019.EMP',DB::raw('SUM(IMPORTE) as total_importe'))
                        ->groupBy('NOMBRE','ca2019.EMP')
                        ->where('ca2019.CONCEPTO','<', 500)
                        ->join('CONTROL','ca2019.PERIODO','=','CONTROL.PERIODO')
                        ->select('NOMBRE','NetoMensual','ca2019.EMP',DB::raw('SUM(IMPORTE) as total_importe'))
                        ->groupBy('NOMBRE','NetoMensual','ca2019.EMP')
                        ->where('CONTROL.PERIANO',$periodo)
                        ->select('NOMBRE','NetoMensual',DB::raw('SUM(IMPORTE) as total_importe'))
                        ->groupBy('NOMBRE','NetoMensual')
                        ->get();
      //consultas de las deducciones
        $deducciones  = DB::connection('sqlsrv2')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ca2019','EMPLEADO.EMP','=','ca2019.EMP')
                        ->select('NOMBRE','NetoMensual','ca2019.EMP',DB::raw('SUM(IMPORTE) as total_import'))
                        ->groupBy('NOMBRE','ca2019.EMP')
                        ->where('ca2019.CONCEPTO','>', 499)
                        ->join('CONTROL','ca2019.PERIODO','=','CONTROL.PERIODO')
                        ->select('NOMBRE','NetoMensual','ca2019.EMP',DB::raw('SUM(IMPORTE) as total_import'))
                        ->groupBy('NOMBRE','NetoMensual','ca2019.EMP')
                        ->where('CONTROL.PERIANO',$periodo)
                        ->select('NOMBRE','NetoMensual',DB::raw('SUM(IMPORTE) as total_import'))
                        ->groupBy('NOMBRE','NetoMensual')
                        ->get();
       
        //percepciones - deducciones para obtener el sueldo neto
        for ($i=0; $i < count($percepciones) ; $i++) { 
          foreach ($deducciones as $deduccione) {
            if ($percepciones[$i]->NOMBRE == $deduccione->NOMBRE) {
              $percepciones[$i]->total_importe= $percepciones[$i]->total_importe-$deduccione->total_import;
            }
          }
        }
    return $percepciones;
  }

  public function Provision($periodo)
  {
    $provisiones = DB::connection('sqlsrv2')->table('EMPLEADO')
                        ->where('ESTATUS','!=','B')
                        ->join('ProvisionAcumula','EMPLEADO.EMP','=','ProvisionAcumula.Empleado')
                        ->select('NOMBRE','ProvisionAcumula.Pmensual')
                        ->groupBy('NOMBRE','ProvisionAcumula.Pmensual')
                        ->join('CONTROL','ProvisionAcumula.Periodo','=','CONTROL.PERIODO')
                        ->select('NOMBRE','CONTROL.PERIANO','ProvisionAcumula.Pmensual')
                        ->groupBy('NOMBRE','CONTROL.PERIANO','ProvisionAcumula.Pmensual')
                        ->where('CONTROL.PERIANO',$periodo)
                        ->get();
    return $provisiones;
  }

  public function ReporteCinco(Request $periodo)
  {
      $periodo = $periodo->tipo;
        $fiscal = $this::fiscalNeto($periodo);
        $asimilado = $this::asimiladoNeto($periodo);
        
         // dd($fiscal,$asimilado);
          //termino de calcular los campos para la tabla
          for ($i=0; $i <count($fiscal) ; $i++) { 
            foreach ($asimilado as $percepcion) {
              if ($fiscal[$i]->NOMBRE==$percepcion->NOMBRE) {
                $fiscal[$i]->asimilado = $percepcion->total_importe;
                 $fiscal[$i]->total_periodo_actual = $fiscal[$i]->asimilado + $fiscal[$i]->total_fiscal;
              }
            }
          }
        //preparo el arrelgo para regresar por ajax
          for ($i=0; $i <count($fiscal) ; $i++) { 
            $array[$i][0] = $fiscal[$i]->NOMBRE;
             $array[$i][1] = $fiscal[$i]->NetoMensual; //netomensual
            // $array[$i][2] = $fiscal[$i]->PERIODO;
            $array[$i][2] = round($fiscal[$i]->total_importe,2); //sueldo fiscal
            $array[$i][3] = round($fiscal[$i]->provision,2); //provision social con estrategia
            $array[$i][4] = round($fiscal[$i]->total_fiscal,2); //total fiscal
            if (!isset($fiscal[$i]->asimilado)) {
              $fiscal[$i]->asimilado = 0;
              $fiscal[$i]->total_periodo_actual = $fiscal[$i]->total_fiscal;
            }
            $array[$i][5] = round($fiscal[$i]->asimilado,2); 
            $array[$i][6] = round($fiscal[$i]->total_periodo_actual,2);
            $array[$i][7] = round($fiscal[$i]->NetoMensual,2);
            $array[$i][8] = 0;
            $array[$i][9] = 0;
            $array[$i][10] = 0;
            $array[$i][11] = 0;
            
          }

          $provisiones = $this::Provision($periodo);
          
          $total[1]=0;
          $total[2]=0;
           $total[3]=0;
          for ($i=0; $i <count($array) ; $i++) { 
            foreach ($provisiones as $provision) {
              if ($array[$i][0]==$provision->NOMBRE) {
                $array[$i][8] = round($provision->Pmensual,2); //<-Provision mensual o estimado del empleado
                $array[$i][9] = round($array[$i][8]+$array[$i][7],2); //total costo sin estrategia promensual + sueldo sin estrategia
                $array[$i][10] = round($array[$i][9]-$array[$i][6],2); //difeencia entre total con estrategia y sin estra (ahorro compañia)
                $array[$i][11] = Round(($array[$i][10]/ $array[$i][9])*100, 2).'%'; //porcentaje de ahorro
                $total[1] = round($total[1]+$array[$i][6],2); //total con estrategia
                $total[2] = round($total[2]+$array[$i][9],2); //total sin estrategia
                $total[3] = round($total[3]+$array[$i][10],2); //total de ahorro
              }
            }
          }

          return response(array('tabla'=>$array,'totales'=>$total));
  }

  public function ReporteSeis(Request $reporte)
  {
    $puestos = Puesto::get();
      for ($i=0; $i < count($puestos) ; $i++) { 
        $array[$i][0] = $puestos[$i]->NOMBRE;
        $array[$i][1] = $puestos[$i]->AUTORIZADA;
        $array[$i][2] = $puestos[$i]->OCUPADAS;
        $array[$i][3] = round(($array[$i][2]/$array[$i][1])*100,2).'%';
        $nombres[$i] = $puestos[$i]->NOMBRE;
        $total[$i] = round(($array[$i][2]/$array[$i][1])*100,2);
      }

    return response(array('tabla'=>$array,'nombres'=>$nombres,'totales'=>$total));
  }
} 
