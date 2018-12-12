<?php
 //inicio del codigo escrito por Ricardo Cordero.2018
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
use App\Empresa;
use App\EmpleadoAsimi;
use App\DatosGeAsimi;
use App\DatosAfoAsimi;
use App\ImssAsimi;
use Illuminate\Validation\Rule;
use App\ListaDoc;
use App\Ciasno;
use App\Cell;
use App\DocsRequeridos;
use App\Client;
use App\Nomina;

// DB::transaction(function () use($data) {
// });
class EmpleadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('database');
        $this->middleware('databaseAsimi');

    }

    public function index(){  

        $selProceso = Session::get('selProceso');
    	$emps = Empleado::where('TIPONO', $selProceso)->get();
        $jobs = Job::all();
        $deps = Depto::all();
        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        //mkdir("../utilerias/creado", 0700);
    	return view('catalogos.empleados.index')->with(compact('navbar','emps', 'jobs', 'deps'));
    }

    public function getDatosEmpleado(Request $data) {
        
        $emp= $data->fldide;
        $empleado = Empleado::where('EMP', $emp)->get()->first();
        $empleado2 = DatosGe::where('EMP', $emp)->get()->first();
        $foto = $empleado2->FOTO;
        $sangre = $empleado2->SANGRE;
        $nombre = $empleado->NOMBRE;
        $imss = $empleado->IMSS;
        $puesto = $empleado->PUESTO;
        $puesto1 = Job::where('PUESTO', $puesto)->get()->first();
        $puesto2 = $puesto1->NOMBRE;
        $depto = $empleado->DEPTO;
        $depto1 = Depto::where('DEPTO', $depto)->get()->first();
        $depto2 = $depto1->DESCRIP;
        $localidad = $empleado2->CIUDAD;
        $telefono = $empleado2->TELEFONO;
        $curri =ListaDoc::where('EMP', $emp)->get()->first();
        $curriculum = $curri->NOMBRE11;
        $data = array(
            "nombre" => $nombre,
            "puesto" => $puesto2,
            "depto" => $depto2,
            "localidad" => $localidad,
            "telefono" => $telefono,
            "foto" => $foto,
            "sangre" => $sangre,
            "imss" => $imss,
            "curriculum" => $curriculum

        );
         
        // echo json_encode($data);
       return response($data);
        // $data2 = $data->fldide;
        // return response($data2);
    }

    public function create() {
        $selProceso = Session::get('selProceso');
        $cliente = auth()->user()->client;
        if ($cliente->fiscal==1 && $cliente->asimilado==1){
            $AsimiFiscal = 1;
        }else{
            $AsimiFiscal = 0;
        }
        $emps = Empleado::where('TIPONO', $selProceso)->get()->last();
        if ($emps==null){
            $ultimo = 1;
            $add = str_pad($selProceso,2, "0", STR_PAD_LEFT);
        $ultimo2 = str_pad($ultimo,5, "0", STR_PAD_LEFT);
        $ultimo3 =  $add.$ultimo2;
        }else{
             $ultimo = $emps->EMP + 1;
             $ultimo3 = str_pad($ultimo,7, "0", STR_PAD_LEFT);
        }
        
        
        $jobs = Job::all();
        $deps = Depto::all();
        $ests = Estados::all();
        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        $emp = new Empleado();
        $emp->TIPONO = $selProceso;
        $docsReque = DocsRequeridos::first();
        $minimodia = Nomina::first()->MINIMODIA2;

    	return view('catalogos.empleados.create')->with(compact('jobs','deps', 'ests', 'selProceso', 'navbar','emp', 'ultimo3','AsimiFiscal','docsReque','minimodia'));
    }


    public function getSalarioIntegrado(Request $data) {

        $selProceso = Session::get('selProceso');
        $minimoDF = Session::get('minimoDF');               
        $hoy = date_create();
        $ingreso2 = date('d-m-Y', strtotime($data->fldIngreso));
        $ingreso = date_create($data->fldIngreso);
        $anios = date_diff($hoy, $ingreso)->y;
        $factor = DB::connection("sqlsrv2")->table('TABINTEG')->where('TIPONO',$selProceso)->where('NUMANO',$anios)->first()->FACTOR;
        $topes = DB::connection("sqlsrv2")->table('PARIMSS')->where('FECHAI','<=',$ingreso2)->where('FECHAF','>=', $ingreso2)->first();
  
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
         
      
        return response($data);
        
    }


    public function store(Request $request){
        
        $messages = [
            'EMP.required' => 'el numero de empleado es requerido',
            'EMP.min' => 'el numero de empleado no cumple con los 7 digitos',
            'EMP.unique' => 'el numero de empleado ya esta registrado',
            'RFC.regex' => 'El RFC no tiene el formato correcto',
            'RFC.required' =>'El RFC es requerido',
            'RFC.unique' => 'El RFC del empleado ya se encuentra registrado en otro proceso.'
            
        ];

        $rules = [
            'EMP' => 'required|min:7|unique:sqlsrv2.EMPLEADO,EMP',
            'RFC' => ['unique:sqlsrv2.EMPLEADO,RFC','required','regex:/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/']
            
            
        ];
        // validar
        $this->validate($request,$rules,$messages);
        $cliente = auth()->user()->client;
        $AsimiFiscal = Session::get('tinom');
        if ($AsimiFiscal == 'fiscal') {
            //inicio de las inserciones de fiscal--------------------------------------------------------------------------

           //inicio fiscal?
                                if ($cliente->fiscal==1 && $cliente->asimilado==1)
                                {
                                        
                                        DB::transaction(function () use($request) {
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
                                            
                                            $path = public_path(). '/img_emp/';
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
                                        //dd('listo fiscal');
                                       });

                                        

                                        DB::transaction(function () use($request) {
                                        $selProceso = Session::get('selProceso');
                                        $rfcempleado = EmpleadoAsimi::where('RFC', $request->input('RFC'))->first();
                                        if ($rfcempleado!=null) {
                                            return back()->with('advertencia','Se ha dado de alta correctamente el empleado en la nomina fiscal, pero no se ha dado de alta en la nomina de asimilados ya que el RFC del empleado ya existe.');
                                        }
                                        
                                        
                                        $emps = EmpleadoAsimi::where('TIPONO', $selProceso)->get()->last();
                                                if ($emps==null){
                                                    $ultimo = 1;
                                                    $add = str_pad($selProceso,2, "0", STR_PAD_LEFT);
                                                $ultimo2 = str_pad($ultimo,5, "0", STR_PAD_LEFT);
                                                $ultimo3 =  $add.$ultimo2;
                                                }else{
                                                     $ultimo = $emps->EMP + 1;
                                                     $ultimo3 = str_pad($ultimo,7, "0", STR_PAD_LEFT);
                                                }
                                        $empAsimi = new EmpleadoAsimi();
                                        $empAsimi->TIPONO = $selProceso;
                                        $empAsimi->EMP = $ultimo3;
                                        $empAsimi->NOMBRE = $request->input('NOMBRES') . ' ' . $request->input('PATERNO') . ' ' . $request->input('MATERNO');
                                        $empAsimi->PUESTO = $request->input('PUESTO');
                                        $empAsimi->cuenta = $request->input('cuenta');
                                        $empAsimi->DEPTO = $request->input('DEPTO');
                                        $empAsimi->TIPOTRA = $request->input('TIPOTRA');
                                        $empAsimi->c_Estado = $request->input('c_Estado');
                                        $empAsimi->DIRIND = $request->input('DIRIND');
                                        $empAsimi->TIPOJORNADA = $request->input('TIPOJORNADA');
                                        $empAsimi->TIPOREGIMEN = 9;
                                        $empAsimi->CHECA = $request->input('CHECA');
                                        $empAsimi->SINDIC = $request->input('SINDIC');
                                        $empAsimi->TURNO = $request->input('TURNO');
                                        $empAsimi->ZONAECO = $request->input('ZONAECO') . "";
                                        $empAsimi->ESTATUS = $request->input('ESTATUS');
                                        $empAsimi->CLIMSS = $request->input('CLIMSS') . "";
                                        $empAsimi->TIPOPAGO = $request->input('TIPOPAGO');
                                        $empAsimi->c_TipoContrato = "09 Modalidades de contratación donde no existe relación de trabajo";
                                        $empAsimi->INGRESO = date('d-m-Y', strtotime($request->input('INGRESO')));
                                        $empAsimi->VACACION = date('d-m-Y', strtotime($request->input('VACACION')));
                                        $empAsimi->PLANTA = date('d-m-Y', strtotime($request->input('PLANTA')));
                                        $empAsimi->VENCIM = date('d-m-Y', strtotime($request->input('VENCIM')));
                                        $empAsimi->BAJA = date('d-m-Y', strtotime($request->input('BAJA')));
                                        $empAsimi->REGPAT = $request->input('REGPAT');
                                        $empAsimi->RFC = $request->input('RFC');
                                        $empAsimi->IMSS = '';
                                        $empAsimi->GRUIMS = $request->input('GRUIMS');
                                        $empAsimi->FONACOT = $request->input('FONACOT') . "";
                                        $empAsimi->INFONAVIT = $request->input('INFONAVIT') . "";
                                        $empAsimi->OTRACIA = $request->input('OTRACIA');
                                        $empAsimi->TAXOTRA = $request->input('TAXOTRA');
                                        $empAsimi->CASOTRA = $request->input('CASOTRA');
                                        $empAsimi->SAROTR = $request->input('SAROTR') . "";
                                        $empAsimi->DESINFO = $request->input('DESINFO');
                                        $empAsimi->SUELDO = 0.01;
                                        $empAsimi->NetoMensual = $request->input('NetoMensual');
                                        $empAsimi->VARIMSS = 0.01;
                                        $empAsimi->INTEG = 0.01;
                                        $empAsimi->INTIV = 0.01;
                                        $empAsimi->PRESDEC = $request->input('PRESDEC');
                                        $empAsimi->NOCRED = $request->input('NOCRED'); 
                                        $empAsimi->save();

                                        $dage = new DatosGeAsimi();
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
                                            
                                            $path = public_path(). '/img_emp/';
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

                                        $daafo = new DatosAfoAsimi();
                                        $daafo->EMP = $ultimo3;
                                        $daafo->TIPONO = $selProceso;
                                        $daafo->CURP = $request->input('CURP');
                                        $daafo->IMSS = '';
                                        $daafo->NOMBRES = $request->input('NOMBRES');
                                        $daafo->PATERNO = $request->input('PATERNO') . "";
                                        $daafo->MATERNO = $request->input('MATERNO') . "";
                                        $daafo->save();
                                       
                                        $imss = new ImssAsimi();
                                        $imss->TIPONO = $selProceso;
                                        $imss->EMP = $ultimo3;
                                        $imss->FECHA = date('d-m-Y', strtotime($request->input('INGRESO')));
                                        $imss->CLAVE = 15;
                                        $imss->SUELDO = 0.01;
                                        $imss->INTEG = 0.01;
                                        $imss->INTIV = 0.01;
                                        $imss->SUELDONUE = 0.01;
                                        $imss->INTEGNUE = 0.01;
                                        $imss->INTIVNUE = 0.01;
                                        $imss->save();
            //------------------------------------------------------------------Codigo para gregar los documentos del empleado RFCC 29/11/2018---------------------------------------------------------------------------------------
                                        $emp = $request->input('EMP');
                                        $rfc_emp = $request->input('RFC');
                                        //$rutabase = Empleado::Rutas['Documentos'] .'/';
                                        $cliente = Session::get('selCliente');
                                        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
                                        $rfc_cliente = Ciasno::first()->RFCCIA;
                                        $rfc_empleado0 = Empleado::where('EMP',$emp)->first()->RFC;
                                        $rfc_empleado1=substr ($rfc_empleado0, 0,4);
                                        $rfc_empleado2=substr ($rfc_empleado0, 5,6);
                                        $rfc_empleado3=substr ($rfc_empleado0, 12,3);
                                        $rfc_empleado= $rfc_empleado1.$rfc_empleado2.$rfc_empleado3;
                                        $rutaEmpleados = Client::getRutaEmpleados($cliente->cell_id,  $rfc_cliente);
                                        $file = $rutaEmpleados.'/'.$rfc_empleado.'/documentos/';
                                        try {
                                            mkdir($file,0755,true);
                                           
                                        } catch (\Exception $e) {
                                            \Session::flash('error', "No pude crear los directorios de FISCAL para el nuevo cliente... verifique  -  ".$e->getMessage());
                                        }
                                         //dd($file);

                                        $listdoc = new ListaDoc();
                                        $listdoc->EMP = $request->input('EMP');
                                        $listdoc->TIPONO = $selProceso;
                                        
                                        $acta = $request->file('nacimiento');
                                           if ($acta !== null) {
                                                
                                                $path = $file;
                                                $extension = explode(".",$acta->getClientOriginalName());
                                                $fileName = 'acta.'.$extension[1];
                                                $moved =  $acta->move($path, $fileName);
                                                
                                                if ($moved) {
                                                //     // guarda la liga en la BD
                                                $listdoc->CHECK1 = 1;
                                                $listdoc->NOMBRE1 = $fileName;
                                                $listdoc->FECHAVENCI1 = $request->input('fechanaci');
                                                
                                                    //dd('actualizada imagen');
                                                 }
                                            }
                                            else{
                                                //dd('no actualizada');
                                            }

                                        $rfc = $request->file('rfc');
                                           if ($rfc !== null) {
                                                
                                                $path = $file;
                                                $extension = explode(".",$rfc->getClientOriginalName());
                                                $fileName2 = 'rfc.'.$extension[1];
                                                $moved2 =  $rfc->move($path, $fileName);
                                                
                                                if ($moved2) {
                                                //     // guarda la liga en la BD
                                                $listdoc->CHECK2 = 1;
                                                $listdoc->NOMBRE2 = $fileName2;
                                                $listdoc->FECHAVENCI2 = $request->input('fecharfc');
                                                
                                                    //dd('actualizada imagen');
                                                 }
                                            }
                                            else{
                                                //dd('no actualizada');
                                            }

                                        $curp = $request->file('curp');
                                           if ($curp !== null) {
                                                
                                                $path = $file;
                                                $extension = explode(".",$curp->getClientOriginalName());
                                                $fileName = 'curp.'.$extension[1];
                                                $moved3 =  $curp->move($path, $fileName);
                                                
                                                if ($moved3) {
                                                //     // guarda la liga en la BD
                                                $listdoc->CHECK3 = 1;
                                                $listdoc->NOMBRE3 = $fileName;
                                                $listdoc->FECHAVENCI3 = $request->input('fechacurp');
                                                
                                                    //dd('actualizada imagen');
                                                 }
                                            }
                                            else{
                                                //dd('no actualizada');
                                            }

                                        $comprobante = $request->file('comprobante');
                                           if ($comprobante !== null) {
                                                
                                                $path = $file;
                                                $extension = explode(".",$comprobante->getClientOriginalName());
                                                $fileName = 'comprobante.'.$extension[1];
                                                $moved4 =  $comprobante->move($path, $fileName);
                                                
                                                if ($moved4) {
                                                //     // guarda la liga en la BD
                                                $listdoc->CHECK4 = 1;
                                                $listdoc->NOMBRE4 = $fileName;
                                                $listdoc->FECHAVENCI4 = $request->input('fechacompro');
                                                
                                                    //dd('actualizada imagen');
                                                 }
                                            }
                                            else{
                                                //dd('no actualizada');
                                            }

                                        $empleo = $request->file('empleo');
                                           if ($empleo !== null) {
                                                
                                                $path = $file;
                                                $extension = explode(".",$empleo->getClientOriginalName());
                                                $fileName = 'solicitud.'.$extension[1];
                                                $moved5 =  $empleo->move($path, $fileName);
                                                
                                                if ($moved5) {
                                                //     // guarda la liga en la BD
                                                $listdoc->CHECK5 = 1;
                                                $listdoc->NOMBRE5 = $fileName;
                                                $listdoc->FECHAVENCI5 = $request->input('fechaempleo');
                                                
                                                    //dd('actualizada imagen');
                                                 }
                                            }
                                            else{
                                                //dd('no actualizada');
                                            }

                                        $ine = $request->file('ine');
                                           if ($ine !== null) {
                                                
                                                $path = $file;
                                                $extension = explode(".",$ine->getClientOriginalName());
                                                $fileName = 'ine.'.$extension[1];
                                                $moved6 =  $ine->move($path, $fileName);
                                                
                                                if ($moved6) {
                                                //     // guarda la liga en la BD
                                                $listdoc->CHECK6 = 1;
                                                $listdoc->NOMBRE6 = $fileName;
                                                $listdoc->FECHAVENCI6 = $request->input('fechaine');
                                                
                                                    //dd('actualizada imagen');
                                                 }
                                            }
                                            else{
                                                //dd('no actualizada');
                                            }

                                        $boda = $request->file('boda');
                                           if ($boda !== null) {
                                                
                                                $path = $file;
                                                $extension = explode(".",$boda->getClientOriginalName());
                                                $fileName = 'boda.'.$extension[1];
                                                $moved7 =  $boda->move($path, $fileName);
                                                
                                                if ($moved7) {
                                                //     // guarda la liga en la BD
                                                $listdoc->CHECK7 = 1;
                                                $listdoc->NOMBRE7 = $fileName;
                                                $listdoc->FECHAVENCI7 = $request->input('fechaboda');
                                                
                                                    //dd('actualizada imagen');
                                                 }
                                            }
                                            else{
                                                //dd('no actualizada');
                                            }

                                        $titulo = $request->file('titulo');
                                           if ($titulo !== null) {
                                                
                                                $path = $file;
                                                $extension = explode(".",$titulo->getClientOriginalName());
                                                $fileName = 'titulo.'.$extension[1];
                                                $moved8 =  $titulo->move($path, $fileName);
                                                
                                                if ($moved8) {
                                                //     // guarda la liga en la BD
                                                $listdoc->CHECK8 = 1;
                                                $listdoc->NOMBRE8 = $fileName;
                                                $listdoc->FECHAVENCI8 = $request->input('fechatitulo');
                                                
                                                    //dd('actualizada imagen');
                                                 }
                                            }
                                            else{
                                                //dd('no actualizada');
                                            }

                                        $antecedentes = $request->file('antecedentes');
                                           if ($antecedentes !== null) {
                                                
                                                $path = $file;
                                                $extension = explode(".",$antecedentes->getClientOriginalName());
                                                $fileName = 'antecedentes.'.$extension[1];
                                                $moved9 =  $antecedentes->move($path, $fileName);
                                                
                                                if ($moved9) {
                                                //     // guarda la liga en la BD
                                                $listdoc->CHECK9 = 1;
                                                $listdoc->NOMBRE9 = $fileName;
                                                $listdoc->FECHAVENCI9 = $request->input('fechaante');
                                                
                                                    //dd('actualizada imagen');
                                                 }
                                            }
                                            else{
                                                //dd('no actualizada');
                                            }

                                        $contrato = $request->file('contrato');
                                           if ($contrato !== null) {
                                                
                                                $path = $file;
                                                $extension = explode(".",$contrato->getClientOriginalName());
                                                $fileName = 'contrato.'.$extension[1];
                                                $moved10 =  $contrato->move($path, $fileName);
                                                
                                                if ($moved10) {
                                                //     // guarda la liga en la BD
                                                $listdoc->CHECK10 = 1;
                                                $listdoc->NOMBRE10 = $fileName;
                                                $listdoc->FECHAVENCI10 = $request->input('fechacompro');
                                                
                                                    //dd('actualizada imagen');
                                                 }
                                            }
                                            else{
                                                //dd('no actualizada');
                                            }

                                        $curriculum = $request->file('curriculum');
                                           if ($curriculum !== null) {
                                                
                                                $path = $file;
                                                $extension = explode(".",$curriculum->getClientOriginalName());
                                                $fileName = 'curriculum.'.$extension[1];
                                                $moved11 =  $curriculum->move($path, $fileName);
                                                
                                                if ($moved11) {
                                                //     // guarda la liga en la BD
                                                $listdoc->CHECK11 = 1;
                                                $listdoc->NOMBRE11 = $fileName;
                                                $listdoc->FECHAVENCI11 = $request->input('fechacurri');
                                                
                                                    //dd('actualizada imagen');
                                                 }
                                            }
                                            else{
                                                //dd('no actualizada');
                                            }

                                        $cedula = $request->file('cedula');
                                           if ($cedula !== null) {
                                                
                                                $path = $file;
                                                $extension = explode(".",$cedula->getClientOriginalName());
                                                $fileName = 'cedula.'.$extension[1];
                                                $moved12 =  $cedula->move($path, $fileName);
                                                
                                                if ($moved12) {
                                                //     // guarda la liga en la BD
                                                $listdoc->CHECK12 = 1;
                                                $listdoc->NOMBRE12 = $fileName;
                                                $listdoc->FECHAVENCI12 = $request->input('fechacedula');
                                                
                                                    //dd('actualizada imagen');
                                                 }
                                            }
                                            else{
                                                //dd('no actualizada');
                                            }

                                        $diplomas = $request->file('diplomas');
                                           if ($diplomas !== null) {
                                                
                                                $path = $file;
                                                $extension = explode(".",$diplomas->getClientOriginalName());
                                                $fileName = 'diplomas.'.$extension[1];
                                                $moved13 =  $diplomas->move($path, $fileName);
                                                
                                                if ($moved13) {
                                                //     // guarda la liga en la BD
                                                $listdoc->CHECK13 = 1;
                                                $listdoc->NOMBRE13 = $fileName;
                                                $listdoc->FECHAVENCI13 = $request->input('fechadiplo');
                                                
                                                    //dd('actualizada imagen');
                                                 }
                                            }
                                            else{
                                                //dd('no actualizada');
                                            }

                                        $certificaciones = $request->file('certificaciones');
                                           if ($certificaciones !== null) {
                                                
                                                $path = $file;
                                                $extension = explode(".",$certificaciones->getClientOriginalName());
                                                $fileName = 'certificaciones.'.$extension[1];
                                                $moved14 =  $certificaciones->move($path, $fileName);
                                                
                                                if ($moved14) {
                                                //     // guarda la liga en la BD
                                                $listdoc->CHECK14 = 1;
                                                $listdoc->NOMBRE14 = $fileName;
                                                $listdoc->FECHAVENCI14 = $request->input('fechacerti');
                                                
                                                    //dd('actualizada imagen');
                                                 }
                                            }
                                            else{
                                                //dd('no actualizada');
                                            }

                                        $licencia = $request->file('licencia');
                                           if ($licencia !== null) {
                                                
                                                $path = $file;
                                                $extension = explode(".",$licencia->getClientOriginalName());
                                                $fileName = 'licencia.'.$extension[1];
                                                $moved15 =  $licencia->move($path, $fileName);
                                                
                                                if ($moved15) {
                                                //     // guarda la liga en la BD
                                                $listdoc->CHECK15 = 1;
                                                $listdoc->NOMBRE15 = $fileName;
                                                $listdoc->FECHAVENCI15 = $request->input('fechalicencia');
                                                
                                                    //dd('actualizada imagen');
                                                 }
                                            }
                                            else{
                                                //dd('no actualizada');
                                            }

                                        $listdoc->save();
                                            //dd('listo');

        //----------------------------------Fin de codigo para agregar documentos del empleado-------------------------------------------------------------------------------------------------------------------------------------

                                        //dd('listo fiscal y asimilados');
                                       });
                                        
                                }else{  
                                    // ---------------------inicio de solo fiscal-----------------------------
                    DB::transaction(function () use($request) {
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
                        
                        $path = public_path(). '/img_emp/';
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
        //---------------------------------------------------------------Codigo para gregar los documentos del empleado RFCC 29/11/2018---------------------------------------------------------------------------------------
                    $emp = $request->input('EMP');
                    $rfc_emp = $request->input('RFC');
                    //$rutabase = Empleado::Rutas['Documentos'] .'/';
                    $cliente = Session::get('selCliente');
                    $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
                    $rfc_cliente = Ciasno::first()->RFCCIA;
                    $rfc_empleado0 = Empleado::where('EMP',$emp)->first()->RFC;
                    $rfc_empleado1=substr ($rfc_empleado0, 0,4);
                    $rfc_empleado2=substr ($rfc_empleado0, 5,6);
                    $rfc_empleado3=substr ($rfc_empleado0, 12,3);
                    $rfc_empleado= $rfc_empleado1.$rfc_empleado2.$rfc_empleado3;
                    $rutaEmpleados = Client::getRutaEmpleados($cliente->cell_id,  $rfc_cliente);
                    $file = $rutaEmpleados.'/'.$rfc_empleado.'/documentos/';
                    try {
                        mkdir($file,0755,true);
                       
                    } catch (\Exception $e) {
                        \Session::flash('error', "No pude crear los directorios de FISCAL para el nuevo cliente... verifique  -  ".$e->getMessage());
                    }
                     //dd($file);

                    $listdoc = new ListaDoc();
                    $listdoc->EMP = $request->input('EMP');
                    $listdoc->TIPONO = $selProceso;
                    
                    $acta = $request->file('nacimiento');
                       if ($acta !== null) {
                            
                            $path = $file;
                            $extension = explode(".",$acta->getClientOriginalName());
                            $fileName = 'acta.'.$extension[1];
                            $moved =  $acta->move($path, $fileName);
                            
                            if ($moved) {
                            //     // guarda la liga en la BD
                            $listdoc->CHECK1 = 1;
                            $listdoc->NOMBRE1 = $fileName;
                            $listdoc->FECHAVENCI1 = $request->input('fechanaci');
                            
                                //dd('actualizada imagen');
                             }
                        }
                        else{
                            //dd('no actualizada');
                        }

                    $rfc = $request->file('rfc');
                       if ($rfc !== null) {
                            
                            $path = $file;
                            $extension = explode(".",$rfc->getClientOriginalName());
                            $fileName2 = 'rfc.'.$extension[1];
                            $moved2 =  $rfc->move($path, $fileName);
                            
                            if ($moved2) {
                            //     // guarda la liga en la BD
                            $listdoc->CHECK2 = 1;
                            $listdoc->NOMBRE2 = $fileName2;
                            $listdoc->FECHAVENCI2 = $request->input('fecharfc');
                            
                                //dd('actualizada imagen');
                             }
                        }
                        else{
                            //dd('no actualizada');
                        }

                    $curp = $request->file('curp');
                       if ($curp !== null) {
                            
                            $path = $file;
                            $extension = explode(".",$curp->getClientOriginalName());
                            $fileName = 'curp.'.$extension[1];
                            $moved3 =  $curp->move($path, $fileName);
                            
                            if ($moved3) {
                            //     // guarda la liga en la BD
                            $listdoc->CHECK3 = 1;
                            $listdoc->NOMBRE3 = $fileName;
                            $listdoc->FECHAVENCI3 = $request->input('fechacurp');
                            
                                //dd('actualizada imagen');
                             }
                        }
                        else{
                            //dd('no actualizada');
                        }

                    $comprobante = $request->file('comprobante');
                       if ($comprobante !== null) {
                            
                            $path = $file;
                            $extension = explode(".",$comprobante->getClientOriginalName());
                            $fileName = 'comprobante.'.$extension[1];
                            $moved4 =  $comprobante->move($path, $fileName);
                            
                            if ($moved4) {
                            //     // guarda la liga en la BD
                            $listdoc->CHECK4 = 1;
                            $listdoc->NOMBRE4 = $fileName;
                            $listdoc->FECHAVENCI4 = $request->input('fechacompro');
                            
                                //dd('actualizada imagen');
                             }
                        }
                        else{
                            //dd('no actualizada');
                        }

                    $empleo = $request->file('empleo');
                       if ($empleo !== null) {
                            
                            $path = $file;
                            $extension = explode(".",$empleo->getClientOriginalName());
                            $fileName = 'solicitud.'.$extension[1];
                            $moved5 =  $empleo->move($path, $fileName);
                            
                            if ($moved5) {
                            //     // guarda la liga en la BD
                            $listdoc->CHECK5 = 1;
                            $listdoc->NOMBRE5 = $fileName;
                            $listdoc->FECHAVENCI5 = $request->input('fechaempleo');
                            
                                //dd('actualizada imagen');
                             }
                        }
                        else{
                            //dd('no actualizada');
                        }

                    $ine = $request->file('ine');
                       if ($ine !== null) {
                            
                            $path = $file;
                            $extension = explode(".",$ine->getClientOriginalName());
                            $fileName = 'ine.'.$extension[1];
                            $moved6 =  $ine->move($path, $fileName);
                            
                            if ($moved6) {
                            //     // guarda la liga en la BD
                            $listdoc->CHECK6 = 1;
                            $listdoc->NOMBRE6 = $fileName;
                            $listdoc->FECHAVENCI6 = $request->input('fechaine');
                            
                                //dd('actualizada imagen');
                             }
                        }
                        else{
                            //dd('no actualizada');
                        }

                    $boda = $request->file('boda');
                       if ($boda !== null) {
                            
                            $path = $file;
                            $extension = explode(".",$boda->getClientOriginalName());
                            $fileName = 'boda.'.$extension[1];
                            $moved7 =  $boda->move($path, $fileName);
                            
                            if ($moved7) {
                            //     // guarda la liga en la BD
                            $listdoc->CHECK7 = 1;
                            $listdoc->NOMBRE7 = $fileName;
                            $listdoc->FECHAVENCI7 = $request->input('fechaboda');
                            
                                //dd('actualizada imagen');
                             }
                        }
                        else{
                            //dd('no actualizada');
                        }

                    $titulo = $request->file('titulo');
                       if ($titulo !== null) {
                            
                            $path = $file;
                            $extension = explode(".",$titulo->getClientOriginalName());
                            $fileName = 'titulo.'.$extension[1];
                            $moved8 =  $titulo->move($path, $fileName);
                            
                            if ($moved8) {
                            //     // guarda la liga en la BD
                            $listdoc->CHECK8 = 1;
                            $listdoc->NOMBRE8 = $fileName;
                            $listdoc->FECHAVENCI8 = $request->input('fechatitulo');
                            
                                //dd('actualizada imagen');
                             }
                        }
                        else{
                            //dd('no actualizada');
                        }

                    $antecedentes = $request->file('antecedentes');
                       if ($antecedentes !== null) {
                            
                            $path = $file;
                            $extension = explode(".",$antecedentes->getClientOriginalName());
                            $fileName = 'antecedentes.'.$extension[1];
                            $moved9 =  $antecedentes->move($path, $fileName);
                            
                            if ($moved9) {
                            //     // guarda la liga en la BD
                            $listdoc->CHECK9 = 1;
                            $listdoc->NOMBRE9 = $fileName;
                            $listdoc->FECHAVENCI9 = $request->input('fechaante');
                            
                                //dd('actualizada imagen');
                             }
                        }
                        else{
                            //dd('no actualizada');
                        }

                    $contrato = $request->file('contrato');
                       if ($contrato !== null) {
                            
                            $path = $file;
                            $extension = explode(".",$contrato->getClientOriginalName());
                            $fileName = 'contrato.'.$extension[1];
                            $moved10 =  $contrato->move($path, $fileName);
                            
                            if ($moved10) {
                            //     // guarda la liga en la BD
                            $listdoc->CHECK10 = 1;
                            $listdoc->NOMBRE10 = $fileName;
                            $listdoc->FECHAVENCI10 = $request->input('fechacompro');
                            
                                //dd('actualizada imagen');
                             }
                        }
                        else{
                            //dd('no actualizada');
                        }

                    $curriculum = $request->file('curriculum');
                       if ($curriculum !== null) {
                            
                            $path = $file;
                            $extension = explode(".",$curriculum->getClientOriginalName());
                            $fileName = 'curriculum.'.$extension[1];
                            $moved11 =  $curriculum->move($path, $fileName);
                            
                            if ($moved11) {
                            //     // guarda la liga en la BD
                            $listdoc->CHECK11 = 1;
                            $listdoc->NOMBRE11 = $fileName;
                            $listdoc->FECHAVENCI11 = $request->input('fechacurri');
                            
                                //dd('actualizada imagen');
                             }
                        }
                        else{
                            //dd('no actualizada');
                        }

                    $cedula = $request->file('cedula');
                       if ($cedula !== null) {
                            
                            $path = $file;
                            $extension = explode(".",$cedula->getClientOriginalName());
                            $fileName = 'cedula.'.$extension[1];
                            $moved12 =  $cedula->move($path, $fileName);
                            
                            if ($moved12) {
                            //     // guarda la liga en la BD
                            $listdoc->CHECK12 = 1;
                            $listdoc->NOMBRE12 = $fileName;
                            $listdoc->FECHAVENCI12 = $request->input('fechacedula');
                            
                                //dd('actualizada imagen');
                             }
                        }
                        else{
                            //dd('no actualizada');
                        }

                    $diplomas = $request->file('diplomas');
                       if ($diplomas !== null) {
                            
                            $path = $file;
                            $extension = explode(".",$diplomas->getClientOriginalName());
                            $fileName = 'diplomas.'.$extension[1];
                            $moved13 =  $diplomas->move($path, $fileName);
                            
                            if ($moved13) {
                            //     // guarda la liga en la BD
                            $listdoc->CHECK13 = 1;
                            $listdoc->NOMBRE13 = $fileName;
                            $listdoc->FECHAVENCI13 = $request->input('fechadiplo');
                            
                                //dd('actualizada imagen');
                             }
                        }
                        else{
                            //dd('no actualizada');
                        }

                    $certificaciones = $request->file('certificaciones');
                       if ($certificaciones !== null) {
                            
                            $path = $file;
                            $extension = explode(".",$certificaciones->getClientOriginalName());
                            $fileName = 'certificaciones.'.$extension[1];
                            $moved14 =  $certificaciones->move($path, $fileName);
                            
                            if ($moved14) {
                            //     // guarda la liga en la BD
                            $listdoc->CHECK14 = 1;
                            $listdoc->NOMBRE14 = $fileName;
                            $listdoc->FECHAVENCI14 = $request->input('fechacerti');
                            
                                //dd('actualizada imagen');
                             }
                        }
                        else{
                            //dd('no actualizada');
                        }

                    $licencia = $request->file('licencia');
                       if ($licencia !== null) {
                            
                            $path = $file;
                            $extension = explode(".",$licencia->getClientOriginalName());
                            $fileName = 'licencia.'.$extension[1];
                            $moved15 =  $licencia->move($path, $fileName);
                            
                            if ($moved15) {
                            //     // guarda la liga en la BD
                            $listdoc->CHECK15 = 1;
                            $listdoc->NOMBRE15 = $fileName;
                            $listdoc->FECHAVENCI15 = $request->input('fechalicencia');
                            
                                //dd('actualizada imagen');
                             }
                        }
                        else{
                            //dd('no actualizada');
                        }

                    $listdoc->save();
                        //dd('listo');

        //-----------------------------------Fin de codigo para agregar documentos del empleado-------------------------------------------------------------------------------------------------------------------------------------


                   }); 
                    //dd('solo fiscal');
        }
            //fin fiscal?
        

            //fin de las inserciones de fiscal-----------------------------------------------------------------------------
        }else{
            //inicio de las inserciones de asimilados----------------------------------------------------------------------
            DB::transaction(function () use($request) {
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
            $emp->TIPOREGIMEN = 9;
            $emp->CHECA = $request->input('CHECA');
            $emp->SINDIC = $request->input('SINDIC');
            $emp->TURNO = $request->input('TURNO');
            $emp->ZONAECO = $request->input('ZONAECO') . "";
            $emp->ESTATUS = $request->input('ESTATUS');
            $emp->CLIMSS = $request->input('CLIMSS') . "";
            $emp->TIPOPAGO = $request->input('TIPOPAGO');
            $emp->c_TipoContrato = "09 Modalidades de contratación donde no existe relación de trabajo";
            $emp->INGRESO = date('d-m-Y', strtotime($request->input('INGRESO')));
            $emp->VACACION = date('d-m-Y', strtotime($request->input('VACACION')));
            $emp->PLANTA = date('d-m-Y', strtotime($request->input('PLANTA')));
            $emp->VENCIM = date('d-m-Y', strtotime($request->input('VENCIM')));
            $emp->BAJA = date('d-m-Y', strtotime($request->input('BAJA')));
            $emp->REGPAT = $request->input('REGPAT');
            $emp->RFC = $request->input('RFC');
            $emp->IMSS = '';
            $emp->GRUIMS = $request->input('GRUIMS');
            $emp->FONACOT = $request->input('FONACOT') . "";
            $emp->INFONAVIT = $request->input('INFONAVIT') . "";
            $emp->OTRACIA = $request->input('OTRACIA');
            $emp->TAXOTRA = $request->input('TAXOTRA');
            $emp->CASOTRA = $request->input('CASOTRA');
            $emp->SAROTR = $request->input('SAROTR') . "";
            $emp->DESINFO = $request->input('DESINFO');
            $emp->SUELDO = 0.01;
            $emp->VARIMSS = 0.01;
            $emp->INTEG = 0.01;
            $emp->INTIV = 0.01;
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
                
                $path = public_path(). '/img_emp/';
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
            $daafo->IMSS = '';
            $daafo->NOMBRES = $request->input('NOMBRES');
            $daafo->PATERNO = $request->input('PATERNO') . "";
            $daafo->MATERNO = $request->input('MATERNO') . "";
            $daafo->save();
           
            $imss = new Imss();
            $imss->TIPONO = $selProceso;
            $imss->EMP = $request->input('EMP');
            $imss->FECHA = date('d-m-Y', strtotime($request->input('INGRESO')));
            $imss->CLAVE = 15;
            $imss->SUELDO = 0.01;
            $imss->INTEG = 0.01;
            $imss->INTIV = 0.01;
            $imss->SUELDONUE = 0.01;
            $imss->INTEGNUE = 0.01;
            $imss->INTIVNUE = 0.01;
            $imss->save();
        //---------------------------------------------------------Codigo para gregar los documentos del empleado RFCC 29/11/2018---------------------------------------------------------------------------------------
            $emp = $request->input('EMP');
            $rfc_emp = $request->input('RFC');
            //$rutabase = Empleado::Rutas['Documentos'] .'/';
            $cliente = Session::get('selCliente');
            $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
            $rfc_cliente = Ciasno::first()->RFCCIA;
            $rfc_empleado0 = Empleado::where('EMP',$emp)->first()->RFC;
            $rfc_empleado1=substr ($rfc_empleado0, 0,4);
            $rfc_empleado2=substr ($rfc_empleado0, 5,6);
            $rfc_empleado3=substr ($rfc_empleado0, 12,3);
            $rfc_empleado= $rfc_empleado1.$rfc_empleado2.$rfc_empleado3;
            $rutaEmpleados = Client::getRutaEmpleados($cliente->cell_id,  $rfc_cliente);
            $file = $rutaEmpleados.'/'.$rfc_empleado.'/documentos/';

            try {
                mkdir($file,0755,true);
               
            } catch (\Exception $e) {
                \Session::flash('error', "No pude crear los directorios de FISCAL para el nuevo cliente... verifique  -  ".$e->getMessage());
            }
             //dd($file);

            $listdoc = new ListaDoc();
            $listdoc->EMP = $request->input('EMP');
            $listdoc->TIPONO = $selProceso;
            
            $acta = $request->file('nacimiento');
               if ($acta !== null) {
                    
                    $path = $file;
                    $extension = explode(".",$acta->getClientOriginalName());
                    $fileName = 'acta.'.$extension[1];
                    $moved =  $acta->move($path, $fileName);
                    
                    if ($moved) {
                    //     // guarda la liga en la BD
                    $listdoc->CHECK1 = 1;
                    $listdoc->NOMBRE1 = $fileName;
                    $listdoc->FECHAVENCI1 = $request->input('fechanaci');
                    
                        //dd('actualizada imagen');
                     }
                }
                else{
                    //dd('no actualizada');
                }

            $rfc = $request->file('rfc');
               if ($rfc !== null) {
                    
                    $path = $file;
                    $extension = explode(".",$rfc->getClientOriginalName());
                    $fileName2 = 'rfc.'.$extension[1];
                    $moved2 =  $rfc->move($path, $fileName);
                    
                    if ($moved2) {
                    //     // guarda la liga en la BD
                    $listdoc->CHECK2 = 1;
                    $listdoc->NOMBRE2 = $fileName2;
                    $listdoc->FECHAVENCI2 = $request->input('fecharfc');
                    
                        //dd('actualizada imagen');
                     }
                }
                else{
                    //dd('no actualizada');
                }

            $curp = $request->file('curp');
               if ($curp !== null) {
                    
                    $path = $file;
                    $extension = explode(".",$curp->getClientOriginalName());
                    $fileName = 'curp.'.$extension[1];
                    $moved3 =  $curp->move($path, $fileName);
                    
                    if ($moved3) {
                    //     // guarda la liga en la BD
                    $listdoc->CHECK3 = 1;
                    $listdoc->NOMBRE3 = $fileName;
                    $listdoc->FECHAVENCI3 = $request->input('fechacurp');
                    
                        //dd('actualizada imagen');
                     }
                }
                else{
                    //dd('no actualizada');
                }

            $comprobante = $request->file('comprobante');
               if ($comprobante !== null) {
                    
                    $path = $file;
                    $extension = explode(".",$comprobante->getClientOriginalName());
                    $fileName = 'comprobante.'.$extension[1];
                    $moved4 =  $comprobante->move($path, $fileName);
                    
                    if ($moved4) {
                    //     // guarda la liga en la BD
                    $listdoc->CHECK4 = 1;
                    $listdoc->NOMBRE4 = $fileName;
                    $listdoc->FECHAVENCI4 = $request->input('fechacompro');
                    
                        //dd('actualizada imagen');
                     }
                }
                else{
                    //dd('no actualizada');
                }

            $empleo = $request->file('empleo');
               if ($empleo !== null) {
                    
                    $path = $file;
                    $extension = explode(".",$empleo->getClientOriginalName());
                    $fileName = 'solicitud.'.$extension[1];
                    $moved5 =  $empleo->move($path, $fileName);
                    
                    if ($moved5) {
                    //     // guarda la liga en la BD
                    $listdoc->CHECK5 = 1;
                    $listdoc->NOMBRE5 = $fileName;
                    $listdoc->FECHAVENCI5 = $request->input('fechaempleo');
                    
                        //dd('actualizada imagen');
                     }
                }
                else{
                    //dd('no actualizada');
                }

            $ine = $request->file('ine');
               if ($ine !== null) {
                    
                    $path = $file;
                    $extension = explode(".",$ine->getClientOriginalName());
                    $fileName = 'ine.'.$extension[1];
                    $moved6 =  $ine->move($path, $fileName);
                    
                    if ($moved6) {
                    //     // guarda la liga en la BD
                    $listdoc->CHECK6 = 1;
                    $listdoc->NOMBRE6 = $fileName;
                    $listdoc->FECHAVENCI6 = $request->input('fechaine');
                    
                        //dd('actualizada imagen');
                     }
                }
                else{
                    //dd('no actualizada');
                }

            $boda = $request->file('boda');
               if ($boda !== null) {
                    
                    $path = $file;
                    $extension = explode(".",$boda->getClientOriginalName());
                    $fileName = 'boda.'.$extension[1];
                    $moved7 =  $boda->move($path, $fileName);
                    
                    if ($moved7) {
                    //     // guarda la liga en la BD
                    $listdoc->CHECK7 = 1;
                    $listdoc->NOMBRE7 = $fileName;
                    $listdoc->FECHAVENCI7 = $request->input('fechaboda');
                    
                        //dd('actualizada imagen');
                     }
                }
                else{
                    //dd('no actualizada');
                }

            $titulo = $request->file('titulo');
               if ($titulo !== null) {
                    
                    $path = $file;
                    $extension = explode(".",$titulo->getClientOriginalName());
                    $fileName = 'titulo.'.$extension[1];
                    $moved8 =  $titulo->move($path, $fileName);
                    
                    if ($moved8) {
                    //     // guarda la liga en la BD
                    $listdoc->CHECK8 = 1;
                    $listdoc->NOMBRE8 = $fileName;
                    $listdoc->FECHAVENCI8 = $request->input('fechatitulo');
                    
                        //dd('actualizada imagen');
                     }
                }
                else{
                    //dd('no actualizada');
                }

            $antecedentes = $request->file('antecedentes');
               if ($antecedentes !== null) {
                    
                    $path = $file;
                    $extension = explode(".",$antecedentes->getClientOriginalName());
                    $fileName = 'antecedentes.'.$extension[1];
                    $moved9 =  $antecedentes->move($path, $fileName);
                    
                    if ($moved9) {
                    //     // guarda la liga en la BD
                    $listdoc->CHECK9 = 1;
                    $listdoc->NOMBRE9 = $fileName;
                    $listdoc->FECHAVENCI9 = $request->input('fechaante');
                    
                        //dd('actualizada imagen');
                     }
                }
                else{
                    //dd('no actualizada');
                }

            $contrato = $request->file('contrato');
               if ($contrato !== null) {
                    
                    $path = $file;
                    $extension = explode(".",$contrato->getClientOriginalName());
                    $fileName = 'contrato.'.$extension[1];
                    $moved10 =  $contrato->move($path, $fileName);
                    
                    if ($moved10) {
                    //     // guarda la liga en la BD
                    $listdoc->CHECK10 = 1;
                    $listdoc->NOMBRE10 = $fileName;
                    $listdoc->FECHAVENCI10 = $request->input('fechacompro');
                    
                        //dd('actualizada imagen');
                     }
                }
                else{
                    //dd('no actualizada');
                }

            $curriculum = $request->file('curriculum');
               if ($curriculum !== null) {
                    
                    $path = $file;
                    $extension = explode(".",$curriculum->getClientOriginalName());
                    $fileName = 'curriculum.'.$extension[1];
                    $moved11 =  $curriculum->move($path, $fileName);
                    
                    if ($moved11) {
                    //     // guarda la liga en la BD
                    $listdoc->CHECK11 = 1;
                    $listdoc->NOMBRE11 = $fileName;
                    $listdoc->FECHAVENCI11 = $request->input('fechacurri');
                    
                        //dd('actualizada imagen');
                     }
                }
                else{
                    //dd('no actualizada');
                }

            $cedula = $request->file('cedula');
               if ($cedula !== null) {
                    
                    $path = $file;
                    $extension = explode(".",$cedula->getClientOriginalName());
                    $fileName = 'cedula.'.$extension[1];
                    $moved12 =  $cedula->move($path, $fileName);
                    
                    if ($moved12) {
                    //     // guarda la liga en la BD
                    $listdoc->CHECK12 = 1;
                    $listdoc->NOMBRE12 = $fileName;
                    $listdoc->FECHAVENCI12 = $request->input('fechacedula');
                    
                        //dd('actualizada imagen');
                     }
                }
                else{
                    //dd('no actualizada');
                }

            $diplomas = $request->file('diplomas');
               if ($diplomas !== null) {
                    
                    $path = $file;
                    $extension = explode(".",$diplomas->getClientOriginalName());
                    $fileName = 'diplomas.'.$extension[1];
                    $moved13 =  $diplomas->move($path, $fileName);
                    
                    if ($moved13) {
                    //     // guarda la liga en la BD
                    $listdoc->CHECK13 = 1;
                    $listdoc->NOMBRE13 = $fileName;
                    $listdoc->FECHAVENCI13 = $request->input('fechadiplo');
                    
                        //dd('actualizada imagen');
                     }
                }
                else{
                    //dd('no actualizada');
                }

            $certificaciones = $request->file('certificaciones');
               if ($certificaciones !== null) {
                    
                    $path = $file;
                    $extension = explode(".",$certificaciones->getClientOriginalName());
                    $fileName = 'certificaciones.'.$extension[1];
                    $moved14 =  $certificaciones->move($path, $fileName);
                    
                    if ($moved14) {
                    //     // guarda la liga en la BD
                    $listdoc->CHECK14 = 1;
                    $listdoc->NOMBRE14 = $fileName;
                    $listdoc->FECHAVENCI14 = $request->input('fechacerti');
                    
                        //dd('actualizada imagen');
                     }
                }
                else{
                    //dd('no actualizada');
                }

            $licencia = $request->file('licencia');
               if ($licencia !== null) {
                    
                    $path = $file;
                    $extension = explode(".",$licencia->getClientOriginalName());
                    $fileName = 'licencia.'.$extension[1];
                    $moved15 =  $licencia->move($path, $fileName);
                    
                    if ($moved15) {
                    //     // guarda la liga en la BD
                    $listdoc->CHECK15 = 1;
                    $listdoc->NOMBRE15 = $fileName;
                    $listdoc->FECHAVENCI15 = $request->input('fechalicencia');
                    
                        //dd('actualizada imagen');
                     }
                }
                else{
                    //dd('no actualizada');
                }

            $listdoc->save();
                //dd('listo');

        //--------------------------------Fin de codigo para agregar documentos del empleado-------------------------------------------------------------------------------------------------------------------------------------


            });
                //dd('es asimilado');

                //fin de las inserciones de asimilados-------------------------------------------------------------------------
            }
        
        return redirect('/catalogos/empleados');
    }

    public function edit($emp){
        
        
        $empl = Empleado::where('EMP', $emp)->get()->first(); 
        $empl1 = DatosGe::where('EMP', $emp)->get()->first();
        $empl11 = DatosAfo::where('EMP', $emp)->get()->first();
        $jobs = Job::all();
        $deps = Depto::all();
        $ests = Estados::all();
        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        $cliente = Session::get('selCliente');
        $rfc_cliente = Ciasno::first()->RFCCIA;
        $rfc_empleado0 = $empl->RFC;
        $rfc_empleado1=substr ($rfc_empleado0, 0,4);
        $rfc_empleado2=substr ($rfc_empleado0, 5,6);
        $rfc_empleado3=substr ($rfc_empleado0, 12,3);
        $rfc_empleado= $rfc_empleado1.$rfc_empleado2.$rfc_empleado3;
        $rutaEmpleados = Client::getRutaEmpleados($cliente->cell_id,  $rfc_cliente);
        $path = $rutaEmpleados.'/'.$rfc_empleado.'/documentos/';
    	return view('catalogos.empleados.edit')->with(compact('empl', 'jobs', 'deps', 'ests', 'empl1', 'empl11', 'navbar','path')); 
    }

    public function update(Request $request, $EMP){
            DB::beginTransaction(); //Start transaction!
            try{
                $selProceso = Session::get('selProceso');
                $EMP = $request->input('EMP');
                $BajaImss = $request->input('BajaImss');
                //actualizar estado de empleado en la tabla imss por movimiento de status
                $estatus = $request->input('ESTATUS');
                $emps = Empleado::where('EMP', $EMP)->get()->first();
                if ($emps->ESTATUS==$estatus) {
                     echo "No hubo cambio";
                    } 
                else{   
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
                    if ($file !== null) { 
                        // $cliente = Session::get('selCliente');
                        // $rfc_cliente = Ciasno::first()->RFCCIA;
                        // $rfc_empleado0 = $request->input('RFC');
                        // $rfc_empleado1=substr ($rfc_empleado0, 0,4);
                        // $rfc_empleado2=substr ($rfc_empleado0, 5,6);
                        // $rfc_empleado3=substr ($rfc_empleado0, 12,3);
                        // $rfc_empleado= $rfc_empleado1.$rfc_empleado2.$rfc_empleado3;
                        // $rutaEmpleados = Client::getRutaEmpleados($cliente->cell_id,  $rfc_cliente);
                        $path = public_path(). '/img_emp/';
                        $fileName = uniqid() . $file->getClientOriginalName();
                        $moved =  $file->move($path, $fileName);
                        if ($moved) {
                            $emple1->FOTO = $fileName;
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
            }
            catch(\Exception $e){       
               DB::rollback();
               throw $e;
            }
            DB::commit(); 
            return redirect('/catalogos/empleados');
    }


    public function documentos($emp)
    {  
        session(['emp' => $emp]);

        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        $listdoc = ListaDoc::where('EMP',$emp)->first();
        $cliente = Session::get('selCliente');
        $rfc_cliente = Ciasno::first()->RFCCIA;
        $rfc_empleado0 = Empleado::where('EMP',$emp)->first()->RFC;
        $rfc_empleado1=substr ($rfc_empleado0, 0,4);
        $rfc_empleado2=substr ($rfc_empleado0, 5,6);
        $rfc_empleado3=substr ($rfc_empleado0, 12,3);
        $rfc_empleado= $rfc_empleado1.$rfc_empleado2.$rfc_empleado3;
        session(['rfc_emp' => $rfc_empleado]);
        $docsReque = DocsRequeridos::first();
        //$ruta = '/utilerias/Nominas/'.$celula_empresa.'/'.$rfc_cliente.'/empleados/'.$rfc_empleado.'/documentos/curriculum.pdf';
        //dd($ruta); 

        return view('catalogos.empleados.documentos')->with(compact('navbar','emp','listdoc','docsReque')); 
    }
    
     public function visualizar($documento)
    {  
        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        $emp = Session::get('emp');
        $listdoc = ListaDoc::where('EMP',$emp)->first();
        $cliente = Session::get('selCliente');
        $rfc_cliente = Ciasno::first()->RFCCIA;
        $rfc_empleado0 = Empleado::where('EMP',$emp)->first()->RFC;
        $rfc_empleado1=substr ($rfc_empleado0, 0,4);
        $rfc_empleado2=substr ($rfc_empleado0, 5,6);
        $rfc_empleado3=substr ($rfc_empleado0, 12,3);
        $rfc_empleado= $rfc_empleado1.$rfc_empleado2.$rfc_empleado3;
        $rutaEmpleados = Client::getRutaEmpleados($cliente->cell_id,  $rfc_cliente);
        $file = $rutaEmpleados.'/'.$rfc_empleado.'/documentos/'.$documento;
        //dd($file);

        return Response()->file($file);
    }
    public function UpDocs(Request $request)
    {     
        $emp = Session::get('emp');
        $rfc_emp = Session::get('rfc_emp');
        //$rutabase = Empleado::Rutas['Documentos'] .'/';
        $cliente = Session::get('selCliente');
        $celula_empresa = Cell::where('id', $cliente->cell_id)->first()->nombre;
        $rfc_cliente = Ciasno::first()->RFCCIA;
        $rfc_empleado0 = Empleado::where('EMP',$emp)->first()->RFC;
        $rfc_empleado1=substr ($rfc_empleado0, 0,4);
        $rfc_empleado2=substr ($rfc_empleado0, 5,6);
        $rfc_empleado3=substr ($rfc_empleado0, 12,3);
        $rfc_empleado= $rfc_empleado1.$rfc_empleado2.$rfc_empleado3;
        $rutaEmpleados = Client::getRutaEmpleados($cliente->cell_id,  $rfc_cliente);
        $file = $rutaEmpleados.'/'.$rfc_empleado.'/documentos/';
         //dd($file);

        $listdoc = ListaDoc::where('EMP',$emp)->first();

        $acta = $request->file('nacimiento');
           if ($acta !== null) {
                
                $path = $file;
                $extension = explode(".",$acta->getClientOriginalName());
                $fileName = 'acta.'.$extension[1];
                $moved =  $acta->move($path, $fileName);
                
                if ($moved) {
                //     // guarda la liga en la BD
                $listdoc->CHECK1 = 1;
                $listdoc->NOMBRE1 = $fileName;
                $listdoc->FECHAVENCI1 = $request->input('fechanaci');
                
                    //dd('actualizada imagen');
                 }
            }
            else{
                //dd('no actualizada');
            }

        $rfc = $request->file('rfc');
           if ($rfc !== null) {
                
                $path = $file;
                $extension = explode(".",$rfc->getClientOriginalName());
                $fileName2 = 'rfc.'.$extension[1];
                $moved2 =  $rfc->move($path, $fileName2
                );
                
                if ($moved2) {
                //     // guarda la liga en la BD
                $listdoc->CHECK2 = 1;
                $listdoc->NOMBRE2 = $fileName2;
                $listdoc->FECHAVENCI2 = $request->input('fecharfc');
                
                    //dd('actualizada imagen');
                 }
            }
            else{
                //dd('no actualizada');
            }

        $curp = $request->file('curp');
           if ($curp !== null) {
                
                $path = $file;
                $extension = explode(".",$curp->getClientOriginalName());
                $fileName = 'curp.'.$extension[1];
                $moved3 =  $curp->move($path, $fileName);
                
                if ($moved3) {
                //     // guarda la liga en la BD
                $listdoc->CHECK3 = 1;
                $listdoc->NOMBRE3 = $fileName;
                $listdoc->FECHAVENCI3 = $request->input('fechacurp');
                
                    //dd('actualizada imagen');
                 }
            }
            else{
                //dd('no actualizada');
            }

        $comprobante = $request->file('comprobante');
           if ($comprobante !== null) {
                
                $path = $file;
                $extension = explode(".",$comprobante->getClientOriginalName());
                $fileName = 'comprobante.'.$extension[1];
                $moved4 =  $comprobante->move($path, $fileName);
                
                if ($moved4) {
                //     // guarda la liga en la BD
                $listdoc->CHECK4 = 1;
                $listdoc->NOMBRE4 = $fileName;
                $listdoc->FECHAVENCI4 = $request->input('fechacompro');
                
                    //dd('actualizada imagen');
                 }
            }
            else{
                //dd('no actualizada');
            }

        $empleo = $request->file('empleo');
           if ($empleo !== null) {
                
                $path = $file;
                $extension = explode(".",$empleo->getClientOriginalName());
                $fileName = 'solicitud.'.$extension[1];
                $moved5 =  $empleo->move($path, $fileName);
                
                if ($moved5) {
                //     // guarda la liga en la BD
                $listdoc->CHECK5 = 1;
                $listdoc->NOMBRE5 = $fileName;
                $listdoc->FECHAVENCI5 = $request->input('fechaempleo');
                
                    //dd('actualizada imagen');
                 }
            }
            else{
                //dd('no actualizada');
            }

        $ine = $request->file('ine');
           if ($ine !== null) {
                
                $path = $file;
                $extension = explode(".",$ine->getClientOriginalName());
                $fileName = 'ine.'.$extension[1];
                $moved6 =  $ine->move($path, $fileName);
                
                if ($moved6) {
                //     // guarda la liga en la BD
                $listdoc->CHECK6 = 1;
                $listdoc->NOMBRE6 = $fileName;
                $listdoc->FECHAVENCI6 = $request->input('fechaine');
                
                    //dd('actualizada imagen');
                 }
            }
            else{
                //dd('no actualizada');
            }

        $boda = $request->file('boda');
           if ($boda !== null) {
                
                $path = $file;
                $extension = explode(".",$boda->getClientOriginalName());
                $fileName = 'boda.'.$extension[1];
                $moved7 =  $boda->move($path, $fileName);
                
                if ($moved7) {
                //     // guarda la liga en la BD
                $listdoc->CHECK7 = 1;
                $listdoc->NOMBRE7 = $fileName;
                $listdoc->FECHAVENCI7 = $request->input('fechaboda');
                
                    //dd('actualizada imagen');
                 }
            }
            else{
                //dd('no actualizada');
            }

        $titulo = $request->file('titulo');
           if ($titulo !== null) {
                
                $path = $file;
                $extension = explode(".",$titulo->getClientOriginalName());
                $fileName = 'titulo.'.$extension[1];
                $moved8 =  $titulo->move($path, $fileName);
                
                if ($moved8) {
                //     // guarda la liga en la BD
                $listdoc->CHECK8 = 1;
                $listdoc->NOMBRE8 = $fileName;
                $listdoc->FECHAVENCI8 = $request->input('fechatitulo');
                
                    //dd('actualizada imagen');
                 }
            }
            else{
                //dd('no actualizada');
            }

        $antecedentes = $request->file('antecedentes');
           if ($antecedentes !== null) {
                
                $path = $file;
                $extension = explode(".",$antecedentes->getClientOriginalName());
                $fileName = 'antecedentes.'.$extension[1];
                $moved9 =  $antecedentes->move($path, $fileName);
                
                if ($moved9) {
                //     // guarda la liga en la BD
                $listdoc->CHECK9 = 1;
                $listdoc->NOMBRE9 = $fileName;
                $listdoc->FECHAVENCI9 = $request->input('fechaante');
                
                    //dd('actualizada imagen');
                 }
            }
            else{
                //dd('no actualizada');
            }

        $contrato = $request->file('contrato');
           if ($contrato !== null) {
                
                $path = $file;
                $extension = explode(".",$contrato->getClientOriginalName());
                $fileName = 'contrato.'.$extension[1];
                $moved10 =  $contrato->move($path, $fileName);
                
                if ($moved10) {
                //     // guarda la liga en la BD
                $listdoc->CHECK10 = 1;
                $listdoc->NOMBRE10 = $fileName;
                $listdoc->FECHAVENCI10 = $request->input('fechacompro');
                
                    //dd('actualizada imagen');
                 }
            }
            else{
                //dd('no actualizada');
            }

        $curriculum = $request->file('curriculum');
           if ($curriculum !== null) {
                
                $path = $file;
                $extension = explode(".",$curriculum->getClientOriginalName());
                $fileName = 'curriculum.'.$extension[1];
                $moved11 =  $curriculum->move($path, $fileName);
                
                if ($moved11) {
                //     // guarda la liga en la BD
                $listdoc->CHECK11 = 1;
                $listdoc->NOMBRE11 = $fileName;
                $listdoc->FECHAVENCI11 = $request->input('fechacurri');
                
                    //dd('actualizada imagen');
                 }
            }
            else{
                //dd('no actualizada');
            }

        $cedula = $request->file('cedula');
           if ($cedula !== null) {
                
                $path = $file;
                $extension = explode(".",$cedula->getClientOriginalName());
                $fileName = 'cedula.'.$extension[1];
                $moved12 =  $cedula->move($path, $fileName);
                
                if ($moved12) {
                //     // guarda la liga en la BD
                $listdoc->CHECK12 = 1;
                $listdoc->NOMBRE12 = $fileName;
                $listdoc->FECHAVENCI12 = $request->input('fechacedula');
                
                    //dd('actualizada imagen');
                 }
            }
            else{
                //dd('no actualizada');
            }

        $diplomas = $request->file('diplomas');
           if ($diplomas !== null) {
                
                $path = $file;
                $extension = explode(".",$diplomas->getClientOriginalName());
                $fileName = 'diplomas.'.$extension[1];
                $moved13 =  $diplomas->move($path, $fileName);
                
                if ($moved13) {
                //     // guarda la liga en la BD
                $listdoc->CHECK13 = 1;
                $listdoc->NOMBRE13 = $fileName;
                $listdoc->FECHAVENCI13 = $request->input('fechadiplo');
                
                    //dd('actualizada imagen');
                 }
            }
            else{
                //dd('no actualizada');
            }

        $certificaciones = $request->file('certificaciones');
           if ($certificaciones !== null) {
                
                $path = $file;
                $extension = explode(".",$certificaciones->getClientOriginalName());
                $fileName = 'certificaciones.'.$extension[1];
                $moved14 =  $certificaciones->move($path, $fileName);
                
                if ($moved14) {
                //     // guarda la liga en la BD
                $listdoc->CHECK14 = 1;
                $listdoc->NOMBRE14 = $fileName;
                $listdoc->FECHAVENCI14 = $request->input('fechacerti');
                
                    //dd('actualizada imagen');
                 }
            }
            else{
                //dd('no actualizada');
            }

        $licencia = $request->file('licencia');
           if ($licencia !== null) {
                
                $path = $file;
                $extension = explode(".",$licencia->getClientOriginalName());
                $fileName = 'licencia.'.$extension[1];
                $moved15 =  $licencia->move($path, $fileName);
                
                if ($moved15) {
                //     // guarda la liga en la BD
                $listdoc->CHECK15 = 1;
                $listdoc->NOMBRE15 = $fileName;
                $listdoc->FECHAVENCI15 = $request->input('fechalicencia');
                
                    //dd('actualizada imagen');
                 }
            }
            else{
                //dd('no actualizada');
            }

            $listdoc->save();
            //dd('listo');


        return back()->with('flash','Documentos Actualizados');
    }

    public function configuracion()
    {  
        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        $docsReque = DocsRequeridos::first();
        return view('configuracion.documentosemp.index')->with(compact('navbar','docsReque')); 
    }

    public function DocsUpdate(Request $request)
    {  
        $perfil = auth()->user()->profile_id;        
        $navbar = ProfileController::getNavBar('',0,$perfil);
        $docsReque = DocsRequeridos::first();
        $docsReque->REQUERIDO1 = $request->input('requerido1');//dd($request->input('requerido1'));
        $docsReque->REQUERIDO2 = $request->input('requerido2');
        $docsReque->REQUERIDO3 = $request->input('requerido3');
        $docsReque->REQUERIDO4 = $request->input('requerido4');
        $docsReque->REQUERIDO5 = $request->input('requerido5');
        $docsReque->REQUERIDO6 = $request->input('requerido6');
        $docsReque->REQUERIDO7 = $request->input('requerido7');
        $docsReque->REQUERIDO8 = $request->input('requerido8');
        $docsReque->REQUERIDO9 = $request->input('requerido9');
        $docsReque->REQUERIDO10 = $request->input('requerido10');
        $docsReque->REQUERIDO11 = $request->input('requerido11');
        $docsReque->REQUERIDO12 = $request->input('requerido12');
        $docsReque->REQUERIDO13 = $request->input('requerido13');
        $docsReque->REQUERIDO14 = $request->input('requerido14');
        $docsReque->REQUERIDO15 = $request->input('requerido15');
        $docsReque->FECHAREQUE1 = $request->input('fecha1');
        $docsReque->FECHAREQUE2 = $request->input('fecha2');
        $docsReque->FECHAREQUE3 = $request->input('fecha3');
        $docsReque->FECHAREQUE4 = $request->input('fecha4');
        $docsReque->FECHAREQUE5 = $request->input('fecha5');
        $docsReque->FECHAREQUE6 = $request->input('fecha6');
        $docsReque->FECHAREQUE7 = $request->input('fecha7');
        $docsReque->FECHAREQUE8 = $request->input('fecha8');
        $docsReque->FECHAREQUE9 = $request->input('fecha9');
        $docsReque->FECHAREQUE10 = $request->input('fecha10');
        $docsReque->FECHAREQUE11 = $request->input('fecha11');
        $docsReque->FECHAREQUE12 = $request->input('fecha12');
        $docsReque->FECHAREQUE13 = $request->input('fecha13');
        $docsReque->FECHAREQUE14 = $request->input('fecha14');
        $docsReque->FECHAREQUE15 = $request->input('fecha15');
        $docsReque->save();

        return view('configuracion.documentosemp.index')->with(compact('navbar','docsReque')); 
    }

    
}
//fin del codigo escrito por Ricardo Cordero.