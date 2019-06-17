@extends('layouts.app')
@section('content')
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<style type="text/css" >
  .parrafo{
    font-size: 16px;
    border: 1px blue solid;
    border-bottom: 3px blue solid;

  }
  table{
    padding: 0px; border-radius: 0px;
    margin-top: 10px;

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
    <div id="tabla1" style="width: 97%;margin: auto;margin-right: 100px;">
      <h3 id="titulo1" style="margin-left: 50px;" hidden>REPORTE DE % DE ASISTENCIA MENSUAL</h3> <label id="ubicacion1" style="float: right;"></label>
          <table id="table_1" class="display" hidden> 
                    <thead>                           
                        <tr>
                            <th>Empleado</th>
                            <th>Per. Normal</th>
                            <th>INC. Maternal</th>
                            <th>INC. Transito</th>
                            <th>INC. Enf. Profesional</th>
                            <th>INC. Acc. Trabajo</th>
                            <th>INC. Enf. Gral</th>
                            <th>Retardos</th>
                            <th>Per. S/Goce de Sueldo</th>
                            <th>Suspención</th>
                            <th>Faltas</th>
                            <th>% de Asistencia</th>
                        </tr>  
                    </thead>                   
                         
                    <tbody>
                        <tr class="pruebacolor">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                                       
                        </tr>  
                    </tbody>
                             
                    </table>
            
          </div> 
          <!-- <table id="totales1" style="clear: both;width: 100%;" hidden> 
                    <thead style="">                           
                        <tr style="">
                            <td class="parrafo" id="reporte1_total0" style="width: 9.5%;"></td>
                            <td class="parrafo" id="reporte1_total1" style="width: 8.5%;"></td>
                            <td class="parrafo"  id="reporte1_total2"></td>
                            <td class="parrafo" id="reporte1_total3"></td>
                            <td class="parrafo" id="reporte1_total4"></td>
                            <td class="parrafo" id="reporte1_total5"></td>
                            <td class="parrafo" id="reporte1_total6"></td>
                            <td class="parrafo" id="reporte1_total7"></td>
                            <td class="parrafo" id="reporte1_total8"></td>
                            <td class="parrafo" id="reporte1_total9"></td>
                            <td class="parrafo" id="reporte1_total10"></td>
                            <td class="parrafo" id="reporte1_total11"></td>
                           
                        </tr>  
                    </thead>                   
                         
                    <tbody>
                        <tr class="pruebacolor">
                            
                                       
                        </tr>  
                    </tbody>
                             
                    </table> -->
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
        <h3 id="titulo2" style="margin-left: 50px;" hidden>REPORTE DE % DE ASISTENCIA POR PERÍODO</h3><label id="ubicacion2" style="float: right;"></label>
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
        <h3 id="titulo3" style="margin-left: 50px;" hidden>REPORTE DE NÓMINA "VARIACIONES POR PERIODO"</h3><label id="ubicacion3" style="float: right;"></label>
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
        <h3 id="titulo4" style="margin-left: 50px;" hidden>REPORTE VARIACIÓN DE COSTO AÑO ANTERIOR</h3><label id="ubicacion4" style="float: right;"></label>
          <table id="table_4" class="display" hidden> 
            <thead>                           
              <tr>
                <th class="parrafo">Empleado</th>
                <th class="parrafo">Nominas Fiscal</th>
                <th class="parrafo">Prevision Social</th>
                <th class="parrafo">Total costo FISCAL</th>
                <th class="parrafo">Asimilados</th>
                <th class="parrafo">Total Costo Periodo Actual</th>
                <th class="parrafo">Total Costo Periodo Año Anterior</th>
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
  <label style="margin-left: 35px;">Mes: &nbsp;</label>
  <select name="variacionE" class="variacionE" id="variacionE" >
    <option value="0">Seleccione Una Opción</option>
    @foreach ($control as $contro)
  <option value="{{$contro->PERIANO}}">{{$contro->PERIANO}}</option>
  @endforeach
  </select>
  <div style="width: 100%; margin:auto;" >
    <div  id="indicador5">
      <div id="tabla5">
        <h3 id="titulo5" style="margin-left: 50px;" hidden>REPORTE DE VARIACIÓN EN COSTO CON ESTRATEGIA VS SIN ESTRATREGIA</h3><label id="ubicacion5" style="float: right;"></label>
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
<!-- --------------------------------------------------------------------------------------------------------------------------------------------- -->
<div style="width: 90%; margin:auto; border-bottom: 1px blue solid;">
  <h3 style="margin-left: 35px;">REPORTE DE PLAZAS</h3>
  <label style="margin-left: 35px;">Generar Reporte: &nbsp;</label>
  <select name="plazas" class="plazas" id="plazas" >
    <option value="0">Seleccione Para Generar</option> 
    <option value="1">Generar</option>
  </select>
  <div style="width: 100%; margin:auto;" >
    <div  id="indicador6">
      <div id="tabla6">
        <h3 id="titulo6" style="margin-left: 50px;" hidden>REPORTE DE PLAZAS</h3><label id="ubicacion6" style="float: right;"></label>
          <table id="table_6" class="display" hidden> 
            <thead>                           
              <tr>
                <th class="parrafo">PUESTO</th>
                <th class="parrafo">PLAZAS AUTORIZADAS</th>
                <th class="parrafo">PLAZAS OCUPADAS</th>
                <th class="parrafo">% DE PLAZAS COMPLETAS</th>
              </tr>  
            </thead>                   
                           
            <tbody>
              
              <tr class="pruebacolor">
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
              </tr>
            </tbody>
          </table>
      </div>  
      <br>
                      <!-- <button type="button" id="boton3" hidden style="float: right;" onclick="javascript:imptabla2(graficaLineal2);">Imprimir Tabla</button> -->
      
        <div id="container6" style="  width: 70%;padding-right: 340px; padding-left: 0px; margin-left: 150px;" hidden>
        </div>
        
      
    </div>
    <button type="button" style="float: right;" id="boton8" hidden onclick="javascript:imprimir6(graficaLineal2);">Imprimir Reporte Completo</button> <br><br>
  </div>
</div>

<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->

<!-- --------------------------------------------------------------------------------------------------------------------------------------------- -->
<div style="width: 90%; margin:auto; border-bottom: 1px blue solid;">
  <h3 style="margin-left: 35px;">REPORTE DE FALTAS VS HORAS EXTRAS</h3>
  <label style="margin-left: 35px;">Generar Reporte: &nbsp;</label>
  <select name="horas" class="horas" id="horas" >
    <option value="0">Seleccione Para Generar</option> 
    <option value="1">Generar</option>
  </select>
  <div style="width: 100%; margin:auto;" >
    <div  id="indicador7">
      <div id="tabla7">
        <h3 id="titulo7" style="margin-left: 50px;" hidden>REPORTE DE FALTAS VS HORAS EXTRAS</h3><label id="ubicacion7" style="float: right;"></label>
          <table id="table_7" class="display" hidden> 
            <thead>                           
              <tr>
                <th class="parrafo">PERIODO</th>
                <th class="parrafo">IMPORTE HRS</th>
                <th class="parrafo">IMPORTE AUS</th>
                
              </tr>  
            </thead>                   
                           
            <tbody>
              
              <tr class="pruebacolor">
                <td class="parrafo"></td>
                <td class="parrafo"></td>
                <td class="parrafo"></td>
                              
              </tr>
              
              <tr class="pruebacolor">
                
                <td class="parrafo"></td>
                <td class="parrafo"></td>
                <td class="parrafo"></td>
                         
              </tr>
            </tbody>
          </table>
      </div>  
      <br>
                      <!-- <button type="button" id="boton3" hidden style="float: right;" onclick="javascript:imptabla2(graficaLineal2);">Imprimir Tabla</button> -->
      
        <div id="container7" style="  width: 70%;padding-right: 340px; padding-left: 0px; margin-left: 150px;" hidden>
        </div>
        
      
    </div>
    <button type="button" style="float: right;" id="boton9" hidden onclick="javascript:imprimir7(graficaLineal2);">Imprimir Reporte Completo</button> <br><br>
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
              // document.getElementById('reporte1_total0').innerHTML=data['totales'][0];
              // document.getElementById('reporte1_total1').innerHTML=data['totales'][1];
              // document.getElementById('reporte1_total2').innerHTML=data['totales'][2];
              // document.getElementById('reporte1_total3').innerHTML=data['totales'][3];
              // document.getElementById('reporte1_total4').innerHTML=data['totales'][4];
              // document.getElementById('reporte1_total5').innerHTML=data['totales'][5];
              // document.getElementById('reporte1_total6').innerHTML=data['totales'][6];
              // document.getElementById('reporte1_total7').innerHTML=data['totales'][7];
              // document.getElementById('reporte1_total8').innerHTML=data['totales'][8];
              // document.getElementById('reporte1_total9').innerHTML=data['totales'][9];
              // document.getElementById('reporte1_total10').innerHTML=data['totales'][10];
              // document.getElementById('reporte1_total11').innerHTML=data['totales'][11];
               
            } else {
                alert('Error de acceso a la base de datos. Verifique la conexión...')
            }

        });   
  });


  function tabla($valores) {

       var data = $valores;
        document.getElementById('table_1').style.display = 'block';
        // document.getElementById('totales1').style.display = 'block';
        
        document.getElementById('boton2').style.display = 'block';
        $('#table_1').DataTable( {
             destroy: true,
             data: data,   
             "order": [[ 1, "asc" ]],
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
      marcacion = new Date()
      /* Capturamos la Hora */
      Hora = marcacion.getHours()
      /* Capturamos los Minutos */
      Minutos = marcacion.getMinutes()
      /* Capturamos los Segundos */
      Segundos = marcacion.getSeconds()
      /*variable para el apóstrofe de am o pm*/
      dn = "a.m"
      if (Hora > 12) {
      dn = "p.m"
      Hora = Hora - 12
      }
      if (Hora == 0)
      Hora = 12
      /* Si la Hora, los Minutos o los Segundos son Menores o igual a 9, le añadimos un 0 */
      if (Hora <= 9) Hora = "0" + Hora
      if (Minutos <= 9) Minutos = "0" + Minutos
      if (Segundos <= 9) Segundos = "0" + Segundos
      document.getElementById('ubicacion1').innerHTML = 'Cancún, Quintana Roo, México &nbsp;&nbsp;&nbsp;'+' HORA: '+ Hora + ":" + Minutos + ":" + Segundos+ " " + dn;
    
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
             "order": [[ 1, "asc" ]],
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
    marcacion = new Date()
      /* Capturamos la Hora */
      Hora = marcacion.getHours()
      /* Capturamos los Minutos */
      Minutos = marcacion.getMinutes()
      /* Capturamos los Segundos */
      Segundos = marcacion.getSeconds()
      /*variable para el apóstrofe de am o pm*/
      dn = "a.m"
      if (Hora > 12) {
      dn = "p.m"
      Hora = Hora - 12
      }
      if (Hora == 0)
      Hora = 12
      /* Si la Hora, los Minutos o los Segundos son Menores o igual a 9, le añadimos un 0 */
      if (Hora <= 9) Hora = "0" + Hora
      if (Minutos <= 9) Minutos = "0" + Minutos
      if (Segundos <= 9) Segundos = "0" + Segundos
      document.getElementById('ubicacion2').innerHTML = 'Cancún, Quintana Roo, México &nbsp;&nbsp;&nbsp;'+' HORA: '+ Hora + ":" + Minutos + ":" + Segundos+ " " + dn;
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
             "order": [[ 1, "asc" ]],
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
              return '<b>'+ this.point.name +'</b>: $'+ this.y +' pesos';
            }
          }
        }
      },
        series: [{
        type: 'pie',
        name: 'Browser share',
        data: [['Total Variación',$valores[1]],['Total Costo Periodo Actual',$valores[2]],['Total Costo Periodo Anterior',$valores[3]]
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
    marcacion = new Date()
      /* Capturamos la Hora */
      Hora = marcacion.getHours()
      /* Capturamos los Minutos */
      Minutos = marcacion.getMinutes()
      /* Capturamos los Segundos */
      Segundos = marcacion.getSeconds()
      /*variable para el apóstrofe de am o pm*/
      dn = "a.m"
      if (Hora > 12) {
      dn = "p.m"
      Hora = Hora - 12
      }
      if (Hora == 0)
      Hora = 12
      /* Si la Hora, los Minutos o los Segundos son Menores o igual a 9, le añadimos un 0 */
      if (Hora <= 9) Hora = "0" + Hora
      if (Minutos <= 9) Minutos = "0" + Minutos
      if (Segundos <= 9) Segundos = "0" + Segundos
      document.getElementById('ubicacion3').innerHTML = 'Cancún, Quintana Roo, México &nbsp;&nbsp;&nbsp;'+' HORA: '+ Hora + ":" + Minutos + ":" + Segundos+ " " + dn;
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
    alert('Datos insuficientes');
    var token = $('input[name=_token]').val();        
    var tipo  =  $('#variacionA').val();

    $.post("get-reporte-cuatro", { tipo: tipo, _token: token }, function( data ) { 
           
            if (data != 'Error') {
              tabla4(data['tabla']);
              Reporte4Circular(data['totales']);
              Reporte4Barras(data['grafica'],data['nombres'],data['anterior']);
              // grafica1(data['grafica'],data['nombres']);
               
            } else {
                alert('Error de acceso a la base de datos. Verifique la conexión...')
            }

        });


    document.getElementById('graficaCircular2').style.display = 'block';
    document.getElementById('graficabarras2').style.display = 'block';
          
  });

  function tabla4($valores){
    
    var data = $valores;
    document.getElementById('table_4').style.display = 'block';
    document.getElementById('boton6').style.display = 'block';
    $('#table_4').DataTable( {
             destroy: true,  
             data: data,   
             "order": [[ 1, "asc" ]],
             dom: 'Bfrtip',
              buttons: [
                  'csv', 'excel', 'pdf', 'print'
              ]        
        });
  }


    var chart;
  function Reporte4Circular ($valores) {
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
        data: [['Total Variación $',$valores[1]],['Total Costo Periodo Actual',$valores[2]],['Total Costo Periodo Anterior',$valores[3]]
            ]
      }]
    });
  };

  function Reporte4Barras($valores,$nombres,$valoresdos){
    Highcharts.chart('graficabarras2', {
          chart: {
              type: 'area'
          },
          title: {
              text: 'VARIACIÓN POR PERÍODO ANUAL'
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
              name: 'Costo Periodo Año Anterior',
              data: [<?php for ($i=0; $i <$NoEmp ; $i++) { 
                          echo '$valoresdos['; echo $i; echo "],";
                        } ?>]
          }, {
              name: '',
              data: []
          }]
      });
  };

    function imprimir4(emp3){
      
    document.getElementById('titulo4').style.display = 'block';
    marcacion = new Date()
      /* Capturamos la Hora */
      Hora = marcacion.getHours()
      /* Capturamos los Minutos */
      Minutos = marcacion.getMinutes()
      /* Capturamos los Segundos */
      Segundos = marcacion.getSeconds()
      /*variable para el apóstrofe de am o pm*/
      dn = "a.m"
      if (Hora > 12) {
      dn = "p.m"
      Hora = Hora - 12
      }
      if (Hora == 0)
      Hora = 12
      /* Si la Hora, los Minutos o los Segundos son Menores o igual a 9, le añadimos un 0 */
      if (Hora <= 9) Hora = "0" + Hora
      if (Minutos <= 9) Minutos = "0" + Minutos
      if (Segundos <= 9) Segundos = "0" + Segundos
      document.getElementById('ubicacion4').innerHTML = 'Cancún, Quintana Roo, México &nbsp;&nbsp;&nbsp;'+' HORA: '+ Hora + ":" + Minutos + ":" + Segundos+ " " + dn;
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

    var tipo  =  $('#variacionE').val();

    $.post("get-reporte-cinco", { tipo: tipo, _token: token }, function( data ) { 
            if (data != 'Error') {
              tabla5(data['tabla']);
              Reporte5Barras(data['totales']);
               
            } else {
                alert('Error de acceso a la base de datos. Verifique la conexión...')
            }

        });

    document.getElementById('container2').style.display = 'block';
          
  });

  function tabla5($valores){
    
    var data = $valores;
    document.getElementById('table_5').style.display = 'block';
    document.getElementById('boton7').style.display = 'block';
    $('#table_5').DataTable( {
             destroy: true,  
             data: data,   
             "order": [[ 1, "asc" ]],
             dom: 'Bfrtip',
              buttons: [
                  'csv', 'excel', 'pdf', 'print'
              ]        
        });
  }

    var chart;
  function Reporte5Barras($valores){
    
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
                    format: '${point.y:.1f} pesos en total'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>${point.y:.2f}</b> pesos del total<br/>'
        },

        "series": [
            {
                "name": "VARIACION EN COSTO CON ESTRATEGIA VS SIN ESTRATREGIA",
                "colorByPoint": true,
                "data": [
                    {
                        "name": "Total Costo CON Estrategia",
                        "y": $valores[1],
                        "drilldown": ""
                    },
                    {
                        "name": "Total Costo SIN Estrategia",
                        "y": $valores[2],
                        "drilldown": ""
                    },
                    {
                        "name": "Ahorro Compañía",
                        "y":$valores[3],
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
  }

    function imprimir5(emp3){
      
    document.getElementById('titulo5').style.display = 'block';
    marcacion = new Date()
      /* Capturamos la Hora */
      Hora = marcacion.getHours()
      /* Capturamos los Minutos */
      Minutos = marcacion.getMinutes()
      /* Capturamos los Segundos */
      Segundos = marcacion.getSeconds()
      /*variable para el apóstrofe de am o pm*/
      dn = "a.m"
      if (Hora > 12) {
      dn = "p.m"
      Hora = Hora - 12
      }
      if (Hora == 0)
      Hora = 12
      /* Si la Hora, los Minutos o los Segundos son Menores o igual a 9, le añadimos un 0 */
      if (Hora <= 9) Hora = "0" + Hora
      if (Minutos <= 9) Minutos = "0" + Minutos
      if (Segundos <= 9) Segundos = "0" + Segundos
      document.getElementById('ubicacion5').innerHTML = 'Cancún, Quintana Roo, México &nbsp;&nbsp;&nbsp;'+' HORA: '+ Hora + ":" + Minutos + ":" + Segundos+ " " + dn;
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
       
</script>

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
  });  
  $('#plazas').change(function() {
    var token = $('input[name=_token]').val();        
    var tipo  =  $('#plazas').val();

        $.post("get-reporte-seis", { tipo: tipo, _token: token }, function( data ) {  

            if (data != 'Error') {
              tabla6(data['tabla']);
              grafica6(data['totales'],data['nombres']);
               
            } else {
                alert('Error de acceso a la base de datos. Verifique la conexión...')
            }

        });   
  });


  function tabla6($valores) {

       var data = $valores;
        document.getElementById('table_6').style.display = 'block';
        
        document.getElementById('boton8').style.display = 'block';
        $('#table_6').DataTable( {
             destroy: true,
             data: data,   
             "order": [[ 1, "asc" ]],
             dom: 'Bfrtip',
              buttons: [
                  'csv', 'excel', 'pdf', 'print'
              ]
        });
      
    };
 
  var chart;
  function grafica6($valores,$nombres) {
    document.getElementById('container6').style.display = 'block';
    chart = new Highcharts.Chart({
      chart: {
        renderTo: 'container6',  // Le doy el nombre a la gráfica
        defaultSeriesType: 'line' // Pongo que tipo de gráfica es
      },
      title: {
        text: '% de plazas completas'  // Titulo (Opcional)
      },
      subtitle: {
        text: 'Vally.com'   // Subtitulo (Opcional)
      },
      // Pongo los datos en el eje de las 'X'
      xAxis: {
        categories: [<?php for ($i=0; $i <$NoPues ; $i++) { 
                        echo '$nombres['; echo $i; echo "],";
                      } ?>],
          // Pongo el título para el eje de las 'X'
          title: {
            text: 'Plazas'
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
                      name: '% de Plazas Completas',
                      data: [<?php for ($i=0; $i <$NoPues ; $i++) { 
                        echo '$valores['; echo $i; echo "],";
                      } ?>]
                  }],
      }); 
    };

  function imprimir6(imp1){
      
      document.getElementById('titulo6').style.display = 'block';
      marcacion = new Date()
      /* Capturamos la Hora */
      Hora = marcacion.getHours()
      /* Capturamos los Minutos */
      Minutos = marcacion.getMinutes()
      /* Capturamos los Segundos */
      Segundos = marcacion.getSeconds()
      /*variable para el apóstrofe de am o pm*/
      dn = "a.m"
      if (Hora > 12) {
      dn = "p.m"
      Hora = Hora - 12
      }
      if (Hora == 0)
      Hora = 12
      /* Si la Hora, los Minutos o los Segundos son Menores o igual a 9, le añadimos un 0 */
      if (Hora <= 9) Hora = "0" + Hora
      if (Minutos <= 9) Minutos = "0" + Minutos
      if (Segundos <= 9) Segundos = "0" + Segundos
      document.getElementById('ubicacion6').innerHTML = 'Cancún, Quintana Roo, México &nbsp;&nbsp;&nbsp;'+' HORA: '+ Hora + ":" + Minutos + ":" + Segundos+ " " + dn;
    
    document.getElementsByClassName('dt-buttons')[0].style.visibility = "hidden";
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
    
  var contenido= document.getElementById('indicador6').innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;

    location.reload(true);
        return true;}    
</script>

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
  });  
  $('#horas').change(function() {
    var token = $('input[name=_token]').val();        
    var tipo  =  $('#horas').val();

        $.post("get-reporte-siete", { tipo: tipo, _token: token }, function( data ) {  

            if (data != 'Error') {
              tabla7(data['tabla']);
              grafica7(data['horas'],data['nombres'],data['aus']);
               
            } else {
                alert('Error de acceso a la base de datos. Verifique la conexión...')
            }

        });   
  });


  function tabla7($valores) {

       var data = $valores;
        document.getElementById('table_7').style.display = 'block';
        
        document.getElementById('boton9').style.display = 'block';
        $('#table_7').DataTable( {
             destroy: true,
             data: data,   
             "order": [[ 0, "asc" ]],
             dom: 'Bfrtip',
              buttons: [
                  'csv', 'excel', 'pdf', 'print'
              ]
        });
      
    };
 
  var chart;
  function grafica7($horas,$nombres,$aus) {
    
    document.getElementById('container7').style.display = 'block';
    chart = new Highcharts.Chart('container7',{
          chart: {
              type: 'line'
          },
          title: {
              text: 'FALTAS VS HORAS EXTRAS'
          },
          xAxis: {
              categories: [<?php for ($i=0; $i <$array ; $i++) { 
                          echo '$nombres['; echo $i; echo "],";
                        } ?>]
          },
          yAxis: {
                // Pongo el título para el eje de las 'Y'
                title: {
                  text: 'Importe en pesos'
                }
              },
          credits: {
              enabled: false
          },
          series: [{
              name: 'IMPORTE HRS',
              data: [<?php for ($i=0; $i <$array ; $i++) { 
                          echo '$horas['; echo $i; echo "],";
                        } ?>]
          }, {
              name: 'IMPORTE AUS',
              data: [<?php for ($i=0; $i <$array ; $i++) { 
                          echo '$aus['; echo $i; echo "],";
                        } ?>]
          }]
      }); 
    };

  function imprimir7(imp1){
      
      document.getElementById('titulo7').style.display = 'block';
      marcacion = new Date()
      /* Capturamos la Hora */
      Hora = marcacion.getHours()
      /* Capturamos los Minutos */
      Minutos = marcacion.getMinutes()
      /* Capturamos los Segundos */
      Segundos = marcacion.getSeconds()
      /*variable para el apóstrofe de am o pm*/
      dn = "a.m"
      if (Hora > 12) {
      dn = "p.m"
      Hora = Hora - 12
      }
      if (Hora == 0)
      Hora = 12
      /* Si la Hora, los Minutos o los Segundos son Menores o igual a 9, le añadimos un 0 */
      if (Hora <= 9) Hora = "0" + Hora
      if (Minutos <= 9) Minutos = "0" + Minutos
      if (Segundos <= 9) Segundos = "0" + Segundos
      document.getElementById('ubicacion7').innerHTML = 'Cancún, Quintana Roo, México &nbsp;&nbsp;&nbsp;'+' HORA: '+ Hora + ":" + Minutos + ":" + Segundos+ " " + dn;
    
    document.getElementsByClassName('dt-buttons')[0].style.visibility = "hidden";
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
    
  var contenido= document.getElementById('indicador7').innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;

    location.reload(true);
        return true;}    
</script>
@endsection