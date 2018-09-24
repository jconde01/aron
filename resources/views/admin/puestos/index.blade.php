@extends('layouts.app')
@section('title', 'Listado de puestos')
@section('body-class', 'profile-page') <!-- Paso la clase class="login-page sidebar-collapse" por medio de una seccion en el lugar que se llama body-class, en la pagina donde quiero que funcione la clase -->
@section('content')
    
  </div>
  <div class="main main-raised"> 
    <div class="container">
       
      <div class="section text-center">
        <h2 class="titulo">Listado de Puestos</h2>

        <a href=" {{url('admin/puestos/create')}} " class="primario1 separation" style="width: 160px;"><i class="fas fas fa-plus-square icon-left"></i> &nbsp;Agregar Puesto</a>
        <br> <br>
        <div class="team">
          <div class="row">

            <table >      
                        
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
                        @foreach ($jobs as $job)
                        


                        <tr>
                            <td class="parrafo">{{$job->PUESTO}} </td>
                            <td class="parrafo">{{$job->NOMBRE}}</td>
                            <td class="parrafo">{{$job->NIVEL}}</td>
                            <td class="parrafo">{{$job->NPUESTO}}</td>
                            <td class="parrafo">{{$job->AUTORIZADA}}</td>
                            <td class="parrafo">{{$job->OCUPADAS}}</td>
                            <!-- <td class="parrafo">${{$job->OCUPEVEN}}</td> -->
                            <td class="parrafo">${{$job->SUELDO}}</td>
                            <td class="parrafo"><?php 
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
                            <td class="parrafo"><a href=" {{url('/admin/puestos/'.$job->PUESTO.'/edit')}} " ><i class="icon-left grey far fa-edit"></i>Editar</a></td>
                            
                        </tr> 
                         @endforeach
                    </table>
                    {{$jobs->links()}}

           
            
          </div>
        </div>
      </div>
      
    </div>
  </div>
@endsection
