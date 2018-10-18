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
      // dd($ruta,$rfc, $id_empleado);
        $ru = $ruta.$celula_empresa.'/'.$rfc_cliente.'/timbrado';

          
          //dd($ru);
            $directorio = opendir($ru); 

            while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {
                if (is_dir($archivo))//verificamos si es o no un directorio
                {
                    //echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
                }
                else
                {
                 // AAGS-73-04-20-H-DF-LNM-08
                    $rfc=$rfc_empleado;;
                    $ext = '.pdf';
                    $xml = '.xml';
                    //echo '<a href="/archivos/'.$archivo.'">'.$archivo.'</a>' . "<br />";
                    $restar=substr ($archivo, 7,-15 );
                    $pdf=substr ($archivo, -4);
                    if ($rfc==$restar && $ext== $pdf){
                      
                      
                       echo '<div class="col-lg-5" style="border:1px blue solid; border-radius:10px; margin-right: 80px; margin-top: 20px;"><br><i class="fas fa-file-alt" style="font-size: 50px;"></i><br><br><a href="/descarga/'.$archivo.'">'.$archivo.'</a>' . "<br/><br></div>";
 


                    }
                    
                    if ($rfc==$restar && $xml== $pdf){
                       echo '<div class="col-lg-5" style="border:1px blue solid; border-radius:10px;margin-right: 80px; margin-top: 20px;"><br><i class="fas fa-file-alt" style="font-size: 50px;"></i><br><br><a href="/descarga/'.$archivo.'">'.$archivo.'</a>' . "<br /><br></div>"; 
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
