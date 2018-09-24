@extends('layouts.app') 
@section('title', 'Listado de departamentos')
@section('body-class', 'profile-page') 
@section('content')   
  <div class="main main-raised"> 
    <div class="container">
       
      <div class="section text-center">
        <h2 class="titulo">Listado de Departamentos</h2>

        <a href=" {{url('catalogos/deptos/create')}} " class="primario1 separation" style="width: 160px;"><i class="fas fas fa-plus-square icon-left"></i> &nbsp;Agregar Departamento</a>
        <br> <br>

            <table id="table_id" class="display">      
                       <thead>
                        <tr>
                            <th class="parrafo">Departamento</th>
                            <th class="parrafo">Nombre del Departamento</th>
                            <th class="parrafo">Nombre Corto</th>
                            <th class="parrafo">Depto. al que Reporta</th>
                            <th class="parrafo">Acciones</th>
                        </tr> 
                       </thead> 
                          
                        
                       <tbody>
                        @foreach ($deps as $dep)<tr> 
                            <td class="parrafo">{{$dep->DEPTO}}</td>
                            <td class="parrafo">{{$dep->DESCRIP}}</td>
                            <td class="parrafo">{{$dep->NDEPTO}}</td>
                            <td class="parrafo">@foreach ($deps as $dep2)
                              <?php if ($dep->NAREA==$dep2->DEPTO) {
                                echo $dep2->DESCRIP;    
                              } ?>
                              @endforeach
                            </td>
                            <td class="parrafo"><a href="{{url('/catalogos/deptos/'.$dep->DEPTO.'/edit')}}" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a></td>    
                        </tr> @endforeach
                      </tbody>
                         
                    </table> 
          
      </div>
      
    </div>
  </div>
  <div style="height: 15px;"></div>
  @include('includes.footer')
@endsection
