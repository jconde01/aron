@extends('layouts.app')

@section('title','Ausentismo / Incapacidad')
@section('body-class','')

@section('content')
<!-- {!! Session::get("message", '') !!} -->
<div class="container" style="border:1px grey solid;">
	<h3>Incidencias por incapacidad</h3>
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
                        <option value="{{ $emp->RFC }}" data-sexo="{{ $emp->SEXO }}" data-sueldo="{{ $emp->SUELDO }}" data-promed="{{ $emp->PROMED }}" >{{ $emp->NOMBRE }}</option>
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
    				<input type="text" id="refIMSS" name="RefIMSS" pattern="[A-Za-z]{2}[0-9]{6}" title="Formato: AA999999" value="">
				</div>
				<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
    				<label class="label-left" style="font-size: 14px;">Tipo de Incapacidad</label>
    				<input type="text" id="tipo" name="Tipo" readonly value="">
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
<div class="modal fade" id="edit" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edite los campos y presione OK</h4>
        </div>
        <div class="modal-body">
            <div class="input-data">
            	<input type="hidden" id="ed_emp" name="emp" value="">
				<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
        			<label class="label-left" style="font-size: 14px;">Empleado</label>
        			<input type="text" id="ed_empleado" name="Nombre" readonly value="">
        		</div>
				<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
        			<label class="label-left" style="font-size: 14px;">Fecha</label>
        			<input type="date" id="ed_fecha" name="Fecha" value="">
        		</div>
				<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
    				<label class="label-left" style="font-size: 14px;">Dias</label>
    				<input type="text" id="ed_dias" name="Dias" value="">
				</div>
				<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
    				<label class="label-left" style="font-size: 14px;">Ref. IMSS</label>
    				<input type="text" id="ed_refIMSS" name="RefIMSS" pattern="[A-Za-z]{2}[0-9]{6}" value="">
				</div>
				<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
    				<label class="label-left" style="font-size: 14px;">Tipo de Incapacidad</label>
    				<input type="text" id="ed_tipo" name="Tipo" readonly value="">
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

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	// INCAPACIDADES
	const MATERNIDAD = "400";
	const TRANSITO = "401";
	const ENFERMEDAD_PROF = "402";
	const ACCIDENTE = "403";
	const ENFERMEDAD_GRAL = "404";
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

	var dias;
	var sexo;
	var tipo;
	var fecha;
	var tabla;
	var token;
	var metodo;
	var refIMSS;	
	var metodoIsp;
	var pantalla;
	var concepto;
	var periodo;
	var rowElem
	var empleado;
	var sueldo;
	var tipConcep;
	var varClave;
	var totUnidades;
	var fechaIncidencia;
	var pideFolioIMMS = [MATERNIDAD, TRANSITO, ENFERMEDAD_PROF, ACCIDENTE, ENFERMEDAD_GRAL];


	function date2Str(fecha) {
		// fecha en formato YYYY-MM-DD
		var fechaParts = fecha.substr(0,10).split('-');
		// DD-MM-YYYY
		return fechaParts[2] + '-' + fechaParts[1] + '-' + fechaParts[0];	
	}

	function stringToDate(_date,_format,_delimiter)
	{
        var formatLowerCase=_format.toLowerCase();
        var formatItems=formatLowerCase.split(_delimiter);
        var dateItems=_date.split(_delimiter);
        var monthIndex=formatItems.indexOf("mm");
        var dayIndex=formatItems.indexOf("dd");
        var yearIndex=formatItems.indexOf("yyyy");
        var month=parseInt(dateItems[monthIndex]);
        month-=1;
        var formatedDate = new Date(dateItems[yearIndex],month,dateItems[dayIndex]);
        return formatedDate;
	}	


	$(document).ready(function() {
		token = $('input[name=_token]').val();
    	tabla = this.getElementById("captura");
	    creaPantalla();
	    totUnidades = 0;
	    // dias = document.getElementById("dias");
	    fechaIncidencia = document.getElementById("fecha");
	    // refIMSS = document.getElementById("refIMSS");

	    // evento que se dispara al presionar el boton de 'Editar' un renglon
	    // obtiene loa datos de la tabla, los inserta en el modal y lo despliega 
		$('#captura tbody').on('click', '.btn-success', function () {
		    rowElem = $(this).closest("tr");
		    //var row_index = rowElem.index();
		    //var col_index = $(this).index();

		    // asigna valores a los campos del modal de edicion
		    document.getElementById("ed_emp").value = rowElem.find('td .emp').val();
		    document.getElementById("ed_empleado").value = rowElem.find('td:eq(1)').text();
		    document.getElementById("ed_dias").value = rowElem.find('td .dias').val();
		    document.getElementById("ed_fecha").value = date2Str(rowElem.find('td .fecha').val());
			// Si no es una Incapacidad, 
			// Elimina del modal de captura los camps de RefIMSS y Tipo
			if (!pideFolioIMMS.includes(concepto)) {
				$("#edit .input-data .form-group")[3].innerHTML = '';
				$("#edit .input-data .form-group")[4].innerHTML = '';
			} else {	    
		    	document.getElementById("ed_refIMSS").value = rowElem.find('td .refIMSS').val();
		    	document.getElementById("ed_tipo").value = rowElem.find('td .tipo').val();
		    }
	     	$("#edit").modal();
		});

		// evento para borrar un renglon al presionar el boton de 'eliminar'
		$('#captura tbody').on('click', '.btn-danger', function () {
		    rowElem = $(this).closest("tr");
		    tabla.deleteRow(rowElem.index());
		});			
	});


	// Evento disparado al presionar el boton de 'Agregar empleado'
	// prepara el modal para capturar los datos y lo despliega
	$("#btnNuevo").click(function(){
		concepto  = $('.cpto').val();
		periodo   = $('.pdo').val(); 
    	if ( concepto != 0 && periodo != 0 ) {
    		$('#empleado').val('');
    		$('#dias').val(0);
    		$('#refIMSS').val('');
    		$('#tipo').val('');
    		// Toma la fecha inicial del período
			var fechaIni = $('.pdo>option:selected').data('fi');
			fechaIncidencia.value = fechaIni;
			// Si no es una Incapacidad, 
			// Elimina del modal de captura los camps de RefIMSS y Tipo
			if (!pideFolioIMMS.includes(concepto)) {
				$("#nuevo .input-data .form-group")[2].innerHTML = '';
				$("#nuevo .input-data .form-group")[3].innerHTML = '';
			} else {
				switch (concepto) {
					case MATERNIDAD:
						$('#tipo').val('MA');
						break;
					case TRANSITO:
						$('#tipo').val('TR');
						break;
					case ENFERMEDAD_PROF:
						$('#tipo').val('EP');
						break;
					case ACCIDENTE:
						$('#tipo').val('AT');
						break;
					case ENFERMEDAD_GRAL:
						$('#tipo').val('EG');
						break;
				}			
			}			
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
		empleado  =  $('#empleado').val();
		sueldo =  Number($('#empleado').find(':selected').data('sueldo'));
		sexo = $('#empleado').find(':selected').data('sexo');
		dias = parseInt($('#dias').val());
		fecha = $('#fecha').val();
		refIMSS = '';
		tipo = '';
		if (pideFolioIMMS.includes(concepto)) {
			refIMSS = $('#refIMSS').val();
			//tipo = $('#tipo>option:selected').val();
			tipo = $('#tipo').val();
		}

		if (validaNuevo()) {
			var fechaStr = date2Str(fecha);			
        	var row = tabla.insertRow(tabla.rows.length);
        	var col1 = row.insertCell(0);
        	var col2 = row.insertCell(1);
        	var col3 = row.insertCell(2);
        	var col4 = row.insertCell(3);
        	var col5 = row.insertCell(4);
        	var col6 = row.insertCell(5);
        	var col7 = row.insertCell(6);        	

			col1.innerHTML = '<td><input type="text" class="emp" name="emp[]" value="'+empleado+'"/></td>'; col1.style.display = 'none';
			col2.innerHTML = '<td style="text-align:left!important;">' + nombre + '</td>';
			col3.innerHTML = '<td><input type="text" class="fecha" name="fecha[]" style="border:0px;width:150px!important;" readonly value="'+fechaStr+'"/></td>'; 
			col4.innerHTML = '<td><input type="text" class="dias" name="dias[]" style="border:0px;width:100px!important;text-align:right!important;" readonly value="'+dias+'"/></td>';			
			col5.innerHTML = '<td><input type="text" class="refIMSS" name="refIMSS[]" style="border:0px;width:150px!important;" readonly value="'+refIMSS+'"/></td>'; 
			col6.innerHTML = '<td><input type="text" class="tipo" name="tipo[]" style="border:0px;width:150px!important;" readonly value="'+tipo+'"/></td>'; 
			col7.innerHTML = '<td class="td-actions text-center">'+
					'<a href="#" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a>'+
					'&nbsp&nbsp<a href="#" rel="tooltip" id="delete" title="Eliminar" class="btn btn-danger btn-simple btn-xs"><i class="fa fa-times"></i></a>'+'</td>';
        }
    });


    // evento disparado cuando se selecciona un concepto de ausentismo o incapacidad
    // ejecuta un Ajax para obtener los parametros pertinentes al concepto
	$('.cpto').change(function() {
		var conceptData;
		var tipoCaptura;

		concepto = $('.cpto').val();
		$("body").css("cursor", "wait");		
        $.post("get-concepto", { concepto: concepto, _token: token }, function( data ) {
        	$("body").css("cursor", "default");
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
				case MATERNIDAD:
				case TRANSITO:
				case ENFERMEDAD_PROF:
				case ACCIDENTE:
				case ENFERMEDAD_GRAL:
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
	// ejecuta un ajax para obtener los datos de los empleados guardados
	// para este concepto y periodo
	$('.pdo').change(function() {
		concepto  =  $('.cpto').val();
		periodo = $('.pdo').val();
		$("body").css("cursor", "wait");
		//alert('concepto: '+concepto+ ' - Periodo: '+periodo+ ' - Token: '+ token);
    	// checa si hay movimientos capturados del período en cuyo caso los despliega
        $.post("get-from-imss", { concepto: concepto, periodo: periodo, _token: token }, function( data ) {
        	$("body").css("cursor", "default");
            var movtos = Object.values(data);
    		console.log(movtos);	
		    while (tabla.rows.length > 1) {
		        tabla.deleteRow(tabla.rows.length-1);
    		}
    		// Aqui los despliega 
    	    for (var i = 0; i < movtos.length; i++) {
				var fechaParts = movtos[i]["FECHA"].substr(0,10).split('-');
				var theDate = new Date(fechaParts[0], fechaParts[1] - 1, fechaParts[2]);
				var fechaStr = fechaParts[2] + '-' + fechaParts[1] + '-' + fechaParts[0];
	        	var row = tabla.insertRow(tabla.rows.length);

				totUnidades = totUnidades + movtos[i]["DIAS"];
				movtos[i]["TIPO"] = (movtos[i]["TIPO"] == null)? "" : movtos[i]["TIPO"];
				movtos[i]["DIAS"] = parseInt(movtos[i]["DIAS"]);

				var col1 = row.insertCell(0);
	        	var col2 = row.insertCell(1);
	        	var col3 = row.insertCell(2);
	        	var col4 = row.insertCell(3);
	        	var col5 = row.insertCell(4);
	        	var col6 = row.insertCell(5);
	        	var col7 = row.insertCell(6);

				col1.innerHTML = '<td><input type="text" class="emp" name="emp[]" value="'+movtos[i]["RFC"]+'"/></td>'; col1.style.display = 'none';
				col2.innerHTML = '<td style="text-align:left!important;">' + movtos[i]["NOMBRE"] + '</td>';
				col3.innerHTML = '<td><input type="text" class="fecha" name="fecha[]" style="border:0px;width:150px!important;" readonly value="'+fechaStr+'"/></td>'; 
				col4.innerHTML = '<td><input type="text" class="dias" name="dias[]" style="border:0px;width:100px!important;text-align:right!important;" readonly value="'+movtos[i]["DIAS"]+'"/></td>';
				col5.innerHTML = '<td><input type="text" class="refIMSS" name="refIMSS[]" style="border:0px;width:150px!important;" readonly value="'+movtos[i]["REFIMSS"]+'"/></td>'; 
				col6.innerHTML = '<td><input type="text" class="tipo" name="tipo[]" style="border:0px;width:150px!important;" readonly value="'+movtos[i]["TIPO"]+'"/></td>';
				col7.innerHTML = '<td class="td-actions text-center">'+
					'<a href="#" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a>'+
					'&nbsp&nbsp<a href="#" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs"><i class="fa fa-times"></i></a>'+'</td>';
            }
        });		
	});


    $("#Edit").click(function(event) {
    	var emp = $('#ed_emp').val();
		var dias = $('#ed_dias').val();
		var fecha = $('#ed_fecha').val();
		var refIMSS = $('#ed_refIMSS').val();
		//var tipo = $('#ed_tipo>option:selected').val();
		var tipo = $('#ed_tipo').val();
		var row_index = rowElem.index();
		//console.log(row_index);

		if (validaEdicion(row_index, emp, dias, fecha, refIMSS)) {
		    rowElem.find('td .dias').val(dias);
		    rowElem.find('td .fecha').val(date2Str(fecha));
		    rowElem.find('td .refIMSS').val(refIMSS);
		    rowElem.find('td .tipo').val(tipo);			
		}
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

		col1.innerHTML = '<th>Empleado</th>'; 	col1.style.display = 'none';
		col2.innerHTML = '<th>Nombre</th>'; 	col2.style.width = "50%"; col2.style.backgroundColor="lightgrey";
		col3.innerHTML = '<th>Fecha</th>'; 		col3.style.width = "10%"; col3.style.backgroundColor="lightgrey";
		col4.innerHTML = '<th>Dias</th>'; 		col4.style.width = "10%"; col4.style.backgroundColor="lightgrey";
		col5.innerHTML = '<th>Ref. IMSS</th>'; 	col5.style.width = "10%"; col5.style.backgroundColor="lightgrey";
		col6.innerHTML = '<th>Tipo</th>'; 		col6.style.width = "10%"; col6.style.backgroundColor="lightgrey";
		col7.innerHTML = '<th>Opciones</th>';	col7.style.width = "10%"; col7.style.backgroundColor="lightgrey";
	}

	function validaNuevo() {
		var bOK = true;
		var rowLength = tabla.rows.length;

    	if ( empleado != '' ) {
			// Checa si ya existe el empleado con la misma fecha
			for(var i=1; i<rowLength; i+=1){
			    var row = tabla.rows[i];
				console.log(row + ' - ' + row.cells[0].firstChild.value + ' - ' + empleado)
			    if (row.cells[0].firstChild.value == empleado) {
			    	
					var fechaStr = date2Str(fecha);
					var fechaIni = stringToDate(row.cells[2].firstChild.value,"dd-mm-yyyy","-");
					var fechaFin = fechaIni;
					fechaFin = new Date(fechaFin.getFullYear(),fechaFin.getMonth(),fechaFin.getDate()+parseInt(row.cells[3].firstChild.value));				    	
			  		if (row.cells[2].firstChild.value == fechaStr) {
			  			alert('Ya existe esa fecha en la lista!');
			  			bOK = false;
			  		}
			  		// obtiene la fecha capturada y la compara con los datos del renglon actual
			  		curDate = stringToDate(fechaStr,"dd-mm-yyyy","-");
			  		//alert(curDate + ' - ' + fechaIni+' - '+ fechaFin);
			  		if (curDate > fechaIni && curDate < fechaFin) {
			  			alert('Esa fecha está comprendida en el evento capturado en el renglon # '+i);
			  			bOK = false;
			  		}
			  	}
			}
	    	if ( dias == 0 || isNaN(dias)) {
	           alert('No se capturó el número de dias!');
	           bOK = false;
	        }
	        // Si es MATERNIDAD, debe ser de sexo FEMENINO (F)
	        if (concepto == MATERNIDAD) {
	        	if (sexo != 'F') {
	        		alert('Este concepto solo aplica a empleados de sexo FEMENINO');
	        		bOK = false;
	        	}
	        }
	        // verifica que la referencia no haya sido capturada previamente
	        if (refIMSS != '') {
		        for(var i=1; i<rowLength; i+=1){
					var row = tabla.rows[i];
		        	if (row.cells[4].firstChild.value == refIMSS) {
						alert('Ya existe esa referencia en la lista!');
						bOK = false;
					}
				}	        	
	        }
	        // verifica que se haya capturado una referencia o folio de Incapacidad
	        if (pideFolioIMMS.includes(concepto)) {
	        	if (refIMSS == '') {
	        		alert('Debe capturar el folio de Incapacidad!');
	        		bOK = false;
	        	}
	        }

		} else {
           alert('No se capturó el empleado!');
           bOK = false;
        }
        return bOK;
	}

	function validaEdicion(rowNum, emp, dias, fecha, refIMSS) {
		var bOK = true;
		var rowLength = tabla.rows.length;

		// Checa si ya existe el empleado con la misma fecha
		for(var i=1; i<rowLength; i+=1){
		    var row = tabla.rows[i];

	        // verifica que la referencia no haya sido capturada
	        if (refIMSS != '' ) {
		        for(var i=1; i<rowLength; i+=1){
					var row = tabla.rows[i];
		        	if (row.cells[4].firstChild.value == refIMSS && rowNum != i) {
						alert('Ya existe esa referencia en la lista!');
						bOK = false;
					}
				}
			}
		    if (row.cells[0].firstChild.value == emp) {

		    	if (rowNum != i) {
					var fechaStr = date2Str(fecha);
					var fechaIni = stringToDate(row.cells[2].firstChild.value,"dd-mm-yyyy","-");
					var fechaFin = fechaIni;
					fechaFin = new Date(fechaFin.getFullYear(),fechaFin.getMonth(),fechaFin.getDate()+parseInt(row.cells[3].firstChild.value));						
			  		if (row.cells[2].firstChild.value == fechaStr && rowNum != i) {
			  			alert('Ya existe esa fecha en la lista!');
			  			bOK = false;
			  		}

			  		// obtiene la fecha capturada y la compara con los datos del renglon actual
			  		curDate = stringToDate(fechaStr,"dd-mm-yyyy","-");
			  		//alert(curDate + ' - ' + fechaIni+' - '+ fechaFin);
			  		if (curDate > fechaIni && curDate < fechaFin) {
			  			alert('Esa fecha está comprendida en el evento capturado en el renglon # '+i);
			  			bOK = false;
			  		}		  		
			  	}
			}
		}
    	if ( dias == 0 || isNaN(dias)) {
           alert('No se capturó el número de dias!');
           bOK = false;
        }

        return bOK;
	}	
</script>            
@endsection 