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
          try {
             
           
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
          } catch (Exception $e) {
            echo '<span style="color: white;">'.$e->getMessage().'</span>'; 
           } 
         ?>                           
      
      </div>
      @if ($documentos!==null)
      <form method="POST" action=" {{url('/consultas/contratos/fechas')}} ">
        {{ csrf_field() }}
        <input type="hidden" name="NoEmp" value="{{$NoEmpleado}}">
        <div style="border: 1px blue solid; border-radius: 5px;">
          <div class="col-md-4">
            <div class="form-group">
              <label class="bmd-label-floating">Contrato 3 Meses</label>
              <input type="date" name="tres" class="form-control" value="{{$documentos->tresmeses}}">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="bmd-label-floating">Contrato 6 Meses</label>
              <input type="date" name="seis" class="form-control" value="{{$documentos->seismeses}}">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="bmd-label-floating">Contrato Indefinido</label>
              <input type="hidden" name="indefinido" value="0" class="form-control">
              <input type="checkbox" name="indefinido" value="1" class="form-control" @if ($documentos->indefinido==1) checked @endif>
            </div>
          </div>
          <button class="btn btn-primary">Guardar</button> 
        </div>
      </form>
      @else
          <div style="background-color: red;color: white; border-radius: 5px; text-align: center;">
            <h3>Para activar las fechas de los contratos favor de ir al catálogo de empleados y a continuación los documentos del empleado requerido o dandole click al sig. link -> <a href="{{url('/catalogos/empleados/'.$NoEmpleado.'/documentos')}}" rel="tooltip" title="Documentos" class="btn btn-warning btn-simple btn-xs">
                                <i class="fa fa-file"></i>
                              </a></h3>
          </div>
      @endif

    </div>
  </div>
<br><br><br>
@include('includes.footer')
@endsection
