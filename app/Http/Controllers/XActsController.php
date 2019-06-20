<?php

namespace App\Http\Controllers;

use Session;
use App\Imss;
use App\Incapa;
use App\Movesp;
use App\Movtos;
use App\Nomina;
use App\Calculo;
use App\Periodo;
use App\Concepto;
use App\Empleado;
use App\ImssAsimi;
use App\IncapaAsimi;
use App\MovtosAsimi;
use App\EmpleadoAsimi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class XActsController extends Controller
{

    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('database');
        $this->middleware('databaseAsimi');
    }

	const conIncap = ['400','401','402','403','404','405','406','407','408','360','361','100'];
	const HORASEXTRA = '200';
	const CONINFONAVIT0 = "652";

	public function porConcepto()
	{
		$perfil = auth()->user()->profile_id; 
        $navbar = ProfileController::getNavBar('',0,$perfil);
		$selProceso = Session::get('selProceso');
		$periCalc = Nomina::where('TIPONO',$selProceso)->first()->PERICALC;		
		$conceptos = Concepto::where('TIPONO',$selProceso)->where('TIPCAPT','<>','0')->whereNotIn('CONCEPTO',$this::conIncap)->orderBy('NOMBRE')->get();
		$periodos = Periodo::where('TIPONO',$selProceso)->where('SWCIERRE','0')->limit(3)->get();
		$empleados = Empleado::where('TIPONO',$selProceso)->where('ESTATUS','A')->get();
		return view('transacciones.por-concepto')->with(compact('navbar','conceptos','periCalc','periodos','empleados'));
	}


	public function porIncapacidad()
	{
		$perfil = auth()->user()->profile_id; 
        $navbar = ProfileController::getNavBar('',0,$perfil);
		$selProceso = Session::get('selProceso');
		$conceptos = Concepto::where('TIPONO',$selProceso)->where('TIPCAPT','<>','0')->whereIn('CONCEPTO',$this::conIncap)->orderBy('NOMBRE')->get();
		$periCalc = Nomina::where('TIPONO',$selProceso)->first()->PERICALC;
		$periodos = Periodo::where('TIPONO',$selProceso)->where('SWCIERRE','0')->get();
		$empleados = Empleado::Join('EMPGEN', function($q) {
        				$q->on('EMPGEN.EMP', '=', 'EMPLEADO.EMP')
            				->on('EMPGEN.TIPONO', '=', 'EMPLEADO.TIPONO');
    					})
					->where('EMPLEADO.TIPONO',$selProceso)->where('ESTATUS','A')
					->select('EMPGEN.SEXO','EMPLEADO.*')
					->orderBy('EMPLEADO.NOMBRE')->get();
		return view('transacciones.por-incapacidad')->with(compact('navbar','conceptos','periCalc','periodos','empleados'));
	}


	public function horasExtra()
	{
		$perfil = auth()->user()->profile_id; 
        $navbar = ProfileController::getNavBar('',0,$perfil);
		$selProceso = Session::get('selProceso');
		// aqui obtenemos el objeto completo y así se pasa a la vista
		$concepto = Concepto::where('TIPONO',$selProceso)->where('CONCEPTO',$this::HORASEXTRA)->first();
		$periCalc = Nomina::where('TIPONO',$selProceso)->first()->PERICALC;
		$periodos = Periodo::where('TIPONO',$selProceso)->where('SWCIERRE','0')->get();
		$empleados = Empleado::where('TIPONO',$selProceso)->where('ESTATUS','A')->get();
		return view('transacciones.horas-extra')->with(compact('navbar','concepto','periCalc','periodos','empleados'));
	}

	
	public function getConcepto(Request $data)
	{
		$selProceso = Session::get('selProceso');
		$concepto = Concepto::where('TIPONO', $selProceso)
				->where('CONCEPTO', $data->concepto)
				->first();			
        return array($concepto);
	}


	public function getMovtosCapturados(Request $data)
	{
		$selProceso = Session::get('selProceso');
		$periodo = $data->periodo;
		$capturado = Movtos::join('Empleado','MOVTOS.EMP', '=', 'EMPLEADO.EMP')
				->where('MOVTOS.TIPONO', $selProceso)
				->where('MOVTOS.CONCEPTO', $data->concepto)
				->where(function($query) use ($periodo){
            		if ($periodo != '') {
                		$query->where('MOVTOS.PERIODO', '=', $periodo);
            		}
            	})->select('EMPLEADO.EMP','EMPLEADO.NOMBRE','EMPLEADO.SUELDO','EMPLEADO.PROMED','MOVTOS.*')
				->orderBy('EMPLEADO.EMP')
				->get();

        return response($capturado);
        //return response(array(['EMP' => $selProceso, 'NOMBRE' => $data->concepto,'CALCULO' => $data->periodo]));
	}


	public function getMovtosEspeciales(Request $data)
	{
		$selProceso = Session::get('selProceso');
		$periodo = $data->periodo;
		$capturado = Movesp::join('Empleado','MOVESP.EMP', '=', 'EMPLEADO.EMP')
				->where('MOVESP.TIPONO', $selProceso)
				->where('MOVESP.CONCEPTO', $data->concepto)
				->where(function($query) use ($periodo){
            		if ($periodo != '') {
                		$query->where('MOVESP.PERIODO', '=', $periodo);
            		}
            	})->select('EMPLEADO.EMP','EMPLEADO.NOMBRE','EMPLEADO.SUELDO','EMPLEADO.PROMED','MOVESP.*')
				->orderBy('EMPLEADO.EMP')
				->get();

        return response($capturado);
        //return response(array(['EMP' => $selProceso, 'NOMBRE' => $data->concepto,'CALCULO' => $data->periodo]));
	}


	// Obtiene los datos de la tabla IMSS y tabla INCAPA
	// del concepto y período pasados en el REQUEST
	public function getFromImss(Request $data)
	{
		$selProceso = Session::get('selProceso');
		$movtos = Imss::join('EMPLEADO','EMPLEADO.EMP', '=', 'IMSS.EMP')
					->leftJoin('Incapa', function($join) {
         				$join->on('INCAPA.EMP', '=', 'IMSS.EMP');
         				$join->on('INCAPA.REFIMSS', '=', 'IMSS.REFIMSS');
         				$join->on('INCAPA.FECHA', '=', 'IMSS.FECHA');
     				})->where('IMSS.TIPONO',$selProceso)
						->where('IMSS.CONCEPTO',$data->concepto)
						->where('IMSS.PERIODO',$data->periodo)
						->select('EMPLEADO.NOMBRE','EMPLEADO.RFC','INCAPA.TIPO','IMSS.*')
						->orderBy('EMPLEADO.NOMBRE')
						->get();				
        return response($movtos);
	}


	public function storeMovtos(Request $data)
	{
		// INSERT INTO MOVTOS (TIPONO,EMP,CONCEPTO,PERIODO,METODO,UNIDADES,SALDO,SUMRES,
		//                    CALCULO,METODOISP,FLAGCIEN,CUENTA,ACTIVO,OTROS,ESPECIAL,PLAZO,fecvac)
		// Str = "Delete from movtos where tipono='" & tipn & "' and concepto='" & TxtConcepto.Text & "'"
		// dd($data->all());
        $messages = [
            'emp.required' => 'No se ha ingresado ningún empleado'
        ];

        $rules = [
            'emp' => 'required|array|min:1'
        ];
        // validar
        $this->validate($data,$rules,$messages);

		DB::transaction(function () use($data) {
			$selProceso = Session::get('selProceso');
			$sumRes = substr($data->Metodo, 1, 1) == "3"? "2" : "0";

			if ($data->Pdo != '0') {
				$deleted = Movtos::where('TIPONO',$selProceso)->where('CONCEPTO',$data->Concepto)->where('PERIODO',$data->Pdo)->delete();
			} else {
				$deleted = Movtos::where('TIPONO',$selProceso)->where('CONCEPTO',$data->Concepto)->delete();
			}
			
		    foreach ($data->emp as $key => $emp) {
		    	$cuenta = Empleado::where('TIPONO',$selProceso)->where('EMP',$emp)->value('cuenta');
		    	$mov = New Movtos();
		    	$mov->TIPONO = $selProceso;
		    	$mov->EMP = $emp;
		    	$mov->CONCEPTO = $data->Concepto;
		    	$mov->PERIODO = $data->periodo[$key];
		    	$mov->METODO = $data->Metodo;
		    	$mov->UNIDADES = $data->unidades[$key];
		    	$mov->SALDO = 0;
		    	$mov->SUMRES = $sumRes;
		    	$mov->CALCULO = $data->calculo[$key];	// Para que guardar????
		    	$mov->METODOISP = $data->MetodoISP;		// Para que grabar esto en Movtos si está en CONCEPTOS ???????
		    	$mov->FLAGCIEN = $data->FlagCien;		// Investigar para que sirve esto??????
		    	$mov->ACTIVO = 1;
		    	$mov->OTROS = 0;
		    	$mov->ESPECIAL = 1;
		    	$mov->PLAZO = 0;
		    	if ($data->Concepto == $this::CONINFONAVIT0) {
		    		$mov->OTROS = $data->otros[$key];
		    	}
		    	$mov->cuenta = $cuenta;					// para que grabar la cuenta si esta asociada a un solo empleado?????
		    	//dd($mov);
		    	$mov->save();
		    }
		});
  		//session()->flash('message', 'Movimientos guardados exitósamente!');
    	//return redirect()->back();
    	return back()->with('flash','Movimientos guardados exitósamente!');

	}

	public function storeIncapacidad(Request $data)
	{

        $messages = [
            'emp.required' => 'No se ha ingresado ningún empleado'
        ];

        $rules = [
            'emp' => 'required|array|min:1'
        ];
        // validar
        $this->validate($data,$rules,$messages);

        $cliente = auth()->user()->client;
		$tipo = Session::get('tinom');        

		DB::connection('sqlsrv2')->transaction(function () use($data) {
			
			$selProceso = Session::get('selProceso');
			$deleted1 = Movtos::where('TIPONO',$selProceso)->where('CONCEPTO',$data->Concepto)->where('PERIODO',$data->Periodo)->delete();
			$deleted2 = Imss::where('TIPONO',$selProceso)->where('CONCEPTO',$data->Concepto)->where('PERIODO',$data->Periodo)->delete();
		    $concepto = Concepto::where('TIPONO',$selProceso)->where('CONCEPTO',$data->Concepto)
		    				->select('METODO','PARAM1','PARAM2')->get()->first();
		    $empleados = [];
		    foreach ($data->emp as $key => $emp) {
		    	$empleado = Empleado::where('TIPONO',$selProceso)->where('RFC',$emp)
		    					->select('EMP','CUENTA','SUELDO','PROMED','INTEG','INTIV')->get()->first();

		    					
		    	$empleados[$emp] = $empleado;

		    	$imss = New Imss();
		    	$imss->TIPONO = $selProceso;
		    	$imss->EMP = $empleado->EMP;
		    	$imss->SUELDO = $empleado->SUELDO;
		    	$imss->SUELDONUE = $empleado->SUELDO;
		    	$imss->INTEG = $empleado->INTEG;
		    	$imss->INTIV = $empleado->INTIV;
		    	$imss->INTEGNUE = $empleado->INTEG;
		    	$imss->INTIVNUE = $empleado->INTIV;

		    	$imss->REFIMSS = $data->refIMSS[$key] . "";

		    	$imss->FECHA = date('d-m-Y', strtotime($data->fecha[$key]));

		    	$imss->DIAS = $data->dias[$key];

		    	$imss->CONCEPTO = $data->Concepto;
		    	$imss->PERIODO = $data->Periodo;
		    	$imss->CLAVE = $data->Clave;

		    	$imss->save();
		    
            	// If rstgrid!Refimss <> "" Then
	            //    rstincapa.Filter = "emp = '" & rstgrid!Emp & "' and refimss = '" & rstgrid!Refimss & "' and fecha = " &  rstgrid!Fecha
	            //    If rstincapa.RecordCount <= 0 Then
	            //         rstincapa.AddNew
	            //         rstincapa!Emp = rstgrid!Emp
	            //         rstincapa!Refimss = rstgrid!Refimss
	            //         rstincapa!Fecha = rstgrid!Fecha
	            //         rstincapa!dias = rstgrid!dias
	            //         rstincapa!tipo = Mid(rstgrid!tipo, 1, 2)
	            //         rstincapa!RegPat = ""
	            //         rstincapa.Update
	            //     Else
	            //         rstincapa!dias = rstgrid!dias
	            //         rstincapa!tipo = rstgrid!tipo
	            //     End If
	            // End If


		    	// Si es una incapacidad, guarda la informacion del el folio del IMSS

				if ($data->refIMSS[$key] != null) {
					try {
						$incapa = Incapa::where('EMP',$empleado->EMP)
									->where('REFIMSS',$data->refIMSS[$key])
									->where('FECHA',$data->fecha[$key])->firstOrFail();
						$incapa->DIAS = $data->dias[$key];
						$incapa->TIPO = $data->tipo[$key];
						$incapa->save();
					} catch (ModelNotFoundException $ex) {
						// Error handling code
					  	// No se encontró el registro. Crea uno nuevo...
					  	$incapa = New Incapa();
					  	$incapa->EMP = $empleado->EMP;
					  	$incapa->REFIMSS = $data->refIMSS[$key] . '';
					  	$incapa->Fecha = date('d-m-Y', strtotime($data->fecha[$key]));
					  	$incapa->DIAS = $data->dias[$key];
					  	$incapa->TIPO = $data->tipo[$key];
					  	$incapa->REGPAT = "";
					  	$incapa->save();
					}
				}

		    }

		    // El codigo siguiente es un relajo... 
		    // Acumula los dias de incapacidad del período POR EMPLEADO.
		    // Como el arreglo no esta ordenado, tiene que hacer un doble ciclo
		    // Pero funciona...
		    $totalizados = [];					// arreglo de los empleados que YA FUERON totalizados
		    $totIndex = 0;						// Indice actual de el arreglo anterior
		    $empIndex = 0;						// Indice de la tabla recibida enn el Request
		    $currEmp = $empleado->EMP;	// Empleado actual que será totalizado
		    $terminado = 0;						// Flag de proceso termiinado
		    while ($terminado !== 1 && $empIndex < count($data->emp)) {
			    $totalizados[$totIndex] = $currEmp;	// Agrega a la tabla el empleado a ser totalizado
			    $totDias = 0;
			    // Acumula dias del mismo empleado
			    foreach ($data->emp as $key => $emp) {
			    	if ($emp == $currEmp) {
			    		$totDias += $data->dias[$key];
			    	}
			    }
			    // Al terminar de 'barrer' el arreglo de empleados,
			    // Si acumuló algo, lo graba...
			    if ($totDias > 0) {
			    	$mov = New Movtos();
			    	$mov->TIPONO = $selProceso;
			    	$mov->EMP = $empleados[$currEmp]->EMP;
			    	$mov->CONCEPTO = $data->Concepto;
			    	$mov->PERIODO = $data->Periodo;
			    	$mov->METODO = $data->Metodo;
			    	$mov->UNIDADES = $totDias;
			    	$mov->SALDO = 0;
			    	$mov->SUMRES = 0;
			    	$mov->CALCULO = Calculo::perPrim($empleados[$currEmp], $mov, $concepto);
			    	$mov->METODOISP = $data->MetodoISP;			// Para que grabar esto en Movtos si está en CONCEPTOS ???????
			    	$mov->FLAGCIEN = '';						// Investigar para que sirve esto??????
			    	$mov->ACTIVO = 1;
			    	$mov->OTROS = 0;
			    	$mov->ESPECIAL = 1;
			    	$mov->PLAZO = 0;
			    	//$mov->cuenta = $emp->cuenta[$key];		// para que grabar la cuenta si esta asociada a un solo empleado?????
			    	$mov->cuenta = '';
			    	//dd($mov);
			    	$mov->save();
			    	
			    	// Aqui viene el doble ciclo...
			    	$empIndex++; 							// Incrementa el indice del arreglo de empleados
			    	$continuar = 1;
			    	// Aqui se verifica si el empleado que sigue, NO ha sido acumulado
			    	while ($continuar == 1 && $empIndex < count($data->emp)) {
			    		$currEmp = $data->emp[$empIndex];		// Toma el empleado que sigue de la tabla recibida en el Request
						$idx = 0;			    		
						$yaAcumulado = 0;
			    		while ($yaAcumulado == 0 && $idx < count($totalizados)) {
			    			if ($currEmp == $totalizados[$idx]) {
			    				$yaAcumulado = 1;
			    			}
			    			$idx++;
			    		}
			    		if ($yaAcumulado == 1) {
			    			$empIndex++;						// Incrementa el indice del arreglo de empleados
			    			//$currEmp = $data->emp[$empIndex];	// Toma el empleado que sigue de la tabla recibida en el Request 
			    		} else {
			    			$totIndex++;
			    			$continuar = 0;
			    		}
			    	}
			    } else {
			    	$terminado = 1;	// esto creo que esta mal. Debe ser solo al final del ciclo
			    }

		    }
		});

		if ($tipo == 'fiscal' && $cliente->asimilado==1) {
        	$this->storeAsimiladosIncapacidad($data);
        }
  		//session()->flash('message', 'Movimientos guardados exitósamente!');
    	//return redirect()->back();
		return back()->with('flash','Movimientos guardados exitósamente!');
	}

	private function storeAsimiladosIncapacidad($data)
	{
		DB::connection('sqlsrv3')->transaction(function () use($data) {
		
			$selProceso = Session::get('selProceso');
			$deleted1 = MovtosAsimi::where('TIPONO',$selProceso)->where('CONCEPTO',$data->Concepto)->where('PERIODO',$data->Periodo)->delete();
			$deleted2 = ImssAsimi::where('TIPONO',$selProceso)->where('CONCEPTO',$data->Concepto)->where('PERIODO',$data->Periodo)->delete();
		    $concepto = DB::connection('sqlsrv3')
		    					->select(' select METODO,PARAM1,PARAM2 FROM CONCEPTOS WHERE TIPONO = :tipo AND CONCEPTO = :cpto',
		    						['tipo' => $selProceso, 'cpto' => $data->Concepto]);
		    $empleados = [];

		    foreach ($data->emp as $key => $emp) {
		    	$empleado = EmpleadoAsimi::where('TIPONO',$selProceso)->where('RFC',$emp)
		    					->select('EMP','CUENTA','SUELDO','PROMED','INTEG','INTIV')->get()->first();
		    	if ($empleado != null) {
			    	$empleados[$emp] = $empleado;		    					
			    	$imss = New ImssAsimi();
			    	$imss->TIPONO = $selProceso;
			    	$imss->EMP = $empleado->EMP;
			    	$imss->SUELDO = $empleado->SUELDO;
			    	$imss->SUELDONUE = $empleado->SUELDO;
			    	$imss->INTEG = $empleado->INTEG;
			    	$imss->INTIV = $empleado->INTIV;
			    	$imss->INTEGNUE = $empleado->INTEG;
			    	$imss->INTIVNUE = $empleado->INTIV;
			    	$imss->REFIMSS = $data->refIMSS[$key] . "";
			    	$imss->FECHA = date('d-m-Y', strtotime($data->fecha[$key]));
			    	$imss->DIAS = $data->dias[$key];
			    	$imss->CONCEPTO = $data->Concepto;
			    	$imss->PERIODO = $data->Periodo;
			    	$imss->CLAVE = $data->Clave;
			    	$imss->save();

	            	// If rstgrid!Refimss <> "" Then
		            //    rstincapa.Filter = "emp = '" & rstgrid!Emp & "' and refimss = '" & rstgrid!Refimss & "' and fecha = " &  rstgrid!Fecha
		            //    If rstincapa.RecordCount <= 0 Then
		            //         rstincapa.AddNew
		            //         rstincapa!Emp = rstgrid!Emp
		            //         rstincapa!Refimss = rstgrid!Refimss
		            //         rstincapa!Fecha = rstgrid!Fecha
		            //         rstincapa!dias = rstgrid!dias
		            //         rstincapa!tipo = Mid(rstgrid!tipo, 1, 2)
		            //         rstincapa!RegPat = ""
		            //         rstincapa.Update
		            //     Else
		            //         rstincapa!dias = rstgrid!dias
		            //         rstincapa!tipo = rstgrid!tipo
		            //     End If
		            // End If

					if ($data->refIMSS[$key] != null) {
						try {
							$incapa = IncapaAsimi::where('EMP',$empleado->EMP)
										->where('REFIMSS',$data->refIMSS[$key])
										->where('FECHA',$data->fecha[$key])->firstOrFail();
							$incapa->DIAS = $data->dias[$key];
							$incapa->TIPO = $data->tipo[$key];
							$incapa->save();
						} catch (ModelNotFoundException $ex) {
							// Error handling code
						  	// No se encontró el registro. Crea uno nuevo...
						  	$incapa = New IncapaAsimi();
						  	$incapa->EMP = $empleado->EMP;
						  	$incapa->REFIMSS = $data->refIMSS[$key] . '';
						  	$incapa->Fecha = date('d-m-Y', strtotime($data->fecha[$key]));
						  	$incapa->DIAS = $data->dias[$key];
						  	$incapa->TIPO = $data->tipo[$key];
						  	$incapa->REGPAT = "";
						  	$incapa->save();
						}
					}
		    	}

		    }

		    // El codigo siguiente es un relajo... 
		    // Acumula los dias de incapacidad del período POR EMPLEADO.
		    // Como el arreglo no esta ordenado, tiene que hacer un doble ciclo
		    // Pero funciona...
		    $totalizados = [];					// arreglo de los empleados que YA FUERON totalizados
		    $totIndex = 0;						// Indice actual de el arreglo anterior
		    $empIndex = 0;						// Indice de la tabla recibida enn el Request
		    $currEmp = $data->emp[$empIndex];	// Empleado actual que será totalizado
		    $terminado = 0;						// Flag de proceso termiinado
		    while ($terminado !== 1 && $empIndex < count($data->emp)) {
			    $totalizados[$totIndex] = $currEmp;	// Agrega a la tabla el empleado a ser totalizado
			    $totDias = 0;
			    // Acumula dias del mismo empleado
			    foreach ($data->emp as $key => $emp) {
			    	if ($emp == $currEmp) {
			    		$totDias += $data->dias[$key];
			    	}
			    }
			    // Al terminar de 'barrer' el arreglo de empleados,
			    // Si acumuló algo, lo graba...
			    if ($totDias > 0) {
			    	$mov = New MovtosAsimi();
			    	$mov->TIPONO = $selProceso;
			    	$mov->EMP = $empleados[$currEmp]->EMP;
			    	$mov->CONCEPTO = $data->Concepto;
			    	$mov->PERIODO = $data->Periodo;
			    	$mov->METODO = $data->Metodo;
			    	$mov->UNIDADES = $totDias;
			    	$mov->SALDO = 0;
			    	$mov->SUMRES = 0;
			    	$mov->CALCULO = Calculo::perPrimAsimi($empleados[$currEmp], $mov, $concepto[0]);
			    	$mov->METODOISP = $data->MetodoISP;			// Para que grabar esto en Movtos si está en CONCEPTOS ???????
			    	$mov->FLAGCIEN = '';						// Investigar para que sirve esto??????
			    	$mov->ACTIVO = 1;
			    	$mov->OTROS = 0;
			    	$mov->ESPECIAL = 1;
			    	$mov->PLAZO = 0;
			    	//$mov->cuenta = $emp->cuenta[$key];		// para que grabar la cuenta si esta asociada a un solo empleado?????
			    	$mov->cuenta = '';
			    	//dd($mov);
			    	$mov->save();

			    	// Aqui viene el doble ciclo...
			    	$empIndex++; 							// Incrementa el indice del arreglo de empleados
			    	$continuar = 1;
			    	// Aqui se verifica si el empleado que sigue, NO ha sido acumulado
			    	while ($continuar == 1 && $empIndex < count($data->emp)) {
			    		$currEmp = $data->emp[$empIndex];		// Toma el empleado que sigue de la tabla recibida en el Request
						$idx = 0;			    		
						$yaAcumulado = 0;
			    		while ($yaAcumulado == 0 && $idx < count($totalizados)) {
			    			if ($currEmp == $totalizados[$idx]) {
			    				$yaAcumulado = 1;
			    			}
			    			$idx++;
			    		}
			    		if ($yaAcumulado == 1) {
			    			$empIndex++;						// Incrementa el indice del arreglo de empleados
			    			//$currEmp = $data->emp[$empIndex];	// Toma el empleado que sigue de la tabla recibida en el Request 
			    		} else {
			    			$totIndex++;
			    			$continuar = 0;
			    		}
			    	}
			    } else {
			    	$terminado = 1;	// esto creo que esta mal.
			    }

		    }
		});
		
	}


	public function storeHorasExtra(Request $data)
	{

        $messages = [
            'emp.required' => 'No se ha ingresado ningún empleado'
        ];

        $rules = [
            'emp' => 'required|array|min:1'
        ];
        // validar
        $this->validate($data,$rules,$messages);

		DB::transaction(function () use($data) {

			$selProceso = Session::get('selProceso');
		    $concepto = Concepto::where('TIPONO',$selProceso)->where('CONCEPTO',$this::HORASEXTRA)->first();			
			$deleted1 = Movesp::where('TIPONO',$selProceso)
							->where('CONCEPTO',$concepto->CONCEPTO)
							->where('PERIODO',$data->Periodo)->delete();
			//$deleted2 = Imss::where('TIPONO',$selProceso)
			//				->where('CONCEPTO',$concepto->CONCEPTO)
			//				->where('PERIODO',$data->Periodo)->delete();


		    foreach ($data->emp as $key => $emp) {
		    	$empleado = Empleado::where('TIPONO',$selProceso)->where('EMP',$emp)
		    					->select('CUENTA','SUELDO','PROMED','INTEG','INTIV')->get()->first();

		    	$mov = New Movesp();
		    	$mov->TIPONO = $selProceso;
		    	$mov->EMP = $emp;
		    	$mov->CONCEPTO = $concepto->CONCEPTO;
		    	$mov->FECHA = date('d-m-Y', strtotime($data->fecha[$key]));
		    	$mov->PERIODO = $data->Periodo;
		    	$mov->METODO = $concepto->TIPCONCEP . $concepto->TIPCALCUL . $concepto->METODO;
		    	$mov->METODOISP = $concepto->METODOISP;		// Para que grabar esto en Movtos si está en CONCEPTOS ???????
		    	$mov->UNIDADES = $data->unidades[$key];
		    	$mov->CATEG = $emp;
		    	if ($data->cuenta[$key]=='undefined') {
		    		$mov->CUENTA =null;
		    	}else{
		    		$mov->CUENTA = $data->cuenta[$key];
		    	}		// para que grabar la cuenta si esta asociada a un solo empleado?????
		    	$mov->save();
		    }
		});
		return back()->with('flash','Movimientos guardados exitósamente!');
	}

}
