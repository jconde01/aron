@extends('layouts.app')

@section('title','Aron | Menú')
@section('body-class','')

@section('content')
<div class="main main-raised"> 
    <div class="container">   
      <div class="section text-center">
        <h2 class="titulo">Documentos Generales</h2>
	 	
	
		    <?php
            try {
                $directorio = opendir($ruta_documentos); 
                while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
                {

                    if (is_dir($archivo)==false)//verificamos si es o no un directorio
                    {
                        $extension = explode(".",$archivo);
                        $extension = count($extension);
                        if ($extension==1) {
                            echo '<a href="/consultas/documentos/'.$archivo.'" ><div class="col-lg-5" style="border:1px blue solid; border-radius:10px; margin-right: 80px; height:170px; margin-top: 20px;" > <br> <i class="fas fa-folder" style="font-size: 50px;" > </i> <br> <br> Período '.$archivo.' <br/><br><br>';
                            echo '</div></a>';
                        }
                        
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
@include('includes.footer')
@endsection
