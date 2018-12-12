@extends('layouts.app')

@section('title','Horas Extra')
@section('body-class','')

@section('content')
{!! Session::get("message", '') !!}
<div class="container" style="border:1px red solid;">
    <h3>Horas Extra</h3>
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
    <form class="form" method="POST" action="{{ url('transacciones/horasExtra') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" id="Concepto"  name="Concepto" value="{{ $concepto->CONCEPTO }}">
		<!-- input type="hidden" id="Metodo"  name="Metodo" value="">
		<input type="hidden" id="MetodoISP"  name="MetodoISP" value="" -->

        <!-- <p class="text-center" style="color:Azure; text-align: center;">Ingresa tus datos</p> -->
        <div class="row" style="margin-bottom: 0px;">
            <div class="col-md-6 col-md-offset-3">
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
        			<th style="width:0%; display:none;">Empleado</th>
        			<th style="width:40%;text-align: center;">Nombre</th>
        			<!-- <th style="width:12%;text-align: center;">Suplencia</th> -->
        			<th style="width:12%;">Fecha</th>
        			<th style="width:12%;text-align: center;">Unidades</th>
        			<th style="width:14%;">Cuenta</th>
                    <th style="width:10%;text-align: center;">Acciones</th>
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
<!--                 <div class="col-md-4 col-md-offset-4 text-center">
                    <div class="form-group checkbox">
                        <label>
                            <input type="checkbox" id="suplencia" name="Suplencia">
                            Suplencia
                        </label>
                    </div>
                </div>  -->           	
				<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
        			<label class="label-left" style="font-size: 14px;">Fecha</label>
        			<input type="date" id="fecha" name="Fecha" value="">
        		</div>
				<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
    				<label class="label-left" style="font-size: 14px;">Unidades</label>
    				<input type="text" id="unidades" name="Unidades" value="">
				</div>
				<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
    				<label class="label-left" style="font-size: 14px;">Cuenta</label>
    				<input type="text" id="cuenta" name="Cuenta" value="">
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
            <input type="hidden" id="ed_emp" name="emp" value="">
            <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                <label class="label-left" style="font-size: 14px;">Empleado</label>
                <input type="text" id="ed_empleado" name="Nombre" readonly value="">
            </div> 
            <div class="input-data">
