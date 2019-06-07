@extends('layouts.app')
@section('content')
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<style type="text/css" >
  .parrafo{
    font-size: 12px;
    border: 1px blue solid;
  }
 /* @media print{
     #tabla1{
    writing-mode: tb-rl;
  }
  }*/
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

<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
<div style="width: 90%; margin:auto; border-bottom: 1px blue solid;">
  <h3 style="margin-left: 35px;">REPORTE DE NÓMINA "VARIACIONES POR PERIODO"</h3>
  <label style="margin-left: 35px;">Período: &nbsp;</label>
  <select name="variacion" class="variacion" id="variacion" >
    <option value="0">Seleccione Una Opción</option>
    @foreach ($controlPeriodos as $controlPeriodo)
    <option value="{{$controlPeriodo->PERIODO}}">{{$controlPeriodo->PERIODO}}</option>
    @endforeach
  </select>
  <div style="width: 100%; margin:auto;" >
    <div  id="indicador3">
      <div id="tabla3">
        <h3 id="titulo3" style="margin-left: 50px;" hidden>REPORTE DE NÓMINA "VARIACIONES POR PERIODO"</h3><label>Cancún, Quintana Roo, México</label>
          <table id="table_3" class="display" hidden> 
            <thead>                           
              <tr>
                <th class="parrafo">Empleado</th>
                <th class="parrafo">Nominas Fiscal</th>
                <th class="parrafo">Prevision Social</th>
                <th class="parrafo">Total costo FISCAL</th>
                <th class="parrafo">Asimilados</th>
                <th class="parrafo">Total Costo Periodo Actual</th>
                <th class="parrafo">Total Costo Periodo Anterior</th>
                <th class="parrafo">Variación en $</th>
                <th class="parrafo">Variación en %</th>
                
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
              </tr>
            
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
              </tr>
            </tbody>
          </table>
      </div>  
      <br>
                      <!-- <button type="button" id="boton3" hidden style="float: right;" onclick="javascript:imptabla2(graficaLineal2);">Imprimir Tabla</button> -->
      <div style="display: flex;margin-top: 140px;">
        <div id="graficaCircular1" style="margin: auto; width: 45%;" hidden>
        </div>
        <div id="graficabarras1" style="margin: auto; width: 45%;" hidden>
        </div>
      </div>
    </div>
    <button type="button" style="float: right;" id="boton5" hidden onclick="javascript:imprimir3(graficaLineal2);">Imprimir Reporte Completo</button> <br><br>
  </div>
</div>

<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->

<!-- -------------------------------------------------------------------------------------------------------------------------------------------------- -->
<div style="width: 90%; margin:auto; border-bottom: 1px blue solid;">
  <h3 style="margin-left: 35px;">REPORTE VARIACIÓN DE COSTO AÑO ANTERIOR</h3>
  <label style="margin-left: 35px;">Período: &nbsp;</label>
  <select name="variacionA" class="variacionA" id="variacionA" >
    <option value="0">Seleccione Una Opción</option>
    @foreach ($controlPeriodos as $controlPeriodo)
    <option value="{{$controlPeriodo->PERIODO}}">{{$controlPeriodo->PERIODO}}</option>
    @endforeach
  </select>
  <div style="width: 100%; margin:auto;" >
    <div id="indicador4">
      <div id="tabla4">
        <h3 id="titulo4" style="margin-left: 50px;" hidden>REPORTE VARIACIÓN DE COSTO AÑO ANTERIOR</h3>
          <table id="table_4" class="display" hidden> 
            <thead>                           
              <tr>
                <th class="parrafo">Empleado</th>
                <th class="parrafo">Nominas Fiscal</th>
                <th class="parrafo">Prevision Social</th>
                <th class="parrafo">Total costo FISCAL</th>
                <th class="parrafo">Asimilados</th>
                <th class="parrafo">Total Costo Periodo Actual</th>
                <th class="parrafo">Total Costo Periodo Anterior</th>
                <th class="parrafo">Variación en $</th>
                <th class="parrafo">Variación en %</th>
                
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
              </tr>
              
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
              </tr>
            </tbody>
          </table>
      </div>  
      <br>
                      <!-- <button type="button" id="boton3" hidden style="float: right;" onclick="javascript:imptabla2(graficaLineal2);">Imprimir Tabla</button> -->
      <div style="display: flex;">
        <div id="graficaCircular2" style="margin: auto; width: 45%;" hidden>
        </div>
        <div id="graficabarras2" style="margin: auto; width: 45%;" hidden>
        </div>
      </div>
    </div>
    <button type="button" style="float: right;" id="boton6" hidden onclick="javascript:imprimir4(graficaLineal2);">Imprimir Reporte Completo</button> <br><br>
  </div>
