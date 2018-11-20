@extends('layouts.app')

@section('title','Transacciones x Concepto')
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
            <form class="form" method="POST" action="{{ url('transacciones/porConcepto') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" id="Metodo"  name="Metodo" value="">
				<input type="hidden" id="MetodoISP"  name="MetodoISP" value="">
				<input type="hidden" id="FlagCien"  name="FlagCien" value="">
                <!-- <p class="text-center" style="color:Azure; text-align: center;">Ingresa tus datos</p> -->
                <div class="row" style="margin-bottom: 0px;">
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Concepto:</label>
                            <select class="form-control cpto" id="concepto" name="Concepto">
                                <option value="0" selected>Seleccione un concepto...</option>
                                @foreach ($conceptos as $cpto)
                                    <option value="{{ $cpto->CONCEPTO }}">{{ $cpto->CONCEPTO . ' - ' . $cpto->NOMBRE }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
	                <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Período:</label>
                            <select class="form-control pdo" id="periodo" name="Periodo">
                                <option value="0" selected>Seleccione el período...</option>
                                @foreach ($periodos as $pdo)
                                    <option value="{{ $pdo->PERIODO }}">{{ $pdo->PERIODO . ' - Inicia: ' . date('d-m-Y',strtotime($pdo->FECINI)) . ' - Finaliza: ' . date('d-m-Y',strtotime($pdo->FECFIN)) }}</option>
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
    				<label class="label-left" style="font-size: 14px;">Descuentos:</label>
    				<input type="text" id="descuento" name="Descuento" value="">
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
	const CAPUNI = "1";				// Captura unidades
	const CAPIMP = "2";				// Captura importes
	const CONINFONAVIT0 = "652";	// CONCEPTO DE INFONAVIT
	const CONISPTNORMAL = "500"; 	// CONCEPTO DE I.S.P.T. NORMAL
	const CONFONACOT = ["905","906","907","908","909","910"];

	var descuento;
	var unidades;
	var saldo;
	var token;
	var flagCien;
	var metodo;	
	var metodoIsp;
	var pantalla;
	var concepto;
	var periodo;
	var tabla;
	var empleado;
	var sueldo;
	var totUnidades;
	var totImporte;
	var conceptParam = [];

	var activoFld 	= 	'<div class="form-group checkbox text-center"> ' +
						'	<label><input type="checkbox" id="activo" name="Activo">Activo</label> ' +
                    	'</div>'; 
	var periodoFld 	= '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Período</label>' +
            			'	<input type="text" id="periodo" name="Periodo" value="">' +
        				'</div>';
	var descuentoFld = '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Descuento</label>' +
            			'	<input type="text" id="descuento" name="Descuento" value="">' +
        				'</div>';
	var unidadesFld = '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Unidades</label>' +
            			'	<input type="text" id="unidades" name="Unidades" value="">' +
        				'</div>';
	var importeFld =  '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Importe</label>' +
            			'	<input type="text" id="importe" name="Importe" value="">' +
        				'</div>';
    var fechaFld	= '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Fecha</label>' +
            			'	<input type="date" id="fecha" name="Fecha" value="">' +
        				'</div>';
	var saldoFld =  '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Saldo</label>' +
            			'	<input type="text" id="saldo" name="Saldo" value="">' +
        				'</div>';

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).ready(function() {
		token = $('input[name=_token]').val();
    	tabla = this.getElementById("captura");

		console.log('here we are. The token is: ' + token);

		$("#nuevo").on('show.bs.modal', function() {
			// Agrega al MODAL, los campos que se deben capturar de acuerdo al valor de 'pantalla'
			var inputfields = $(".input-data");	

    		switch (pantalla) {
    			case 1:
    			case 2:
    				inputfields[0].innerHTML = periodoFld;
    			    inputfields[0].innerHTML += descuentoFld;
    			    inputfields[0].innerHTML += saldoFld;
    			    inputfields[0].innerHTML += activoFld;
    			    if (pantalla == 1) {
    			    	inputfields[0].innerHTML += fechaFld;
    			    }
    				break;
    			case 3:
    			    inputfields[0].innerHTML = unidadesFld;
    				break;
    			case 4:
					inputfields[0].innerHTML = importeFld;    			
    				break;
    			case 5:
					if (concepto >= CONISPTNORMAL) {
						inputfields[0].innerHTML = descuentoFld;
					} else {
						inputfields[0].innerHTML = importeFld;
					}
					inputfields[0].innerHTML += saldoFld;
    				break;
    		}
		});
	});

    $("#btnNuevo").click(function(){
		//var concepto  =  $('.cpto').val();
    	if ( concepto != 0 && periodo != 0 ) {
        	$("#nuevo").modal();
        } else {
           alert('No ha seleccionado un concepto o período!');
        }
    });


    $("#Add").click(function(event){
		var nombre = $('#empleado>option:selected').text();
		var importe;

		empleado  =  $('.emp').val();
		sueldo =  Number($('.emp').find(':selected').data('sueldo'));
		promed = Number($('.emp').find(':selected').data('promed'));
 		descuento = $('#descuento').val();
		unidades = $('#unidades').val();
		saldo = $('#saldo').val();
		console.log('empleado: ' + empleado + ', sueldo: ' + sueldo + ', promed: ' + promed);
	    console.log('pantalla: ' + pantalla + ', descuento: ' + descuento + ', unidades: ' + unidades + ', saldo: ' + saldo);

		if (validaPantalla(pantalla)) {
			console.log('adding input data');
	    	switch (pantalla) {
	    		case 1:
	    		case 2:
		        	var row = tabla.insertRow(tabla.rows.length);
		        	var col0 = row.insertCell(0);
		        	var col1 = row.insertCell(1);
		        	var col2 = row.insertCell(2);
		        	var col3 = row.insertCell(3);
					col0.innerHTML = '<td><input type="text" name="emp[]" value="'+empleado+'" /></td>'; col0.style.display = 'none'; 
					col1.innerHTML = nombre;
					col2.innerHTML = periodo;
					col3.innerHTML = '<td style="text-align:right;border:0px;width:150px!important;"><input type="text" name="unidades[]" value="'+unidades+'" /></td>';
			        break;
			    case 3:
		            switch (metodo.substr(2, 2)) {
		            	case "01":
		            		importe = (sueldo + promed) * unidades;
		            		break;
		            	case "05":
		            		importe = unidades;
		            		break;
		                case "06":
		                    // Sal.Base * param1 * uni.dias  
				            importe = (sueldo + promed)  * conceptParam[1] / 100 * unidades;
		                    break;
		                case "21":
		                    //ObjCal.DedPrim rs, RsAux, rstinteg, RstCon, rstnom, Afe100con, Result, sr, tipn
		                    break;
		            }

		        	var row = tabla.insertRow(tabla.rows.length);
		        	var col0 = row.insertCell(0);
		        	var col1 = row.insertCell(1);
		        	var col2 = row.insertCell(2);
		        	var col3 = row.insertCell(3);
		        	var col4 = row.insertCell(4);
					col0.innerHTML = '<td><input type="text" name="emp[]" value="'+empleado+'"/></td>'; col0.style.display = 'none'; 
					col1.innerHTML = '<td>' + nombre + '</td>';
					col2.innerHTML = '<td style="text-align:right;"><input type="text" name="periodo[]" style="border:0px;width:150px!important;" value="'+periodo+'"/></td>';
					col3.innerHTML = '<td style="text-align:right;border:0px;width:150px!important;"><input type="text" name="unidades[]" value="'+unidades+'" /></td>';
					col4.innerHTML = '<td style="text-align:right;border:0px;width:150px!important;"><input type="text" name="calculo[]" value="'+importe+'" /></td>';
			    	break;
			    case 4:
			    	unidades = $('#importe').val();
		            switch (metodo.substr(2, 2)) {
		            	case "01":
		            		if (metodo.substr(0,2) == '11') {
		            			Result = (sueldo + promed) * unidades;
		            		} else {
		            			Result = unidades;
		            		}
		            		break;
		                case "05":
 				            Result = unidades;
		                    break;
		                case "11":
				            var VAR1 = -1 * Math.abs(unidades);
				            var VAR2 = sueldo * conceptParam[1] / 100;
				            Result = VAR1 * VAR2;
				            unidades = VAR1;
		                    break;
						default:
							alert('Metodo NO definido!');
							Result = 0;
							break;
		            }
		            if (Result != 0) {
			        	var row = tabla.insertRow(tabla.rows.length);
			        	var col0 = row.insertCell(0);
			        	var col1 = row.insertCell(1);
			        	var col2 = row.insertCell(2);
			        	var col3 = row.insertCell(3);
			        	var col4 = row.insertCell(4);
			        	col0.innerHTML = '<td><input type="text" name="emp[]" value="'+empleado+'" /></td>'; col0.style.display = 'none'; 
						col1.innerHTML = '<td>' + nombre + '</td>';
						col2.innerHTML = '<td style="text-align:right;"><input type="text" name="periodo[]" style="border:0px;width:150px!important;" value="'+periodo+'"/></td>'; col2.style.display = 'none';
						col3.innerHTML = '<td style="text-align:right;border:0px;width:150px!important;"><input type="text" name="unidades[]" value="'+unidades+'" /></td>';
						col4.innerHTML = '<td style="text-align:right;"><input type="text" name="calculo[]" value="'+Result+'" /></td>'; col4.style.display = 'none';
					}
			    	break;
			    case 5:
			        var row = tabla.insertRow(tabla.rows.length);
		        	var col0 = row.insertCell(0);
		        	var col1 = row.insertCell(1);
		        	var col2 = row.insertCell(2);
		        	var col3 = row.insertCell(3);
		        	var col4 = row.insertCell(4);
					col0.innerHTML = '<td><input type="text" name="emp[]" value="'+empleado+'"/></td>'; col0.style.display = 'none'; 
					col1.innerHTML = '<td>' + nombre + '</td>';
					col2.innerHTML = '<td style="text-align:right;"><input type="text" name="periodo[]" style="border:0px;width:150px!important;" value="'+periodo+'"/></td>';
					if (concepto >= 500) {
						col3.innerHTML = '<td style="text-align:right;border:0px;width:150px!important;"><input type="text" name="importe[]" value="'+descuento+'" /></td>';
					} else {
						col3.innerHTML = '<td style="text-align:right;border:0px;width:150px!important;"><input type="text" name="importe[]" value="'+importe+'" /></td>';
					}
					col4.innerHTML = '<td style="text-align:right;border:0px;width:150px!important;"><input type="text" name="saldo[]" value="'+saldo+'" /></td>';
					col5.innerHTML = '<td style="text-align:center;border:0px;width:150px!important;"><input type="checkbox" name="activo[]"'+  +' /></td>';
			    	break;
			}
        }
    });

	$('.cpto').change(function() {
		var conceptData;
		var tipoCaptura;

		function getFlagValue(metodo, tipoCaptura) {
			var flagValue = 0;
			switch (metodo) {
				case "08":
				case "19":
				case "20": flagValue = "1"; break;
				case "09":
				case "13":
				case "23": flagValue = "3"; break;
				case "10": if (tipoCaptura == 4 || tipoCaptura == 5) {
						flagValue = "1";
					} else {
						flagValue = "3";
					}
					break;
			}
			return flagValue;
		}

		concepto = $('.cpto').val();
        $.post("get-concepto", { concepto: concepto, _token: token }, function( data ) {
            conceptData = Object.values(data);
            metodo = conceptData[0]["TIPCONCEP"] + conceptData[0]["TIPCALCUL"] + conceptData[0]["METODO"];
            metodoIsp = conceptData[0]["METODOISP"];
            conceptParam[1] = Number(conceptData[0]["PARAM1"]);
            conceptParam[2] = Number(conceptData[0]["PARAM2"]);
			document.getElementById("Metodo").value = metodo;
			document.getElementById("MetodoISP").value = metodoIsp;
            tipoCaptura = conceptData[0]["TIPCAPT"];
            flagCien = getFlagValue(conceptData[0]["METODO"],tipoCaptura);
    		document.getElementById("FlagCien").value = flagCien;
			switch (concepto) {
				case CONINFONAVIT0:
					pantalla = 1;
					break;
				case (CONFONACOT.includes(concepto)?concepto:null):
					pantalla = 2;
					break;
				default:
					//console.log(tipoCaptura);
	    			switch (tipoCaptura) {
			    		case CAPUNI: 		// Captura Unidades y calcula importe
			    			pantalla = 3;
			    			break;
			    		case CAPIMP: 		// Captura Importes 
			    			pantalla = 4;
			    			break;
			    		case "3": 	// Captura Saldo Automático (CAPSALAUT)
			    			if (metodo == "2303" || metodo == "2310" || metodo == "2323" || metodo == "2327" || metodo == "2328" ) {
			    				pantalla = 1;
			    			} else {
			    				pantalla = 5;
			    			}
			    			break;
			    	}
			    	break;
	    	}
    		console.log('concepto: '+ concepto +', metodo: ' + metodo + ', flagCien:' + flagCien + ', pantalla:' + pantalla + ', tipo captura: '+tipoCaptura);
	    	creaPantalla(pantalla);
        });
	});

	$('.pdo').change(function() {
		concepto  =  $('.cpto').val();
		periodo = $('.pdo').val();
    	//console.log(concepto + ' - ' + periodo);
    	// checa si hay movimientos capturados del período en cuyo caso los despliega
		totUnidades = 0;
		totImporte = 0;    	
        $.post("get-movtos", { concepto: concepto, periodo: periodo, _token: token }, function( data ) {
            var movtos = Object.values(data);
    		// console.log(movtos);
    		// limpia la tabla para desplegar los movtos leidos
		    while (tabla.rows.length > 1) {
		        tabla.deleteRow(tabla.rows.length-1);
    		}
    		// Aqui los despliega
    	    for (var i = 0; i < movtos.length; i++) {
    	    	switch (pantalla) {
    	    		case 1:
    	    		case 2:
    	    		case 5:
						totUnidades = totUnidades + movtos[i]["UNIDADES"];
						totImporte = totImporte + movtos[i]["SALDO"];
						// Falta desplegar estos valores!!!
    	    			break;
    	    		case 3:
    	    		case 4:
						totUnidades = totUnidades + movtos[i]["UNIDADES"];
						totImporte = totImporte + movtos[i]["CALCULO"];    	    		
		            	var row = tabla.insertRow(tabla.rows.length);
		            	var col0 = row.insertCell(0);
		            	var col1 = row.insertCell(1);
		            	var col2 = row.insertCell(2);
			        	var col3 = row.insertCell(3);
			        	var col4 = row.insertCell(4);
						col0.innerHTML = '<td><input type="text" name="emp[]" value="'+movtos[i]["EMP"]+'"/></td>'; col0.style.display = 'none'; 
						col1.innerHTML = '<td>' + movtos[i]["NOMBRE"] + '</td>';
						col2.innerHTML = '<td style="text-align:right;"><input type="text" name="periodo[]" style="border:0px;width:150px!important;" value="'+periodo+'"/></td>'; col2.style.display = 'none';

						col3.innerHTML = '<td style="text-align:right;border:0px;width:150px!important;"><input type="text" name="unidades[]" value="'+movtos[i]["UNIDADES"]+'" /></td>';
						col4.innerHTML = '<td style="text-align:right;border:0px;width:150px!important;"><input type="text" name="calculo[]" value="'+movtos[i]["CALCULO"]+'" /></td>'; col4.style.display = 'none';
						break;

    	    	}

            }
        });		
	});


	function creaPantalla(numPantalla) {
    	//console.log(numPantalla);
	    while (tabla.rows.length > 0) {
	        tabla.deleteRow(tabla.rows.length-1);
		}
    	var row = tabla.insertRow(tabla.rows.length);
    	var col0 = row.insertCell(0);
    	var col1 = row.insertCell(1);
    	var col2 = row.insertCell(2);
		col0.innerHTML = '<th>Empleado</th>'; 	col1.style.display = 'none'; 
		col1.innerHTML = '<th>Nombre</th>'; 	col1.style.width = "50%";
		col2.innerHTML = '<th>Período</th>';	col2.style.width = "10%"; 
		switch (numPantalla) {
			case 1:
    			var col3 = row.insertCell(3);
    			var col4 = row.insertCell(4);
    			var col5 = row.insertCell(5);
    			var col6 = row.insertCell(6);
    			var col7 = row.insertCell(7);
				col3.innerHTML = "<th>Descuento</th>";	col3.style.width = "10%";
				col4.innerHTML = "<th>Saldo</th>";		col4.style.width = "10%";
				col5.innerHTML = "<th>Activo</th>";		col5.style.width = "10%";
				col6.innerHTML = '<th style="width:0%; display: none;">Cálculo</th>'; 
				col7.innerHTML = "<th>Fecha</th>";		col7.style.width = "10%";
				break;
			case 2:
    			var col3 = row.insertCell(3);
    			var col4 = row.insertCell(4);
    			var col5 = row.insertCell(5);
    			var col6 = row.insertCell(6);
    			var col7 = row.insertCell(7);
    			var col8 = row.insertCell(8);
				col3.innerHTML = "<th>Descuento</th>";	col3.style.width = "8%";
				col4.innerHTML = "<th>Saldo</th>";		col4.style.width = "8%";
				col5.innerHTML = "<th>Desc. mes</th>";	col5.style.width = "8%";
				col6.innerHTML = "<th>Plazo</th>";		col6.style.width = "8%";
				col7.innerHTML = "<th>Activo</th>";		col7.style.width = "8%";
				col8.innerHTML = '<th>Cálculo</th>'; 	col8.style.display = 'none'; 
				break;
			case 3:
    			var col3 = row.insertCell(3);
    			var col4 = row.insertCell(4);
				col3.innerHTML = "<th>Unidades</th>";	col3.style.width = "20%";
				col4.innerHTML = "<th>Importe</th>";	col4.style.width = "20%";
				break;
			case 4:
				col2.style.display = 'none';
    			var col3 = row.insertCell(3);
    			var col4 = row.insertCell(4);
				col3.innerHTML = "<th>Importe</th>";	col3.style.width = "20%"; // Debe ser Unidades el titulo???
				col4.innerHTML = '<th>Cálculo</th>';	col4.style.display = 'none'; 		
				break;
			case 5:
    			var col3 = row.insertCell(3);
    			var col4 = row.insertCell(4);
    			var col5 = row.insertCell(5);
    			var col6 = row.insertCell(6);
				if (concepto >= "500") {
					col3.innerHTML = "<th>Descuento</th>";	col3.style.width = "10%";
				} else {
					col3.innerHTML = "<th>Importe</th>";	col3.style.width = "10%";

				}
				col4.innerHTML = "<th>Saldo</th>";		col4.style.width = "10%";
				col5.innerHTML = "<th>Activo</th>";		col5.style.width = "10%";
				col6.innerHTML = '<th>Cálculo</th>'; 	col6.style.display = 'none'; 
				break;
		}

	}

	function validaPantalla(numPantalla) {
		var bOK = true;
    	if ( empleado != 0 ) {
			// Checa si ya existe el empleado en la tabla
			var table = document.getElementById('captura');
			var rowLength = table.rows.length;

			for(var i=1; i<rowLength; i+=1){
			  var row = table.rows[i];

			  if (row.cells[0].firstChild.value == empleado) {
			  		alert('Ese empleado ya existe en la lista!');
			  		bOK = false;
			  }
			}			
		} else {
           alert('No se capturó el empleado!');
           bOK = false;
        }		
		switch (numPantalla) {
			case 1:
				break;
			case 2:
		    	if ( descuento == 0 ) {	
		           alert('No ha capturado el importe del descuento!');
		           bOK = false;
		        }
				break;
			case 3:
				//alert($.isNumeric(unidades));
				//alert(isNaN(unidades));
				bOK =  (unidades != 0);
				break;
			case 5:

				break;
		}
		return bOK;
	}	
</script>            
@endsection 