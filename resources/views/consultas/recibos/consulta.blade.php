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
        try {
          
       
            $directorio = opendir($ruta); 
            //dd($ruta);
            while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {
              //dd($archivo);
                if (is_dir($archivo))//verificamos si es o no un directorio
                {
                  while ($subdirectorio = readdir($directorio)){
                    if ($subdirectorio!=="..") {
                      $subruta= $ruta.'/'.$subdirectorio;
                      $subcarpeta = opendir($subruta); 
                      while ($archivo2 = readdir($subcarpeta)){
                        if ($archivo2!=="..") {
                          if ($archivo2!==".") {
                            $coincidencia = strpos($archivo2, $rfc_empleado);

                            if ($coincidencia==true){                            
                               echo '<div class="col-lg-5" style="border:1px blue solid; border-radius:10px; margin-right: 80px; margin-top: 20px;"><br><i class="fas fa-file-alt" style="font-size: 50px;"></i><br><br><a href="/descarga/'.$subdirectorio.'/'.$archivo2.'">'.$archivo2.'</a>' . "<br/><br></div>";
                            }
                            
                      }
                      }
                      }

                    }
                    
                  }
                }
                else
                {
                  
                 // AAGS-73-04-20-H-DF-LNM-08
                    $rfc = $rfc_empleado;
                    $pdf = '.pdf';
                    $xml = '.xml';
                    //echo '<a href="/archivos/'.$archivo.'">'.$archivo.'</a>' . "<br />";
                    $restar=substr ($archivo, 7,-15 );
                    $ext=substr ($archivo, -4);
                    if ($rfc==$restar && $ext== $pdf){
                      
                      
                       echo '<div class="col-lg-5" style="border:1px blue solid; border-radius:10px; margin-right: 80px; margin-top: 20px;"><br><i class="fas fa-file-alt" style="font-size: 50px;"></i><br><br><a href="/descarga/'.$archivo.'">'.$archivo.'</a>' . "<br/><br></div>";
 


                    }
                    
                    if ($rfc==$restar && $ext == $xml){
                       echo '<div class="col-lg-5" style="border:1px blue solid; border-radius:10px;margin-right: 80px; margin-top: 20px;"><br><i class="fas fa-file-alt" style="font-size: 50px;"></i><br><br><a href="/descarga/'.$archivo.'">'.$archivo.'</a>' . "<br /><br></div>"; 
                    }
                    
                    //echo $restar;
                   
                }
            }

             } catch (Exception $e) {
          echo '<span style="color: white;">'.$e->getMessage().'</span>';
        }
         ?>                           
         
         
             
        
      </div>

    </div>
  </div>
   <br><br><br><br>

@include('includes.footer')
@endsection
