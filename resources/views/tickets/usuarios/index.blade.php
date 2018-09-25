@extends('layouts.app')

@section('title','Aron | Menú')
@section('body-class','')

@section('content')
<meta http-equiv="refresh" content="20">
  <div class="main main-raised"> 
    <div class="container">
       
      <div class="section text-center">
        <h2 class="titulo">Tickets</h2> <br>
        <a href=" {{url('tickets/usuarios/create')}} " class="primario1 separation" style="width: 160px;"><i class="fas fas fa-plus-square icon-left"></i> &nbsp;Generar ticket Nuevo</a>
        <br> <br>

            <table id="table_id" class="display">      
                       <thead>
                        <tr>
                            <th class="parrafo">Folio</th>
                            <th class="parrafo">Clasificacion</th>
                            <th class="parrafo" style="width: 700px;">Motivo</th>
                            <th class="parrafo">Estado</th>
                            <th class="parrafo">Fecha del levantamiento</th>
                            <th class="parrafo">Fecha de finalización</th>
                            <th class="parrafo">Comentarios</th>
                            <th class="parrafo">Solución</th>
                            <th class="parrafo">Cancelar</th>
                        </tr> 
                       </thead> 
                          
                        
                       <tbody>
                         @foreach ($tickets as $ticket)
                        <tr> 
                            <td class="parrafo">{{$ticket->folio}}</td>
                            <td class="parrafo">{{$ticket->clasificacion}}</td>
                            <td class="parrafo">{{$ticket->motivo}}</td>
                            <td class="parrafo">{{$ticket->estado}}</td>
                            <td class="parrafo">{{$ticket->fechale}}</td>
                            <td class="parrafo">{{$ticket->fechafina}}</td>
                            <td class="parrafo">{{$ticket->comentarios}}</td>
                            <td class="parrafo">{{$ticket->solucion}}</td>
                            <td class="parrafo"> @if ($ticket->estado == 'Pendiente')<a href="{{url('/tickets/usuarios/'.$ticket->folio.'/cancel')}}" rel="tooltip" title="Cancelar"><i class="fas fa-trash-alt"></i></a>@endif</td>    
                        </tr> @endforeach
                      </tbody>
                         
                    </table> 
          
      </div>
      
    </div>
  </div>
@include('includes.footer');
</html>

@endsection