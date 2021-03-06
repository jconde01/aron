@extends('layouts.app')

@section('title','Aron | Menú')
@section('body-class','')

@section('content')
<div class="main main-raised"> 
    <div class="container">   
      <div class="section text-center">
        <h5 class="titulo">Autorizar Nómina</h5>
 	
		<?php
        try {
            
        
            $directorio = opendir($ruta);
            while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {
                if (!is_dir($archivo)) //verificamos si es o no un directorio
                {
                    echo '<div class="col-lg-5" style="border:1px blue solid; border-radius:10px; margin-right: 80px; height:200px; margin-top: 20px;" > <br> <i class="fas fa-file-alt" style="font-size: 50px;" > </i> <br> <br>
                        <a href="/descargaTimbres/'.$archivo.'" > '.$archivo.' </a><br/><br><br>';

                    $prefijo=substr($archivo,0,10);
                    if ($prefijo !== 'autorizado') {
                        //echo '<input type="hidden" name="archivo[]" id="'.$archivo.'" value="'.$archivo.'" />';
                        echo '<a class="primario1 separation firmar" id="'.$archivo.'">Autorizar</a>';
                        // echo '<form class="form" method="POST" action="/consultas/timbrado/firmar/$archivo">';
                        // echo '  <input type="hidden" name="_token" value="{{ csrf_token() }}">';
                        // echo '  <div class="row text-center">';
                        // echo '      <button type="button" class="btn btn-info btn-sm" id="firmar">Confirmar</button>';
                        // echo '  </div>';
                        // echo '</form>';
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
<div class="modal fade" id="confirma" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">

        <!-- url('/consultas/timbrado/firmar/') -->
        <form method="POST" action="{{ url('/consultas/timbrado/firmar') }}" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">';
            <input type="hidden" name="archivo" id="Archivo">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ingrese contraseña de clave privada</h4>
                </div>
                <div class="modal-body">
                    <div class="input-data">
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left" style="font-size: 14px;">Contraseña</label>
                            <input type="password" id="pkey_pwd" name="pkey_pwd" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">Autorizar</button>
                </div>
            </div>
        </form>            
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
        token = $('input[name=_token]').val();
    });

    $(".firmar").click(function(){
        var id = $(this).attr('id');
        // alert('id: ' + id + ' - ' + 'valor: ' + valor);
        var arch = document.getElementById("Archivo");
        arch.value = id;       
        $("#confirma").modal();      
    });
</script>
@endsection
