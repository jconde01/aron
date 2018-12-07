@extends('layouts.app')

@section('title','Transacciones x Concepto')
@section('body-class','')

@section('content')
{!! Session::get("message", '') !!}
<div class="container" style="border:1px red solid;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>
                    	{{ $error }}
                    	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    </li>
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
                    <select class="form-control pdo" id="pdo" name="Pdo">
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
    				<label class="label-left" style="font-size: 14px;">Filler</label>
    				<input type="text" name="Filler" value="">
        		</div>            
        	</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="Add">Agregar</button>
        </div>
      </div>
      
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="editar" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edite los campos y presione OK</h4>
        </div>
        <div class="modal-body">
        	<input type="hidden" id="ed_emp" name="emp" value="">
			<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
    			<label class="label-left" style="font-size: 14px;">Empleado</label>
    			<input type="text" id="ed_empleado" name="Nombre" readonly value="">
    		</div>            	
            <div class="input-data">
				<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> 
    				<label class="label-left" style="font-size: 14px;">Filler</label>
    				<input type="text" name="Filler" value="">
        		</div>            
        	</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="Edit">OK</button>
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
	const CAPSALAUTO = "3"			// Captura Saldo Automático
	const DEDUCCIONES = 500;		// Inician los conceptos de deducciones
	const CONINFONAVIT0 = "652";	// CONCEPTO DE INFONAVIT
	const CONISPTNORMAL = "500"; 	// CONCEPTO DE I.S.P.T. NORMAL
	const CONFONACOT = ["905","906","907","908","909","910"];

	var token;
	var tabla;
	var saldo;
	var activo;
	var sueldo;
	var metodo;	
	var periodo;
	var rowElem;
	var descuento;
	var unidades;
	var flagCien;
	var metodoIsp;
	var empleado;
	var concepto;
	var pantalla;
	var totUnidades;
	var totImporte;

	var conceptParam = [];
	var activoFld = [];
	var periodoFld = [];
	var descuentoFld = [];
	var unidadesFld = [];
	var importeFld = [];
	var fechaFld = [];
	var saldoFld = [];

	activoFld["Add"] 	= '<div class="form-group checkbox text-center"> ' +
						'	<label><input type="checkbox" id="activo" name="Activo">Activo</label> ' +
                    	'</div>'; 
	periodoFld["Add"] 	= '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Período</label>' +
            			'	<input type="text" id="periodo" name="Periodo" value="">' +
        				'</div>';
	descuentoFld["Add"] = '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Descuento</label>' +
            			'	<input type="text" id="descuento" name="Descuento" value="">' +
        				'</div>';
	unidadesFld["Add"] = '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Unidades</label>' +
            			'	<input type="text" id="unidades" name="Unidades" value="">' +
        				'</div>';
	importeFld["Add"] =  '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Importe</label>' +
            			'	<input type="text" id="importe" name="Importe" value="">' +
        				'</div>';
    fechaFld["Add"]	= '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Fecha</label>' +
            			'	<input type="date" id="fecha" name="Fecha" value="">' +
        				'</div>';
	saldoFld["Add"] =  '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Saldo</label>' +
            			'	<input type="text" id="saldo" name="Saldo" value="">' +
        				'</div>';

	activoFld["Edit"] 	= '<div class="form-group checkbox text-center"> ' +
						'	<label><input type="checkbox" id="ed_activo" name="Activo">Activo</label> ' +
                    	'</div>'; 
	periodoFld["Edit"] 	= '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Período</label>' +
            			'	<input type="text" id="ed_periodo" name="Periodo" readonly value="">' +
        				'</div>';
	descuentoFld["Edit"] = '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Descuento</label>' +
            			'	<input type="text" id="ed_descuento" name="Descuento" value="">' +
        				'</div>';
	unidadesFld["Edit"] = '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Descuento</label>' +
            			'	<input type="text" id="ed_unidades" name="Unidades" value="">' +
        				'</div>';
	importeFld["Edit"] =  '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Importe</label>' +
            			'	<input type="text" id="ed_importe" name="Importe" value="">' +
        				'</div>';
    fechaFld["Edit"]	= '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Fecha</label>' +
            			'	<input type="date" id="ed_fecha" name="Fecha" value="">' +
        				'</div>';
	saldoFld["Edit"] =  '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Saldo</label>' +
            			'	<input type="text" id="ed_saldo" name="Saldo" value="">' +
        				'</div>';        				

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).ready(function() {
		token = $('input[name=_token]').val();
    	tabla = this.getElementById("captura");
	});


	$("#captura").on("click", ".btn-danger", function() {
	    rowElem = $(this).closest("tr");
	    tabla.deleteRow(rowElem.index());
	});


	// EDITA los datos del renglon donde se presionó el botón
	$("#captura").on("click", ".btn-success", function() {
		rowElem = $(this).closest("tr");
		addInputFields("Edit", $("#editar .input-data"));
		editaRenglon(rowElem);
	});


    $("#btnNuevo").click(function(){
		concepto  = $('.cpto').val();
		periodo   = $('.pdo').val();
    	if ( concepto != 0 && periodo != 0 ) {
        	$("#nuevo").modal();
        } else {
           alert('No ha seleccionado un concepto o período!');
        }
    });

	$("#nuevo").on('show.bs.modal', function() {
		// Agrega al MODAL, los campos que se deben capturar de acuerdo al valor de 'pantalla'
		addInputFields("Add", $("#nuevo .input-data"));
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
    		// Choose pantalla
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
			    		case CAPSALAUTO: 	// Captura Saldo Automático 
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
		$("body").css("cursor", "wait");
        $.post("get-movtos", { concepto: concepto, periodo: periodo, _token: token }, function( data ) {
        	$("body").css("cursor", "default");
            var movtos = Object.values(data);
    		// console.log(movtos);
    		// limpia la tabla para desplegar los movtos leidos
		    while (tabla.rows.length > 1) {
		        tabla.deleteRow(tabla.rows.length-1);
    		}
    		// Aqui los despliega !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    	    for (var i = 0; i < movtos.length; i++) {
            	var row = tabla.insertRow(tabla.rows.length);
            	var col0 = row.insertCell(0);
            	var col1 = row.insertCell(1);
            	var col2 = row.insertCell(2);
	        	var col3 = row.insertCell(3);
	        	var col4 = row.insertCell(4);
	        	var col5 = row.insertCell(5);    	    	
				col0.innerHTML = '<td><input type="text" class="emp" name="emp[]" value="'+movtos[i]["EMP"]+'"/></td>'; col0.style.display = 'none';
				col1.innerHTML = '<td style="text-align:left!important;">' + movtos[i]["NOMBRE"] + '</td>';
				col2.innerHTML = '<td><input type="text" class="periodo" name="periodo[]" style="border:0px;width:150px!important;text-align:center!important;" readonly value="'+movtos[i]["PERIODO"]+'"/></td>';
				switch (pantalla) {
    	    		case 1:
    	    		case 2:
						totUnidades = totUnidades + movtos[i]["UNIDADES"];
						totImporte = totImporte + movtos[i]["SALDO"];

			        	var col6 = row.insertCell(6);
			        	var col7 = row.insertCell(7);
			        	var col8 = row.insertCell(8);
						var checked = (movtos[i]["ACTIVO"] == 1)?'checked':'';
						if (concepto >= DEDUCCIONES) {
							col3.innerHTML = '<td><input type="text" class="descuento" name="unidades[]" style="border:0px;width:100px!important;text-align:right!important;" readonly value="'+movtos[i]["UNIDADES"]+'" /></td>';
						} else {
							col3.innerHTML = '<td><input type="text" class="importe" name="importe[]"  style="border:0px;width:100px!important;text-align:right!important;" readonly value="'+movtos[i]["UNIDADES"]+'" /></td>';
						}
						col4.innerHTML = '<td><input type="text" class="saldo" name="saldo[]"  style="border:0px;width:100px!important;text-align:right!important;" readonly value="'+movtos[i]["SALDO"]+'" /></td>';
						col5.innerHTML = '<td><input type="checkbox" class="activo" name="activo[]"  style="border:0px;width:100px!important;text-align:center!important;" readonly '+ checked +'/></td>';
						col6.innerHTML = '<td><input type="text" class="calculo" name="calculo[]" readonly value="'+movtos[i]["CALCULO"]+'" /></td>'; col6.style.display = 'none';
						col7.innerHTML = '<td><input type="text" class="fecha" name="fecha[]" style="border:0px;width:100px!important;text-align:right!important;" readonly value="'+movtos[i]["fecha"]+'"/></td>';
						col8.innerHTML = '<td class="td-actions text-center">'+
							'<a href="#" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a>'+
							'&nbsp&nbsp<a href="#" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs"><i class="fa fa-times"></i></a>'+'</td>';						
    	    			break;
    	    		case 3:
						totUnidades = totUnidades + movtos[i]["UNIDADES"];
						totImporte = totImporte + movtos[i]["CALCULO"];    	    		

						col3.innerHTML = '<td><input type="text" class="unidades" name="unidades[]" style="border:0px;width:150px!important;text-align:right!important;" readonly value="'+movtos[i]["UNIDADES"]+'"/></td>';
						col4.innerHTML = '<td><input type="text" class="calculo" name="calculo[]"  style="border:0px;width:150px!important;text-align:right!important;" readonly value="'+movtos[i]["CALCULO"]+'" /></td>';
						col5.innerHTML = '<td class="td-actions text-center">'+
							'<a href="#" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a>'+
							'&nbsp&nbsp<a href="#" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs"><i class="fa fa-times"></i></a>'+'</td>';						
						break;
    	    		case 4:
						totUnidades = totUnidades + movtos[i]["UNIDADES"];
						totImporte = totImporte + movtos[i]["CALCULO"];    	    		

						col3.innerHTML = '<td><input type="text" class="unidades" name="unidades[]" style="border:0px;width:150px!important;text-align:right!important;" readonly value="'+movtos[i]["UNIDADES"]+'"/></td>';
						col4.innerHTML = '<td><input type="text" class="calculo" name="calculo[]"  style="border:0px;width:150px!important;text-align:right!important;" readonly value="'+movtos[i]["CALCULO"]+'" /></td>'; col4.style.display = 'none';
						col5.innerHTML = '<td class="td-actions text-center">'+
							'<a href="#" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a>'+
							'&nbsp&nbsp<a href="#" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs"><i class="fa fa-times"></i></a>'+'</td>';						
						break;
    	    		case 5:
    	    			break;
       	    	}

            }
        });		
	});


    $("#Add").click(function(event){
		var nombre = $('#empleado>option:selected').text();
		var importe;
		empleado  =  $('#empleado').val();
		sueldo =  Number($('.emp').find(':selected').data('sueldo'));
		promed = Number($('.emp').find(':selected').data('promed'));
 		//descuento = $('#descuento').val();
 		fecha = $('#fecha').val();
		unidades = $('#unidades').val();
		saldo = $('#saldo').val();
		activo = $('#activo').is(':checked');
		calculo = 0; // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! Checar este valor en TISANOM !!!!!!!!!!!!!!!!!!!!!!!!!
		console.log('periodo: ' + periodo);
		console.log('empleado: ' + empleado + ', sueldo: ' + sueldo + ', promed: ' + promed);
	    console.log('pantalla: ' + pantalla + ', descuento: ' + descuento + ', unidades: ' + unidades + ', saldo: ' + saldo + ', activo: ' + activo);

		if (validaNuevo()) {
			console.log('adding input data to table');
	        var row = tabla.insertRow(tabla.rows.length);
        	var col0 = row.insertCell(0);
        	var col1 = row.insertCell(1);
        	var col2 = row.insertCell(2);
        	var col3 = row.insertCell(3);
        	var col4 = row.insertCell(4);
        	var col5 = row.insertCell(5);
	    	switch (pantalla) {
	    		case 1:
	    		case 2:
		        	var col6 = row.insertCell(6);
		        	var col7 = row.insertCell(7);
		        	var col8 = row.insertCell(8);

		        	var checked = (activo)?'checked':'';
					col0.innerHTML = '<td><input type="text" class="emp" name="emp[]" value="'+empleado+'"/></td>'; col0.style.display = 'none';
					col1.innerHTML = '<td style="text-align:left!important;">' + nombre + '</td>';					
					col2.innerHTML = '<td style="text-align:center!important;">' + periodo + '</td>';
					col3.innerHTML = '<td><input type="text" class="unidades" name="unidades[]" style="border:0px;width:100px!important;text-align:right!important;" readonly value="'+unidades+'" /></td>';
					col4.innerHTML = '<td><input type="text" class="saldo" name="saldo[]"  style="border:0px;width:150px!important;text-align:right!important;" readonly value="'+saldo+'" /></td>';
					col5.innerHTML = '<td><input type="checkbox" class="activo" name="activo[]"  style="border:0px;width:150px!important;text-align:center!important;" readonly '+ checked +'/></td>';
					col6.innerHTML = '<td><input type="text" class="calculo" name="calculo[]"  style="border:0px;width:0px!important;text-align:right!important;" readonly value="'+calculo+'" /></td>'; col6.style.display = 'none';
					col7.innerHTML = '<td><input type="text" class="fecha" name="fecha[]" style="border:0px;width:100px!important;text-align:right!important;" readonly value="'+fecha+'"/></td>';
					col8.innerHTML = '<td class="td-actions text-center">'+
						'<a href="#" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a>'+
						'&nbsp&nbsp<a href="#" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs"><i class="fa fa-times"></i></a>'+'</td>';
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

					col0.innerHTML = '<td><input type="text" class="emp" name="emp[]" value="'+empleado+'"/></td>'; col0.style.display = 'none'; 
					col1.innerHTML = '<td style="text-align:left!important;">' + nombre + '</td>';
					col2.innerHTML = '<td style="text-align:center!important;">' + periodo + '</td>';
					col3.innerHTML = '<td><input type="text" class="unidades" name="unidades[]" style="border:0px;width:150px!important;text-align:right!important;" readonly value="'+unidades+'"/></td>';	
					col4.innerHTML = '<td><input type="text" class="calculo" name="calculo[]"  style="border:0px;width:150px!important;text-align:right!important;" readonly value="'+importe+'"/></td>';
					col5.innerHTML = '<td class="td-actions text-center">'+
						'<a href="#" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a>'+
						'&nbsp&nbsp<a href="#" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs"><i class="fa fa-times"></i></a>'+'</td>';
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
			        	col0.innerHTML = '<td><input type="text" class="emp" name="emp[]" value="'+empleado+'"/></td>'; col0.style.display = 'none'; 
						col1.innerHTML = '<td style="text-align:left!important;">' + nombre + '</td>';
						col2.innerHTML = '<td><input type="text" class="periodo" name="periodo[]" style="border:0px;width:150px!important;text-align:right;" readonly value="'+periodo+'"/></td>'; col2.style.display = 'none';
						col3.innerHTML = '<td><input type="text" class="unidades" name="unidades[]" style="border:0px;width:150px!important;text-align:right;" readonly value="'+unidades+'" /></td>';
						col4.innerHTML = '<td><input type="text" class="calculo" name="calculo[]" readonly value="'+Result+'" /></td>'; col4.style.display = 'none';
						col5.innerHTML = '<td class="td-actions text-center">'+
							'<a href="#" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a>'+
							'&nbsp&nbsp<a href="#" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs"><i class="fa fa-times"></i></a>'+'</td>';						
					}
			    	break;
			    case 5:
		        	var col6 = row.insertCell(6);
		        	var col7 = row.insertCell(7);
					col0.innerHTML = '<td><input type="text" class="emp" name="emp[]" value="'+empleado+'"/></td>'; col0.style.display = 'none'; 
					col1.innerHTML = '<td style="text-align:left!important;">' + nombre + '</td>';
					col2.innerHTML = '<td><input type="text" class="periodo" name="periodo[]" style="border:0px;width:150px!important;text-align:center!important;" readonly value="'+periodo+'"/></td>';
					col3.innerHTML = '<td><input type="text" class="importe" name="unidades[]" style="border:0px;width:150px!important;text-align:right!important;" readonly value="'+unidades+'" /></td>';
					// if (concepto >= DEDUCCIONES) {
					// 	col3.innerHTML = '<td><input type="text" class="importe" name="unidades[]" style="border:0px;width:150px!important;text-align:right!important;" readonly value="'+unidades+'" /></td>';
					// } else {
					// 	col3.innerHTML = '<td><input type="text" class="importe" name="unidades[]"  style="border:0px;width:150px!important;text-align:right!important;"readonly value="'+importe+'" /></td>';
					// }
					col4.innerHTML = '<td><input type="text" class="saldo" name="saldo[]"  style="border:0px;width:150px!important;text-align:right!important;" readonly value="'+saldo+'" /></td>';
					col5.innerHTML = '<td><input type="checkbox" class="activo" name="activo[]"  style="border:0px;width:150px!important;text-align:center!important;"'+  +' /></td>';
					col6.innerHTML = '<td><input type="text" class="calculo" name="calculo[]" value="'+calculo+'" /></td>'; col6.style.display = 'none';					
					col7.innerHTML = '<td class="td-actions text-center">'+
						'<a href="#" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a>'+
						'&nbsp&nbsp<a href="#" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs"><i class="fa fa-times"></i></a>'+'</td>';
			    	break;
			}
        }
    });


	// Valida pantalla de edición y pasa los datos a la tabla
    $("#Edit").click(function(event) {
    	empleado = $('#ed_emp').val();
		if (validaEdicion(rowElem.index())) {
			switch (pantalla) {
				case 1:
					var descto = $('#ed_descuento').val();
					var saldo = $('#ed_saldo');
					var activo = $('#ed_activo');
					var fecha = $('#ed_fecha');
				    rowElem.find('td .descuento').val(descto);
				    rowElem.find('td .saldo').val(saldo);
				    rowElem.find('td .activo').val(activo);			
				    rowElem.find('td .fecha').val(date2Str(fecha));
					break;			
				case 2:
					break;
				case 3:
					break;
				case 4:
					break;
				case 5:
					break;
			}
		}
	});

	function addInputFields(action, fields) {
		fields[0].innerHTML = periodoFld[action];
		switch (pantalla) {
			case 1:
			case 2:
			    fields[0].innerHTML += unidadesFld[action];
			    fields[0].innerHTML += saldoFld[action];
			    fields[0].innerHTML += activoFld[action];
			    if (pantalla == 1) {
			    	fields[0].innerHTML += fechaFld[action];
			    }	
				break;
			case 3:
			    fields[0].innerHTML += unidadesFld[action];
				break;
			case 4:
				fields[0].innerHTML += importeFld[action];    			
				break;
			case 5:
				if (concepto >= DEDUCCIONES) {
					fields[0].innerHTML += descuentoFld[action];
				} else {
					fields[0].innerHTML += importeFld[action];
				}
				fields[0].innerHTML += saldoFld[action];
			    fields[0].innerHTML += activoFld[action];				
				break;
		}
		if (action == "Add") {
			document.getElementById("periodo").value = periodo;
		} else {
			document.getElementById("ed_periodo").value = periodo;
		}
	}


	function creaPantalla(numPantalla) {
	    while (tabla.rows.length > 0) {
	        tabla.deleteRow(tabla.rows.length-1);
		}
    	var row = tabla.insertRow(tabla.rows.length);
    	var col0 = row.insertCell(0);
    	var col1 = row.insertCell(1);
    	var col2 = row.insertCell(2);
		col0.innerHTML = '<th>Empleado</th>'; 	col0.style.display = 'none'; 
		col1.innerHTML = '<th>Nombre</th>'; 	col1.style.width = "40%"; col1.style.backgroundColor="lightgrey";
		col2.innerHTML = '<th>Período</th>';	col2.style.width = "10%"; col2.style.backgroundColor="lightgrey";
		switch (numPantalla) {
			case 1:
    			var col3 = row.insertCell(3);
    			var col4 = row.insertCell(4);
    			var col5 = row.insertCell(5);
    			var col6 = row.insertCell(6);
    			var col7 = row.insertCell(7);
    			var col8 = row.insertCell(8);
				col3.innerHTML = "<th>Descuento</th>";	col3.style.width = "10%"; 		col3.style.backgroundColor="lightgrey";
				col4.innerHTML = "<th>Saldo</th>";		col4.style.width = "10%"; 		col4.style.backgroundColor="lightgrey";
				col5.innerHTML = "<th>Activo</th>";		col5.style.width = "10%";		col5.style.backgroundColor="lightgrey";
				col6.innerHTML = '<th>Cálculo</th>'; 	col6.style.display = 'none'; 
				col7.innerHTML = "<th>Fecha</th>";		col7.style.width = "10%";		col7.style.backgroundColor="lightgrey";
				col8.innerHTML = '<th>Opciones</th>';	col8.style.width = "10%"; 		col8.style.backgroundColor="lightgrey";
				break;
			case 2:
    			var col3 = row.insertCell(3);
    			var col4 = row.insertCell(4);
    			var col5 = row.insertCell(5);
    			var col6 = row.insertCell(6);
    			var col7 = row.insertCell(7);
    			var col8 = row.insertCell(8);
    			var col9 = row.insertCell(9);
				col3.innerHTML = "<th>Descuento</th>";	col3.style.width = "8%";		col3.style.backgroundColor="lightgrey";
				col4.innerHTML = "<th>Saldo</th>";		col4.style.width = "8%";		col4.style.backgroundColor="lightgrey";
				col5.innerHTML = "<th>Desc. mes</th>";	col5.style.width = "8%";		col5.style.backgroundColor="lightgrey";
				col6.innerHTML = "<th>Plazo</th>";		col6.style.width = "8%";		col6.style.backgroundColor="lightgrey";
				col7.innerHTML = "<th>Activo</th>";		col7.style.width = "8%";		col7.style.backgroundColor="lightgrey";
				col8.innerHTML = '<th>Cálculo</th>'; 	col8.style.display = 'none'; 	col8.style.backgroundColor="lightgrey";
				col9.innerHTML = '<th>Opciones</th>';	col9.style.width = "10%"; 		col9.style.backgroundColor="lightgrey";
				break;
			case 3:
    			var col3 = row.insertCell(3);
    			var col4 = row.insertCell(4);
    			var col5 = row.insertCell(5);
				col3.innerHTML = "<th>Unidades</th>";	col3.style.width = "15%";		col3.style.backgroundColor="lightgrey";
				col4.innerHTML = "<th>Importe</th>";	col4.style.width = "15%";		col4.style.backgroundColor="lightgrey";
				col5.innerHTML = '<th>Opciones</th>';	col5.style.width = "20%"; 		col5.style.backgroundColor="lightgrey";
				break;
			case 4:
				//col2.style.display = 'none';
    			var col3 = row.insertCell(3);
    			var col4 = row.insertCell(4);
    			var col5 = row.insertCell(5);
				col3.innerHTML = "<th>Importe</th>";	col3.style.width = "20%"; 		col3.style.backgroundColor="lightgrey";
				col4.innerHTML = '<th>Cálculo</th>';	col4.style.display = 'none'; 	
				col5.innerHTML = '<th>Opciones</th>';	col5.style.width = "30%"; 		col5.style.backgroundColor="lightgrey";
				break;
			case 5:
    			var col3 = row.insertCell(3);
    			var col4 = row.insertCell(4);
    			var col5 = row.insertCell(5);
    			var col6 = row.insertCell(6);
    			var col7 = row.insertCell(7);
				if (concepto >= DEDUCCIONES) {
					col3.innerHTML = "<th>Descuento</th>";	col3.style.width = "12.5%";
				} else {
					col3.innerHTML = "<th>Importe</th>";	col3.style.width = "12.5%";

				}
				col3.style.backgroundColor="lightgrey";
				col4.innerHTML = "<th>Saldo</th>";		col4.style.width = "12.5%";		col4.style.backgroundColor="lightgrey";
				col5.innerHTML = "<th>Activo</th>";		col5.style.width = "12.5%";		col5.style.backgroundColor="lightgrey";
				col6.innerHTML = '<th>Cálculo</th>'; 	col6.style.display = 'none';
				col7.innerHTML = '<th>Opciones</th>';	col7.style.width = "12.5%"; 	col7.style.backgroundColor="lightgrey";
				break;
		}

	}


    // ASIGNA valores a los campos del modal de edicion y lanza el modal
	function editaRenglon(rowElem) {
	    document.getElementById("ed_emp").value = rowElem.find('td .emp').val();
	    document.getElementById("ed_empleado").value = rowElem.find('td:eq(1)').text();
		switch (pantalla) {
			case 1:
			    document.getElementById("ed_periodo").value = rowElem.find('td .periodo').val();
				if (concepto >= DEDUCCIONES) {
					document.getElementById("ed_descuento").value = rowElem.find('td .unidades').val();
				} else {
					document.getElementById("ed_importe").value = rowElem.find('td .importe').val();
				}			    
			    document.getElementById("ed_saldo").value = rowElem.find('td .saldo').val();
			    document.getElementById("ed_activo").value = rowElem.find('td .activo').val();
			    document.getElementById("ed_fecha").value = rowElem.find('td .fecha').val();
				break;
			case 2:
				document.getElementById("ed_descuento").value = rowElem.find('td .importe').val();
				document.getElementById("ed_saldo").value = rowElem.find('td .saldo').val();
			    document.getElementById("ed_activo").value = rowElem.find('td .activo').val();											
				break;
			case 3:
			    document.getElementById("ed_periodo").value = rowElem.find('td .periodo').val();
				document.getElementById("ed_unidades").value = rowElem.find('td .unidades').val();
				break;
			case 4:
				document.getElementById("ed_importe").value = rowElem.find('td .importe').val();
				break;
			case 5:
			    document.getElementById("ed_periodo").value = rowElem.find('td .periodo').val();
				if (concepto >= DEDUCCIONES) {
					document.getElementById("ed_descuento").value = rowElem.find('td .importe').val();
				} else {
					document.getElementById("ed_importe").value = rowElem.find('td .importe').val();
				}			    
			    document.getElementById("ed_saldo").value = rowElem.find('td .saldo').val();
			    document.getElementById("ed_activo").value = rowElem.find('td .activo').val();

	    		break;
		}
     	$("#editar").modal();		
	}	


	function validaNuevo() {
		var bOK = true;
    	if ( empleado != 0 ) {
			// Checa si ya existe el empleado en la tabla
			var rowLength = tabla.rows.length;

			for(var i=1; i<rowLength; i+=1){
			  var row = tabla.rows[i];

			  if (row.cells[0].firstChild.value == empleado) {
			  		alert('Ese empleado ya existe en la lista!');
			  		return false;
			  }
			}			
		} else {
           alert('No se capturó el empleado!');
           return false;
        }		
		switch (pantalla) {
			case 1:
				break;
			case 2:
		    	if ( descuento == 0 ) {	
		           alert('No ha capturado el importe del descuento!');
		           bOK = false;
		        }
				break;
			case 3:
				bOK = (unidades != 0);
				break;
			case 5:
				break;
		}
		return bOK;
	}


	// valida datos editados
	function validaEdicion(rowNum) {
		var bOK = true;
		var rowLength = tabla.rows.length;
		var descuento = $('#ed_descuento').val();
		var unidades = $('#ed_unidades').val();
		var importe = $('#ed_importe').val();

		// // Checa si ya existe el empleado con la misma fecha
		// for(var i=1; i<rowLength; i+=1){
		//     var row = tabla.rows[i];

		//     if (row.cells[0].firstChild.value == empleado) {
		//     	if (rowNum != i) {
		//     		// No es el renlglon que se esta editando ?
		// 	  	}
		// 	}
		// }

		switch (pantalla) {
			case 1:
				break;
			case 2:
		    	if ( descuento == 0 ) {	
		           alert('No ha capturado el importe del descuento!');
		           bOK = false;
		        }
				break;
			case 3:
				bOK = (unidades != 0);
				break;
			case 5:
				break;
		}
        return bOK;
	}		
</script>            
@endsection 