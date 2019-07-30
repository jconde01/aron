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

<!-- --------------------------------------------------------------------------------------------------------------------------------------------- -->
<div style="width: 90%; margin:auto; border-bottom: 1px blue solid;">
  <h3 style="margin-left: 35px;">REPORTE IRP</h3>
  <label style="margin-left: 35px;">Generar Reporte: &nbsp;</label>
  <select name="irp" class="irp" id="irp" >
    <option value="0">Seleccione Para Generar</option> 
    <option value="1">Generar</option>
  </select>
  <div style="width: 100%; margin:auto;" >
    <div  id="indicador8">
      <div id="tabla8">
        <h3 id="titulo8" style="margin-left: 50px;" hidden>REPORTE IRP</h3><label id="ubicacion8" style="float: right;"></label>
          <table id="table_8" class="display" hidden> 
            <thead>                           
              <tr>
                <th class="parrafo">MES</th>
                <th class="parrafo">ALTAS</th>
                <th class="parrafo">BAJAS</th>
                <th class="parrafo">NUMERO DE TRABAJADORES A INICIAR EL PERIODO</th>
                <th class="parrafo">NUMERO DE TRABAJADORES AL FINAL DEL PERIODO</th>
                <th class="parrafo">IRP</th>
                
              </tr>  
            </thead>                   
                           
            <tbody>
              
              <tr class="pruebacolor">
                <td class="parrafo">01-ENERO</td>
                <td class="parrafo">9</td>
                <td class="parrafo">5</td>
                <td class="parrafo">45</td>
                <td class="parrafo">49</td>
                <td class="parrafo">8.51%</td>                  
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">02-FEBRERO</td>
                <td class="parrafo">8</td>
                <td class="parrafo">4</td>
                <td class="parrafo">49</td>
                <td class="parrafo">53</td>
                <td class="parrafo">7.84%</td>                  
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">03-MARZO</td>
                <td class="parrafo">3</td>
                <td class="parrafo">1</td>
                <td class="parrafo">53</td>
                <td class="parrafo">55</td>
                <td class="parrafo">3.70%</td>                  
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">04-ABRIL</td>
                <td class="parrafo">6</td>
                <td class="parrafo">4</td>
                <td class="parrafo">55</td>
                <td class="parrafo">57</td>
                <td class="parrafo">3.57%</td>                  
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">05-MAYO</td>
                <td class="parrafo">6</td>
                <td class="parrafo">1</td>
                <td class="parrafo">57</td>
                <td class="parrafo">62</td>
                <td class="parrafo">8.40%</td>                  
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">06-JUNIO</td>
                <td class="parrafo">5</td>
                <td class="parrafo">2</td>
                <td class="parrafo">62</td>
                <td class="parrafo">65</td>
                <td class="parrafo">4.72%</td>                  
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">07-JULIO</td>
                <td class="parrafo">10</td>
                <td class="parrafo">6</td>
                <td class="parrafo">65</td>
                <td class="parrafo">69</td>
                <td class="parrafo">5.97%</td>                  
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">08-AGOSTO</td>
                <td class="parrafo">8</td>
                <td class="parrafo">3</td>
                <td class="parrafo">69</td>
                <td class="parrafo">74</td>
                <td class="parrafo">6.99%</td>                  
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">09-SEPTIEMBRE</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0%</td>                  
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">10-OCTUBRE</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0%</td>                  
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">11-NOVIEMBRE</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0%</td>                  
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">12-DICIEMBRE</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0</td>
                <td class="parrafo">0%</td>                  
              </tr>
              
              
            </tbody>
          </table>
      </div>  
      <br>
                      <!-- <button type="button" id="boton3" hidden style="float: right;" onclick="javascript:imptabla2(graficaLineal2);">Imprimir Tabla</button> -->
      
        <div id="container8" style="  width: 80%;padding-right: 340px; padding-left: 0px; margin-left: 150px;" hidden>
        </div>
        
      
    </div>
    <button type="button" style="float: right;" id="boton10" hidden onclick="javascript:imprimir8(graficaLineal2);">Imprimir Reporte Completo</button> <br><br>
  </div>
</div>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->

