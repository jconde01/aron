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
                                @if ($cliente->fiscal)
                                    <option value="fiscal">Fiscal</option>
                                @endif
                                @if ($cliente->asimilado)
                                    <option value="asimilado">Asimilados</option>
                                @endif
                            </select>
                            </div>
                        </div>
                    </div>
	                    <div class="row">
                        <div class="form-group label-floating col col-md-8 col-md-offset-2" id="mostrar" style="display: none;">
                            <label class="control-label" style="color: white;">Proceso:</label><br>
							<select id="procesos" name="proceso" class="form-control" onChange="activa_boton(this,this.form.boton), desactiva_boton(value)" >         
                             <option selected value="0">Seleccione un Proceso</option>          
                            </select>
						</div>
                    </div>
                </div>
                <div class="row text-center">
                    <button type="submit" class="primario" name="boton" id="boton" value="Enviar" disabled=true>Ingresar</button>
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


     function activa_boton(campo,boton){
        if (campo.value != "0"){
            boton.disabled=false;
        } else {
            boton.disabled=true;
        }
    }

     function desactiva_boton($valor){
        
        if ($valor == "0"){
            boton.disabled=true;
        } else {
            boton.disabled=false;
        }
    }



	$('.tipo').change(function() {
		var token = $('input[name=_token]').val();				
		var tipo  =  $('.tipo').val();
    	var selProcesos = document.getElementById("procesos");
        var boton = document.getElementById("boton");
        $("body").css("cursor", "wait");
        $.post("/sistema/get-procesos", { tipo: tipo, _token: token }, function( data ) {
            var procesos = Object.values(data);
            $("body").css("cursor", "default");
            if (data != 'Error') {
                while (selProcesos.options.length > 1) {
                    selProcesos.remove(selProcesos.options.length-1);
                     boton.disabled=true;
                    //alert('removiendo');
                }
                for (var i = 0; i < procesos.length; i++) {
                    var proceso = new Option(procesos[i]["NOMBRE"], procesos[i]["TIPONO"]);
                    selProcesos.options.add(proceso);
                }

                $('#mostrar').show();
            } else {
                alert('Error de acceso a la base de datos. Verifique la conexión...')
            }

        });		
	});

    //     $(document).ready(function(){
    //     $("#Tipo").on( "click", function() {
    //         $('#mostrar').show(); //muestro mediante id
    //      });
    // });
</script> 

@endsection