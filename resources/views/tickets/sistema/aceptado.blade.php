@extends('layouts.app')

@section('title','Aron | Menú')
@section('body-class','')

@section('content')
  <div class="main main-raised"> 
    <div class="container">
       
      <div class="section text-center">
        <h2 class="titulo">Tickets en Proceso</h2> <br>
        
        <br> <br>

            <table id="table_id" class="display">      
                       <thead>
                        <tr>
                            <th class="parrafo">Folio</th>
                            <th class="parrafo">Clasificacion</th>
                            <th class="parrafo" style="width: 700px;">Motivo</th>
                            <th class="parrafo">Estado</th>
                            <th class="parrafo">Fecha del levantamiento</th>
                            <th class="parrafo">Cliente</th>
                            <th class="parrafo">Emisor</th>
                            <th class="parrafo">Comentarios</th>
                            <th class="parrafo">Dar Seguimiento</th>
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
                            <td class="parrafo">{{$ticket->cliente}}</td>
                            <td class="parrafo">{{$ticket->emisor}}</td>
                            <td class="parrafo">{{$ticket->comentarios}}</td>
                            <td class="parrafo"> <a href="{{url('/tickets/sistema/'.$ticket->folio.'/seguimiento')}}" rel="tooltip" title="Seguimiento"><i class="fas fa-arrow-alt-circle-right"></i></a></td>    
                        </tr> @endforeach
                      </tbody>
                         
                    </table> 
          
      </div>
      
    </div>
  </div>
@include('includes.footer');
</html>

@endsection