<!-- --------------------------------------------------------------------------------------------------------------------------------------------- -->
<div style="width: 90%; margin:auto; border-bottom: 1px blue solid;">
  <h3 style="margin-left: 35px;">REPORTE CAUSAS DE BAJA</h3>
  <label style="margin-left: 35px;">Generar Reporte: &nbsp;</label>
  <select name="baja" class="baja" id="baja" >
    <option value="0">Seleccione Para Generar</option> 
    <option value="1">Generar</option>
  </select>
  <div style="width: 100%; margin:auto;" >
    <div  id="indicador9">
      <div id="tabla9">
        <h3 id="titulo9" style="margin-left: 50px;" hidden>REPORTE CAUSAS DE BAJA</h3><label id="ubicacion9" style="float: right;"></label>
          <table id="table_9" class="display" hidden> 
            <thead>                           
              <tr>
                <th class="parrafo">FECHA DE BAJA</th>
                <th class="parrafo">MES</th>
                <th class="parrafo">SEXO</th>
                <th class="parrafo">CAUSA DE SALIDA</th>          
              </tr>  
            </thead>                                             
            <tbody>         
              <tr class="pruebacolor">
                <td class="parrafo">02/01/2019</td>
                <td class="parrafo">01-ENERO</td>
                <td class="parrafo">M</td>
                <td class="parrafo">PROBLEMAS FAMILIARES</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">08/01/2019</td>
                <td class="parrafo">01-ENERO</td>
                <td class="parrafo">M</td>
                <td class="parrafo">OTRO EMPLEO</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">15/01/2019</td>
                <td class="parrafo">01-ENERO</td>
                <td class="parrafo">F</td>
                <td class="parrafo">CAMBIO DE RESIDENCIA</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">19/01/2019</td>
                <td class="parrafo">01-ENERO</td>
                <td class="parrafo">F</td>
                <td class="parrafo">MEJOR SUELDO</td>                  
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">30/01/2019</td>
                <td class="parrafo">01-ENERO</td>
                <td class="parrafo">F</td>
                <td class="parrafo">PROBLEMAS PERSONALES</td>                
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">05/02/2019</td>
                <td class="parrafo">02-FEBRERO</td>
                <td class="parrafo">M</td>
                <td class="parrafo">MEJOR SUELDO</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">20/02/2019</td>
                <td class="parrafo">02-FEBRERO</td>
                <td class="parrafo">M</td>
                <td class="parrafo">MEJOR SUELDO</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">23/03/2019</td>
                <td class="parrafo">03-MARZO</td>
                <td class="parrafo">M</td>
                <td class="parrafo">OTRO EMPLEO</td>                
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">05/04/2019</td>
                <td class="parrafo">04-ABRIL</td>
                <td class="parrafo">F</td>
                <td class="parrafo">CUIDADO DE SUS HIJOS</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">10/04/2019</td>
                <td class="parrafo">04-ABRIL</td>
                <td class="parrafo">F</td>
                <td class="parrafo">ACOSO</td>                
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">23/04/2019</td>
                <td class="parrafo">04-ABRIL</td>
                <td class="parrafo">M</td>
                <td class="parrafo">RENUNCIA VOLUNTARIA</td>               
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">25/04/2019</td>
                <td class="parrafo">04-ABRIL</td>
                <td class="parrafo">F</td>
                <td class="parrafo">MEJOR SUELDO</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">09/05/2019</td>
                <td class="parrafo">05-MAYO</td>
                <td class="parrafo">M</td>
                <td class="parrafo">LEJANIA</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">14/06/2019</td>
                <td class="parrafo">06-JUNIO</td>
                <td class="parrafo">M</td>
                <td class="parrafo">LEJANIA</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">04/06/2019</td>
                <td class="parrafo">06-JUNIO</td>
                <td class="parrafo">F</td>
                <td class="parrafo">OTRO EMPLEO</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">09/07/2019</td>
                <td class="parrafo">07-JULIO</td>
                <td class="parrafo">M</td>
                <td class="parrafo">MEJOR HORARIO</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">12/07/2019</td>
                <td class="parrafo">07-JULIO</td>
                <td class="parrafo">F</td>
                <td class="parrafo">MAYOR PRESTACIONES</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">12/07/2019</td>
                <td class="parrafo">07-JULIO</td>
                <td class="parrafo">F</td>
                <td class="parrafo">CAMBIO DE RESIDENCIA</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">17/07/2019</td>
                <td class="parrafo">07-JULIO</td>
                <td class="parrafo">M</td>
                <td class="parrafo">PROBLEMAS FAMILIARES</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">23/07/2019</td>
                <td class="parrafo">07-JULIO</td>
                <td class="parrafo">F</td>
                <td class="parrafo">CUIDADO DE SUS HIJOS</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">30/07/2019</td>
                <td class="parrafo">07-JULIO</td>
                <td class="parrafo">F</td>
                <td class="parrafo">CUIDADO DE SUS HIJOS</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">05/08/2019</td>
                <td class="parrafo">08-AGOSTO</td>
                <td class="parrafo">M</td>
                <td class="parrafo">CAMBIO DE RESIDENCIA</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">07/08/2019</td>
                <td class="parrafo">08-AGOSTO</td>
                <td class="parrafo">M</td>
                <td class="parrafo">OTRO EMPLEO</td>                 
              </tr>
              <tr class="pruebacolor">
                <td class="parrafo">12/08/2019</td>
                <td class="parrafo">08-AGOSTO</td>
                <td class="parrafo">M</td>
                <td class="parrafo">MEJOR HORARIO</td>                 
              </tr>             
            </tbody>
          </table>
      </div>  
      <br>
                      <!-- <button type="button" id="boton3" hidden style="float: right;" onclick="javascript:imptabla2(graficaLineal2);">Imprimir Tabla</button> -->
      
        <div id="container9" style="  width: 50%;float: left;" hidden>
        </div>
        <div id="container10" style="  width: 50%; float: right;" hidden>
        </div>
        
      
    </div>
    <button type="button" style="float: right;" id="boton11" hidden onclick="javascript:imprimir9(graficaLineal2);">Imprimir Reporte Completo</button> <br><br>
  </div>
