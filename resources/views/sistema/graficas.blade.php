@extends('layouts.app')

@section('title','Listado de Graficas')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <h2 class="titulo">Graficas DashBoard</h2>
            <div class="row">
                <!-- <a href="{{ url('/admin/celulas/create')}}" class="btn btn-primary btn-round" role="button">Nueva Célula</a> -->
                <br>
                <br>
                <form method="post" action="{{ url('/sistema/home') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table class="table" style="width: 400px; margin: auto;">
                         <tr>
                            <th>Mensaje de Bienvenida</th>
                            <td class="text-center"><input type="hidden" name="mensaje" value="0"><input type="checkbox" name="mensaje" value="1" {{ $graficas->mensaje? 'checked':'' }}></td>    
                        </tr>
                        <tr>
                            <th>Grafica 1</th>
                            <td class="text-center"><input type="hidden" name="grafica1" value="0"><input type="checkbox" name="grafica1" value="1" {{ $graficas->grafica1? 'checked':'' }}></td>    
                        </tr>
                                                     
                        <tr>
                            <th>Grafica 2</th>
                            <td class="text-center"><input type="hidden" name="grafica2" value="0"><input type="checkbox" name="grafica2" value="1" {{ $graficas->grafica2? 'checked':'' }}></td>    
                        </tr>

                         <tr>
                            <th>Grafica 3</th>
                            <td class="text-center"><input type="hidden" name="grafica3" value="0"><input type="checkbox" name="grafica3" value="1" {{ $graficas->grafica3? 'checked':'' }}></td>    
                        </tr>

                        <tr>
                            <th>Grafica 4</th>
                            <td class="text-center"><input type="hidden" name="grafica4" value="0"><input type="checkbox" name="grafica4" value="1" {{ $graficas->grafica4? 'checked':'' }}></td>
                        </tr>

                        <tr>
                            <th>Grafica 5</th>
                            <td class="text-center"><input type="hidden" name="grafica5" value="0"><input type="checkbox" name="grafica5" value="1" {{ $graficas->grafica5? 'checked':'' }}></td>    
                        </tr>

                        <tr>
                            <th>Grafica 6</th>
                            <td class="text-center"><input type="hidden" name="grafica6" value="0"><input type="checkbox" name="grafica6" value="1" {{ $graficas->grafica6? 'checked':'' }}></td>    
                        </tr>

                        <tr>
                            <th>Grafica 7</th>
                            <td class="text-center"><input type="hidden" name="grafica7" value="0"><input type="checkbox" name="grafica7" value="1" {{ $graficas->grafica7? 'checked':'' }}></td>
                        </tr>

                        <tr>
                            <th>Grafica 8</th>
                            <td class="text-center"><input type="hidden" name="grafica8" value="0"><input type="checkbox" name="grafica8" value="1" {{ $graficas->grafica8? 'checked':'' }}></td>
                        </tr>

                        <tr>
                            <th>Grafica 9</th>
                            <td class="text-center"><input type="hidden" name="grafica9" value="0"><input type="checkbox" name="grafica9" value="1" {{ $graficas->grafica9? 'checked':'' }}></td>    
                        </tr>

                        <tr>
                            <th>Grafica 10</th>
                            <td class="text-center"><input type="hidden" name="grafica10" value="0"><input type="checkbox" name="grafica10" value="1" {{ $graficas->grafica10? 'checked':'' }}></td>    
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