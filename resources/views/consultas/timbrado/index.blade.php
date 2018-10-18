@extends('layouts.app')

@section('title','Aron | Menú')
@section('body-class','')

@section('content')
<div class="main main-raised"> 
    <div class="container">   
      <div class="section text-center">
        <h2 class="titulo">Confirmar Nómina</h2>
	 	
	
		<?php
         $ru = $ruta.$celula_empresa.'/'.$rfc_cliente.'/porautorizar/';
            $directorio = opendir($ru); //ruta actual
            while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {
                if (is_dir($archivo))//verificamos si es o no un directorio
                {
                    //echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
                }
                else
                {
                    echo ' <div class="col-lg-5" style="border:1px blue solid; border-radius:10px; margin-right: 80px; height:200px; margin-top: 20px;" > <br> <i class="fas fa-file-alt" style="font-size: 50px;" > </i> <br> <br> <a href="/descargaTimbres/'.$archivo.'" > '.$archivo.' </a><br/><br><br>';
                     ?> 
                     <?php
                    //echo '<a href="utilerias/timbrado/'.$archivo.'">'.$archivo.'</a>' . "<br /><br /><br />";
                     $restar=substr ($archivo, 0,10 );
                     if ('autorizado'!==$restar) {
                         echo '<a href="/consultas/timbrado/firmar/'.$archivo.'" class="primario1 separation">Confirmar nomina</a>';                    
                          }
                    //echo '<a href="/consultas/timbrado/firmar" class="primario1 separation">Confirmar nomina</a>';
                    echo '</div>';
                }
            }
          ?>               
         <br>
		

      </div>

    </div>
  </div>
<br><br><br style="height: ">

@include('includes.footer');


@endsection
