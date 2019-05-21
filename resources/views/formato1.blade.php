@extends('layouts.app')
@section('content')
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<style type="text/css" >
  .parrafo{
    font-size: 10px;
    border: 1px blue solid;
  }
  @media print{
     #tabla1{
    writing-mode: tb-rl;
  }
  }
</style>
<h3 style="margin-left: 120px;">REPORTE DE % DE ASISTENCIA MENSUAL</h3>
<label style="margin-left: 120px;">Mes: &nbsp;</label>
<select name="control" class="tipo" >
  <option value="0">Seleccione Una Opción</option>
  @foreach ($control as $contro)
  <option value="{{$contro->PERIANO}}">{{$contro->PERIANO}}</option>
  @endforeach
</select>
<br><br>
<div style="width: 90%; margin:auto; border-bottom: 1px blue solid;" >
  <div  id="indicador1">
    <div id="tabla1">
      <h3 id="titulo1" style="margin-left: 50px;" hidden>REPORTE DE % DE ASISTENCIA MENSUAL</h3>
          <table id="table_1" class="display" hidden> 
                    <thead>                           
                        <tr>
                            <th class="parrafo">Empleado</th>
                            <th class="parrafo">Per. Normal</th>
                            <th class="parrafo">INC. Maternal</th>
                            <th class="parrafo">INC. Transito</th>
                            <th class="parrafo">INC. Enf. Profesional</th>
                            <th class="parrafo">INC. Acc. Trabajo</th>
                            <th class="parrafo">INC. Enf. Gral</th>
                            <th class="parrafo">Retardos</th>
                            <th class="parrafo">Per. S/Goce de Sueldo</th>
                            <th class="parrafo">Suspención</th>
                            <th class="parrafo">Faltas</th>
                            <th class="parrafo">% de Asistencia</th>
                        </tr>  
                    </thead>                   
                         
                    <tbody>
                        <tr class="pruebacolor">
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                                       
                        </tr>  
                    </tbody>
                             
                    </table>
          </div>  
                    <br>
                    
    <div id="graficaLineal" style="margin: auto; width: 1200px;">
    </div>
  </div>
  <button type="button" style="float: right;" id="boton2" hidden onclick="javascript:imprim1(graficaLineal);">Imprimir Reporte Completo</button> <br><br>
</div>


<div style="width: 90%; margin:auto; border-bottom: 1px blue solid;">
  <h3 style="margin-left: 35px;">REPORTE DE % DE ASISTENCIA POR PERÍODO</h3>
<label style="margin-left: 35px;">Período: &nbsp;</label>
<select name="periodo" class="periodo" id="periodo" >
  <option value="0">Seleccione Una Opción</option>
  @foreach ($controlPeriodos as $controlPeriodo)
  <option value="{{$controlPeriodo->PERIODO}}">{{$controlPeriodo->PERIODO}}</option>
  @endforeach
</select>
<div style="width: 100%; margin:auto;" >
  <div  id="indicador2">
    <div id="tabla2">
      <h3 id="titulo2" style="margin-left: 50px;" hidden>REPORTE DE % DE ASISTENCIA POR PERÍODO</h3>
          <table id="table_2" class="display" hidden> 
                    <thead>                           
                        <tr>
                            <th class="parrafo">Empleado</th>
                            <th class="parrafo">Per. Normal</th>
                            <th class="parrafo">INC. Maternal</th>
                            <th class="parrafo">INC. Transito</th>
                            <th class="parrafo">INC. Enf. Profesional</th>
                            <th class="parrafo">INC. Acc. Trabajo</th>
                            <th class="parrafo">INC. Enf. Gral</th>
                            <th class="parrafo">Retardos</th>
                            <th class="parrafo">Per. S/Goce de Sueldo</th>
                            <th class="parrafo">Suspención</th>
                            <th class="parrafo">Faltas</th>
                            <th class="parrafo">% de Asistencia</th>
                        </tr>  
                    </thead>                   
                         
                    <tbody>
                        <tr class="pruebacolor">
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                            <td class="parrafo"></td>
                                       
                        </tr>  
                    </tbody>
                             
                    </table>
          </div>  
                    <br>
                    <!-- <button type="button" id="boton3" hidden style="float: right;" onclick="javascript:imptabla2(graficaLineal2);">Imprimir Tabla</button> -->
    <div id="graficaLineal2" style="margin: auto; width: 1200px;">
    </div>
  </div>
  <button type="button" style="float: right;" id="boton4" hidden onclick="javascript:imprimir2(graficaLineal2);">Imprimir Reporte Completo</button> <br><br>
</div>
</div>

@include('includes.footer');
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
  });  
  $('.tipo').change(function() {
    var token = $('input[name=_token]').val();        
    var tipo  =  $('.tipo').val();

        $.post("get-reporte", { tipo: tipo, _token: token }, function( data ) {      
            if (data != 'Error') {
              tabla(data['tabla']);
              grafica1(data['grafica'],data['nombres']);
               
            } else {
                alert('Error de acceso a la base de datos. Verifique la conexión...')
            }

        });   
  });


  function tabla($valores) {

       var data = $valores;
        document.getElementById('table_1').style.display = 'block';
        
        document.getElementById('boton2').style.display = 'block';
        $('#table_1').DataTable( {
             destroy: true,
             data: data,   
             "order": [[ 0, "desc" ]],
             dom: 'Bfrtip',
              buttons: [
                  'csv', 'excel', 'pdf', 'print'
              ]
        });
      
    };
 
  var chart;
  function grafica1($valores,$nombres) {
     

    chart = new Highcharts.Chart({
      chart: {
        renderTo: 'graficaLineal',  // Le doy el nombre a la gráfica
        defaultSeriesType: 'line' // Pongo que tipo de gráfica es
      },
      title: {
        text: '% de asistencia'  // Titulo (Opcional)
      },
      subtitle: {
        text: 'Vally.com'   // Subtitulo (Opcional)
      },
      // Pongo los datos en el eje de las 'X'
      xAxis: {
        categories: [<?php for ($i=0; $i <$NoEmp ; $i++) { 
                        echo '$nombres['; echo $i; echo "],";
                      } ?>],
          // Pongo el título para el eje de las 'X'
          title: {
            text: 'Empleados'
          }
        },
        yAxis: {
          // Pongo el título para el eje de las 'Y'
          title: {
            text: 'Rango'
          }
        },
        // Doy formato al la "cajita" que sale al pasar el ratón por encima de la gráfica
        tooltip: {
          enabled: true,
          formatter: function() {
            return '<b>'+ this.series.name +'</b><br/>'+
              this.x +': '+ this.y +' '+this.series.name;
          }
        },
        // Doy opciones a la gráfica
        plotOptions: {
          line: {
            dataLabels: {
              enabled: true
            },
            enableMouseTracking: true
          }
        },
        // Doy los datos de la gráfica para dibujarlas
        series: [{
                      name: '% de asistencias',
                      data: [<?php for ($i=0; $i <$NoEmp ; $i++) { 
                        echo '$valores['; echo $i; echo "],";
                      } ?>]
                  }],
      }); 
    };

    function imprim1(imp1){
      
      document.getElementById('titulo1').style.display = 'block';
    
    document.getElementsByClassName('dt-buttons')[0].style.visibility = "hidden";
    document.getElementById('table_1_filter').style.visibility = "hidden";
    
    
  var contenido= document.getElementById('indicador1').innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;

    location.reload(true);
        return true;}
  // function tabla1(imp1){
  //   document.getElementById('titulo1').style.display = 'block';
  // var contenido= document.getElementById('tabla1').innerHTML;
  //    var contenidoOriginal= document.body.innerHTML;

  //    document.body.innerHTML = contenido;

  //    window.print();

  //    document.body.innerHTML = contenidoOriginal;

  //   location.reload(true);
  //       return true;}       
</script>
<script type="text/javascript">
    
  $('#periodo').change(function() {
    var token = $('input[name=_token]').val();        
    var tipo  =  $('#periodo').val();
    
        $.post("get-reportePeriodo", { tipo: tipo, _token: token }, function( data ) {      
            if (data != 'Error') {
              tabla2(data['tabla']);
              grafica2(data['grafica'],data['nombres']);
               
            } else {
                alert('Error de acceso a la base de datos. Verifique la conexión...')
            }

        });   
  });


  function tabla2($valores) {

       var data = $valores;
        document.getElementById('table_2').style.display = 'block';
        // document.getElementById('boton3').style.display = 'block';
        document.getElementById('boton4').style.display = 'block';
        $('#table_2').DataTable( {
             destroy: true,
             data: data,   
             "order": [[ 0, "desc" ]],
             dom: 'Bfrtip',
              buttons: [
                  'csv', 'excel', 'pdf', 'print'
              ]        
        });
    };
 
  
  function grafica2($valores,$nombres) {
     

    chart = new Highcharts.Chart({
      chart: {
        renderTo: 'graficaLineal2',  // Le doy el nombre a la gráfica
        defaultSeriesType: 'line' // Pongo que tipo de gráfica es
      },
      title: {
        text: '% de asistencia'  // Titulo (Opcional)
      },
      subtitle: {
        text: 'Vally.com'   // Subtitulo (Opcional)
      },
      // Pongo los datos en el eje de las 'X'
      xAxis: {
        categories: [<?php for ($i=0; $i <$NoEmp ; $i++) { 
                        echo '$nombres['; echo $i; echo "],";
                      } ?>],
          // Pongo el título para el eje de las 'X'
          title: {
            text: 'Empleados'
          }
        },
        yAxis: {
          // Pongo el título para el eje de las 'Y'
          title: {
            text: 'Rango'
          }
        },
        // Doy formato al la "cajita" que sale al pasar el ratón por encima de la gráfica
        tooltip: {
          enabled: true,
          formatter: function() {
            return '<b>'+ this.series.name +'</b><br/>'+
              this.x +': '+ this.y +' '+this.series.name;
          }
        },
        // Doy opciones a la gráfica
        plotOptions: {
          line: {
            dataLabels: {
              enabled: true
            },
            enableMouseTracking: true
          }
        },
        // Doy los datos de la gráfica para dibujarlas
        series: [{
                      name: '% de asistencias',
                      data: [<?php for ($i=0; $i <$NoEmp ; $i++) { 
                        echo '$valores['; echo $i; echo "],";
                      } ?>]
                  }],
      }); 
    };


    function imprimir2(emp3){
      
    document.getElementById('titulo2').style.display = 'block';
    // document.getElementById('boton3').style.visibility = "hidden";
    // document.getElementById('table_1_length').style.visibility = "hidden";
     // document.getElementById('table_1_filter').style.visibility = "hidden";
    
    
  var contenido= document.getElementById('indicador2').innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;

    location.reload(true);
        return true;}
  // function imptabla2(imp4){
  //   document.getElementById('titulo2').style.display = 'block';
  //   var contenido= document.getElementById('tabla2').innerHTML;
  //    var contenidoOriginal= document.body.innerHTML;

  //    document.body.innerHTML = contenido;

  //    window.print();

  //    document.body.innerHTML = contenidoOriginal;

  //   location.reload(true);
  //       return true;} 
          
</script>
@endsection