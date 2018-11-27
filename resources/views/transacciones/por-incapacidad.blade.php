@extends('layouts.app')

@section('title','Ausentismo / Incapacidad')
@section('body-class','')

@section('content')
{!! Session::get("message", '') !!}
<div class="container" style="border:1px red solid;">
<!--     <div class="row"> -->
<!--         <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2" style="border:1px red solid;"> -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>                    
                </div>
            @endif   	
            <form class="form" method="POST" action="{{ url('transacciones/porIncapacidad') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" id="Metodo"  name="Metodo" value="">
				<input type="hidden" id="MetodoISP"  name="MetodoISP" value="">
				<input type="hidden" id="Clave" name="Clave" value="">
                <!-- <p class="text-center" style="color:Azure; text-align: center;">Ingresa tus datos</p> -->
                <div class="row" style="margin-bottom: 0px;">
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Concepto:</label>
                            <select class="form-control cpto" id="concepto" name="Concepto">
                                <option value="0" selected>Seleccione un concepto...</option>
                                @foreach ($conceptos as $cpto)
                                    <option value="{{ $cpto->CONCEPTO }}">{{ $cpto->NOMBRE }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
	                <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Período:</label>
                            <select class="form-control pdo" id="periodo" name="Periodo">
                                <!-- option value="0">Seleccione el período...</option -->
                                @foreach ($periodos as $pdo)
                                    <option value="{{ $pdo->PERIODO }}" data-fi="{{ date('Y-m-d',strtotime($pdo->FECINI)) }}" 
                                    	{{ ($pdo->PERIODO == $periCalc)? 'selected':'' }} >
                                    	{{ $pdo->PERIODO . ' - Inicia: ' . date('d-m-Y',strtotime($pdo->FECINI)) . ' - Finaliza: ' . date('d-m-Y',strtotime($pdo->FECFIN)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                	<button type="button" class="btn btn-info btn-sm" id="btnNuevo">Agregar empleado</button>
                </div>
                <table class="row table" name="Movtos" id="captura">
                	<thead>                    	
                		<tr>
                			<th>Empleado</th>
                			<th>Nombre</th>
                			<th>Importe</th>
                		</tr>
                	</thead>
                </table>
                <div class="row text-center">
                    <button type="submit" class="primario">Guardar</button>
                </div>
            </form>
<!--         </div> -->
<!--     </div> -->
</div>
<!-- Modal -->
<div class="modal fade" id="nuevo" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Seleccione Empleado y capture los datos</h4>
        </div>
        <div class="modal-body">
            <div class="form-group label-floating">
                <label class="control-label">Empleado:</label>
                <select class="form-control emp" id="empleado" name="Empleado">
                    <option value="0" selected>Seleccione un empleado...</option>
                    @foreach ($empleados as $emp)
                        <option value="{{ $emp->EMP }}" data-sueldo="{{ $emp->SUELDO }}" data-promed="{{ $emp->PROMED }}" >{{ $emp->NOMBRE }}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-data">
				<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
        			<label class="label-left" style="font-size: 14px;">Fecha</label>
        			<input type="date" id="fecha" name="Fecha" value="">
        		</div>
				<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
    				<label class="label-left" style="font-size: 14px;">Dias</label>
    				<input type="text" id="dias" name="Dias" value="">
				</div>
				<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
    				<label class="label-left" style="font-size: 14px;">Ref. IMSS</label>
    				<input type="text" id="refIMSS" name="RefIMSS" value="">
				</div>
			<!--Grid.Columns.Item("tipinc").ValueList.Add "EG", "EG"
			    Grid.Columns.Item("tipinc").ValueList.Add "AT", "AT"
			    Grid.Columns.Item("tipinc").ValueList.Add "MA", "MA"
			    Grid.Columns.Item("tipinc").ValueList.Add "MD", "MD"
			    Grid.Columns.Item("tipinc").ValueList.Add "TR", "TR"
			    Grid.Columns.Item("tipinc").ValueList.Add "EP", "EP" -->				
			<!--<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
            		<label class="label-left" style="font-size: 14px;">Tipo</label>
            		<input type="text" id="tipo" name="Tipo" value="">
        		</div> -->
            	<div class="form-group label-floating">
                	<label class="control-label">Tipo de Incapacidad:</label>        		
	                <select class="form-control emp" id="tipo" name="Tipo">
		                <option value="0" selected>Seleccione...</option>
		                <option value="EG">EG</option>
		                <option value="AT">AT</option>
		                <option value="MA">MA</option>
		                <option value="MD">MD</option>
		                <option value="TR">TR</option>
		                <option value="EP">EP</option>	                
	                </select>
	            </div>
        	</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="Add">Agregar</button>
        </div>
      </div>
      
    </div>
</div>
@include('includes.footer')
@endsection
@section('jscript')
<script type="text/javascript">

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	const CONINCAP1 = "400";
	const CONINCAP2 = "401";
	const CONINCAP3 = "402";
	const CONINCAP4 = "403";
	const CONINCAP5 = "404";
	const CONINCAP6 = "405";
	const CONINCAP7 = "406";
	const CONINCAP8 = "407";
	const CONINCAP9 = "408";
	const CONINCAP10 = "360";
	const CONINCAP11 = "361";
	const CONINCAP12 = "100";

	var token;
	var metodo;	
	var metodoIsp;
	var pantalla;
	var concepto;
	var periodo;
	var tabla;
	var empleado;
	var sueldo;
	var tipConcep;
	var varClave;
	var fechaIncidencia;

	$(document).ready(function() {
		token = $('input[name=_token]').val();
    	tabla = this.getElementById("captura");
		console.log('here we are. The token is: ' + token);
	    creaPantalla();
	    fechaIncidencia = document.getElementById("fecha");
	});

    $("#btnNuevo").click(function(){
		concepto  = $('.cpto').val();
		periodo   = $('.pdo').val(); 
    	if ( concepto != 0 && periodo != 0 ) {
			var fechaIni = $('.pdo>option:selected').data('fi');
			//alert(periodo + ' - ' + fechaIni + fechaIncidencia.value);
			fechaIncidencia.value = fechaIni;
        	$("#nuevo").modal();
        } else {
           alert('No ha seleccionado un concepto o período!');
        }
    });


    // Toma los valores de la pantalla modal (recien capturada) y 
    // los inserta en la tabla
    $("#Add").click(function(event) {
		var nombre = $('#empleado>option:selected').text();
		var importe;
		var bOK = true;
		empleado  =  $('.emp').val();
		sueldo =  Number($('.emp').find(':selected').data('sueldo'));

    	if ( empleado != 0 ) {
			// Checa si ya existe el empleado en la tabla
			if ($("table#captura tr").length > 1) {
				$.each($("table#captura tr td"), function(index, cell) {
					if (index > 1) {
						var celda = $(cell);
						// alert($(cell).innerHTML);
						console.log(celda.val());
					}
				});
			}
		} else {
           alert('No ha capturado el empleado!');
           event.preventDefault();
           bOK = false;
        }

		if (bOK) {
			var dias = $('#dias').val();
			var fecha = $('#fecha').val();
			var refIMSS = $('#refIMSS').val();
			var tipo = $('#tipo').val();
	    	if ( dias != 0 ) {
	        	var row = tabla.insertRow(tabla.rows.length);
	        	var col1 = row.insertCell(0);
	        	var col2 = row.insertCell(1);
	        	var col3 = row.insertCell(2);
	        	var col4 = row.insertCell(3);
	        	var col5 = row.insertCell(4);
	        	var col6 = row.insertCell(5);

				col1.innerHTML = '<td><input type="text" name="emp[]" value="'+empleado+'"/></td>'; col1.style.display = 'none';
				col2.innerHTML = '<td>' + nombre + '</td>';
				col3.innerHTML = '<td><input type="text" name="fecha[]" style="border:0px;width:150px!important;" value="'+fecha+'"/></td>'; 
				col4.innerHTML = '<td style="text-align:right;"><input type="text" name="dias[]" style="border:0px;width:150px!important;" value="'+dias+'"/></td>'; //col4.style.width = "10%";
				col5.innerHTML = '<td><input type="text" name="refIMSS[]" style="border:0px;width:150px!important;" value="'+refIMSS+'"/></td>'; 
				col6.innerHTML = '<td><input type="text" name="tipo[]" style="border:0px;width:150px!important;" value="'+tipo+'"/></td>'; 
	        } else {
	           alert('No ha capturado las unidades!');
	        }			    
        }
    });


	$('.cpto').change(function() {
		var conceptData;
		var tipoCaptura;

		concepto = $('.cpto').val();
        $.post("get-concepto", { concepto: concepto, _token: token }, function( data ) {
            conceptData = Object.values(data);
            metodo = conceptData[0]["METODO"];
            metodoIsp = conceptData[0]["METODOISP"];
            tipConcep = conceptData[0]["TIPCONCEP"];
            tipCalcul = conceptData[0]["TIPCALCUL"]
			document.getElementById("Metodo").value = metodo;
			document.getElementById("MetodoISP").value = metodoIsp;
            tipoCaptura = conceptData[0]["TIPCAPT"];

			switch (concepto) {
				case CONINCAP12:
					varClave = 5;
					break;
				case CONINCAP1:
				case CONINCAP2:
				case CONINCAP3:
				case CONINCAP4:
				case CONINCAP5:
				case CONINCAP10:
				case CONINCAP11:
					varClave = 12;
					break;
				case CONINCAP6:
				case CONINCAP7:
				case CONINCAP8:
				case CONINCAP9:
					varClave = 11;
					break;
	    	}
	    	document.getElementById("Clave").value = varClave;
	    	console.log('Clave: ' + varClave);
	    	$('.pdo').change();
        });
	});

	// período change
	$('.pdo').change(function() {
		concepto  =  $('.cpto').val();
		periodo = $('.pdo').val();
    	// checa si hay movimientos capturados del período en cuyo caso los despliega
        $.post("get-movtos", { concepto: concepto, periodo: periodo, _token: token }, function( data ) {
            var movtos = Object.values(data);
    		console.log(movtos);	
		    while (tabla.rows.length > 1) {
		        tabla.deleteRow(tabla.rows.length-1);
    		}
    		// Aqui los despliega
    	    for (var i = 0; i < movtos.length; i++) {
				totUnidades = totUnidades + movtos[i]["UNIDADES"];
				totImporte = totImporte + movtos[i]["CALCULO"];    	    		
	        	var row = tabla.insertRow(tabla.rows.length);
	        	var col1 = row.insertCell(0);
	        	var col2 = row.insertCell(1);
	        	var col3 = row.insertCell(2);
	        	var col4 = row.insertCell(3);
	        	var col5 = row.insertCell(4);
	        	var col6 = row.insertCell(5);

				col1.innerHTML = '<td><input type="text" name="emp[]" value="'+movtos[i]["EMP"]+'"/></td>'; col1.style.display = 'none';
				col2.innerHTML = '<td>' + movtos[i]["NOMBRE"] + '</td>';
				col3.innerHTML = '<td><input type="text" name="fecha[]" style="border:0px;width:150px!important;" value="'+movtos[i]["fecha"]+'"/></td>'; 
				col4.innerHTML = '<td style="text-align:right;"><input type="text" name="dias[]" style="border:0px;width:150px!important;" value="'+movtos[i]["UNIDADES"]+'"/></td>'; //col4.style.width = "10%";
				col5.innerHTML = '<td><input type="text" name="refIMSS[]" style="border:0px;width:150px!important;" value="'+refIMSS+'"/></td>'; 
				col6.innerHTML = '<td><input type="text" name="tipo[]" style="border:0px;width:150px!important;" value="'+tipo+'"/></td>';


            }

        });		
	});


	// Public Function ValidaDias(ByVal Fecha As Date, dias As Integer) As Boolean
	// Dim BimActual As Integer, DiasPasados As Integer
	// Dim FinBim As Date
	// ValidaDias = True
	// BimActual = Int((Month(Fecha) - 1) / 2) + 1
	// DiasPasados = Fecha - IniBim(BimActual)
	// FinBim = IniBim(BimActual) + DiasBim(BimActual) - 1
	// If dias + DiasPasados > DiasBim(BimActual) Then
	//     MsgBox "El total de dias capturado, excede el total de dias disponibles del bimestre " & BimActual & vbCrLf & "a partir de la fecha indicada, debe desglosar los dias" & vbCrLf & " " & vbCrLf & "Inicio de Bimestre=" & Format(IniBim(BimActual), "dd/mm/yyyy") & "; Fin del Bimestre=" & Format(FinBim, "dd/mm/yyyy") & vbCrLf & "Fecha Capturada=" & Format(Fecha, "dd/mm/yyyy") & vbCrLf & "Dias Trancurridos=" & DiasPasados & ";  Dias Disponobles=" & DiasBim(BimActual) - DiasPasados, vbInformation, Me.Caption
	//     ValidaDias = False
	// End If

	// End Function

	// Valida dias
	// $('#dias').change(function() {
	// 	fecha  =  $('#fecha').val();
	// 	var parts =fecha.split('/');
	// 	// Please pay attention to the month (parts[1]); JavaScript counts months from 0:
	// 	// January - 0, February - 1, etc.
	// 	var mydate = new Date(parts[0], parts[1] - 1, parts[2]); 
	// 	alert(fecha + ' - ' + mydate);
	// 	//bimActual = Int((fecha.getMonth() -1) / 2) + 1;

	// 	//periodo = $('.pdo').val();
 //    	// checa si hay movimientos capturados del período en cuyo caso los despliega
 //      //   $.post("get-movtos", { concepto: concepto, periodo: periodo, _token: token }, function( data ) {
 //      //       var movtos = Object.values(data);
 //    		// //console.log(movtos);	
	// 	    // while (tabla.rows.length > 1) {
	// 	    //     tabla.deleteRow(tabla.rows.length-1);
 //    		// }
 //      //   });		
	// });


	function creaPantalla() {
    	//console.log(numPantalla);
	    while (tabla.rows.length > 0) {
	        tabla.deleteRow(tabla.rows.length-1);
		}
    	var row = tabla.insertRow(tabla.rows.length);
    	var col1 = row.insertCell(0);
    	var col2 = row.insertCell(1);
    	var col3 = row.insertCell(2);
		var col4 = row.insertCell(3);
		var col5 = row.insertCell(4);
		var col6 = row.insertCell(5);

		col1.innerHTML = '<th>Empleado</th>'; 	col1.style.display = 'none';
		col2.innerHTML = '<th>Nombre</th>'; 	col2.style.width = "60%";
		col3.innerHTML = '<th>Fecha</th>'; 		col3.style.width = "10%";
		col4.innerHTML = '<th>Dias</th>'; 		col4.style.width = "10%";
		col5.innerHTML = '<th>Ref. IMSS</th>'; 	col5.style.width = "10%";
		col6.innerHTML = '<th>Tipo</th>'; 		col6.style.width = "10%";
	}
</script>            
@endsection 