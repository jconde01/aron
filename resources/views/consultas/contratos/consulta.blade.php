@extends('layouts.app')
 
@section('title','Consultas')
@section('body-class','')

@section('content')
<div class="main main-raised"> 
    <div class="container">   
      <div class="section text-center">
        <h2 class="titulo">Contratos del Empleado</h2>
        
        <br> <br>
        <?php
           
            $directorio = opendir($ruta); //ruta actual
            while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {
                if (is_dir($archivo))//verificamos si es o no un directorio
                {
                    //echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
                }
                else
                {
                     echo '<div class="col-lg-5" style="border:1px blue solid; border-radius:10px; margin-right: 80px; margin-top: 20px;"><br><i class="fas fa-file-alt" style="font-size: 50px;"></i><br><br><a href="/descargaContratos/'.$archivo.'">'.$archivo.'</a>' . "<br/><br></div>";

                }
            }
         ?>                           
         
      </div>

    </div>
  </div>
<br><br><br>
@include('includes.footer')
@endsection