</div>

<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->

<!-- --------------------------------------------------------------------------------------------------------------------------------------------- -->
<div style="width: 90%; margin:auto; border-bottom: 1px blue solid;">
  <h3 style="margin-left: 35px;">REPORTE DE VARIACIÓN EN COSTO CON ESTRATEGIA VS SIN ESTRATREGIA</h3>
  <label style="margin-left: 35px;">Período: &nbsp;</label>
  <select name="variacionE" class="variacionE" id="variacionE" >
    <option value="0">Seleccione Una Opción</option>
    @foreach ($control as $contro)
  <option value="{{$contro->PERIANO}}">{{$contro->PERIANO}}</option>
  @endforeach
  </select>
  <div style="width: 100%; margin:auto;" >
    <div  id="indicador5">
      <div id="tabla5">
        <h3 id="titulo5" style="margin-left: 50px;" hidden>REPORTE DE VARIACIÓN EN COSTO CON ESTRATEGIA VS SIN ESTRATREGIA</h3>
          <table id="table_5" class="display" hidden> 
            <thead>                           
              <tr>
                <th class="parrafo">Empleado</th>
                <th class="parrafo">Sueldo Neto</th>
                <th class="parrafo">Sueldo fiscal CON ESTRATEGIA</th>
                <th class="parrafo">Prevision Social</th>
                <th class="parrafo">Total costo FISCAL</th>
                <th class="parrafo">Nómina Asimilados</th>
                <th class="parrafo">Total Costo CON Estrategia</th>
                <th class="parrafo">Sueldo fiscal SIN ESTRATEGIA</th>
                <th class="parrafo">Provision Social</th>
                <th class="parrafo">Total Costo SIN Estrategia</th>
                <th class="parrafo">Ahorro Compañía</th>
                <th class="parrafo">Ahorro en %</th>
                
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
      
        <div id="container2" style="margin: auto; width: 95%;" hidden>
        </div>
        
      
    </div>
    <button type="button" style="float: right;" id="boton7" hidden onclick="javascript:imprimir5(graficaLineal2);">Imprimir Reporte Completo</button> <br><br>
  </div>
</div>

<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
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
    var contador =document.getElementsByClassName('dt-buttons');
   for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }
    var contador =document.getElementsByClassName('dataTables_filter');
    for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }

   var contador =document.getElementsByClassName('dataTables_paginate');
   for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }

   var contador =document.getElementsByClassName('dataTables_info');
   for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }
    
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
    var contador =document.getElementsByClassName('dt-buttons');
   for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }
    var contador =document.getElementsByClassName('dataTables_filter');
    for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }

   var contador =document.getElementsByClassName('dataTables_paginate');
   for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }

   var contador =document.getElementsByClassName('dataTables_info');
   for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }
    
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

<script type="text/javascript">
    
  $('#variacion').change(function() {
    
    var token = $('input[name=_token]').val();        
    var tipo  =  $('#variacion').val();

     $.post("get-reporte-tres", { tipo: tipo, _token: token }, function( data ) { 
     // alert(data['totales'][1]);     
            if (data != 'Error') {
              tabla3(data['tabla']);
              Reporte3Circular(data['totales']);
              Reporte3Barras(data['grafica'],data['nombres'],data['anterior']);
              // grafica1(data['grafica'],data['nombres']);
               
            } else {
                alert('Error de acceso a la base de datos. Verifique la conexión...')
            }

        });


    
    document.getElementById('graficaCircular1').style.display = 'block';
    document.getElementById('graficabarras1').style.display = 'block';
    



     
          
  });

  function tabla3($valores){
    var data = $valores;
    document.getElementById('table_3').style.display = 'block';
    document.getElementById('boton5').style.display = 'block';
    $('#table_3').DataTable( {
             destroy: true,  
             data: data,   
             "order": [[ 0, "asc" ]],
             dom: 'Bfrtip',
              buttons: [
                  'csv', 'excel', 'pdf', 'print'
              ]        
        });
  }

    var chart;
  function Reporte3Circular($valores) {
    
    chart = new Highcharts.Chart({
      chart: {
        renderTo: 'graficaCircular1'
      },
      title: {
        text: 'Variación por Periodo'
      },
      subtitle: {
        text: 'Vally.com'
      },
      plotArea: {
        shadow: null,
        borderWidth: null,
        backgroundColor: null
      },
      tooltip: {
        formatter: function() {
          return '<b>'+ this.point.name +'</b>: '+ this.y +' pesos';
        }
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: true,
            color: '#000000',
            connectorColor: '#000000',
            formatter: function() {
              return '<b>'+ this.point.name +'</b>: '+ this.y +' pesos';
            }
          }
        }
      },
        series: [{
        type: 'pie',
        name: 'Browser share',
        data: [['Total Variación $',$valores[1]],['Total Costo Periodo Actual',$valores[2]],['Total Costo Periodo Anterior',$valores[3]]
            ]
      }]
    });
  };

function Reporte3Barras($valores,$nombres,$valoresdos){
  
  Highcharts.chart('graficabarras1', {
        chart: {
            type: 'area'
        },
        title: {
            text: 'VARIACIÓN POR PERÍODO'
        },
        xAxis: {
            categories: [<?php for ($i=0; $i <$NoEmp ; $i++) { 
                        echo '$nombres['; echo $i; echo "],";
                      } ?>]
        },
        yAxis: {
              // Pongo el título para el eje de las 'Y'
              title: {
                text: 'Valor en pesos'
              }
            },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Costo Periodo Actual',
            data: [<?php for ($i=0; $i <$NoEmp ; $i++) { 
                        echo '$valores['; echo $i; echo "],";
                      } ?>]
        }, {
            name: 'Costo Periodo Anterior',
            data: [<?php for ($i=0; $i <$NoEmp ; $i++) { 
                        echo '$valoresdos['; echo $i; echo "],";
                      } ?>]
        }, {
            name: '',
            data: []
        }]
    });
};
  


    function imprimir3(emp3){
      
    document.getElementById('titulo3').style.display = 'block';
    // document.getElementById('boton3').style.visibility = "hidden";
    // document.getElementById('table_1_length').style.visibility = "hidden";
     // document.getElementById('table_1_filter').style.visibility = "hidden";
   var contador =document.getElementsByClassName('dt-buttons');
   for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }
    var contador =document.getElementsByClassName('dataTables_filter');
    for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }

   var contador =document.getElementsByClassName('dataTables_paginate');
   for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }

   var contador =document.getElementsByClassName('dataTables_info');
   for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }

  var contenido= document.getElementById('indicador3').innerHTML;
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

