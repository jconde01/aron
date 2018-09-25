@extends('layouts.app')

@section('title','Aron | Menú')
@section('body-class','')

@section('content')
<meta http-equiv="refresh" content="6">
  <div class="main main-raised"> 
    <div class="container">
       
      <div class="section text-center">
        <h2 class="titulo">Tickets Pendientes</h2> <br>
        
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
                            <th class="parrafo">Atender Ticket</th>
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
                            <td class="parrafo"> @if ($ticket->estado == 'Pendiente')<a href="{{url('/tickets/sistema/'.$ticket->folio.'/atender')}}" rel="tooltip" title="Atender"><i class="fas fa-check-square"></i></i></a>@endif</td>    
                        </tr> @endforeach
                      </tbody>
                         
                    </table> 
          
      </div>
      
    </div>
  </div>
@include('includes.footer');
</html>

@endsection