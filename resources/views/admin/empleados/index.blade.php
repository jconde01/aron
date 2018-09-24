@extends('layouts.app')
@section('title', 'Listado de departamentos')
@section('body-class', 'profile-page') <!-- Paso la clase class="login-page sidebar-collapse" por medio de una seccion en el lugar que se llama body-class, en la pagina donde quiero que funcione la clase -->
@section('content')

    
  </div>
  <div class="main main-raised"> 
    <div class="container">
       
      <div class="section text-center">
        <h2 class="titulo">Listado de Empleados</h2>

        <a href=" {{url('admin/empleados/create')}} " class="primario1 separation" style="width: 160px;"><i class="fas fas fa-plus-square icon-left"></i> &nbsp;Agregar Empleado</a>
        <br> <br>
        <div class="team">
          <div class="row">
    
            <table >      
                        
                        <tr>
                            <th class="parrafo">Tipo de Nomina</th>
                            <th class="parrafo">Empleado</th>
                            <th class="parrafo">Nombre</th>
                            <th class="parrafo">Puesto</th>
                            <th class="parrafo">Departamento</th>
                            <th class="parrafo">Estado</th>
                            <th class="parrafo">Tipo de Jornada</th>
                            <th class="parrafo">Turno</th>
                            <th class="parrafo">Estatus</th>
                            <th class="parrafo">Tipo de Pago</th>
                            <th class="parrafo">Acciones</th>
                        </tr> 
                        
                        @foreach ($emps as $emp)


                        <tr>
                            <td class="parrafo">{{$emp->TIPONO}}</td>
                            <td class="parrafo">{{$emp->EMP}}</td>
                            <td class="parrafo">{{$emp->NOMBRE}}</td>
                            <td class="parrafo"> @foreach ($jobs as $job)
                                <?php if ($emp->PUESTO==$job->PUESTO) {
                                    echo "$job->NOMBRE";
                                } ?>
                             @endforeach</td>
                            <td class="parrafo">@foreach ($deps as $dep)
                                <?php if ($emp->DEPTO==$dep->DEPTO) {
                                    echo "$dep->DESCRIP";
                                } ?>
                             @endforeach</td>
                            <td class="parrafo">{{$emp->c_Estado}}</td>
                            <td class="parrafo"> <?php 
                            if ($emp->TIPOJORNADA==1) {
                                echo "Diurna";
                            }
                            if ($emp->TIPOJORNADA==2) {
                                echo "Nocturna";
                            }
                            if ($emp->TIPOJORNADA==3) {
                                echo "Mixta";
                            }
                            if ($emp->TIPOJORNADA==4) {
                                echo "Por hora";
                            }
                            if ($emp->TIPOJORNADA==5) {
                                echo "Reducida";
                            }
                            if ($emp->TIPOJORNADA==6) {
                                echo "Continuada";
                            }
                            if ($emp->TIPOJORNADA==7) {
                                echo "Partida";
                            }
                            if ($emp->TIPOJORNADA==8) {
                                echo "Por turno";
                            }
                            if ($emp->TIPOJORNADA==99) {
                                echo "Otra jornada";
                            }


                            ?></td>
                            <td class="parrafo"><?php 
                            if ($emp->TURNO==1) {
                                echo "Diurno";
                            }
                            if ($emp->TURNO==2) {
                                echo "Nocturno";
                            }
                            if ($emp->TURNO==3) {
                                echo "Mixto";
                            }
                            ?></td>
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
                            
                            <td class="parrafo"><a href="{{url('/admin/empleados/'.$emp->EMP.'/edit')}}" ><i class="icon-left grey far fa-edit"></i>Editar</a></td>
                            
                        </tr> 
                        @endforeach
                         
                    </table>
                    {{$emps->links()}}
                    

           
          </div>
        </div>
      </div>
      
    </div>
  </div>



   

@endsection