<script type="text/javascript">
    
  $('#variacionA').change(function() {
    
    var token = $('input[name=_token]').val();        
    
    document.getElementById('table_4').style.display = 'block';
    document.getElementById('graficaCircular2').style.display = 'block';
    document.getElementById('graficabarras2').style.display = 'block';
        // document.getElementById('boton3').style.display = 'block';
        document.getElementById('boton6').style.display = 'block';
     $('#table_4').DataTable( {
             destroy: true,   
             "order": [[ 0, "asc" ]],
             dom: 'Bfrtip',
              buttons: [
                  'csv', 'excel', 'pdf', 'print'
              ]        
        });
          
  });

    var chart;
  function Reporte3Circularx {
    chart = new Highcharts.Chart({
      chart: {
        renderTo: 'graficaCircular2'
      },
      title: {
        text: 'Variación por Periodo Anual'
      },
      subtitle: {
        text: 'Vally.com'
      },
      plotArea: {
        shadow: null,
        borderWidth: null,
        backgroundColor: null
      },
      tooltip: {
        formatter: function() {
          return '<b>'+ this.point.name +'</b>: '+ this.y +' pesos';
        }
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: true,
            color: '#000000',
            connectorColor: '#000000',
            formatter: function() {
              return '<b>'+ this.point.name +'</b>: '+ this.y +' pesos';
            }
          }
        }
      },
        series: [{
        type: 'pie',
        name: 'Browser share',
        data: ['Total Costo Periodo Actual',1,'Total Costo Periodo Anterior',2,'Variación en $',3
            ]
      }]
    });
  });

  Highcharts.chart('graficabarras2', {
        chart: {
            type: 'area'
        },
        title: {
            text: 'VARIACIÓN POR PERÍODO ANUAL'
        },
        xAxis: {
            categories: [1,2,3]
        },
        yAxis: {
              // Pongo el título para el eje de las 'Y'
              title: {
                text: 'Valor en pesos'
              }
            },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Costo Periodo Actual',
            data: [1,2,3]
        }, {
            name: 'Costo Periodo Anterior',
            data: [1,2,3,4]
        }, {
            name: '',
            data: []
        }]
    });


    function imprimir4(emp3){
      
    document.getElementById('titulo4').style.display = 'block';
    // document.getElementById('boton3').style.visibility = "hidden";
    // document.getElementById('table_1_length').style.visibility = "hidden";
     // document.getElementById('table_1_filter').style.visibility = "hidden";
    var contador =document.getElementsByClassName('dt-buttons');
   for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }
    var contador =document.getElementsByClassName('dataTables_filter');
    for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }

   var contador =document.getElementsByClassName('dataTables_paginate');
   for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }

   var contador =document.getElementsByClassName('dataTables_info');
   for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }
    
  var contenido= document.getElementById('indicador4').innerHTML;
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

