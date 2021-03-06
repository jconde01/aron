@extends('layouts.app')

@section('title','Aron | Menú')
@section('body-class','')

@section('content')
<div class="main main-raised"> 
    <div class="container">   
      <div class="section text-center">
        <h5 class="titulo">FACTURACIÓN</h5> 
		<input type="hidden" name="_token" value="{{ csrf_token() }}">        	
		<?php
        try {
            
       
            $directorio = opendir($ruta);
            while ($archivo = readdir($directorio)) {
                if ($archivo != "." && $archivo != ".." && !is_dir($archivo)) {
      				// Allow only XML (filter)
      				if (strstr($archivo, ".xml")) {

        				// Path to the actual file
        				$ruta_archivo = $ruta . '/' . $archivo;
                    	echo '<div class="col-lg-5" style="border:1px blue solid; border-radius:10px; margin-right: 80px; height:200px; margin-top: 20px;" > <br> <i class="fas fa-file-alt" style="font-size: 50px;" > </i> <br> <br>
                        <a href="/consultaAutorizados/'.$archivo.'">'.$archivo.'</a><br/><br><br>';
                       	echo '<a class="primario1 separation consultar" id="'.$archivo.'">Consultar datos firmados</a>';
                    } elseif (strstr($archivo, ".pdf")) {
                        // Path to the actual file
                        $ruta_archivo = $ruta . '/' . $archivo;
                        echo '<div class="col-lg-5" style="border:1px blue solid; border-radius:10px; margin-right: 80px; height:200px; margin-top: 20px;" > <br> <i class="fas fa-file-alt" style="font-size: 50px;" > </i> <br> <br>
                        <a href="/consultaAutorizados/'.$archivo.'">'.$archivo.'</a>';
                        echo '<br><br><br><span style="color: red; font-size:9px;">*Para consultar el detalle de la nómina autorizada vaya a <a href="/consultas/documentos">DOCUMENTOS GENERALES</a></span>';
                    }
                    echo '</div>';
                }
            }
         } catch (Exception $e) {
           echo '<span style="color: white;">'.$e->getMessage().'</span>'; 
        }
          ?>               
         <br>
      </div>
    </div>
  </div>
<br><br><br style="height: ">
<!-- Modal -->
<div class="modal fade" id="consulta" role="dialog">
    <div class="modal-dialog">

        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Contenido del documento firmado</h4>
        <div class="modal-body">
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="loading" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style=" margin: auto; text-align: center;">
        <img src="{{ asset('img/loading.gif') }}">
    </div>
</div>
@include('includes.footer')
@endsection
@section('jscript')
<script type="text/javascript">


    $(".consultar").click(function(){
        $("#loading").modal();
        var id = $(this).attr('id');
        console.log('file: '+ id + ', token: '+token);
        $.post("get-signed-data", { file: id, _token: token }, function( data ) {
            //signedData = Object.values(data);
            //alert('back');
            console.log(data);
            //console.log(signedData);
            $('.modal-body').html(data);
            $("#loading").modal('hide');
            $("#consulta").modal(); 
        });        
    });

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).ready(function() {
		token = $('input[name=_token]').val();
    	console.log('here we are... token is : ' + token);
	});	


</script>
@endsection
