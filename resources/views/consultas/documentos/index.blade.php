@extends('layouts.app')

@section('title','Aron | Menú')
@section('body-class','')

@section('content')
<div class="main main-raised"> 
    <div class="container">   
      <div class="section text-center">
        <h2 class="titulo">Documentos</h2>
	 	
	
		    <?php
            $directorio = opendir($ruta_documentos); 
            while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {
                if (!is_dir($archivo))//verificamos si es o no un directorio
                {
                    echo '<a href="/consultas/documentos/'.$archivo.'" ><div class="col-lg-5" style="border:1px blue solid; border-radius:10px; margin-right: 80px; height:170px; margin-top: 20px;" > <br> <i class="fas fa-folder" style="font-size: 50px;" > </i> <br> <br> Periodo '.$archivo.' <br/><br><br>';
                    echo '</div></a>';
                }
            }
        ?>               
        <br>
      </div>
    </div>
  </div>
<br><br><br style="height: ">
@include('includes.footer')
@endsection
