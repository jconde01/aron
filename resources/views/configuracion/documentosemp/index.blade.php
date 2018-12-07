@extends('layouts.app')

@section('title','Listado de Graficas')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <h2 class="titulo">Documentos Requeridos de los Empleados</h2>
            <div class="row">
                <!-- <a href="{{ url('/admin/celulas/create')}}" class="btn btn-primary btn-round" role="button">Nueva Célula</a> -->
                <br>
                <br>
               
                <form method="post" action="{{ url('/configuracion/documentos/update') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table class="table" style="width: 700px; margin: auto;">
                         <tr> 
                            <th>Acta de nacimiento</th>
                            <td class="text-center"><input type="hidden" name="requerido1" value="0"><input type="checkbox" name="requerido1" value="1" {{ $docsReque->REQUERIDO1==1? 'checked':'' }}></td>
                            <th>Fecha de vencimiento requerida</th>
                            <td class="text-center"><input type="hidden" name="fecha1" value="0"><input type="checkbox" name="fecha1" value="1" {{ $docsReque->FECHAREQUE1==1? 'checked':'' }}></td>    
                        </tr>
                        <tr>
                            <th>RFC</th>
                            <td class="text-center"><input type="hidden" name="requerido2" value="0"><input type="checkbox" name="requerido2" value="1" {{$docsReque->REQUERIDO2==1? 'checked':'' }}></td>
                            <th>Fecha de vencimiento requerida</th>
                            <td class="text-center"><input type="hidden" name="fecha2" value="0"><input type="checkbox" name="fecha2" value="1" {{ $docsReque->FECHAREQUE2==1? 'checked':'' }}></td>    
                        </tr>
                                                     
                        <tr>
                            <th>CURP</th>
                            <td class="text-center"><input type="hidden" name="requerido3" value="0"><input type="checkbox" name="requerido3" value="1" {{$docsReque->REQUERIDO3==1? 'checked':'' }}></td> 
                            <th>Fecha de vencimiento requerida</th>
                            <td class="text-center"><input type="hidden" name="fecha3" value="0"><input type="checkbox" name="fecha3" value="1" {{ $docsReque->FECHAREQUE3==1? 'checked':'' }}></td>   
                        </tr>

                         <tr>
                            <th>Comprobante domiciliario</th>
                            <td class="text-center"><input type="hidden" name="requerido4" value="0"><input type="checkbox" name="requerido4" value="1" {{$docsReque->REQUERIDO4==1? 'checked':'' }}></td> 
                            <th>Fecha de vencimiento requerida</th>
                            <td class="text-center"><input type="hidden" name="fecha4" value="0"><input type="checkbox" name="fecha4" value="1" {{ $docsReque->FECHAREQUE4==1? 'checked':'' }}></td>   
                        </tr>

                        <tr>
                            <th>Solicitud de Empleo</th>
                            <td class="text-center"><input type="hidden" name="requerido5" value="0"><input type="checkbox" name="requerido5" value="1" {{$docsReque->REQUERIDO5==1? 'checked':'' }}></td>
                            <th>Fecha de vencimiento requerida</th>
                            <td class="text-center"><input type="hidden" name="fecha5" value="0"><input type="checkbox" name="fecha5" value="1" {{ $docsReque->FECHAREQUE5==1? 'checked':'' }}></td>
                        </tr>

                        <tr>
                            <th>IFE o INE</th>
                            <td class="text-center"><input type="hidden" name="requerido6" value="0"><input type="checkbox" name="requerido6" value="1" {{$docsReque->REQUERIDO6==1? 'checked':'' }}></td> 
                            <th>Fecha de vencimiento requerida</th>
                            <td class="text-center"><input type="hidden" name="fecha6" value="0"><input type="checkbox" name="fecha6" value="1" {{ $docsReque->FECHAREQUE6==1? 'checked':'' }}></td>   
                        </tr>

                        <tr>
                            <th>Acta de boda</th>
                            <td class="text-center"><input type="hidden" name="requerido7" value="0"><input type="checkbox" name="requerido7" value="1" {{$docsReque->REQUERIDO7==1? 'checked':'' }}></td>  
                            <th>Fecha de vencimiento requerida</th>
                            <td class="text-center"><input type="hidden" name="fecha7" value="0"><input type="checkbox" name="fecha7" value="1" {{ $docsReque->FECHAREQUE7==1? 'checked':'' }}></td>  
                        </tr>

                        <tr>
                            <th>Titulo</th>
                            <td class="text-center"><input type="hidden" name="requerido8" value="0"><input type="checkbox" name="requerido8" value="1" {{$docsReque->REQUERIDO8==1? 'checked':'' }}></td>
                            <th>Fecha de vencimiento requerida</th>
                            <td class="text-center"><input type="hidden" name="fecha8" value="0"><input type="checkbox" name="fecha8" value="1" {{ $docsReque->FECHAREQUE8==1? 'checked':'' }}></td>
                        </tr>

                        <tr>
                            <th>Atecedentes no Penales</th>
                            <td class="text-center"><input type="hidden" name="requerido9" value="0"><input type="checkbox" name="requerido9" value="1" {{$docsReque->REQUERIDO9==1? 'checked':'' }}></td>
                            <th>Fecha de vencimiento requerida</th>
                            <td class="text-center"><input type="hidden" name="fecha9" value="0"><input type="checkbox" name="fecha9" value="1" {{ $docsReque->FECHAREQUE9==1? 'checked':'' }}></td>
                        </tr>

                        <tr>
                            <th>Contrato</th>
                            <td class="text-center"><input type="hidden" name="requerido10" value="0"><input type="checkbox" name="requerido10" value="1" {{$docsReque->REQUERIDO10==1? 'checked':'' }}></td>
                            <th>Fecha de vencimiento requerida</th>
                            <td class="text-center"><input type="hidden" name="fecha10" value="0"><input type="checkbox" name="fecha10" value="1" {{ $docsReque->FECHAREQUE10==1? 'checked':'' }}></td>    
                        </tr>

                        <tr>
                            <th>Curriculum</th>
                            <td class="text-center"><input type="hidden" name="requerido11" value="0"><input type="checkbox" name="requerido11" value="1" {{$docsReque->REQUERIDO11==1? 'checked':'' }}></td>
                            <th>Fecha de vencimiento requerida</th>
                            <td class="text-center"><input type="hidden" name="fecha11" value="0"><input type="checkbox" name="fecha11" value="1" {{ $docsReque->FECHAREQUE11==1? 'checked':'' }}></td>    
                        </tr> 

                        <tr>
                            <th>Cedula Profesional</th>
                            <td class="text-center"><input type="hidden" name="requerido12" value="0"><input type="checkbox" name="requerido12" value="1" {{$docsReque->REQUERIDO12==1? 'checked':'' }}></td>  
                            <th>Fecha de vencimiento requerida</th>
                            <td class="text-center"><input type="hidden" name="fecha12" value="0"><input type="checkbox" name="fecha12" value="1" {{ $docsReque->FECHAREQUE12==1? 'checked':'' }}></td>  
                        </tr>  

                        <tr>
                            <th>Diplomas Seminarios y OtrOs</th>
                            <td class="text-center"><input type="hidden" name="requerido13" value="0"><input type="checkbox" name="requerido13" value="1" {{$docsReque->REQUERIDO13==1? 'checked':'' }}></td> 
                            <th>Fecha de vencimiento requerida</th>
                            <td class="text-center"><input type="hidden" name="fecha13" value="0"><input type="checkbox" name="fecha13" value="1" {{ $docsReque->FECHAREQUE13==1? 'checked':'' }}></td>   
                        </tr> 

                        <tr>
                            <th>Certificaciones</th>
                            <td class="text-center"><input type="hidden" name="requerido14" value="0"><input type="checkbox" name="requerido14" value="1" {{$docsReque->REQUERIDO14==1? 'checked':'' }}></td>  
                            <th>Fecha de vencimiento requerida</th>
                            <td class="text-center"><input type="hidden" name="fecha14" value="0"><input type="checkbox" name="fecha14" value="1" {{ $docsReque->FECHAREQUE14==1? 'checked':'' }}></td>  
                        </tr> 

                        <tr>
                            <th>Licencia</th>
                            <td class="text-center"><input type="hidden" name="requerido15" value="0"><input type="checkbox" name="requerido15" value="1" {{$docsReque->REQUERIDO15==1? 'checked':'' }}></td>  
                            <th>Fecha de vencimiento requerida</th>
                            <td class="text-center"><input type="hidden" name="fecha15" value="0"><input type="checkbox" name="fecha15" value="1" {{ $docsReque->FECHAREQUE15==1? 'checked':'' }}></td>  
                        </tr> 

                </table>
                <div class="row text-center">
                    <br><br><br><br>
                    <button class="primario separation">Actualizar</button>
                    <a href="{{ url('/home') }}" class="primario1">Cancelar</a>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection