@extends('layouts.app')

@section('title','Aron | Menú')
@section('body-class','')

@section('content')
  <div class="main main-raised"> 
    <div class="container">
       
      <div class="section text-center">
        <h2 class="titulo">Ticket Nuevo</h2> <br>
        
        <br> <br>

               <form method="POST" action=" {{url('/tickets/usuarios')}} ">
         {{ csrf_field() }}

          <div class="row" style="border: 1px red solid; max-width: 700px; margin: auto!important;"> 
                     <div class="col-md-6 col-md-offset-3" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; ">
                            <div class="label-left"><p>Clasificación</p></div>
                            <select style="width: 300px; height: 40px; border-radius: 10px; text-align: right; " name="clasificacion" class="inderecha" required>
                                <option active></option>
                                <option value="Sugerencia">Sugerencia</option>
                                <option value="Queja">Queja</option>
                                <option value="Reporte">Reporte</option>
                                <option value="Solicitud de cambio">Solicitud de cambio</option>
                                <option value="Ajuste Fiscal">Ajuste Fiscal</option>
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
                            <textarea rows="4" cols="40" name="motivo" placeholder="Escriba una breve descripción de su solicitud." required></textarea>
                        </div> 
                    </div>

                    
                
            </div>
            <br>
            <button class="mediano separation">Generar ticket</button> 
            <a href="{{url('/tickets/usuarios/')}}" class="primario1">Cancelar</a>   
        </form>
          
      </div>
      
    </div>
  </div>
@include('includes.footer');
</html>

@endsection