<!--                 <div class="col-md-4 col-md-offset-4 text-center">
                    <div class="form-group checkbox">
                        <label>
                            <input type="checkbox" id="ed_suplencia" name="Suplencia">
                            Suplencia
                        </label>
                    </div>
                </div>  -->             
                <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                    <label class="label-left" style="font-size: 14px;">Fecha</label>
                    <input type="date" id="ed_fecha" name="Fecha" value="">
                </div>
                <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                    <label class="label-left" style="font-size: 14px;">Unidades</label>
                    <input type="text" id="ed_unidades" name="Unidades" value="">
                </div>
                <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                    <label class="label-left" style="font-size: 14px;">Cuenta</label>
                    <input type="text" id="ed_cuenta" name="Cuenta" value="">
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

    var fecha;
    var tabla;
    var token;
    var cuenta;
	var metodo;	
	var metodoIsp;
	var pantalla;
	var concepto;
	var periodo;
	var empleado;
	var sueldo;
    var unidades;
    var suplencia;
	var tipConcep;
	var varClave;
	var fechaIncidencia;


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
        concepto  = $('#Concepto').val();
        fechaIncidencia = document.getElementById("fecha");
		console.log('here we are. Concepto: '+ concepto +', token is: ' + token);
    });


    // período change
    $('.pdo').change(function() {
        periodo = $('.pdo').val();
        // checa si hay movimientos capturados del período en cuyo caso los despliega
        totUnidades = 0;
        totImporte = 0;
        $("body").css("cursor", "wait");
        $.post("get-movesp", { concepto: concepto, periodo: periodo, _token: token }, function( data ) {
            $("body").css("cursor", "default");
            var movtos = Object.values(data);
            console.log(movtos);
            despliegaDatos(movtos);
        });    
    });


    $("#btnNuevo").click(function(){
		periodo = $('.pdo').val(); 
    	if ( periodo != 0 ) {
			// alert(periodo + ' - ' + fechaIni + fechaIncidencia.value);
			fechaIncidencia.value = $('.pdo>option:selected').data('fi');
        	$("#nuevo").modal();
        } else {
           alert('No ha seleccionado un concepto o período!');
        }
    });


    // Toma los valores de la pantalla modal (recien capturada) y 
    // los inserta en la tabla
    $("#Add").click(function(event) {
		var nombre = $('#empleado>option:selected').text();
		empleado  = $('#empleado>option:selected').val();  //$('.emp').val();
		sueldo =  Number($('.emp').find(':selected').data('sueldo'));
        unidades = $('#unidades').val();
        fecha = $('#fecha').val();
        cuenta = $('#cuenta').val();
        //suplencia = $('#suplencia').is(':checked');

		if (validaPantalla()) {

        	var row = tabla.insertRow(tabla.rows.length);
        	var col1 = row.insertCell(0);
        	var col2 = row.insertCell(1);
       	    var col3 = row.insertCell(2);
        	var col4 = row.insertCell(3);
        	var col5 = row.insertCell(4);
        	var col6 = row.insertCell(5);

            // _checked = (suplencia)?'checked':'';
			col1.innerHTML = '<td><input type="text" class="emp" name="emp[]" value="'+empleado+'"/></td>'; col1.style.display = 'none'; 
            col2.innerHTML = '<td style="text-align:left!important;">' + nombre + '</td>';
			// col3.innerHTML = '<td><input type="checkbox" class="suplencia" name="suplencia[]" '+_checked+' style="border:0px;width:150px!important;" value="'+suplencia+'"/></td>'; 
			col3.innerHTML = '<td><input type="text" name="fecha[]" class="fecha" style="border:0px;width:150px!important;" value="'+fecha+'"/></td>'; 
			col4.innerHTML = '<td><input type="text" class="unidades" name="unidades[]" style="text-align:center;border:0px;width:150px!important;" value="'+unidades+'"/></td>'; 
			col5.innerHTML = '<td><input type="text" class="cuenta" name="cuenta[]" style="border:0px;width:150px!important;" value="'+cuenta+'"/></td>';
            col6.innerHTML = '<td class="td-actions text-center">'+
                '<a href="#" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a>'+
                '&nbsp&nbsp<a href="#" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs"><i class="fa fa-times"></i></a>'+'</td>';
        }
    });


    $("#Edit").click(function(event) {
        empleado = $('#ed_emp').val();
        //suplencia = $('#ed_suplencia').is(':checked');
        unidades = $('#ed_unidades').val();
        fecha = $('#ed_fecha').val();
        cuenta = $('#ed_cuenta').val();
        row_index = rowElem.index();

        if (validaEdicion(row_index, empleado, fecha, unidades)) {
            //rowElem.find('td .suplencia').checked = suplencia;
            rowElem.find('td .fecha').val(fecha);
            rowElem.find('td .unidades').val(unidades);            
            rowElem.find('td .cuenta').val(cuenta);         
        }
    });


    // EDITA el renglón
    $('#captura').on('click', '.btn-success', function () {
        rowElem = $(this).closest("tr");

        // asigna valores a los campos del modal de edicion
        document.getElementById("ed_emp").value = rowElem.find('td .emp').val();
        document.getElementById("ed_empleado").value = rowElem.find('td:eq(1)').text();
        //document.getElementById("ed_suplencia").value = rowElem.find('td .suplencia').val();
        document.getElementById("ed_fecha").value = rowElem.find('td .fecha').val();
        document.getElementById("ed_unidades").value = rowElem.find('td .unidades').val();
        document.getElementById("ed_cuenta").value = rowElem.find('td .cuenta').val();
        $("#edit").modal();
    });


    $('#captura').on('click', '.btn-danger', function () {
        rowElem = $(this).closest("tr");
        tabla.deleteRow(rowElem.index());
    });        


    function despliegaDatos(movtos) {
        // limpia la tabla para desplegar los movtos leidos
        while (tabla.rows.length > 1) {
            tabla.deleteRow(tabla.rows.length-1);
        }
        // Aqui los despliega !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        for (var i = 0; i < movtos.length; i++) {
            var row = tabla.insertRow(tabla.rows.length);
            var col1 = row.insertCell(0);
            var col2 = row.insertCell(1);
            var col3 = row.insertCell(2);
            var col4 = row.insertCell(3);
            var col5 = row.insertCell(4);
            var col6 = row.insertCell(5);
            //var col7 = row.insertCell(6);

            var fechaParts = movtos[i]["FECHA"].substr(0,10).split('-');
            var theDate = new Date(fechaParts[0], fechaParts[1] - 1, fechaParts[2]);
            var fechaStr = fechaParts[2] + '-' + fechaParts[1] + '-' + fechaParts[0];

            // NO SABEMOS DONDE GUARDA ESTE VALOR !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            // var _checked = (movtos[i]["SUPLENCIA"] == 1)?'checked':'';
            //_checked = false;
            col1.innerHTML = '<td><input type="text" class="emp" name="emp[]" value="'+movtos[i]["EMP"]+'"/></td>'; col1.style.display = 'none'; 
            col2.innerHTML = '<td style="text-align:left!important;">' + movtos[i]["NOMBRE"] + '</td>';
            //col3.innerHTML = '<td><input type="checkbox" class="suplencia" name="suplencia[]" '+_checked+' style="border:0px;width:150px!important;" value="'+suplencia+'"/></td>'; 
            col3.innerHTML = '<td><input type="text" name="fecha[]" class="fecha" style="border:0px;width:150px!important;" value="'+fechaStr+'"/></td>'; 
            col4.innerHTML = '<td><input type="text" class="unidades" name="unidades[]" style="text-align:center;border:0px;width:150px!important;" value="'+movtos[i]["UNIDADES"]+'"/></td>'; 
            col5.innerHTML = '<td><input type="text" class="cuenta" name="cuenta[]" style="border:0px;width:150px!important;" value="'+movtos[i]["CUENTA"]+'"/></td>';
            col6.innerHTML = '<td class="td-actions text-center">'+
                '<a href="#" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a>'+
                '&nbsp&nbsp<a href="#" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs"><i class="fa fa-times"></i></a>'+'</td>';
        }
    }

    // valida datos nuevos
    function validaPantalla() {
        var bOK = true;
        var rowLength = tabla.rows.length;
        if ( empleado != 0 ) {
            // Checa si ya existe el empleado con la misma fecha
            for(var i=1; i<rowLength; i+=1){
                var row = tabla.rows[i];

                if (row.cells[0].firstChild.value == empleado) {
                    console.log(row + ' - ' + row.cells[0].firstChild.value + ' - ' + empleado)                    
                    var fechaStr = date2Str(fecha);
                    var fechaIni = stringToDate(row.cells[2].firstChild.value,"dd-mm-yyyy","-");
                    var fechaFin = fechaIni;
                    fechaFin = new Date(fechaFin.getFullYear(),fechaFin.getMonth(),fechaFin.getDate()+parseInt(row.cells[3].firstChild.value));                     
                    if (row.cells[2].firstChild.value == fechaStr) {
                        alert('Ya existe esa fecha en la lista!');
                        bOK = false;
                    }
                }
            }
        } else {
           alert('No ha capturado el empleado!');
           bOK = false;
        }
        if (unidades <= 0) {
            alert('No ha capturado las unidades!');
            bOK = false;
        }               
        return bOK;        
    }

    // valida datos editados
    function validaEdicion(rowNum) {
        var bOK = true;
        var rowLength = tabla.rows.length;

        if (unidades <= 0) {
            alert('No ha capturado las unidades!');
            bOK = false;
        }
        return bOK;
    }
</script>            
@endsection 