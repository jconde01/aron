@extends('layouts.app')
@section('title', 'Bajas de empleados')
@section('body-class', 'profile-page')
@section('content') 
  <div class="main main-raised"> 
    <div class="container">   
      <div class="section text-center">
        <h2 class="titulo">Bajas Físicas de Empleados</h2>
        
        <br> <br>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">                 
                        
                    @foreach ($emps as $emp)
                        <tr>
                            <td class="parrafo">{{$emp->EMP}}</td>
                            <!-- <td class="parrafo" > <input type="" name="" id="nombre" value="{{$emp->NOMBRE}}" readonly style="border: 0px;" href=""data-toggle="modal" data-target="#GSCCModal"> <a></a></td> -->
                            <td class="parrafo" ><a href=""data-toggle="modal" data-target="#GSCCModal" id="{{$emp->EMP}}" rel="tooltip" title="Consulta rapida" name="nom">{{$emp->NOMBRE}} <input type="hidden" name="{{$emp->EMP}}" value="{{$emp->EMP}}"> </a></td>           
                        </tr>  @endforeach 
                    
                             
                   
                                <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>     
                            
         
      </div>
    </div>
  </div>
  <div style="height: 15px;"></div>
  @include('includes.footer')
  

@endsection
