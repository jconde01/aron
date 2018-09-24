@extends('layouts.app')

@section('title','Seleccionar Empresa y Tipo de Nómina')
@section('body-class','')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3" style="border:1px red solid;">
            <form class="form" method="POST" action="{{ url('sistema/set-session-data') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="articulo text-center">Seleccione:</div>
                <br>
                <!-- <p class="text-center" style="color:Azure; text-align: center;">Ingresa tus datos</p> -->
                <div class="content">
                    <div class="row">
                        <div class="form-group label-floating">
                            <label class="control-label">Cliente:</label>
                            <select class="form-control cia" id="tisanom_cia" name="Tisanom_cia">
                                <option value="0" selected>Seleccione un cliente...</option>
                                @foreach ($clientes as $cia)
                                    <option value="{{ $cia->id }}">{{ $cia->Nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
	                    <div class="row">
                        <div class="form-group label-floating">
                            <label class="control-label">Proceso:</label>
							<select id="procesos" name="proceso"></select>
						</div>
                    </div>
                </div>
                <div class="row text-center">
                    <button type="submit" class="primario">Ingresar</button>
                </div>
            </form>
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
	$(document).ready(function() {
		var token = $('input[name=_token]').val();		
		console.log('here we are. The token is: ' + token);
	});

	$('.cia').change(function() {
		var token = $('input[name=_token]').val();				
		var cia  =  $('.cia').val();
    	var selProcesos = document.getElementById("procesos");		
        $.post("get-procesos", { cia: cia, _token: token }, function( data ) {
            var procesos = Object.values(data);
            //alert(procesos[0]["NOMBRE"]);
		    while (selProcesos.options.length) {
		        selProcesos.remove(0);
    		}
    	    for (var i = 0; i < procesos.length; i++) {
            	var proceso = new Option(procesos[i]["NOMBRE"], procesos[i]["TIPONO"]);
            	selProcesos.options.add(proceso);
            }	
        });		
	});
</script>            
@endsection