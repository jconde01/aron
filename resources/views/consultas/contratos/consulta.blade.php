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
            $directorio = opendir("./contratos"); //ruta actual
            while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {
                if (is_dir($archivo))//verificamos si es o no un directorio
                {
                    //echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
                }
                else
                {
                    echo '<a href="/contratos/'.$archivo.'">'.$archivo.'</a>' . "<br />";
                }
            }
         ?>                           
         
      </div>

    </div>
  </div>

@include('includes.footer')
@endsection