<script type="text/javascript">
    
  $('#variacionE').change(function() {
    
    var token = $('input[name=_token]').val();        
    
    document.getElementById('table_5').style.display = 'block';
    document.getElementById('container2').style.display = 'block';
    
        // document.getElementById('boton3').style.display = 'block';
        document.getElementById('boton7').style.display = 'block';
     $('#table_5').DataTable( {
             destroy: true,   
             "order": [[ 0, "asc" ]],
             dom: 'Bfrtip',
              buttons: [
                  'csv', 'excel', 'pdf', 'print'
              ]        
        });
          
  });

    var chart;
  Highcharts.chart('container2', {
      chart: {
          type: 'column'
      },
      title: {
          text: 'VARIACION EN COSTO CON ESTRATEGIA VS SIN ESTRATREGIA'
      },
      subtitle: {
          text: ''
      },
      xAxis: {
          type: 'categoria'
      },
      yAxis: {
          title: {
              text: 'Dinero'
          }

      },
      legend: {
          enabled: false
      },
      plotOptions: {
          series: {
              borderWidth: 0,
              dataLabels: {
                  enabled: true,
                  format: '{point.y:.1f} en total'
              }
          }
      },

      tooltip: {
          headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
          pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> del total<br/>'
      },

      "series": [
          {
              "name": "VARIACION EN COSTO CON ESTRATEGIA VS SIN ESTRATREGIA",
              "colorByPoint": true,
              "data": [
                  {
                      "name": "Total Costo CON Estrategia",
                      "y": 123,
                      "drilldown": ""
                  },
                  {
                      "name": "Total Costo SIN Estrategia",
                      "y": 1234,
                      "drilldown": ""
                  },
                  {
                      "name": "Ahorro Compañía",
                      "y":12345,
                      "drilldown": ""
                  }
              ]
          }
      ],
      "drilldown": {
          "series": [
              {
                  "name": "Chrome",
                  "id": "Chrome",
                  "data": [
                      [
                          "v65.0",
                          0.1
                      ],
                      [
                          "v64.0",
                          1.3
                      ],
                      [
                          "v63.0",
                          53.02
                      ],
                      [
                          "v62.0",
                          1.4
                      ],
                      [
                          "v61.0",
                          0.88
                      ],
                      [
                          "v60.0",
                          0.56
                      ],
                      [
                          "v59.0",
                          0.45
                      ],
                      [
                          "v58.0",
                          0.49
                      ],
                      [
                          "v57.0",
                          0.32
                      ],
                      [
                          "v56.0",
                          0.29
                      ],
                      [
                          "v55.0",
                          0.79
                      ],
                      [
                          "v54.0",
                          0.18
                      ],
                      [
                          "v51.0",
                          0.13
                      ],
                      [
                          "v49.0",
                          2.16
                      ],
                      [
                          "v48.0",
                          0.13
                      ],
                      [
                          "v47.0",
                          0.11
                      ],
                      [
                          "v43.0",
                          0.17
                      ],
                      [
                          "v29.0",
                          0.26
                      ]
                  ]
              },
              {
                  "name": "Firefox",
                  "id": "Firefox",
                  "data": [
                      [
                          "v58.0",
                          1.02
                      ],
                      [
                          "v57.0",
                          7.36
                      ],
                      [
                          "v56.0",
                          0.35
                      ],
                      [
                          "v55.0",
                          0.11
                      ],
                      [
                          "v54.0",
                          0.1
                      ],
                      [
                          "v52.0",
                          0.95
                      ],
                      [
                          "v51.0",
                          0.15
                      ],
                      [
                          "v50.0",
                          0.1
                      ],
                      [
                          "v48.0",
                          0.31
                      ],
                      [
                          "v47.0",
                          0.12
                      ]
                  ]
              },
              {
                  "name": "Internet Explorer",
                  "id": "Internet Explorer",
                  "data": [
                      [
                          "v11.0",
                          6.2
                      ],
                      [
                          "v10.0",
                          0.29
                      ],
                      [
                          "v9.0",
                          0.27
                      ],
                      [
                          "v8.0",
                          0.47
                      ]
                  ]
              },
              {
                  "name": "Safari",
                  "id": "Safari",
                  "data": [
                      [
                          "v11.0",
                          3.39
                      ],
                      [
                          "v10.1",
                          0.96
                      ],
                      [
                          "v10.0",
                          0.36
                      ],
                      [
                          "v9.1",
                          0.54
                      ],
                      [
                          "v9.0",
                          0.13
                      ],
                      [
                          "v5.1",
                          0.2
                      ]
                  ]
              },
              {
                  "name": "Edge",
                  "id": "Edge",
                  "data": [
                      [
                          "v16",
                          2.6
                      ],
                      [
                          "v15",
                          0.92
                      ],
                      [
                          "v14",
                          0.4
                      ],
                      [
                          "v13",
                          0.1
                      ]
                  ]
              },
              {
                  "name": "Opera",
                  "id": "Opera",
                  "data": [
                      [
                          "v50.0",
                          0.96
                      ],
                      [
                          "v49.0",
                          0.82
                      ],
                      [
                          "v12.1",
                          0.14
                      ]
                  ]
              }
          ]
      }
  });


    function imprimir5(emp3){
      
    document.getElementById('titulo5').style.display = 'block';
    // document.getElementById('boton3').style.visibility = "hidden";
    // document.getElementById('table_1_length').style.visibility = "hidden";
     // document.getElementById('table_1_filter').style.visibility = "hidden";
    var contador =document.getElementsByClassName('dt-buttons');
   for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }
    var contador =document.getElementsByClassName('dataTables_filter');
    for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }

   var contador =document.getElementsByClassName('dataTables_paginate');
   for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }

   var contador =document.getElementsByClassName('dataTables_info');
   for (var i = 0; i < contador.length; i++) {
     contador[i].style.visibility = "hidden";
   }
    
  var contenido= document.getElementById('indicador5').innerHTML;
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