</div>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<br><br>
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

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
  });  
  $('#irp').change(function() {
    var token = $('input[name=_token]').val();        
    var tipo  =  $('#horas').val();
      tabla8();
      grafica8();
        // $.post("get-reporte-siete", { tipo: tipo, _token: token }, function( data ) {  

        //     if (data != 'Error') {
        //       tabla7(data['tabla']);
        //       grafica7(data['horas'],data['nombres'],data['aus']);
               
        //     } else {
        //         alert('Error de acceso a la base de datos. Verifique la conexión...')
        //     }

        // });   
  });


  function tabla8() {

       // var data = $valores;
        document.getElementById('table_8').style.display = 'block';
        
        document.getElementById('boton10').style.display = 'block';
        $('#table_8').DataTable( {
             destroy: true,
            
             "order": [[ 0, "asc" ]],
             dom: 'Bfrtip',
              buttons: [
                  'csv', 'excel', 'pdf', 'print'
              ]
        });
      
    };
 
  var chart;
  function grafica8() {
    
    document.getElementById('container8').style.display = 'block';
    Highcharts.chart('container8', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'IRP'
    },
    subtitle: {
        text: 'Fuente: aron.com.mx'
    },
    xAxis: {
        categories: [
            'ENERO',
            'FEBRERO',
            'MARZO',
            'ABRIL',
            'MAYO',
            'JUNIO',
            'JULIO',
            'AGOSTO',
            'SEPTIEMBRE',
            'OCTUBRE',
            'NOVIEMBRE',
            'DICIEMBRE'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'ALTAS',
        data: [9, 8, 3, 6, 6, 5, 10, 8, 0, 0, 0, 0],
        dataLabels: {
                enabled: true,
                rotation: 0,
                color: '#FFFFFF',
                align: 'right',
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '10px',
                    fontFamily: 'helvetica, arial, sans-serif',
                    textShadow: false,
                    fontWeight: 'normal'

                }
            }

    }, {
        name: 'BAJAS',
        data: [5, 4, 1, 4, 1, 2, 6, 3, 0, 0, 0, 0],
        dataLabels: {
                enabled: true,
                rotation: 0,
                color: '#FFFFFF',
                align: 'right',
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '10px',
                    fontFamily: 'helvetica, arial, sans-serif',
                    textShadow: false,
                    fontWeight: 'normal'

                }
            }

    }, {
        name: 'No. DE TRABAJADORES AL INICIAR PERIODO',
        data: [45, 49, 53, 55, 57, 62, 65, 69, 0, 0, 0, 0],
        dataLabels: {
                enabled: true,
                rotation: 0,
                color: '#FFFFFF',
                align: 'right',
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '10px',
                    fontFamily: 'helvetica, arial, sans-serif',
                    textShadow: false,
                    fontWeight: 'normal'

                }
            }

    }, {
        name: 'No. TRABAJADORES AL FINAL PERIODO',
        data: [49, 53, 55, 57, 62, 65, 69, 74, 0, 0, 0, 0],
        dataLabels: {
                enabled: true,
                rotation: 0,
                color: '#FFFFFF',
                align: 'right',
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '10px',
                    fontFamily: 'helvetica, arial, sans-serif',
                    textShadow: false,
                    fontWeight: 'normal'

                }
            }

    },
    {
        type: 'spline',
        name: 'IRP',
        data: [8.51, 7.84, 3.70, 3.57, 8.40, 4.72, 5.97, 6.99],
        marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'white'
        }
    }]
  });
      };

  function imprimir8(imp1){
      
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
      document.getElementById('ubicacion8').innerHTML = 'Cancún, Quintana Roo, México &nbsp;&nbsp;&nbsp;'+' HORA: '+ Hora + ":" + Minutos + ":" + Segundos+ " " + dn;
    
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
    
  var contenido= document.getElementById('indicador8').innerHTML;
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
  $('#baja').change(function() {
    var token = $('input[name=_token]').val();        
    var tipo  =  $('#horas').val();
      tabla9();
      grafica9();
      grafica10();
        // $.post("get-reporte-siete", { tipo: tipo, _token: token }, function( data ) {  

        //     if (data != 'Error') {
        //       tabla7(data['tabla']);
        //       grafica7(data['horas'],data['nombres'],data['aus']);
               
        //     } else {
        //         alert('Error de acceso a la base de datos. Verifique la conexión...')
        //     }

        // });   
  });


  function tabla9() {

       // var data = $valores;
        document.getElementById('table_9').style.display = 'block';
        
        document.getElementById('boton11').style.display = 'block';
        $('#table_9').DataTable( {
             destroy: true,
            
             "order": [[ 1, "asc" ]],
             dom: 'Bfrtip',
              buttons: [
                  'csv', 'excel', 'pdf', 'print'
              ]
        });
      
    };
 
  var chart;
  function grafica9() {
    
    document.getElementById('container9').style.display = 'block';
    Highcharts.chart('container9', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'BAJAS POR GÉNERO'
    },
    subtitle: {
        text: 'Fuente: aron.com.mx'
    },
    xAxis: {
        categories: [
            'ENERO',
            'FEBRERO',
            'MARZO',
            'ABRIL',
            'MAYO',
            'JUNIO',
            'JULIO',
            'AGOSTO',
            'SEPTIEMBRE',
            'OCTUBRE',
            'NOVIEMBRE',
            'DICIEMBRE'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'F',
        data: [3, 0, 0, 3, 0, 1, 4, 1, 0, 0, 0, 0],
        dataLabels: {
                enabled: true,
                rotation: 0,
                color: '#FFFFFF',
                align: 'right',
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '10px',
                    fontFamily: 'helvetica, arial, sans-serif',
                    textShadow: false,
                    fontWeight: 'normal'

                }
            }

    }, {
        name: 'M',
        data: [2, 2, 1, 1, 1, 1, 2, 2, 0, 0, 0, 0],
        dataLabels: {
                enabled: true,
                rotation: 0,
                color: '#FFFFFF',
                align: 'right',
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '10px',
                    fontFamily: 'helvetica, arial, sans-serif',
                    textShadow: false,
                    fontWeight: 'normal'

                }
            }

    },]

    });
  };

  function grafica10() {
    
    document.getElementById('container10').style.display = 'block';
    Highcharts.chart('container10', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'MOTIVOS DE BAJA'
    },
    subtitle: {
        text: 'Fuente: aron.com.mx'
    },
    xAxis: {
        categories: [
            'ACOSO',
            'CAMBIO DE RESIDENCIA',
            'CUIDADO DE SUS HIJOS',
            'LEJANIA',
            'MAYORES PRESTACIONES',
            'MEJOR HORARIO',
            'MEJOR SUELDO',
            'OTRO EMPLEO',
            'PROBLEMAS FAMILIARES',
            'PROBLEMAS PERSONALES',
            'RENUNCIA VOLUNTARIA'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'TOTAL',
        data: [1, 3, 3, 2, 1, 2, 4, 4, 2, 1, 1],
        dataLabels: {
                enabled: true,
                rotation: 0,
                color: '#FFFFFF',
                align: 'right',
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '10px',
                    fontFamily: 'helvetica, arial, sans-serif',
                    textShadow: false,
                    fontWeight: 'normal'

                }
            }

    }]
    });
  };

  function imprimir9(imp1){
      
      document.getElementById('titulo9').style.display = 'block';
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
      document.getElementById('ubicacion8').innerHTML = 'Cancún, Quintana Roo, México &nbsp;&nbsp;&nbsp;'+' HORA: '+ Hora + ":" + Minutos + ":" + Segundos+ " " + dn;
    
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
    
  var contenido= document.getElementById('indicador9').innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;

    location.reload(true);
        return true;}    
</script>
@endsection