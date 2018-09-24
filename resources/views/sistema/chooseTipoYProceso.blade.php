@extends('layouts.app')

@section('title','Seleccionar Tipo de Nómina y Proceso')
@section('body-class','')

@section('content')
<div class="container">
    <div class="row">
        
        <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3" style="border-radius: 5px; background-color: rgb(179, 215, 243);">
            <form class="form" method="POST" action="{{ url('sistema/set-session-data') }}">
                <!-- action="{{ url('/sistema/testProcesos/asimilado') }}" -->
                <input type="hidden" name="tipo" value="{{ 'asimilado' }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
                <br>
                <div class="articulo text-center" style="color: white;">Seleccione:</div>
                <br>
                <!-- <p class="text-center" style="color:Azure; text-align: center;">Ingresa tus datos</p> -->
                <div class="content">
                    <div class="row">
                        <div class="col col-md-8 col-md-offset-2">
                            <div class="form-group label-floating">
                            <label class="control-label" style="color: white;">Tipo de Nómina:</label>
                            <select class="form-control tipo" id="Tipo" name="TipoNom">
                                <option value="0" selected>Seleccione el Tipo de nómina...</option>
                                @if ($cliente->fiscal != NULL)
                                    <option value="fiscal">Fiscal</option>
                                @endif
                                @if ($cliente->asimilado != NULL)
                                    <option value="asimilado">Asimilados</option>
                                @endif
                            </select>
                            </div>
                        </div>
                    </div>
	                    <div class="row">
                        <div class="form-group label-floating col col-md-8 col-md-offset-2" id="mostrar" style="display: none;">
                            <label class="control-label" style="color: white;">Proceso:</label><br>
							<select id="procesos" name="proceso" class="form-control tipo"></select>
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

	$('.tipo').change(function() {
		var token = $('input[name=_token]').val();				
		var tipo  =  $('.tipo').val();
    	var selProcesos = document.getElementById("procesos");
        $.post("/sistema/get-procesos", { tipo: tipo, _token: token }, function( data ) {
            var procesos = Object.values(data);
            //alert(procesos[0]["NOMBRE"]);
		    while (selProcesos.options.length) {
		        selProcesos.remove(0);
    		}
    	    for (var i = 0; i < procesos.length; i++) {
            	var proceso = new Option(procesos[i]["NOMBRE"], procesos[i]["TIPONO"]);
            	selProcesos.options.add(proceso);
            }
            $('#mostrar').show();
        });		
	});

    //     $(document).ready(function(){
    //     $("#Tipo").on( "click", function() {
    //         $('#mostrar').show(); //muestro mediante id
    //      });
    // });
</script> 

@endsection