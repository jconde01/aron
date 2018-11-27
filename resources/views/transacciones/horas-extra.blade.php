@extends('layouts.app')

@section('title','Horas Extra')
@section('body-class','')

@section('content')
{!! Session::get("message", '') !!}
<div class="container" style="border:1px red solid;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>                    
        </div>
    @endif   	
    <form class="form" method="POST" action="{{ url('transacciones/horasExtra') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" id="Concepto"  name="Concepto" value="{{ $concepto }}">
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
        			<th style="width:50%;text-align: center;">Nombre</th>
        			<th style="width:12%;text-align: center;">Suplencia</th>
        			<th style="width:12%;">Fecha</th>
        			<th style="width:12%;text-align: center;">Unidades</th>
        			<th style="width:14%;">Cuenta</th>
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
                <div class="col-md-4 col-md-offset-4 text-center">
                    <div class="form-group checkbox">
                        <label>
                            <input type="checkbox" id="suplencia" name="Suplencia">
                            Suplencia
                        </label>
                    </div>
                </div>            	
				<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
        			<label class="label-left" style="font-size: 14px;">Fecha</label>
        			<input type="date" id="fecha" name="Fecha" value="{{ date("Y-m-d") }}">
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
@include('includes.footer')
@endsection
@section('jscript')
<script type="text/javascript">

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

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
	    //creaPantalla();
	    fechaIncidencia = document.getElementById("fecha");
	});

    $("#btnNuevo").click(function(){
		concepto  = $('.cpto').val();
		periodo   = $('.pdo').val(); 
    	if ( concepto != 0 && periodo != 0 ) {
			var fechaIni = $('.pdo>option:selected').data('fi');
			// alert(periodo + ' - ' + fechaIni + fechaIncidencia.value);
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

        bOK = validaPantalla();

		if (bOK) {
			var qty = $('#unidades').val();
			var fecha = $('#fecha').val();
			var cuenta = $('#cuenta').val();
			var suplencia = $('#suplencia').val();
			_checked = (suplencia == 'on')? 'checked':'';
			//alert(suplencia + ' - ' + _checked);
	    	if ( qty != 0 ) {
	        	var row = tabla.insertRow(tabla.rows.length);
	        	var col1 = row.insertCell(0);
	        	var col2 = row.insertCell(1);
	        	var col3 = row.insertCell(2);
	        	var col4 = row.insertCell(3);
	        	var col5 = row.insertCell(4);
	        	var col6 = row.insertCell(5);

				col1.innerHTML = '<td><input type="text" name="emp[]" value="'+empleado+'"/></td>'; col1.style.display = 'none'; 
				col2.innerHTML = '<td>' + nombre + '</td>';
				col3.innerHTML = '<td><input type="checkbox" name="suplencia[]" '+_checked+' style="border:0px;width:150px!important;" value="'+suplencia+'"/></td>'; 
				col4.innerHTML = '<td><input type="text" name="fecha[]" style="border:0px;width:150px!important;" value="'+fecha+'"/></td>'; 
				col5.innerHTML = '<td><input type="text" name="unidades[]" style="text-align:center;border:0px;width:150px!important;" value="'+qty+'"/></td>'; 
				col6.innerHTML = '<td><input type="text" name="cuenta[]" style="border:0px;width:150px!important;" value="'+cuenta+'"/></td>'; 

	        } else {
	           alert('No ha capturado las unidades!');
	        }			    
        }
    });


	// período change
	$('.pdo').change(function() {
		concepto  =  $('.cpto').val();
		periodo = $('.pdo').val();
    	// checa si hay movimientos capturados del período en cuyo caso los despliega
        $.post("get-movtos", { concepto: concepto, periodo: periodo, _token: token }, function( data ) {
            var movtos = Object.values(data);
    		//console.log(movtos);	
		    while (tabla.rows.length > 1) {
		        tabla.deleteRow(tabla.rows.length-1);
    		}
        });		
	});

    function validaPantalla() {
        var bOK = true;
        if ( empleado != 0 ) {
            // Checa si ya existe el empleado en la tabla
            if ($("table#captura tr").length > 1) {
                $.each($("table#captura tr td"), function(index, cell) {
                    if (index > 0) {
                        var celda = $(cell);
                        // alert($(cell).innerHTML);
                        console.log(celda.val());
                        alert('El empleado ya existe en la lista!');
                        bOK = false;
                    }
                });
            }
        } else {
           alert('No ha capturado el empleado!');
           bOK = false;
        }
        return bOK;        
    }

</script>            
@endsection 