<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Calculo;
use App\Concepto;
use App\Empleado;
use App\Periodo;
use App\Movtos;
use App\Nomina;
use App\Imss;
use App\Incapa;
use Session;

class XActsController extends Controller
{

    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('database');
    }

	const conIncap = ['400','401','402','403','404','405','406','407','408','360','361','100'];
	const horasExtra = '200';

	public function porConcepto()
	{
		$perfil = auth()->user()->profile_id; 
        $navbar = ProfileController::getNavBar('',0,$perfil);
		$selProceso = Session::get('selProceso');
		$conceptos = Concepto::where('TIPONO',$selProceso)->where('TIPCAPT','<>','0')->orderBy('NOMBRE')->get();
		$periodos = Periodo::where('TIPONO',$selProceso)->where('SWCIERRE','0')->get();
		$empleados = Empleado::where('TIPONO',$selProceso)->where('ESTATUS','A')->get();
		return view('transacciones.por-concepto')->with(compact('navbar','conceptos','periodos','empleados'));
	}


	public function porIncapacidad()
	{
		$perfil = auth()->user()->profile_id; 
        $navbar = ProfileController::getNavBar('',0,$perfil);
		$selProceso = Session::get('selProceso');
		$conceptos = Concepto::where('TIPONO',$selProceso)->where('TIPCAPT','<>','0')->whereIn('CONCEPTO',$this::conIncap)->orderBy('NOMBRE')->get();
		$periCalc = Nomina::where('TIPONO',$selProceso)->first()->PERICALC;
		$periodos = Periodo::where('TIPONO',$selProceso)->where('SWCIERRE','0')->get();
		$empleados = Empleado::where('TIPONO',$selProceso)->where('ESTATUS','A')->get();
		return view('transacciones.por-incapacidad')->with(compact('navbar','conceptos','periCalc','periodos','empleados'));
	}


	public function horasExtra()
	{
		$perfil = auth()->user()->profile_id; 
        $navbar = ProfileController::getNavBar('',0,$perfil);
		$selProceso = Session::get('selProceso');
		$concepto = Concepto::where('TIPONO',$selProceso)->where('CONCEPTO',$this::horasExtra)->get();
		$periCalc = Nomina::where('TIPONO',$selProceso)->first()->PERICALC;
		$periodos = Periodo::where('TIPONO',$selProceso)->where('SWCIERRE','0')->get();
		$empleados = Empleado::where('TIPONO',$selProceso)->where('ESTATUS','A')->get();
		return view('transacciones.horas-extra')->with(compact('navbar','concepto','periCalc','periodos','empleados'));
	}

	public function getMovtosCapturados(Request $data)
	{
		$selProceso = Session::get('selProceso');
		$capturado = DB::connection('sqlsrv2')->table('Movtos')->join('Empleado','MOVTOS.EMP', '=', 'EMPLEADO.EMP')
				->where('MOVTOS.TIPONO', $selProceso)
				->where('MOVTOS.CONCEPTO', $data->concepto)
				->where('MOVTOS.PERIODO', $data->periodo)
				->select('EMPLEADO.EMP','EMPLEADO.NOMBRE','MOVTOS.*')
				->orderBy('EMPLEADO.EMP')
				->get();
        return response($capturado);
        //return response(array(['EMP' => $selProceso, 'NOMBRE' => $data->concepto,'CALCULO' => $data->periodo]));
	}

	public function getConcepto(Request $data)
	{
		$selProceso = Session::get('selProceso');
		$concepto = Concepto::where('TIPONO', $selProceso)
				->where('CONCEPTO', $data->concepto)
				->first();
        return array($concepto);
	}

	public function storeMovtos(Request $data)
	{
		// INSERT INTO MOVTOS (TIPONO,EMP,CONCEPTO,PERIODO,METODO,UNIDADES,SALDO,SUMRES,
		//                    CALCULO,METODOISP,FLAGCIEN,CUENTA,ACTIVO,OTROS,ESPECIAL,PLAZO,fecvac)
		// Str = "Delete from movtos where tipono='" & tipn & "' and concepto='" & TxtConcepto.Text & "'"

        $messages = [
            'emp.required' => 'No se ha ingresado ningún empleado'
        ];

        $rules = [
            'emp' => 'required|array|min:1'
        ];
        // validar
        $this->validate($data,$rules,$messages);

		DB::transaction(function () use($data) {
			//$selProceso = \Cache::get('selProceso');
			$selProceso = Session::get('selProceso');
			$sumRes = substr($data->Metodo, 1, 1) == "3"? "2" : "0";
			$deleted = Movtos::where('TIPONO',$selProceso)->where('CONCEPTO',$data->Concepto)->where('PERIODO',$data->Periodo)->delete();
		    foreach ($data->emp as $key => $emp) {
		    	$cuenta = Empleado::where('TIPONO',$selProceso)->where('EMP',$emp)->select('cuenta')->get()->first();
		    	$mov = New Movtos();
		    	$mov->TIPONO = $selProceso;
		    	$mov->EMP = $emp;
		    	$mov->CONCEPTO = $data->Concepto;
		    	$mov->PERIODO = $data->Periodo;
		    	$mov->METODO = $data->Metodo;
		    	$mov->UNIDADES = $data->unidades[$key];
		    	$mov->SALDO = 0;
		    	$mov->SUMRES = $sumRes;
		    	$mov->CALCULO = $data->calculo[$key];		// Para que guardar????
		    	$mov->METODOISP = $data->MetodoISP;			// Para que grabar esto en Movtos si está en CONCEPTOS ???????
		    	$mov->FLAGCIEN = '';						// Investigar para que sirve esto??????
		    	$mov->ACTIVO = 1;
		    	$mov->OTROS = 0;
		    	$mov->ESPECIAL = 1;
		    	$mov->PLAZO = 0;
		    	$mov->cuenta = $cuenta;						// para que grabar la cuenta si esta asociada a un solo empleado?????
		    	//dd($mov);
		    	$mov->save();
		    }
		});
  		session()->flash('message', 'Movimientos guardados exitósamente!');
    	return redirect()->back();
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

		DB::transaction(function () use($data) {
		    // Sql = "DELETE FROM MOVTOS WHERE TIPONO='" & TipNom & "' AND  CONCEPTO='" & CveCon & "'"
		    // Sql = Sql & " " & IIf(Numper > 0, " AND PERIODO=" & Numper, "")
		    // Set cn = New ADODB.Connection
		    // cn.Open Cnstr
		    // Afectados = 0
		    // cn.Execute Sql, Afectados
		    // cn.Close
		    // DelByClave = Afectados			
			$selProceso = Session::get('selProceso');
			$deleted1 = Movtos::where('TIPONO',$selProceso)->where('CONCEPTO',$data->Concepto)->where('PERIODO',$data->Periodo)->delete();
			$deleted2 = Imss::where('TIPONO',$selProceso)->where('CONCEPTO',$data->Concepto)->where('PERIODO',$data->Periodo)->delete();
		    $concepto = Concepto::where('TIPONO',$selProceso)->where('CONCEPTO',$data->Concepto)
		    				->select('METODO','PARAM1','PARAM2')->get()->first();

		    foreach ($data->emp as $key => $emp) {
		    	$empleado = Empleado::where('TIPONO',$selProceso)->where('EMP',$emp)
		    					->select('CUENTA','SUELDO','PROMED','INTEG','INTIV')->get()->first();
		    	$imss = New Imss();
		    	$imss->TIPONO = $selProceso;
		    	$imss->EMP = $emp;
		    	$imss->SUELDO = $empleado->SUELDO;
		    	$imss->SUELDONUE = $empleado->SUELDO;
		    	$imss->INTEG = $empleado->INTEG;
		    	$imss->INTIV = $empleado->INTIV;
		    	$imss->INTEGNUE = $empleado->INTEG;
		    	$imss->INTIVNUE = $empleado->INTIV;
		    	$imss->REFIMSS = $data->refIMSS[$key] . "";
		    	$imss->FECHA = date('Y-m-d', strtotime($data->fecha[$key]));
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

				if ($data->RefIMSS != null) {
					try {
						$incapa = Incapa::where('EMP',$emp)
									->where('REFIMSS',$data->refIMSS[$key])
									->where('FECHA',$data->fecha[$key])->firstOrFail();
						$incapa->DIAS = $data->dias[$key];
						$incapa->TIPO = $data->tipo[$key];
						$incapa->save();
					} catch (ModelNotFoundException $ex) {
						// Error handling code
					  	// No se encontró el registro. Crea uno nuevo...
					  	$incapa = New Incapa();
					  	$incapa->EMP = $emp;
					  	$incapa->REFIMSS = $data->refIMSS[$key] . '';
					  	$incapa->Fecha = $data->fecha[$key];
					  	$incapa->DIAS = $data->dias[$key];
					  	$incapa->TIPO = $data->tipo[$key];
					  	$incapa->REGPAT = "";
					  	$incapa->save();
					}
				}

		    	$mov = New Movtos();
		    	$mov->TIPONO = $selProceso;
		    	$mov->EMP = $emp;
		    	$mov->CONCEPTO = $data->Concepto;
		    	$mov->PERIODO = $data->Periodo;
		    	$mov->METODO = $data->Metodo;
		    	$mov->UNIDADES = $data->dias[$key];
		    	$mov->SALDO = 0;
		    	$mov->SUMRES = 0;
		    	$mov->CALCULO = Calculo::perPrim($empleado, $mov, $concepto);
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
		    }
		});
  		session()->flash('message', 'Movimientos guardados exitósamente!');
    	return redirect()->back();
		// redirect('/transacciones/porConcepto');
	}

}
