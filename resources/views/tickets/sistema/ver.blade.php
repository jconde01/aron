@extends('layouts.app')

@section('title','Aron | Menú')
@section('body-class','')

@section('content')
  <div class="main main-raised"> 
    <div class="container">
       
      <div class="section text-center">
        <h2 class="titulo">Consulta del Ticket</h2> <br>
        
        

               <form method="POST" action=" {{url('/tickets/sistema/aceptado')}} ">
         {{ csrf_field() }}

          <div class="row" style="border: 1px red solid; max-width: 700px; margin: auto!important;"> 
                     <div class="col-md-6 col-md-offset-3 " style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;  width: 310px; margin-right: 8px;">
                            <div class="label-left"><p>Folio: </p></div>
                            <input type="text" name="folio" style=" " max="3" value="{{$ticket->folio}}" readonly class="bloqueado">
                        </div> 
                    </div>

                     <div class="col-md-6 col-md-offset-3" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; ">
                            <div class="label-left"><p>Clasificación</p></div>
                            <select style="width: 300px; height: 40px; border-radius: 10px; text-align: right; pointer-events: none; " name="clasificacion" class="inderecha bloqueado">
                                
                                <option value="Sugerencia"  <?php if ($ticket->clasificacion == 'Sugerencia') echo 'selected="selected";'?>>Sugerencia</option>
                                <option value="Queja" <?php if ($ticket->clasificacion == 'Queja') echo 'selected="selected";'?>>Queja</option>
                                <option value="Reporte" <?php if ($ticket->clasificacion == 'Reporte') echo 'selected="selected";' ?>>Reporte</option>
                                <option value="Solicitud de cambio" <?php if ($ticket->clasificacion == 'Solicitud de cambio') echo 'selected="selected";' ?>>Solicitud de cambio</option>
                                <option value="Ajuste Fiscal" <?php if ($ticket->clasificacion == 'Ajuste Fiscal') echo 'selected="selected";' ?>>Ajuste Fiscal</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-6 col-md-offset-3" style="">
                        <div  >
                            <div class="label-left"><p>Motivo: </p></div>
                            
                        </div> 
                    </div>
                    <div class="col-md-6 col-md-offset-3" style="">
                        <div>
                            <textarea rows="4" cols="40" name="motivo" readonly class="bloqueado">{{$ticket->motivo}}</textarea>
                        </div> 
                    </div>

                    <div class="col-md-6 col-md-offset-3" style="">
                        <div  >
                            <div class="label-left"><p>Comentarios: </p></div>
                            
                        </div> 
                    </div>
                    <div class="col-md-6 col-md-offset-3" style="">
                        <div>
                            <textarea rows="4" cols="40" name="comentarios" readonly class="bloqueado"> {{$ticket->comentarios}}</textarea>
                        </div> 
                    </div>

                    <div class="col-md-6 col-md-offset-3" style="">
                        <div  >
                            <div class="label-left"><p>Solución: </p></div>
                            
                        </div> 
                    </div>
                    <div class="col-md-6 col-md-offset-3" style="">
                        <div>
                            <textarea rows="4" cols="40" name="solucion" readonly class="bloqueado">{{$ticket->solucion}}</textarea>
                        </div> 
                    </div>

                    
                
            </div>
            <br>
            
            &nbsp;
            <a href="{{url('/tickets/sistema/consultar')}}" class="primario1" style="padding: 14px!important;">Regresar</a>   
        </form>
          
      </div>
      
    </div>
  </div>
@include('includes.footer');
</html>

@endsection