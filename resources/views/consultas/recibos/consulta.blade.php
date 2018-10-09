@extends('layouts.app')
 
@section('title','Consultas')
@section('body-class','')

@section('content')
<div class="main main-raised"> 
    <div class="container">   
      <div class="section text-center">
        <h2 class="titulo">Recibos del Empleado</h2>
        <br>
        
        <?php
            $directorio = opendir($ruta); 
            while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {
                if (is_dir($archivo))//verificamos si es o no un directorio
                {
                    //echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
                }
                else
                {
                    $rfc='SACM630816CS2';
                    $ext = '.pdf';
                    $xml = '.xml';
                    //echo '<a href="/archivos/'.$archivo.'">'.$archivo.'</a>' . "<br />";
                    $restar=substr ($archivo, 7,-15 );
                    $pdf=substr ($archivo, -4);
                    if ($rfc==$restar && $ext== $pdf){
                       echo '<div class="col-lg-5" style="border:1px blue solid; border-radius:10px;"><br><i class="fas fa-file-alt" style="font-size: 50px;"></i><br><br><a href="/Nominas/Celula1/TIMBRADO/VALLY_MERIDA/201816/'.$archivo.'">'.$archivo.'</a>' . "<br/><br></div>"; 
                       echo '<div class="col-lg-2"></div>';
                    }
                    
                    if ($rfc==$restar && $xml== $pdf){
                       echo '<div class="col-lg-5" style="border:1px blue solid; border-radius:10px;"><br><i class="fas fa-file-alt" style="font-size: 50px;"></i><br><br><a href="/Nominas/Celula1/TIMBRADO/VALLY_MERIDA/201816/'.$archivo.'" download="".$archivo."">'.$archivo.'</a>' . "<br /><br></div>"; 
                    }
                    
                    //echo $restar;
                   
                }
            }
         ?>                           
         
         
             
        
      </div>

    </div>
  </div>
   <br><br><br><br>

@include('includes.footer')
@endsection
