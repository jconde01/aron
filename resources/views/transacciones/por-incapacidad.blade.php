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
                <!-- <p class="text-center" style="color:Azure; text-align: center;">Ingresa tus datos</p> -->
                <div class="row">
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
                                <option value="0" selected>Seleccione el período...</option>
                                @foreach ($periodos as $pdo)
                                    <option value="{{ $pdo->PERIODO }}">{{ $pdo->PERIODO . ' - Inicia: ' . date('d-m-Y',strtotime($pdo->FECINI)) . ' - Finaliza: ' . date('d-m-Y',strtotime($pdo->FECFIN)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                	<button type="button" class="btn btn-info btn-sm" id="btnNuevo">Nuevo</button>
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
	var conceptParam = [];
	var unidadesFld = '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Unidades</label>' +
            			'	<input type="text" id="unidades" name="Unidades" value="">' +
        				'</div>';
	var fechaFld = '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Fecha</label>' +
            			'	<input type="text" id="fecha" name="Fecha" value="">' +
        				'</div>';
	var sueldoFld =  '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Importe</label>' +
            			'	<input type="text" id="importe" name="Importe" value="">' +
        				'</div>';
	var integFld =  '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Integrado</label>' +
            			'	<input type="text" id="integ" name="Integ" value="">' +
        				'</div>';
	var diasFld =  '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Dias</label>' +
            			'	<input type="text" id="dias" name="Dias" value="">' +
        				'</div>';

	$(document).ready(function() {
		token = $('input[name=_token]').val();
    	tabla = this.getElementById("captura");
		console.log('here we are. The token is: ' + token);

		$("#nuevo").on('show.bs.modal', function() {
			// Agrega al MODAL, el array de los campos que se deben capturar (inputFields)
			var inputFields = $(".input-data");	
		    inputFields[0].innerHTML = unidadesFld;
		    inputFields[1].innerHTML = fechaFld;
			inputFields[2].innerHTML = sueldoFld;    			
			inputFields[3].innerHTML = integFld;
			inputFields[4].innerHTML = diasFld;
		});
	});

    $("#btnNuevo").click(function(){
		var concepto  =  $('.cpto').val();
    	if ( concepto != 0 && periodo != 0 ) {
        	$("#nuevo").modal();
        } else {
           alert('No ha seleccionado un concepto o período!');
        }
    });


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
			var unidades = $('#unidades').val();
	    	if ( unidades != 0 ) {
	            switch (metodo) {
	                case "06":
	                    // Sal.Base * param1 * uni.dias  
			            importe = sueldo * unidades;
	                    break;
	                case "21":
	                    //ObjCal.DedPrim rs, RsAux, rstinteg, RstCon, rstnom, Afe100con, Result, sr, tipn
	                    break;
	            }
	        	var row = tabla.insertRow(tabla.rows.length);
	        	var col1 = row.insertCell(0);
	        	var col2 = row.insertCell(1);
	        	var col3 = row.insertCell(2);
	        	var col4 = row.insertCell(3);
	        	var col5 = row.insertCell(4);
				col1.innerHTML = '<td style="text-align:right;"><input type="text" name="emp[]" value="'+empleado+'" /></td>';
				col2.innerHTML = nombre;
				col3.innerHTML = periodo;
				col4.innerHTML = '<td style="text-align:right;"><input type="text" name="unidades[]" value="'+unidades+'" /></td>';
				col5.innerHTML = '<td style="text-align:right;"><input type="text" name="calculo[]" value="'+importe+'" /></td>';
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
            //metodo = conceptData[0]["TIPCONCEP"] + conceptData[0]["TIPCALCUL"] + conceptData[0]["METODO"];
            metodo = conceptData[0]["METODO"];
            metodoIsp = conceptData[0]["METODOISP"];
            tipConcep = conceptData[0]["TIPCONCEP"];
            tipCalcul = conceptData[0]["TIPCALCUL"]
            conceptParam[1] = Number(conceptData[0]["PARAM1"]);
            conceptParam[2] = Number(conceptData[0]["PARAM2"]);
			document.getElementById("Metodo").value = metodo;
			document.getElementById("MetodoISP").value = metodoIsp;
            tipoCaptura = conceptData[0]["TIPCAPT"];
    		//console.log(conceptData[0]["CONCEPTO"] + ' - ' + tipoCaptura);	
    		console.log(metodo);
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
				// default:
				// 	//console.log(tipoCaptura);
	   			//  switch (tipoCaptura) {
			 	//    		case "1": 	// CAPUNI : Captura Unidades y calcula importe
			 	//    			pantalla = 3;
			 	//    			break;
			 	//    		case "2": 	// CAPIMP : Captura Importes 
			 	//    			pantalla = 4;
			 	//    			break;
			 	//    		case "3": 	// Captura Saldo Automático
			 	//    			if (metodo == "2303" || metodo == "2310" || metodo == "2323" || metodo == "2327" || metodo == "2328" ) {
			 	//    				pantalla = 1;
			 	//    			} else {
			 	//    				pantalla = 5;
			 	//    			}
			 	//    			break;
			 	//    	}
			 	//    	break;
	    	}
	    	creaPantalla();
        });
	});

	// período change
	$('.pdo').change(function() {
		var concepto  =  $('.cpto').val();
		periodo = $('.pdo').val();
    	//console.log(concepto + ' - ' + periodo);
    	// checa si hay movimientos capturados del período en cuyo caso los despliega
        $.post("get-movtos", { concepto: concepto, periodo: periodo, _token: token }, function( data ) {
            var movtos = Object.values(data);
    		//console.log(movtos);	
		    while (tabla.rows.length > 1) {
		        tabla.deleteRow(tabla.rows.length-1);
    		}
    	    for (var i = 0; i < movtos.length; i++) {
    	    	switch (pantalla) {
    	    		case 1:
    	    			break;
    	    		case 2:
    	    			break;
    	    		case 3:
		            	var row = tabla.insertRow(tabla.rows.length);
		            	var col1 = row.insertCell(0);
		            	var col2 = row.insertCell(1);
		            	var col3 = row.insertCell(2);
			        	var col4 = row.insertCell(3);
			        	var col5 = row.insertCell(4);
						col1.innerHTML = '<td style="text-align:right;"><input type="text" name="emp[]" value="'+movtos[i]["EMP"]+'" /></td>';
						col2.innerHTML = movtos[i]["NOMBRE"];
						col3.innerHTML = periodo;
						col4.innerHTML = '<td style="text-align:right;"><input type="text" name="unidades[]" value="'+movtos[i]["UNIDADES"]+'" /></td>';
						col5.innerHTML = '<td style="text-align:right;"><input type="text" name="calculo[]" value="'+movtos[i]["CALCULO"]+'" /></td>';
						break;
    	    		case 4:
    	    		case 5:
    	    			break;
    	    	}

            }
        });		
	});


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
		var col7 = row.insertCell(6);
		var col8 = row.insertCell(7);
		var col9 = row.insertCell(8);
		var col10 = row.insertCell(9);
		var col11 = row.insertCell(10);
		var col12 = row.insertCell(11);

		col1.innerHTML = "Empleado";
		col2.innerHTML = "Nombre";
		col3.innerHTML = "Unidades";
		col4.innerHTML = "Fecha";
		col5.innerHTML = "Sueldo";
		col6.innerHTML = "Integ";
		col7.innerHTML = "Dias";
		col8.innerHTML = "IntIv";
		col9.innerHTML = "IntegNue";
		col10.innerHTML = "IntIvNue";
		col11.innerHTML = "RefIMSS";
		col12.innerHTML = "Tipo";		
	}
</script>            
@endsection 