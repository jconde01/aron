@extends('layouts.app')
 
@section('title','Consultas')
@section('body-class','')

@section('content')
<div class="main main-raised"> 
    <div class="container">   
      <div class="section text-center">
        <h2 class="titulo">Contratos de los Empleados</h2>
        
        <br> <br>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table id="table_id" class="display"> 
                    <thead>                           
                        <tr>
                            <th class="parrafo">Tipo de Nomina</th>
                            <th class="parrafo">Empleado</th>
                            <th class="parrafo">Nombre</th>
                            
                            
                            
                            
                            <th class="parrafo">Estatus</th>
                            <th class="parrafo">Tipo de Pago</th>
                            <th class="parrafo">Acciones</th>
                        </tr>  
                    </thead>                   
                        
                    <tbody>@foreach ($emps as $emp)
                        <tr>
                            <td class="parrafo">{{$emp->TIPONO}}</td>
                            <td class="parrafo">{{$emp->EMP}}</td>
                            <!-- <td class="parrafo" > <input type="" name="" id="nombre" value="{{$emp->NOMBRE}}" readonly style="border: 0px;" href=""data-toggle="modal" data-target="#GSCCModal"> <a></a></td> -->
                            <td class="parrafo">{{$emp->NOMBRE}}</td>
                        
                            
                            
                            
                            <td class="parrafo"><?php 
                            if ($emp->ESTATUS=='A') {
                                echo "Activa";
                            }
                            if ($emp->ESTATUS=='B') {
                                echo "Baja";
                            }
                            if ($emp->ESTATUS=='M') {
                                echo "Vacaciones";
                            }
                            ?></td>
                            <td class="parrafo">{{$emp->TIPOPAGO}}</td>                         
                            <td class="parrafo"><a href="{{url('/consultas/contratos/'.$emp->RFC.'/consulta')}}" rel="tooltip" title="Consultar" class="btn btn-success btn-simple btn-xs"><i class="far fa-file-pdf"></i></a></td>             
                        </tr>  @endforeach 
                    </tbody>
                             
                    </table>

                  

                           
                             
         
      </div>
    </div>
  </div>

@include('includes.footer')
@endsection
