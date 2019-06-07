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
      if (auth()->user()->client_id == 8) {
          $costos = VarCostoActual::get();
          $costoAnoAs = VarCostoAnoA::get();
          $variaciones = VariacionEstra::get();
          $bandera = 1;
          return view('/formato1')->with(compact('control','navbar','NoEmp','controlPeriodos','costos','costoAnoAs','variaciones','bandera'));
        }
      $bandera = 0; 
    	return view('/formato1')->with(compact('control','navbar','NoEmp','controlPeriodos','bandera'));
    	
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
                $array[$i][9] = $suspencion->total_unidades*1;
                
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

        // $arrSku = array('empleado' => array('nombre' => 1), 'empleado1' => array('nombre' => 10) );
      
        // $arrNewSku = array();
        // $incI = 0;
        //  $inc = 0;
        // foreach($array AS $arrKey => $arrData){

        // $arrNewSku[$incI]['nombre'] = $arrData[$inc];
        // $arrNewSku[$incI]['uno'] = $arrData[$inc+1];
        // $arrNewSku[$incI]['dos'] = $arrData[$inc+2];
        // $arrNewSku[$incI]['tres'] = $arrData[$inc+3];
        // $arrNewSku[$incI]['cuatro'] = $arrData[$inc+4];
        // $arrNewSku[$incI]['cinco'] = $arrData[$inc+5];
        // $arrNewSku[$incI]['seis'] = $arrData[$inc+6];
        // $arrNewSku[$incI]['siete'] = $arrData[$inc+7];
        // $arrNewSku[$incI]['ocho'] = $arrData[$inc+8];
        // $arrNewSku[$incI]['nueve'] = $arrData[$inc+9];
        // $arrNewSku[$incI]['10'] = $arrData[$inc+10];
        // $incI++;
        
        // }

        // //Convert array to json form...
        // $encodedSku = json_encode($arrNewSku);
        // return response($encodedSku);
      
      
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
                $array[$i][9] = $suspencion->total_unidades*1;
                
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

        // $arrSku = array('empleado' => array('nombre' => 1), 'empleado1' => array('nombre' => 10) );
      
        // $arrNewSku = array();
        // $incI = 0;
        //  $inc = 0;
        // foreach($array AS $arrKey => $arrData){

        // $arrNewSku[$incI]['nombre'] = $arrData[$inc];
        // $arrNewSku[$incI]['uno'] = $arrData[$inc+1];
        // $arrNewSku[$incI]['dos'] = $arrData[$inc+2];
        // $arrNewSku[$incI]['tres'] = $arrData[$inc+3];
        // $arrNewSku[$incI]['cuatro'] = $arrData[$inc+4];
        // $arrNewSku[$incI]['cinco'] = $arrData[$inc+5];
        // $arrNewSku[$incI]['seis'] = $arrData[$inc+6];
        // $arrNewSku[$incI]['siete'] = $arrData[$inc+7];
        // $arrNewSku[$incI]['ocho'] = $arrData[$inc+8];
        // $arrNewSku[$incI]['nueve'] = $arrData[$inc+9];
        // $arrNewSku[$incI]['10'] = $arrData[$inc+10];
        // $incI++;
        
        // }

        // //Convert array to json form...
        // $encodedSku = json_encode($arrNewSku);
        // return response($encodedSku);
      
      
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
} 
