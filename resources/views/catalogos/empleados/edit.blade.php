@extends('layouts.app')
@section('body-class', 'profile-page sidebar-collapse')
@section('content')   
  </div>
  <div class="main main-raised">
    <div>
      <div class="section text-center">
        <h2 class="titulo">Editar Info del Empleado</h2>
        <br>
        
        <form method="POST" action=" {{url('/catalogos/empleados/'.$empl->EMP.'/edit')}} " enctype="multipart/form-data"> 
            {{ csrf_field() }}
          <div class="" style="">           
            <ul class="tab horizontal">
              <li class="tab-group-item"><a data-toggle="tab" href="#nomina1">Nomina 1</a></li>
              <li class="tab-group-item"><a data-toggle="tab" href="#nomina2">Nomina 2</a></li>
              <li class="tab-group-item" style="width: 35%;"><a data-toggle="tab" href="#datosg">Datos Generales</a></li>
              <li class="tab-group-item"><a data-toggle="tab" href="#datosa">Datos Afore</a></li>
            </ul>
            <br><br><br>
            <div class="tab-content">
              <div id="nomina1" class="tab-pane fade in active" style="">
            <div class="row">

                    <div class="col-md-1 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; display: none;">
                            <div class="label-left"><p></p></div>
                            <input type="text"   readonly="readonly" hidden="hidden">
                        </div> 
                    </div>

                    <div class="col-md-5 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo Nomina</p></div>
                            <input type="text" name="TIPONO" value="{{ $empl->tipoNo->NOMBRE }}" readonly="readonly" class="bloqueado">
                        </div> 
                    </div>

                    <div class="col-md-5 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Empleado</p></div>
                            <input type="number" name="EMP" id="EMP" onkeyup="fAgrega2();" value="{{$empl->EMP}}" readonly="readonly" class="bloqueado">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nombre: </p></div>
                            <input type="text" name="NOMBRES" value="{{$empl11->NOMBRES}}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Apellido Paterno: </p></div>
                            <input type="text" name="PATERNO" value="{{$empl11->PATERNO}}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Apellido Materno: </p></div>
                            <input type="text" name="MATERNO" value="{{$empl11->MATERNO}}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>
                    
                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Puesto</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right:0px; margin-left: 75px;" name="PUESTO" value="{{$empl->PUESTO}}" class="inderecha">                             
                                @foreach ($jobs as $job)
                                <option value="{{$job->PUESTO}}" <?php if ($job->PUESTO==$empl->PUESTO) {
                                  echo 'selected="selected"';
                                } ?>>{{$job->NOMBRE}}</option>                 
                                @endforeach
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="border-left: 2px #F0F0F0 solid;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Cuenta Contable</p></div>
                            <input type="text" maxlength="9" name="cuenta" value="{{$empl->cuenta}}" onkeyup="Cue(event, this)">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Departamento</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 0px; margin-left: 75px;font-size: 13px;" name="DEPTO" required value="{{$empl->DEPTO}}" class="inderecha">
                               
                                @foreach ($deps as $dep)
                                <option value="{{$dep->DEPTO}}" <?php if ($dep->DEPTO==$empl->DEPTO) {
                                  echo 'selected="selected"';
                                } ?>>{{$dep->DESCRIP}}</option>                 
                                @endforeach
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="border-left: 2px #F0F0F0 solid;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Trabajador</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="TIPOTRA" value="{{$empl->TIPOTRA}}" class="inderecha">
                                <option value="1" <?php if ($empl->TIPOTRA==1) {
                                    echo 'selected="selected"';
                                } ?> >1-Planta Confianza</option>
                                <option value="2" <?php if ($empl->TIPOTRA==2) {
                                    echo 'selected="selected"';
                                } ?>>2-Eventual Confianza</option>
                                <option value="3"<?php if ($empl->TIPOTRA==3) {
                                    echo 'selected="selected"';
                                } ?>>3-Obrero Planta</option>
                                <option value="4" <?php if ($empl->TIPOTRA==4) {
                                    echo 'selected="selected"';
                                } ?>>4-Obrero Eventaul</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Estado</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="c_Estado" required value="{{$empl->c_Estado}}" class="inderecha">                              
                                @foreach ($ests as $est)
                                <option value="{{$est->c_Estado}}" <?php if ($est->c_Estado==$empl->c_Estado) {
                                    echo 'selected="selected"';
                                } ?>>{{$est->c_NombreEdo}}</option>               
                                @endforeach
                            </select>
                        </div> 
                    </div>

                     <div class="col-md-4 no-pad" style="border-left: 2px #F0F0F0 solid;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Clave Contable</p></div>                           
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="DIRIND" value="{{$empl->DIRIND}}" class="inderecha">
                                <option value="0" <?php if ($empl->DIRIND==0):{
                                    echo 'selected="selected"';
                                } ?>                                   
                                <?php endif ?>>Directa</option>
                                <option value="1" <?php if ($empl->DIRIND==1):{
                                    echo 'selected="selected"';
                                } ?>                                   
                                <?php endif ?>>Indirecta</option>                              
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Jornada</p></div>
                              <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="TIPOJORNADA" value="{{$empl->TIPOJORNADA}}" class="inderecha">
                                <option value="1" <?php if ($empl->TIPOJORNADA==1):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>1-Diurna</option>
                                <option value="2" <?php if ($empl->TIPOJORNADA==2):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>2-Nocturna</option>
                                <option value="3" <?php if ($empl->TIPOJORNADA==3):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>3-Mixta</option>
                                <option value="4" <?php if ($empl->TIPOJORNADA==4):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>4-Por hora</option>
                                <option value="5" <?php if ($empl->TIPOJORNADA==5):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>5-Reducida</option>
                                <option value="6" <?php if ($empl->TIPOJORNADA==6):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>6-Continuada</option>
                                <option value="7" <?php if ($empl->TIPOJORNADA==7):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>7-Partida</option>
                                <option value="8" <?php if ($empl->TIPOJORNADA==8):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>8-Por Turno</option>
                                <option value="99" <?php if ($empl->TIPOJORNADA==99):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>99-Otra Jornada</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Regimen</p></div>
                             <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="TIPOREGIMEN" value="{{$empl->TIPOREGIMEN}}" class="inderecha">                              
                                <option value="2" <?php if ($empl->TIPOREGIMEN==2):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>2-Sueldos</option>
                                <option value="3" <?php if ($empl->TIPOREGIMEN==3):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>3-Jubilados</option>
                                <option value="4" <?php if ($empl->TIPOREGIMEN==4):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>4-Pensionados</option>
                                <option value="5" <?php if ($empl->TIPOREGIMEN==5):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>5-Asimilados Miembros de Sociedades Cooperarivas y Produccion</option>
                                <option value="6" <?php if ($empl->TIPOREGIMEN==6):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>6-Asimilados Integrantes Sociedades Asociaciones Civiles</option>
                                <option value="7" <?php if ($empl->TIPOREGIMEN==7):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>7-Asimilados Miembros Consejo</option>
                                <option value="8" <?php if ($empl->TIPOREGIMEN==8):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>8-Asimilados Comisionistas</option>
                                <option value="9" <?php if ($empl->TIPOREGIMEN==9):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>9-Asimilados Horarios</option>
                                <option value="10" <?php if ($empl->TIPOREGIMEN==10):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>10-Asimilados Acciones</option>
                                <option value="11" <?php if ($empl->TIPOREGIMEN==11):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>11-Asimilados Otros</option>
                                <option value="99" <?php if ($empl->TIPOREGIMEN==99):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>99-Otro Regimen</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="">
                            <div class="input-group" style="margin-left: 45px;">
                                <h5>Checa Tarjeta: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="hidden" name="CHECA" value="False">
                                    <input type="checkbox" aria-label="..." name="CHECA" value="True" <?php if ($empl->CHECA==True):{
                                    echo 'checked';
                                } ?> <?php endif ?>>
                                </span>                               
                            </div>
                            <div class="input-group" style="margin-left: 45px;">
                                <h5>¿Es sindicalizado?: </h5> &nbsp;
                                    <span class="">
                                    <input type="hidden" name="SINDIC" value="False">
                                    <input type="checkbox" aria-label="..." name="SINDIC" value="True" <?php if ($empl->SINDIC==True):{
                                    echo 'checked';
                                } ?> <?php endif ?>>
                                </span> 
                            </div>
                            <br><br><br>
                    </div>

                     <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Turno</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="TURNO" value="{{$empl->TURNO}}" class="inderecha">
                                <option value="1" <?php if ($empl->TURNO==1):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>1-Diurno</option>
                                <option value="2" <?php if ($empl->TURNO==2):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>2-Nocturno</option>
                                <option value="3" <?php if ($empl->TURNO==3):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>3-Mixto</option>                                
                            </select>
                        </div> 
                    </div>

                     <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Zona Economica</p></div>
                            <input type="number" name="ZONAECO" value="{{$empl->ZONAECO}}">
                        </div> 
                    </div>

                     <div class="col-md-4 no-pad" style="border-left: 2px #F0F0F0 solid;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Estatus</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="ESTATUS" value="{{$empl->ESTATUS}}" class="inderecha">
                                <option value="A" <?php if ($empl->ESTATUS=='A'):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>Activo</option>
                                <option value="B" <?php if ($empl->ESTATUS=='B'):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>  data-toggle="modal" data-target="#GSCCModal">Baja</option>
                                <option value="M" <?php if ($empl->ESTATUS=='M'):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>Vacaciones</option>                                
                            </select>
                        </div> 
                    </div>

                    <div style="" id="GSCCModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                             <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">                                 
                                    <h4 class="modal-title" id="myModalLabel">Deseas dar de baja del imss?</h4>
                                  </div>
                                  <div class="modal-body" style="text-align: center;">
                                    <label>Si: &nbsp;</label>
                                    <input type="radio" name="BajaImss" value="1" data-toggle="modal" data-target="#GSCCModal2">
                                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                    <label>No: &nbsp;</label>
                                    <input type="radio" name="BajaImss" value="2">
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>                  
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div style="" id="GSCCModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                             <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Seleccione uno de los motivos.</h4>
                                  </div>
                                  <div class="modal-body" style="text-align: center;">
                                    <label>1- Termino de Contrato: &nbsp;&nbsp;&nbsp;</label>
                                    <input type="radio" name="CAUSA" value="1">
                                    <br>
                                    <label>2- Separación Voluntaria: &nbsp;</label>
                                    <input type="radio" name="CAUSA" value="2">
                                    <br>
                                    <label>3- Abandono de Empleo: &nbsp;&nbsp;</label>
                                    <input type="radio" name="CAUSA" value="3">
                                    <br>
                                    <label>4- Defunción: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="radio" name="CAUSA" value="4">
                                    <br>
                                    <label>5- Clausura: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="radio" name="CAUSA" value="5">
                                    <br>
                                    <label>6- Otra: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="radio" name="CAUSA" value="6">    
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>     
                                  </div>
                                </div>
                              </div>
                            </div>

                     <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Unidad Medica Familiar</p></div>
                            <input type="number" name="CLIMSS" value="{{$empl->CLIMSS}}">
                        </div> 
                    </div>

                     <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Pago</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="TIPOPAGO" required value="{{$empl->TIPOPAGO}}" class="inderecha">
                                <option value="01 Efectivo" <?php if ($empl->TIPOPAGO=="01 Efectivo"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>01 Efectivo</option>
                                <option value="02 Cheque nominativo" <?php if ($empl->TIPOPAGO=="02 Cheque nominativo"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>02 Cheque nominativo</option>
                                <option value="03 Transferencia Electronica" <?php if ($empl->TIPOPAGO=="03 Transferencia Electronica"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>03 Transferencia Electrónica</option>
                                <option value="04 Tarjeta de Credito" <?php if ($empl->TIPOPAGO=="04 Tarjeta de Credito"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>04 Tarjeta de Crédito</option>
                                <option value="05 Monedero Electronico" <?php if ($empl->TIPOPAGO=="05 Monedero Electronico"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>05 Monedero Electrónico</option>
                                <option value="06 Dinero Electronico" <?php if ($empl->TIPOPAGO=="06 Dinero Electronico"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>06 Dinero Electrónico</option>
                                <option value="08 Vales de Despensa" <?php if ($empl->TIPOPAGO=="08 Vales de Despensa"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>08 Vales de Despensa</option>
                                <option value="28 Tarjeta de Debito" <?php if ($empl->TIPOPAGO=="28 Tarjeta de Debito"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>28 Tarjeta de Débito</option>
                                <option value="29 Tarjeta de Servicio" <?php if ($empl->TIPOPAGO=="29 Tarjeta de Servicio"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>29 Tarjeta de Servicio</option>
                                <option value="99 Otros" <?php if ($empl->TIPOPAGO=="99 Otros"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>99 Otros</option>
                            </select>
                        </div> 
                    </div>
                        
                     <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Contrato</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 0px; margin-left: 75px;font-size: 12px;" name="c_TipoContrato" value="{{$empl->c_TipoContrato}}" class="inderecha">
                                <option value="01 Contrato de trabajo por tiempo indeterminado" <?php if ($empl->c_TipoContrato=="01 Contrato de trabajo por tiempo indeterminado"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>01 Contrato de trabajo por tiempo indeterminado</option>
                                <option value="02 Contrato de trabajo para obra determinada" <?php if ($empl->c_TipoContrato=="02 Contrato de trabajo para obra determinada"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>02 Contrato de trabajo para obra determinada</option>
                                <option value="03 Contrato de trabajo por tiempo determinado" <?php if ($empl->c_TipoContrato=="03 Contrato de trabajo por tiempo determinado"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>03 Contrato de trabajo por tiempo determinado</option>
                                <option value="04 Contrato de trabajo por temporada" <?php if ($empl->c_TipoContrato=="04 Contrato de trabajo por temporada"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>04 Contrato de trabajo por temporada</option>
                                <option value="05 Contrato de trabajo sujeto a prueba" <?php if ($empl->c_TipoContrato=="05 Contrato de trabajo sujeto a prueba"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>05 Contrato de trabajo sujeto a prueba</option>
                                <option value="06 Contrato de trabajo con capacitacion inicial" <?php if ($empl->c_TipoContrato=="06 Contrato de trabajo con capacitacion inicial"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>06 Contrato de trabajo con capacitación inicial</option>
                                <option value="07 Modalidad de contratacion por pago de hora laborada" <?php if ($empl->c_TipoContrato=="07 Modalidad de contratacion por pago de hora laborada"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>07 Modalidad de contratación por pago de hora laborada</option>
                                <option value="08 Modalidad de trabajo por comision laboral" <?php if ($empl->c_TipoContrato=="08 Modalidad de trabajo por comision laboral"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>08 Modalidad de trabajo por comisión laboral</option>
                                <option value="09 Modalidades de contratacion donde no existe relacion de trabajo" <?php if ($empl->c_TipoContrato=="09 Modalidades de contratacion donde no existe relacion de trabajo"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>09 Modalidades de contratación donde no existe relación de trabajo</option>
                                <option value="10 Jubilacion, pension, retiro" <?php if ($empl->c_TipoContrato=="10 Jubilacion, pension, retiro"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>10 Jubilación, pensión, retiro.</option>
                                <option value="99 Otro contrato" <?php if ($empl->c_TipoContrato=="99 Otro contrato"):{
                                    echo 'selected="selected"';
                                } ?> <?php endif ?>>99 Otro contrato</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Ingreso</p></div>
                            <input type="date" name="INGRESO" value="<?php echo date('Y-m-d', strtotime($empl->INGRESO)) ?>">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Vacaciones</p></div>
                            <input type="date" name="VACACION" value="<?php echo date('Y-m-d', strtotime($empl->VACACION)) ?>">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Planta</p></div>
                            <input type="date" name="PLANTA" value="<?php echo date('Y-m-d', strtotime($empl->PLANTA)) ?>">
                        </div> 
                    </div>
                    <div class="col-md-2 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; display: none;">
                            <div class="label-left"><p></p></div>
                            <input type="text"   readonly="readonly" hidden="hidden">
                        </div> 
                    </div>
                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Vencimiento de Contrato</p></div>
                            <input type="date" name="VENCIM" value="<?php echo date('Y-m-d', strtotime($empl->VENCIM)) ?>">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Baja</p></div>
                            <input type="date" name="BAJA" value="<?php echo date('Y-m-d', strtotime($empl->BAJA)) ?>">
                        </div> 
                    </div>

                </div>
              </div>

              <div id="nomina2" class="tab-pane fade" style="">
                    <div class="row">
                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p># IMSS Patrón:</p></div>
                            <input type="text" name="REGPAT" value="{{$empl->REGPAT}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Reg. Fed. de C.:</p></div>
                            <input type="text" name="RFC" value="{{$empl->RFC}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>IMSS Empleado:</p></div>
                            <input type="number" name="IMSS" value="{{$empl->IMSS}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="border-bottom: 2px #F0F0F0 solid;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Grupo IMSS:</p></div>
                            
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="GRUIMS" value="{{$empl->GRUIMS}}" class="inderecha">
                                <option value="0" <?php if ($empl->GRUIMS==0) {
                                    echo 'selected="selected"';
                                } ?>>Fijo</option>
                                <option value="1" <?php if ($empl->GRUIMS==1) {
                                    echo 'selected="selected"';
                                } ?>>Variable</option>
                                <option value="2" <?php if ($empl->GRUIMS==2) {
                                    echo 'selected="selected"';
                                } ?>>Mixto</option>
                                <option value="3" <?php if ($empl->GRUIMS==3) {
                                    echo 'selected="selected"';
                                } ?>>Sin Descuento</option>     
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="border-bottom: 2px #F0F0F0 solid;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Crédito FONACOT:</p></div>
                            <input type="text" name="FONACOT" value="{{$empl->FONACOT}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="border-bottom: 2px #F0F0F0 solid;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Crédito INFONAVIT:</p></div>
                            <input type="text" name="INFONAVIT" value="{{$empl->INFONAVIT}}">
                        </div> 
                    </div>

                    <div class="col-md-12" style=" text-align: left;">
                      <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Acu. Otra Cía.</h3>
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Perce:</p></div>
                            <input type="number" name="OTRACIA" value="{{number_format($empl->OTRACIA, 2, '.', '')}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>ISPT:</p></div>
                            <input type="number" name="TAXOTRA" value="{{number_format($empl->TAXOTRA, 2, '.', '')}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>SPE:</p></div>
                            <input type="number" name="CASOTRA" required value="{{number_format($empl->CASOTRA, 2, '.', '')}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>SAR:</p></div>
                            <input type="number" name="SAROTR" value="{{number_format($empl->SAROTR, 2, '.', '')}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>INFONAVIT:</p></div>
                            <input type="number" name="DESINFO" value="{{number_format($empl->DESINFO, 2, '.', '')}}">
                        </div> 
                    </div>

                    <div class="col-md-12" style=" text-align: left; border-top: 2px #F0F0F0 solid;">
                      <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Integrados.</h3>
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Sueldo:</p></div>
                            <input type="number" name="SUELDO" value="{{ number_format($empl->SUELDO, 2, '.', '') }}" readonly="readonly" class="bloqueado">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Var IMSS:</p></div>
                            <input type="text" name="VARIMSS" value="{{ number_format($empl->VARIMSS, 2, '.', '')}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>EYM SAR:</p></div>
                            <input type="number" name="INTEG" value="{{ number_format($empl->INTEG, 2, '.', '')}}" readonly="readonly" class="bloqueado">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>IV-CV-INF:</p></div>
                            <input type="number" name="INTIV" value="{{number_format($empl->INTIV, 2, '.', '')}}" readonly="readonly" class="bloqueado">
                        </div> 
                    </div>

                    <div class="col-md-12 no-pad" style="border-top: 2px #F0F0F0 solid;">
                            <div class="input-group" style="margin-left: 45px;">
                                <h5>¿Presenta Declaración Anual? </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="hidden" name="PRESDEC" value="False">
                                    <input type="checkbox" aria-label="..." name="PRESDEC" value="True" <?php if ($empl->PRESDEC==True):{
                                    echo 'checked';
                                } ?> <?php endif ?>>
                                </span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <h5>¿Tiene SPE en otra Compañia?: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="hidden" name="NOCRED" value="False">
                                    <input type="checkbox" aria-label="..." name="NOCRED" value="True" <?php if ($empl->NOCRED==True):{
                                    echo 'checked';
                                } ?> <?php endif ?>>
                                </span>                            
                            </div>               
                    </div>
                    </div>
                </div>

            <div id="datosg" class="tab-pane fade">
                <div class="row">
                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Clave</p></div>
                            <input type="number" name="EMP2" value="{{$empl1->EMP}}" readonly="readonly" class="bloqueado">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nombre:</p></div>
                            <input type="text" name="NOMBRE2" value="{{$empl->NOMBRE}}" readonly="readonly" class="bloqueado">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nivel:</p></div>
                            <input type="text" name="NIVEL" value="{{$empl1->NIVEL}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Reporta al:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 0px; margin-left: 75px;" name="REPORTA" value="{{$empl1->REPORTA}}" class="inderecha">                         
                                @foreach ($jobs as $job)
                                <option value="{{$job->PUESTO}}" <?php if ($job->PUESTO==$empl1->REPORTA) {
                                  echo 'selected="selected"';
                                } ?>>{{$job->NOMBRE}}</option>     
                                @endforeach
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Calle:</p></div>
                            <input type="text" name="DIRECCION" value="{{$empl1->DIRECCION}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Referencia:</p></div>
                            <input type="text" name="Referencia" value="{{$empl1->Referencia}}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>No. Exterior:</p></div>
                            <input type="number" name="noExterior" value="{{$empl1->noExterior}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>No. Interior:</p></div>
                            <input type="number" name="noInterior" value="{{$empl1->noInterior}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Municipio:</p></div>
                            <input type="text" name="Municipio" value="{{$empl1->Municipio}}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Colonia:</p></div>
                            <input type="text" name="COLONIA" value="{{$empl1->COLONIA}}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Localidad:</p></div>
                            <input type="text" name="CIUDAD" value="{{$empl1->CIUDAD}}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Estado:</p></div>
                            <input type="text" name="ESTADO" value="{{$empl1->ESTADO}}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Telefono:</p></div>
                            <input type="number" name="TELEFONO" value="{{$empl1->TELEFONO}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Codigo Postal:</p></div>
                            <input type="number" name="ZIP" value="{{$empl1->ZIP}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Celular:</p></div>
                            <input type="NUMBER" name="CELULAR" value="{{$empl1->CELULAR}}">
                        </div> 
                    </div>

                    <div class="col-md-4">
                      <h5>Otra Experiencia:</h5>
                        <div class="">
                          <textarea class="campo-texto-etiqueta" placeholder="" name="EXPERI" id="" cols="30" rows="5" value="<?php echo($empl1->EXPERI) ?>"><?php echo($empl1->EXPERI) ?></textarea>
                        </div>
                    </div>
                    <style>
                      .thumb {
                        height: 100px;
                        width:  100px;
                        border: 1px solid #000;
                        
                      }
                    </style>
                    <div class="col-md-4" style="">
                        <h4>Imagen del Empleado: </h4>
                       <input type="file" id="files" name="archivo"/>
                        <br/>
                       <!--  <img src="<?php //echo "/admon/empleados/empresas/$empl1->EMP/$empl1->FOTO"; ?>" style="width: 150px; height: 150px;"> -->
                        <output id="list">
                            <?php 
                            if ($empl1->FOTO==null) {
                              echo '<img src="/admon/empleados/Ideatisa.ico" style="width: 100px; height: 100px;">'; 
                            }else{
                                echo '<img src="/admon/empleados/empresas/'.$empl1->EMP.'/'.$empl1->FOTO.'" style="width: 150px; height: 150px;">';
                            }
                            
                            ?>
                        </output>
                        
                    </div>
                
                    
                    

                    <div class="col-md-12 no-pad" style="border-top: 2px #F0F0F0 solid; margin-bottom: 10px;">                   
                    </div>

                    <div class="col-md-4 no-pad" style="">
                            <div class="input-group" style="margin-left: 45px;">
                                <h5>Sexo: </h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <h5>Femenino: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="radio" name="SEXO" aria-label="..." value="F" <?php if ($empl1->SEXO=='F'):{
                                    echo 'checked';
                                } ?> <?php endif ?>>
                                </span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <h5>Masculino: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="radio" name="SEXO" aria-label="..." value="M" <?php if ($empl1->SEXO=='M'):{
                                    echo 'checked';
                                } ?> <?php endif ?>>
                                </span> 
                            </div>    
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Estado Civil:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="CIVIL" value="{{$empl1->CIVIL}}" class="inderecha">
                                <option value="S" <?php if ($empl1->CIVIL=='S') {
                                    echo 'selected="selected"';
                                } ?>>Soltero</option>
                                <option value="C" <?php if ($empl1->CIVIL=='C') {
                                    echo 'selected="selected"';
                                } ?>>Casado</option>
                                <option value="D" <?php if ($empl1->CIVIL=='D') {
                                    echo 'selected="selected"';
                                } ?>>Divorciado</option>
                                <option value="U" <?php if ($empl1->CIVIL=='U') {
                                    echo 'selected="selected"';
                                } ?>>Unión Libre</option>
                                <option value="V" <?php if ($empl1->CIVIL=='V') {
                                    echo 'selected="selected"';
                                } ?>>Viudo</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Fecha de Boda:</p></div>
                            <input type="date" name="BODA" value="<?php echo date('Y-m-d', strtotime($empl1->BODA)) ?>">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Licencia:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="LICENCIA" value="{{$empl1->LICENCIA}}" class="inderecha">
                                <option value="A" <?php if ($empl1->LICENCIA=='A') {
                                    echo 'selected="selected"';
                                } ?>>Automovilista</option>
                                <option value="C" <?php if ($empl1->LICENCIA=='C') {
                                    echo 'selected="selected"';
                                } ?>>Chofer</option>
                                <option value="M" <?php if ($empl1->LICENCIA=='M') {
                                    echo 'selected="selected"';
                                } ?>>Motociclista</option>
                                <option value="N" <?php if ($empl1->LICENCIA=='N') {
                                    echo 'selected="selected"';
                                } ?>>Ninguno</option>
                                
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Sangre:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="SANGRE" value="{{$empl1->SANGRE}}" class="inderecha">
                                <option value="A+" <?php if ($empl1->SANGRE=='A+') {
                                    echo 'selected="selected"';
                                } ?>>A+</option>
                                <option value="A-" <?php if ($empl1->SANGRE=='A-') {
                                    echo 'selected="selected"';
                                } ?>>A-</option>
                                <option value="B+" <?php if ($empl1->SANGRE=='B+') {
                                    echo 'selected="selected"';
                                } ?>>B+</option>
                                <option value="B-" <?php if ($empl1->SANGRE=='B-') {
                                    echo 'selected="selected"';
                                } ?>>B-</option>
                                <option value="AB+" <?php if ($empl1->SANGRE=='AB+') {
                                    echo 'selected="selected"';
                                } ?>>AB+</option>
                                <option value="AB-" <?php if ($empl1->SANGRE=='AB-') {
                                    echo 'selected="selected"';
                                } ?>>AB-</option>
                                <option value="O+" <?php if ($empl1->SANGRE=='O+') {
                                    echo 'selected="selected"';
                                } ?>>O+</option>
                                <option value="O-" <?php if ($empl1->SANGRE=='O-') {
                                    echo 'selected="selected"';
                                } ?>>O-</option>
                                <option value="I" <?php if ($empl1->SANGRE=='I') {
                                    echo 'selected="selected"';
                                } ?>>I</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Escolaridad:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="ESCOLAR" value="{{$empl1->ESCOLAR}}" class="inderecha">
                                <option value="0" <?php if ($empl1->ESCOLAR=='0') {
                                    echo 'selected="selected"';
                                } ?>>Nada</option>
                                <option value="1" <?php if ($empl1->ESCOLAR=='1') {
                                    echo 'selected="selected"';
                                } ?>>Primaria</option>
                                <option value="2" <?php if ($empl1->ESCOLAR=='2') {
                                    echo 'selected="selected"';
                                } ?>>Secundaria</option>
                                <option value="3" <?php if ($empl1->ESCOLAR=='3') {
                                    echo 'selected="selected"';
                                } ?>>Bachillerato</option>
                                <option value="4" <?php if ($empl1->ESCOLAR=='4') {
                                    echo 'selected="selected"';
                                } ?>>Profesional</option>
                                <option value="5" <?php if ($empl1->ESCOLAR=='5') {
                                    echo 'selected="selected"';
                                } ?>>Posgrado</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="border-left: 2px #F0F0F0 solid;">
                            <div class="input-group" style="margin-left: 45px;">
                                <h5>Cambio de Residencia: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="hidden" name="CAMB_RESID" value="False">
                                    <input type="checkbox" aria-label="..." name="CAMB_RESID" value="True" <?php if ($empl1->CAMB_RESID==1):{
                                    echo 'checked';
                                } ?> <?php endif ?>>
                                </span>              
                            </div>
                            <div class="input-group" style="margin-left: 45px;">
                                <h5>Disposición de Viajar: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="hidden" name="DISP_VIAJE" value="False">
                                    <input type="checkbox" aria-label="..." name="DISP_VIAJE" value="True" <?php if ($empl1->DISP_VIAJE==1):{
                                    echo 'checked';
                                } ?> <?php endif ?>>
                                </span> 
                            </div>
                    </div>

                     <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Fecha de Nacimiento:</p></div>
                            <input type="date" name="BORN" value="<?php echo date('Y-m-d', strtotime($empl1->BORN)) ?>">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Lugar de Nacimiento:</p></div>
                            <input type="text" name="NACIM" value="{{$empl1->NACIM}}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nacionalidad:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="NACIONAL" value="{{$empl1->NACIONAL}}" class="inderecha">
                                <option value="MAXICANA" <?php if ($empl1->NACIONAL=='MEXICANA') {
                                    echo 'selected="selected"';
                                } ?>>MEXICANA</option>
                                <option value="ESTADOUNIDENSE" <?php if ($empl1->NACIONAL=='ESTADOUNIDENSE') {
                                    echo 'selected="selected"';
                                } ?>>ESTADOUNIDENSE</option>
                                <option value="EXTRANJERA" <?php if ($empl1->NACIONAL=='EXTRANJERA') {
                                    echo 'selected="selected"';
                                } ?>>EXTRANJERA</option>                        
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>No. de Dependientes:</p></div>
                            <input type="NUMBER" name="DEPENDIENT" value="{{$empl1->DEPENDIENT}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Transporte:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="MEDIO" value="{{$empl1->MEDIO}}" class="inderecha">
                                <option value="0" <?php if ($empl1->MEDIO=='0') {
                                    echo 'selected="selected"';
                                } ?>>Camión Empresa</option>
                                <option value="1" <?php if ($empl1->MEDIO=='1') {
                                    echo 'selected="selected"';
                                } ?>>Camión Urbano</option>
                                <option value="2" <?php if ($empl1->MEDIO=='2') {
                                    echo 'selected="selected"';
                                } ?>>Trae Tamsporte Personal</option>
                                <option value="3" <?php if ($empl1->MEDIO=='3') {
                                    echo 'selected="selected"';
                                } ?>>Otro Transporte sin Costo</option>                  
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Fuentes de Empleo:</p></div>
                            <input type="number" name="FUENTE" value="{{$empl1->FUENTE}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>E-Mail:</p></div>
                            <input type="email" name="Email" value="{{$empl1->Email}}">
                        </div> 
                    </div>
                </div>
            </div>

              <div id="datosa" class="tab-pane fade">
                <div class="row">
                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nombre: </p></div>
                            <input type="text" id="nombre3" readonly="readonly" value="{{$empl->NOMBRE}}" class="bloqueado">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>CURP: </p></div>
                            <input type="text" name="CURP" value="{{$empl11->CURP}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>No. Nuevo del IMSS: </p></div>
                            <input type="text" name="IMSS2" value="{{$empl11->IMSS2}}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nombre del Padre: </p></div>
                            <input type="text" name="PADRE" value="{{$empl11->PADRE}}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nombre de la Madre: </p></div>
                            <input type="text" name="MADRE" value="{{$empl11->MADRE}}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>
                </div>
            </div>
              <button class="mediano separation">Actualizar</button> 
            <a href="{{url('catalogos/empleados')}}" class="primario1">Cancelar</a>
            </form>
            </div>
        </div>
      </div>   
    </div>
  </div>  
  <div style="height: 15px;"></div>
  @include('includes.footer')
<!-- scrip para copiar valores del input y ponerlo en otro input -->
<script language="javascript">
function fAgrega()
{
document.getElementById("nombre2").value = document.getElementById("nombre1").value;
}
</script>
<script language="javascript">
function fAgrega1()
{
document.getElementById("nombre3").value = document.getElementById("nombre1").value;
}
</script>
<script language="javascript">
function fAgrega2()
{
document.getElementById("EMP2").value = document.getElementById("EMP").value;
}
</script>
<!-- scrip para previsualizaar imagen -->
<script>
              function archivo(evt) {
                  var files = evt.target.files; // FileList object
             
                  // Obtenemos la imagen del campo "file".
                  for (var i = 0, f; f = files[i]; i++) {
                    //Solo admitimos imágenes.
                    if (!f.type.match('image.*')) {
                        continue;
                    }
             
                    var reader = new FileReader();
             
                    reader.onload = (function(theFile) {
                        return function(e) {
                          // Insertamos la imagen
                         document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                        };
                    })(f);
             
                    reader.readAsDataURL(f);
                  }
              }
             
              document.getElementById('files').addEventListener('change', archivo, false);
      </script>

       <script type="text/javascript">
        function Cue(event, el){//Validar nombre   
    //Obteniendo posicion del cursor 
    var val = el.value;//Valor de la caja de texto
    var pos = val.slice(0, el.selectionStart).length;
    
    var out = '';//Salida
    var filtro = '1234567890';
    var v = 0;//Contador de caracteres validos
    
    //Filtar solo los numeros
    for (var i=0; i<val.length; i++){
       if (filtro.indexOf(val.charAt(i)) != -1){
         v++;
         out += val.charAt(i);         
         //Agregando un espacio cada 4 caracteres
         if((v==4))
             out+='';
       }
    }
    //Reemplazando el valor
    el.value = out;
    
    //En caso de modificar un numero reposicionar el cursor
    if(event.keyCode==8){//Tecla borrar precionada
        el.selectionStart = pos;
        el.selectionEnd = pos;
    }
}
</script>
@endsection
