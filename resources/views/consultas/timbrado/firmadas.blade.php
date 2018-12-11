@extends('layouts.app')

@section('title','Aron | Menú')
@section('body-class','')

@section('content')
<div class="main main-raised"> 
    <div class="container">   
      <div class="section text-center">
        <h5 class="titulo">Nóminas autorizadas</h5>
	 	
		<?php
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
                    }
                    echo '</div>';
                }
            }
          ?>               
         <br>
      </div>
    </div>
  </div>
<br><br><br style="height: ">
<!-- Modal -->
<div class="modal fade" id="consulta" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">

        <form action="#">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Contenido del documento firmado</h4>
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
                    <button type="submit" class="btn btn-default">OK</button>
                </div>
            </div>
        </form>            
    </div>
</div>
@include('includes.footer')
@endsection
@section('jscript')
<script type="text/javascript">

    $(".consultar").click(function(){
        var id = $(this).attr('id');
        $("#consulta").modal();      
    });
</script>
@endsection