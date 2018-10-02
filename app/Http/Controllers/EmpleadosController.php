<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProfileController;
use App\Job;
use App\Depto;
use App\Estados;
use App\DatosGe;
use App\DatosAfo;
use App\Imss;
use Session;

class EmpleadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('database');
    }

    public function index()
    {  
        $selProceso = Session::get('selProceso');
    	$emps = Empleado::where('TIPONO', $selProceso)->get();
        $jobs = Job::all();
        $deps = Depto::all();
        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('catalogos.empleados.index')->with(compact('navbar','emps', 'jobs', 'deps'));
    }

     public function getDatosEmpleado(Request $data) {
       
        $emp= $data->fldide;
        $empleado = Empleado::where('EMP', $emp)->get()->first();
        $empleado2 = DatosGe::where('EMP', $emp)->get()->first();
        $foto = $empleado2->FOTO;
        $nombre = $empleado->NOMBRE;
        $puesto = $empleado->PUESTO;
        $puesto1 = Job::where('PUESTO', $puesto)->get()->first();
        $puesto2 = $puesto1->NOMBRE;
        $depto = $empleado->DEPTO;
        $depto1 = Depto::where('DEPTO', $depto)->get()->first();
        $depto2 = $depto1->DESCRIP;
        $localidad = $empleado2->CIUDAD;
        $telefono = $empleado2->TELEFONO;
        $data = array(
            "nombre" => $nombre,
            "puesto" => $puesto2,
            "depto" => $depto2,
            "localidad" => $localidad,
            "telefono" => $telefono,
            "foto" => $foto

        );
         
        // echo json_encode($data);
       return response($data);
        // $data2 = $data->fldide;
        // return response($data2);
    }

    public function create() 
    {
        $selProceso = Session::get('selProceso');
        $jobs = Job::all();
        $deps = Depto::all();
        $ests = Estados::all();
        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        $emp = new Empleado();
        $emp->TIPONO = $selProceso;
    	return view('catalogos.empleados.create')->with(compact('jobs','deps', 'ests', 'selProceso', 'navbar','emp'));
    }


    public function getSalarioIntegrado(Request $data) {
        //$integrado = calculaIntegrado;
        // Calcula Salario Integrado
        // anios = CInt(Date - CDate(dingreso.value))
        // If anios <> 0 Then
        //   anios = anios / 365
        // End If
        // Set rsinteg = Integ.GetBatchOptimistic(Empresa.NominaCnStr, "TABINTEG", "TIPONO= '" & Empresa.Tiponom & "' AND  NUMANO= " & anios)
        // If rsinteg.RecordCount > 0 Then
        //    FACT = rsinteg!Factor
        // Else
        //    FACT = 0
        // End If
        // BUSTOPE CDate(dingreso.value), wkte, wkti
        // If Round(tntsueldo.value * FACT, 2) > wkte Then
        //    tntinteg.value = wkte
        // Else
        //    tntinteg.value = Round(tntsueldo.value * FACT, 2)
        // End If

        $selProceso = Session::get('selProceso');
        $minimoDF = Session::get('minimoDF');               
        $hoy = date_create();
        $ingreso2 = date('d-m-Y', strtotime($data->fldIngreso));
        $ingreso = date_create($data->fldIngreso);
        $anios = date_diff($hoy, $ingreso)->y;
        $factor = DB::connection("sqlsrv2")->table('TABINTEG')->where('TIPONO',$selProceso)->where('NUMANO',$anios)->first()->FACTOR;
        $topes = DB::connection("sqlsrv2")->table('PARIMSS')->where('FECHAI','<=',$ingreso2)->where('FECHAF','>=', $ingreso2)->first();
        //   // salmin = ParamCia.minimodf
        //   // If RSPAR.RecordCount > 0 Then
            
        //   //    wkte = RSPAR!Topeims * salmin
        //   //    wkti = RSPAR!TopeIV * salmin
        //   // Else
        //   //    wkte = 25 * salmin
        //   //    wkti = 10 * salmin
        //   // End If 
        if ($topes->TOPEIMS) {
            $wkte =  $topes->TOPEIMS * $minimoDF;
            $wkti = $topes->TOPEIV * $minimoDF;
        } else {
            $wkte = 25 * $minimoDF;
            $wkti = 10 * $minimoDF;
        }
        if ( Round($data->fldSueldo * $factor,2) > $wkte) {
            $integrado = Round($wkte,2);
        } else {
            $integrado = Round($data->fldSueldo * $factor, 2);
        }

        if ( Round($data->fldSueldo * $factor,2) > $wkti) {
            $integrado2 = Round($wkte,2);
        } else {
            $integrado2 = Round($data->fldSueldo * $factor, 2);
        }
        $data = array(
            "integrado" => $integrado,
            "integrado2" => $integrado2
            
        );
         
        // echo json_encode($data);
        // exit();
        //$integrado = $topes->TOPEIMS;
        return response($data);
        // $data2 = $data->fldSueldo . " - " . $data->fldIngreso . " - " . $anios . " - " . $factor . " - " . $topes;
        // return response($data2);
    }


    public function store(Request $request)
    {
        $selProceso = Session::get('selProceso');

    	$emp = new Empleado();
        $emp->TIPONO = $selProceso;
        $emp->EMP = $request->input('EMP');
        $emp->NOMBRE = $request->input('NOMBRES') . ' ' . $request->input('PATERNO') . ' ' . $request->input('MATERNO');
        $emp->PUESTO = $request->input('PUESTO');
        $emp->cuenta = $request->input('cuenta');
        $emp->DEPTO = $request->input('DEPTO');
        $emp->TIPOTRA = $request->input('TIPOTRA');
        $emp->c_Estado = $request->input('c_Estado');
        $emp->DIRIND = $request->input('DIRIND');
        $emp->TIPOJORNADA = $request->input('TIPOJORNADA');
        $emp->TIPOREGIMEN = $request->input('TIPOREGIMEN');
        $emp->CHECA = $request->input('CHECA');
        $emp->SINDIC = $request->input('SINDIC');
        $emp->TURNO = $request->input('TURNO');
        $emp->ZONAECO = $request->input('ZONAECO') . "";
        $emp->ESTATUS = $request->input('ESTATUS');
        $emp->CLIMSS = $request->input('CLIMSS') . "";
        $emp->TIPOPAGO = $request->input('TIPOPAGO');
        $emp->c_TipoContrato = $request->input('c_TipoContrato');
        $emp->INGRESO = date('d-m-Y', strtotime($request->input('INGRESO')));
        $emp->VACACION = date('d-m-Y', strtotime($request->input('VACACION')));
        $emp->PLANTA = date('d-m-Y', strtotime($request->input('PLANTA')));
        $emp->VENCIM = date('d-m-Y', strtotime($request->input('VENCIM')));
        $emp->BAJA = date('d-m-Y', strtotime($request->input('BAJA')));
        $emp->REGPAT = $request->input('REGPAT');
        $emp->RFC = $request->input('RFC');
        $emp->IMSS = $request->input('IMSS');
        $emp->GRUIMS = $request->input('GRUIMS');
        $emp->FONACOT = $request->input('FONACOT') . "";
        $emp->INFONAVIT = $request->input('INFONAVIT') . "";
        $emp->OTRACIA = $request->input('OTRACIA');
        $emp->TAXOTRA = $request->input('TAXOTRA');
        $emp->CASOTRA = $request->input('CASOTRA');
        $emp->SAROTR = $request->input('SAROTR') . "";
        $emp->DESINFO = $request->input('DESINFO');
        $emp->SUELDO = $request->input('SUELDO');
        $emp->VARIMSS = $request->input('VARIMSS');
        $emp->INTEG = $request->input('INTEG');
        $emp->INTIV = $request->input('INTIV');
        $emp->PRESDEC = $request->input('PRESDEC');
        $emp->NOCRED = $request->input('NOCRED');
        
        $emp->save();

        $dage = new DatosGe();
        $dage->EMP = $request->input('EMP2');
        $dage->NIVEL = $request->input('NIVEL') . "";
        $dage->DEPTO = $request->input('DEPTO') . "";
        $dage->REPORTA = $request->input('REPORTA') . "";
        $dage->DIRECCION = $request->input('DIRECCION') . "";
        $dage->PUESTO = $request->input('PUESTO');
        $dage->Referencia = $request->input('Referencia') . "";
        $dage->noExterior = $request->input('noExterior') . "";
        $dage->noInterior = $request->input('noInterior') . "";
        $dage->Municipio = $request->input('Municipio') . "";
        $dage->COLONIA = $request->input('COLONIA') . "";
        $dage->CIUDAD = $request->input('CIUDAD') . "";
        $dage->ESTADO = $request->input('ESTADO') . "";
        $dage->TELEFONO = $request->input('TELEFONO') . "";
        $dage->ZIP = $request->input('ZIP') . "";
        $dage->CELULAR = $request->input('CELULAR') . "";
        $dage->EXPERI = $request->input('EXPERI') . "";
        $dage->SEXO = $request->input('SEXO') . "";
        $dage->CIVIL = $request->input('CIVIL');
        $dage->BODA = date('d-m-Y', strtotime($request->input('BODA')));
        $dage->LICENCIA = $request->input('LICENCIA');
        $dage->SANGRE = $request->input('SANGRE');
        $dage->ESCOLAR = $request->input('ESCOLAR');
        $dage->CAMB_RESID = $request->input('CAMB_RESID');
        $dage->DISP_VIAJE = $request->input('DISP_VIAJE');
        $dage->BORN = date('d-m-Y', strtotime($request->input('BORN')));
        $dage->NACIM = $request->input('NACIM') . "";
        $dage->TIPONO = $selProceso;
        $dage->NACIONAL = $request->input('NACIONAL');
        $dage->DEPENDIENT = $request->input('DEPENDIENT') . "";
        $dage->MEDIO = $request->input('MEDIO');
        $dage->FUENTE = $request->input('FUENTE') . "";
        $dage->Email = $request->input('Email') . "";
        $file = $request->file('archivo');
        
        if ($file !== null) {
            
            $path = public_path() . '/admon/empleados/empresas/'. $dage->EMP .'/';
            $fileName = uniqid() . $file->getClientOriginalName();
            $moved =  $file->move($path, $fileName);
            
            if ($moved) {
            //     // guarda la liga en la BD
             $dage->FOTO = $fileName;
                
             }
             
        }
        else{
            
        }  
        $dage->save();

        $daafo = new DatosAfo();
        $daafo->EMP = $request->input('EMP');
        $daafo->TIPONO = $selProceso;
        $daafo->CURP = $request->input('CURP');
        $daafo->IMSS = $request->input('IMSS2');
        $daafo->NOMBRES = $request->input('NOMBRES');
        $daafo->PATERNO = $request->input('PATERNO') . "";
        $daafo->MATERNO = $request->input('MATERNO') . "";
        $daafo->PADRE = $request->input('PADRE') . "";
        $daafo->MADRE = $request->input('MADRE') . "";
        $daafo->save();
       
        $imss = new Imss();
        $imss->TIPONO = $selProceso;
        $imss->EMP = $request->input('EMP');
        $imss->FECHA = date('d-m-Y', strtotime($request->input('INGRESO')));
        $imss->CLAVE = 15;
        $imss->SUELDO = $request->input('SUELDO');
        $imss->INTEG = $request->input('INTEG');
        $imss->INTIV = $request->input('INTIV');
        $imss->SUELDONUE = $request->input('SUELDO');
        $imss->INTEGNUE = $request->input('INTEG');
        $imss->INTIVNUE = $request->input('INTIV');
        $imss->save();

       
        return redirect('/catalogos/empleados');
    }

    public function edit($emp)
    {
        
        
        $empl = Empleado::where('EMP', $emp)->get()->first(); 
        $empl1 = DatosGe::where('EMP', $emp)->get()->first();
        $empl11 = DatosAfo::where('EMP', $emp)->get()->first();
        $jobs = Job::all();
        $deps = Depto::all();
        $ests = Estados::all();
        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
    	return view('catalogos.empleados.edit')->with(compact('empl', 'jobs', 'deps', 'ests', 'empl1', 'empl11', 'navbar')); 
    }

     public function update(Request $request, $EMP)
    {
        $selProceso = Session::get('selProceso');
        $EMP = $request->input('EMP');
        $BajaImss = $request->input('BajaImss');
        //actualizar estado de empleado en la tabla imss por movimiento de status
        $estatus = $request->input('ESTATUS');
        $emps = Empleado::where('EMP', $EMP)->get()->first();
        if ($emps->ESTATUS==$estatus) {
             echo "No hubo cambio";
        } else{
            
            if (($estatus=='A') && ($emps->ESTATUS!=='M')) {
                $imss = new Imss();
                $imss->TIPONO = $selProceso;
                $imss->EMP = $request->input('EMP');
                $imss->FECHA = date('d-m-Y', strtotime($request->input('INGRESO')));
                $imss->CLAVE = 8;
                $imss->SUELDO = $request->input('SUELDO');
                $imss->INTEG = $request->input('INTEG');
                $imss->INTIV = $request->input('INTIV');
                $imss->SUELDONUE = $request->input('SUELDO');
                $imss->INTEGNUE = $request->input('INTEG');
                $imss->INTIVNUE = $request->input('INTIV');
                $imss->save();
                    }

            if (($estatus=='B') && ($BajaImss==1)) {
                $imss = new Imss();
                $imss->TIPONO = $selProceso;
                $imss->EMP = $request->input('EMP');
                $imss->FECHA = date('d-m-Y', strtotime($request->input('BAJA')));
                $imss->CLAVE = 2;
                $imss->SUELDO = $request->input('SUELDO');
                $imss->INTEG = $request->input('INTEG');
                $imss->INTIV = $request->input('INTIV');
                $imss->CAUSA = $request->input('CAUSA');
                $imss->SUELDONUE = $request->input('SUELDO');
                $imss->INTEGNUE = $request->input('INTEG');
                $imss->INTIVNUE = $request->input('INTIV');
                $imss->save();
                    }

         }  
        $emple = Empleado::where('EMP', $EMP)->get()->first();
        $emple->TIPONO = $selProceso;
        $emple->EMP = $request->input('EMP');
        $emple->NOMBRE = $request->input('NOMBRES') . ' ' . $request->input('PATERNO') . ' ' . $request->input('MATERNO');
        $emple->PUESTO = $request->input('PUESTO');
        $emple->cuenta = $request->input('cuenta');
        $emple->DEPTO = $request->input('DEPTO');
        $emple->TIPOTRA = $request->input('TIPOTRA');
        $emple->c_Estado = $request->input('c_Estado');
        $emple->DIRIND = $request->input('DIRIND');
        $emple->TIPOJORNADA = $request->input('TIPOJORNADA');
        $emple->TIPOREGIMEN = $request->input('TIPOREGIMEN');
        $emple->CHECA = $request->input('CHECA');
        $emple->SINDIC = $request->input('SINDIC');
        $emple->TURNO = $request->input('TURNO');
        $emple->ZONAECO = $request->input('ZONAECO') . "";
        $emple->ESTATUS = $request->input('ESTATUS');
        $emple->CLIMSS = $request->input('CLIMSS') . "";
        $emple->TIPOPAGO = $request->input('TIPOPAGO');
        $emple->c_TipoContrato = $request->input('c_TipoContrato');
        $emple->INGRESO = date('d-m-Y', strtotime($request->input('INGRESO')));
        $emple->VACACION = date('d-m-Y', strtotime($request->input('VACACION'))); 
        $emple->PLANTA = date('d-m-Y', strtotime($request->input('PLANTA')));
        $emple->VENCIM = date('d-m-Y', strtotime($request->input('VENCIM')));
        $emple->BAJA = date('d-m-Y', strtotime($request->input('BAJA')));
        $emple->REGPAT = $request->input('REGPAT');
        $emple->RFC = $request->input('RFC');
        $emple->IMSS = $request->input('IMSS');
        $emple->GRUIMS = $request->input('GRUIMS');
        $emple->FONACOT = $request->input('FONACOT') . "";
        $emple->INFONAVIT = $request->input('INFONAVIT') . "";
        $emple->OTRACIA = $request->input('OTRACIA');
        $emple->TAXOTRA = $request->input('TAXOTRA');
        $emple->CASOTRA = $request->input('CASOTRA');
        $emple->SAROTR = $request->input('SAROTR') . "";
        $emple->DESINFO = $request->input('DESINFO');
        $emple->SUELDO = $request->input('SUELDO');
        $emple->VARIMSS = $request->input('VARIMSS');
        $emple->INTEG = $request->input('INTEG');
        $emple->INTIV = $request->input('INTIV');
        $emple->PRESDEC = $request->input('PRESDEC');
        $emple->NOCRED = $request->input('NOCRED');
        $emple->save();
  
        $emple1 = DatosGe::where('EMP', $EMP)->get()->first();
        $emple1->NIVEL = $request->input('NIVEL') . "";
        $emple1->DEPTO = $request->input('DEPTO') . "";
        $emple1->REPORTA = $request->input('REPORTA') . "";
        $emple1->DIRECCION = $request->input('DIRECCION') . "";
        $emple1->PUESTO = $request->input('PUESTO');
        $emple1->Referencia = $request->input('Referencia') . "";
        $emple1->noExterior = $request->input('noExterior') . "";
        $emple1->noInterior = $request->input('noInterior') . "";
        $emple1->Municipio = $request->input('Municipio') . "";
        $emple1->COLONIA = $request->input('COLONIA') . "";
        $emple1->CIUDAD = $request->input('CIUDAD') . "";
        $emple1->ESTADO = $request->input('ESTADO') . "";
        $emple1->TELEFONO = $request->input('TELEFONO') . "";
        $emple1->ZIP = $request->input('ZIP') . "";
        $emple1->CELULAR = $request->input('CELULAR') . "";
        $emple1->EXPERI = $request->input('EXPERI') . "";
        $emple1->SEXO = $request->input('SEXO') . "";
        $emple1->CIVIL = $request->input('CIVIL');
        $emple1->BODA = date('d-m-Y', strtotime($request->input('BODA')));
        $emple1->LICENCIA = $request->input('LICENCIA');
        $emple1->SANGRE = $request->input('SANGRE');
        $emple1->ESCOLAR = $request->input('ESCOLAR');
        $emple1->CAMB_RESID = $request->input('CAMB_RESID');
        $emple1->DISP_VIAJE = $request->input('DISP_VIAJE');
        $emple1->BORN = date('d-m-Y', strtotime($request->input('BORN')));
        $emple1->NACIM = $request->input('NACIM') . "";
        $emple1->NACIONAL = $request->input('NACIONAL');
        $emple1->DEPENDIENT = $request->input('DEPENDIENT') . "";
        $emple1->MEDIO = $request->input('MEDIO');
        $emple1->FUENTE = $request->input('FUENTE') . "";
        $emple1->Email = $request->input('Email') . "";
        $file = $request->file('archivo');
        //dd($file);
        if ($file !== null) {
            
            $path = public_path() . '/admon/empleados/empresas/'. $emple1->EMP .'/';
            $fileName = uniqid() . $file->getClientOriginalName();
            $moved =  $file->move($path, $fileName);
            
            if ($moved) {
            //     // guarda la liga en la BD
             $emple1->FOTO = $fileName;
                //dd('actualizada imagen');
             }
        }
        else{
            //dd('no actualizada');
        }
        $emple1->save();

        $emple11 = DatosAfo::where('EMP', $EMP)->get()->first();
        $emple11->CURP = $request->input('CURP');
        $emple11->IMSS = $request->input('IMSS2');
        $emple11->NOMBRES = $request->input('NOMBRES');
        $emple11->PATERNO = $request->input('PATERNO') . "";
        $emple11->MATERNO = $request->input('MATERNO') . "";
        $emple11->PADRE = $request->input('PADRE') . "";
        $emple11->MADRE = $request->input('MADRE') . "";
        $emple11->save();
        return redirect('/catalogos/empleados');
    }
    
}