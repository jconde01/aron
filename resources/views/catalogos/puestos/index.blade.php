@extends('layouts.app')
@section('title', 'Listado de puestos')
@section('body-class', 'profile-page') 
@section('content')  
  </div>
  <div class="main main-raised"> 
    <div class="container">    
      <div class="section text-center">
        <h2 class="titulo">Listado de Puestos</h2>
        <a href=" {{url('catalogos/puestos/create')}} " class="primario1 separation" style="width: 160px;"><i class="fas fas fa-plus-square icon-left"></i> &nbsp;Agregar Puesto</a>
        <br> <br>
        
            <table id="table_id" class="display">
                      <thead>                          
                        <tr>
                            <th class="parrafo">Puesto</th>
                            <th class="parrafo">Nombre</th>
                            <th class="parrafo">Nivel de Puestos</th>
                            <th class="parrafo">Abreviación</th>
                            <th class="parrafo">Plazas autorizadas</th>
                            <th class="parrafo">Plazas Ocupadas</th>
                            <th class="parrafo">Sueldo</th>
                            <th class="parrafo">Categoría</th>
                            <th class="parrafo">Acciones</th>
                        </tr> 
                      </thead>
                      <tbody>
                        @foreach ($jobs as $job)
                        <tr>
                            <td class="parrafo">{{$job->PUESTO}} </td>
                            <td class="parrafo">{{$job->NOMBRE}}</td>
                            <td class="parrafo">{{$job->NIVEL}}</td>
                            <td class="parrafo">{{$job->NPUESTO}}</td>
                            <td class="parrafo">{{$job->AUTORIZADA}}</td>
                            <td class="parrafo">{{$job->OCUPADAS}}</td>
                            <td class="parrafo">${{$job->SUELDO}}</td>
                            <td class="parrafo"><?php 
                            if ($job->CATEGP==0) {
                              echo 'No definido';
                            }
                            if ($job->CATEGP==1) {
                              echo 'Administrativo';
                            }
                            if ($job->CATEGP==2) {
                              echo 'Técnico';
                            }
                            if ($job->CATEGP==3) {
                              echo 'Obrero';
                            }
                            ?></td>
                            <td class="parrafo"><a href=" {{url('/catalogos/puestos/'.$job->PUESTO.'/edit')}} " rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a></td>             
                        </tr>  @endforeach
                        </tbody>
                    </table>
                              
      
      </div>   
    </div>
  </div>
  <div style="height: 15px;"></div>
  @include('includes.footer')
@endsection
