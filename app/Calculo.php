<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Empleado;
use App\Movtos;
use App\Concepto;

class Calculo extends Model
{
    //
	// Public Sub PerPrim(rsEmp As ADODB.Recordset, rsmov As ADODB.Recordset, _
	//  	Rstteg As ADODB.Recordset, rscon As ADODB.Recordset, _
	//  	afe100 As Single, Result As Double, tipo As String)

	//  	Dim VAR1 As Single, VAR2 As Single
	// 	On Error GoTo ErrHan

	//     Select Case rscon!Metodo
	//         Case "01"
	//            Result = (rsEmp!Sueldo + rsEmp!Promed) * rsmov!Unidades
	//         Case "02"
	//            Result = (rsEmp!Sueldo / rscon!Param2) * rscon!Param1 * rsmov!Unidades
	            
	//         Case "03"
	//             ' Horas adicionales. Especial Burger king
	            
	//         Case "04"
	//              Result = (rscon!Param1) * rsmov!Unidades
	             
	//         Case "05"
	//              Result = rsmov!Unidades
	                 
	//         Case "06"
	//              Result = (rsEmp!Sueldo + rsEmp!Promed) * rscon!Param1 / 100 * rsmov!Unidades
	                 
	//         Case "08"
	//              Result = rsEmp!Integ * rsmov!Unidades * rscon!Param1 / 100
	//              afe100 = "1"
	                 
	//         Case "09"
	//              Result = rsEmp!Integ * rsmov!Unidades * rscon!Param1 / 100
	//              afe100 = "3"
	                            
	//         Case "10"
	//              If tipo = 4 Or tipo = 5 Then
	//                If rsEmp!Integ >= rscon!Param2 Then
	//                  VAR1 = rsEmp!Integ
	//                Else
	//                  VAR1 = rscon!Param2
	//                End If
	//                afe100 = "1"
	//              Else
	//                 VAR1 = rsEmp!Sueldo
	//                 afe100 = "3"
	//              End If
	//              VAR1 = VAR1 * rscon!Param1 / 100
	//              VAR2 = 0.6 * rsEmp!Integ
	//              Result = (VAR1 - VAR2) * rsmov!Unidades
	//              If Result < 0 Then
	//                 Result = 0
	//              End If
	               
	//         Case "11"
	//              VAR1 = -1 * Abs(rsmov!Unidades)
	//              VAR2 = rsEmp!Sueldo * rscon!Param1 / 100
	//              Result = VAR1 * VAR2
	//              rsmov!Unidades = VAR1
	             
	//         Case "12"
	//              ' Es calculado  en modulo de anexa movimientos especiales, suplencias
	           
	//         Case "13"
	//              Result = (rsEmp!Sueldo + rsEmp!Promed) * rscon!Param1 / 100 * rsmov!Unidades
	//              afe100 = "3"
	             
	//         Case "14"
	//              Result = rsmov!Unidades
	             
	//         Case "15"
	//              Result = rsEmp!Integ * rsmov!Unidades * 0.6
	             
	//         Case "16"  ' ident al 13 pero para retardos Vogue
	//             ' Boni lo va a utilizar AL 06/06/03
	//             Result = rsEmp!Sueldo * rsmov!Unidades
	//             If rscon!Concepto = "405" Then
	//                 Result = ((rsEmp!Sueldo * 7) / 48) * rsmov!Unidades
	//                 Result = (Result * (-1))
	//             Else
	//                 Result = 0
	//                 afe100 = "3"
	//             End If
	//         Case "17"
	//              Result = rscon!Param1 * rsmov!Unidades * -1
	//              rsmov!Unidades = rsmov!Unidades * -1
	             
	//         Case "18"
	//            ' es calculado en anexa mov. especiales destajos
	           
	//         Case "19"
	//              Result = rsEmp!Sueldo * rsmov!Unidades
	//              afe100 = "1"
	             
	//         Case "20"
	//             If tipo = 4 Or tipo = 5 Then
	//                If rsEmp!Integ >= rscon!Param2 Then
	//                  VAR1 = rsEmp!Integ
	//                Else
	//                  VAR1 = rscon!Param2
	//                End If
	//             Else
	//                 VAR1 = rsEmp!Sueldo
	//             End If
	//              Result = VAR1 * rscon!Param1 / 100 * rsmov!Unidades
	//              afe100 = "1"
	           
	//         Case "21"
	//              ' es calculado en anexa mov esp H E
	             
	//         Case "22"
	//              ' es igual al 13 y 16 para meridana
	             
	//         Case "23"
	//             Result = rsEmp!Sueldo * rscon!Param1 / 100 * rsmov!Unidades
	//             afe100 = "3"
	        
	//         Case "25"
	//              Dim Ant As Integer
	//              Ant = CInt((Date - rsEmp!Ingreso) / 365)
	//              Rstteg.Find "numano= " & Ant
	//              If Rstteg.RecordCount > 0 Then
	//                 Result = rsmov!Unidades * (rsEmp!Sueldo + rsEmp!Promed) * Rstteg!porcpri / 100
	//              End If
	             
	//         Case "26"
	//              ' Suplencias Horas Fraccion incluye 7o. dia DONDE
	        
	//         Case "27"
	//              Result = rsmov!Saldo
	             
	//         Case "28"
	//              Result = (rsEmp!Sueldo + rsEmp!Promed) * rscon!Param1 / 100 * 7
	             
	//         Case "29"
	//              Result = (rsEmp!Sueldo * rscon!Param2 * rsmov!Unidades) + (rscon!Param1 * rsmov!Unidades)
	             
	//         Case "31"
	//              Result = (rsEmp!VarBim * rsmov!Unidades)
	             
	//         Case "33"
	//              ' Bonos de Antiguedad oficinas de ORMEX
	        
	//         Case "35"  'Descuento por Hora (Retardo)
	//             Dim Unid As Single
	//             Unid = -1 * Abs(rsmov!Unidades)
	//             Result = (rsEmp!Sueldo / rscon!Param2) * (rscon!Param1 / 100) * Unid
	             
	//     End Select
	// Exit Sub
	// ErrHan:
	//     Err.Raise Err.Number, Err.Source, Err.Description
	// End Sub

	public static function perPrim(Empleado $emp, Movtos &$movto, Concepto $cpto)
	{
		switch ($cpto->METODO) {
			case '02':
				$result = ($emp->SUELDO / $cpto->PARAM2) * $cpto->PARAM1 * $movto->UNIDADES;
				break;

			case '11':
				$var1 = -1 * abs($movto->UNIDADES);
				$var2 = $emp->SUELDO * $cpto->PARAM1 / 100;
				$result = $var1 * $var2;
				$movto->UNIDADES = $var1;
				break;
			
			case '13':
				$result = ($emp->SUELDO + $emp->PROMED) * $cpto->PARAM1 / 100 * $movto->UNIDADES;
	            $afe100 = "3";
	            break;

			default:
				$result = 0;
				break;
		}
		return $result;
	}

}
