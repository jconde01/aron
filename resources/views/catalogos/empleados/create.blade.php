@extends('layouts.app')
@section('body-class', 'profile-page sidebar-collapse')  
@section('content')

  <div class="main main-raised">
    <div>
 
      <div class="section text-center">
        <h2 class="titulo">Registrar Nuevo Empleado</h2>
        <br>
         
        <form method="POST" action=" {{url('/catalogos/empleados')}} " enctype="multipart/form-data"> 
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="minimoDF" value="{{ \Cache::get('minimoDF') }}">

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
                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo Nomina</p></div>
                            <input type="text" name="TIPONO" value="{{ $emp->tipoNo->NOMBRE }}" readonly="readonly" class="bloqueado">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Empleado</p></div>
                            <input type="number" name="EMP" id="EMP" onkeyup="fAgrega2();" max="9999999" value="{{ $ultimo2}}" required>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nombre: </p></div>
                            <input type="text" name="NOMBRES" id="NOMBRES"  onkeyup="fAgrega1(); javascript:this.value=this.value.toUpperCase();" maxlength="27" required>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Apellido Paterno: </p></div>
                            <input type="text" name="PATERNO" id="PATERNO" onkeyup="fAgrega1(); javascript:this.value=this.value.toUpperCase();" maxlength="27">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Apellido Materno: </p></div>
                            <input type="text" name="MATERNO" id="MATERNO" onkeyup="fAgrega1(); javascript:this.value=this.value.toUpperCase();" maxlength="27">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Puesto</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right !important; padding-right: 20px; font-size: 12px;" name="PUESTO" class="inderecha">
                                @foreach ($jobs as $job)
                                <option value="{{$job->PUESTO}}">{{$job->NOMBRE}}</option>
                   
                                @endforeach
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="border-left: 2px #F0F0F0 solid;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Cuenta Contable</p></div>
                            <input type="text" maxlength="9" name="cuenta"  onkeyup="Cue(event, this)">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Departamento</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 0px; margin-left: 75px; font-size: 13px;" name="DEPTO" required class="inderecha">
                                @foreach ($deps as $dep)
                                <option value="{{$dep->DEPTO}}">{{$dep->DESCRIP}}</option>
                                @endforeach
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Trabajador</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="TIPOTRA" class="inderecha">
                                <option value="1">1-Planta Confianza</option>
                                <option value="2">2-Eventual Confianza</option>
                                <option value="3">3-Obrero Planta</option>
                                <option value="4">4-Obrero Eventaul</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Estado</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="c_Estado" required class="inderecha">
                                @foreach ($ests as $est)
                                <option value="{{$est->c_Estado}}">{{$est->c_NombreEdo}}</option>
                                @endforeach
                            </select>
                        </div> 
                    </div>

                     <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Clave Contable</p></div>
                            
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="DIRIND" class="inderecha">
                                <option value="0">Directa</option>
                                <option value="1">Indirecta</option>
                                
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Jornada</p></div>
                              <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="TIPOJORNADA" class="inderecha">
                                <option value="1">1-Diurna</option>
                                <option value="2">2-Nocturna</option>
                                <option value="3">3-Mixta</option>
                                <option value="4">4-Por hora</option>
                                <option value="5">5-Reducida</option>
                                <option value="6">6-Continuada</option>
                                <option value="7">7-Partida</option>
                                <option value="8">8-Por Turno</option>
                                <option value="99">99-Otra Jornada</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Regimen</p></div>
                             <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="TIPOREGIMEN" class="inderecha"> 
                                <option value="2">2-Sueldos</option>
                                <option value="3">3-Jubilados</option>
                                <option value="4">4-Pensionados</option>
                                <option value="5">5-Asimilados Miembros de Sociedades Cooperarivas y Produccion</option>
                                <option value="6">6-Asimilados Integrantes Sociedades Asociaciones Civiles</option>
                                <option value="7">7-Asimilados Miembros Consejo</option>
                                <option value="8">8-Asimilados Comisionistas</option>
                                <option value="9">9-Asimilados Horarios</option>
                                <option value="10">10-Asimilados Acciones</option>
                                <option value="11">11-Asimilados Otros</option>
                                <option value="99">99-Otro Regimen</option>
                            </select>
                        </div> 
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                    <div class="col-md-4 no-pad" style="">
                            <div class="input-group" style="margin-left: 45px;">
                                <h5>Checa Tarjeta: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                        <input type="hidden"  name="CHECA"  value="False">
                                        <input type="checkbox"  name="CHECA" value="True">
                                    </span>     
                            </div>
                            <div class="input-group" style="margin-left: 45px;">
                                <h5>¿Es sindicalizado?: </h5> &nbsp;
                                    <span class="">
                                        <input type="hidden" aria-label="..." name="SINDIC"  value="False">
                                        <input type="checkbox" aria-label="..." name="SINDIC"  value="True">
                                    </span> 
                            </div>
                    </div>

                     <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Turno</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="TURNO" class="inderecha">
                                <option value="1">1-Diurno</option>
                                <option value="2">2-Nocturno</option>
                                <option value="3">3-Mixto</option>                               
                            </select>
                        </div> 
                    </div>

                     <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Zona Economica</p></div>
                            <input type="number" name="ZONAECO">
                        </div> 
                    </div>

                     <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Estatus</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="ESTATUS" class="inderecha">
                                <option value="A">Activo</option>
                            </select>
                        </div> 
                    </div>

                     <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Unidad Medica Familiar</p></div>
                            <input type="number" name="CLIMSS">
                        </div> 
                    </div>

                     <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Pago</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="TIPOPAGO" required class="inderecha">
                                <option value="01 Efectivo">01 Efectivo</option>
                                <option value="02 Cheque nominativo">02 Cheque nominativo</option>
                                <option value="03 Transferencia Electronica">03 Transferencia Electrónica</option>
                                <option value="04 Tarjeta de Credito">04 Tarjeta de Crédito</option>
                                <option value="05 Monedero Electronico">05 Monedero Electrónico</option>
                                <option value="06 Dinero Electronico">06 Dinero Electrónico</option>
                                <option value="08 Vales de Despensa">08 Vales de Despensa</option>
                                <option value="28 Tarjeta de Debito">28 Tarjeta de Débito</option>
                                <option value="29 Tarjeta de Servicio">29 Tarjeta de Servicio</option>
                                <option value="99 Otros">99 Otros</option>
                            </select>
                        </div> 
                    </div>

                     <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Contrato</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right:0px; font-size: 11px; margin-left: 75px;" name="c_TipoContrato" required class="inderecha">
                                <option value="01 Contrato de trabajo por tiempo indeterminado">01 Contrato de trabajo por tiempo indeterminado</option>
                                <option value="02 Contrato de trabajo para obra determinada">02 Contrato de trabajo para obra determinada</option>
                                <option value="03 Contrato de trabajo por tiempo determinado">03 Contrato de trabajo por tiempo determinado</option>
                                <option value="04 Contrato de trabajo por temporada">04 Contrato de trabajo por temporada</option>
                                <option value="05 Contrato de trabajo sujeto a prueba">05 Contrato de trabajo sujeto a prueba</option>
                                <option value="06 Contrato de trabajo con capacitación inicial">06 Contrato de trabajo con capacitación inicial</option>
                                <option value="07 Modalidad de contratación por pago de hora laborada">07 Modalidad de contratación por pago de hora laborada</option>
                                <option value="08 Modalidad de trabajo por comisión laboral">08 Modalidad de trabajo por comisión laboral</option>
                                <option value="09 Modalidades de contratación donde no existe relación de trabajo">09 Modalidades de contratación donde no existe relación de trabajo</option>
                                <option value="10 Jubilación, pensión, retiro.">10 Jubilación, pensión, retiro.</option>
                                <option value="99 Otro contrato">99 Otro contrato</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Ingreso</p></div>
                            <input type="date" id="Ingreso" name="INGRESO" required>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Vacaciones</p></div>
                            <input type="date" name="VACACION">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Planta</p></div>
                            <input type="date" name="PLANTA">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Vencimiento de Contrato</p></div>
                            <input type="date" name="VENCIM">
                        </div> 
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Baja</p></div>
                            <input type="date" name="BAJA" disabled="disabled" class="bloqueado">
                        </div> 
                    </div>

                </div>
              </div>

              <div id="nomina2" class="tab-pane fade" style="">
                    <div class="row">
                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p># IMSS Patrón:</p></div>
                            <input type="text" name="REGPAT" maxlength="11">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Reg. Fed. de C.:</p></div>
                            <input type="text" name="RFC" maxlength="15" onkeyup="javascript:this.value=this.value.toUpperCase(); Rfc(event, this);">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>IMSS Empleado:</p></div>
                            <input type="number" name="IMSS" max="999999999999999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="border-bottom: 2px #F0F0F0 solid;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Grupo IMSS:</p></div>                          
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="GRUIMS" class="inderecha">
                                <option value="0">Fijo</option>
                                <option value="1">Variable</option>
                                <option value="2">Mixto</option>
                                <option value="3">Sin Descuento</option>                               
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="border-bottom: 2px #F0F0F0 solid;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Crédito FONACOT:</p></div>
                            <input type="number" name="FONACOT" max="999999999999999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="border-bottom: 2px #F0F0F0 solid;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Crédito INFONAVIT:</p></div>
                            <input type="number" name="INFONAVIT" max="999999999999999">
                        </div> 
                    </div>

                    <div class="col-md-12" style=" text-align: left;">
                      <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Acu. Otra Cía.</h3>
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Perce:</p></div>
                            <input type="number" name="OTRACIA" max="999999999" value="0">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>ISPT:</p></div>
                            <input type="number" name="TAXOTRA" max="999999999" value="0">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>SPE:</p></div>
                            <input type="number" name="CASOTRA" max="999999999" required>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>SAR:</p></div>
                            <input type="number" name="SAROTR" max="999999999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>INFONAVIT:</p></div>
                            <input type="number" name="DESINFO" max="999999999" value="0">
                        </div> 
                    </div>

                    <div class="col-md-12" style=" text-align: left; border-top: 2px #F0F0F0 solid;">
                      <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Integrados.</h3>
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Sueldo:</p></div>
                            <input type="number" id="Sueldo" step="0.01" name="SUELDO" max="999999999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Var IMSS:</p></div>
                            <input type="text" name="VARIMSS" step="0.01" max="999999999" value="0">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>EYM SAR:</p></div>
                            <input type="number" step="0.01" id="Integ" name="INTEG" max="999999999" value="0">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>IV-CV-INF:</p></div>
                            <input type="number" step="0.01" id="Intiv" name="INTIV" max="999999999" value="0">
                        </div> 
                    </div>

                    <div class="col-md-12 no-pad" style="border-top: 2px #F0F0F0 solid;">
                            <div class="input-group" style="margin-left: 45px;">
                                <h5>¿Presenta Declaración Anual? </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="hidden" aria-label="..." name="PRESDEC" value="False">
                                    <input type="checkbox" aria-label="..." name="PRESDEC" value="True">
                                </span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <h5>¿Tiene SPE en otra Compañia?: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="hidden" aria-label="..." name="NOCRED" value="False">
                                    <input type="checkbox" aria-label="..." name="NOCRED" value="True">
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
                            <input type="number" name="EMP2" id="EMP2" readonly="readonly" value="{{$ultimo2}}" class="bloqueado">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nivel:</p></div>
                            <input type="text" name="NIVEL" max="9999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Reporta al:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 0px; margin-left: 75px;" name="REPORTA" class="inderecha">
                                
                                @foreach ($jobs as $job)
                                <option value="{{$job->PUESTO}}">{{$job->NOMBRE}}</option>                  
                                @endforeach
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Calle:</p></div>
                            <input type="text" name="DIRECCION">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Referencia:</p></div>
                            <input type="text" name="Referencia" maxlength="50" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>No. Exterior:</p></div>
                            <input type="number" name="noExterior" max="9999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>No. Interior:</p></div>
                            <input type="number" name="noInterior" max="9999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Municipio:</p></div>
                            <input type="text" name="Municipio" maxlength="150" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Colonia:</p></div>
                            <input type="text" name="COLONIA" maxlength="40" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Localidad:</p></div>
                            <input type="text" name="CIUDAD" maxlength="30" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Estado:</p></div>
                            <input type="text" name="ESTADO" maxlength="20" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Telefono:</p></div>
                            <input type="number" name="TELEFONO" max="9999999999999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Codigo Postal:</p></div>
                            <input type="number" name="ZIP" max="99999999999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Celular:</p></div>
                            <input type="NUMBER" name="CELULAR" max="999999999999999">
                        </div> 
                    </div>

                    <div class="col-md-5">
                      <h5>Otra Experiencia:</h5>
                        <div class="">
                          <textarea class="campo-texto-etiqueta" placeholder="" name="EXPERI" id="" cols="30" rows="5"></textarea>
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
                        <output id="list"><img src="<?php echo "/admon/empleados/Ideatisa.ico"; ?>" style="width: 100px; height: 100px;"></output>
                        
                    </div>

                    <div class="col-md-12 no-pad" style="border-top: 2px #F0F0F0 solid; margin-bottom: 10px;">                     
                    </div>

                    <div class="col-md-4 no-pad" style="">
                            <div class="input-group" style="margin-left: 45px;">
                                <h5>Sexo: </h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <h5>Femenino: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="radio" name="SEXO" aria-label="..." value="F" required="">
                                </span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <h5>Masculino: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="radio" name="SEXO" aria-label="..." value="M" required="">
                                </span> 
                            </div>    
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Estado Civil:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="CIVIL" class="inderecha">
                                <option value="S">Soltero</option>
                                <option value="C">Casado</option>
                                <option value="D">Divorciado</option>
                                <option value="U">Unión Libre</option>
                                <option value="V">Viudo</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Fecha de Boda:</p></div>
                            <input type="date" name="BODA">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Licencia:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="LICENCIA" class="inderecha">
                                <option value="A">Automovilista</option>
                                <option value="C">Chofer</option>
                                <option value="M">Motociclista</option>
                                <option value="N">Ninguno</option>
                                
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Sangre:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="SANGRE" class="inderecha">
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="I">I</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Escolaridad:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="ESCOLAR" class="inderecha">
                                <option value="0">Nada</option>
                                <option value="1">Primaria</option>
                                <option value="2">Secundaria</option>
                                <option value="3">Bachillerato</option>
                                <option value="4">Profesional</option>
                                <option value="5">Posgrado</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="border-left: 2px #F0F0F0 solid;">
                            <div class="input-group" style="margin-left: 45px;">

                                <h5>Cambio de Residencia: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="hidden" aria-label="..." name="CAMB_RESID" value="False">
                                    <input type="checkbox" aria-label="..." name="CAMB_RESID" value="True">
                                </span>
                                
                            </div>
                            <div class="input-group" style="margin-left: 45px;">
                                <h5>Disposición de Viajar: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="hidden" aria-label="..." name="DISP_VIAJE" value="False">
                                    <input type="checkbox" aria-label="..." name="DISP_VIAJE" value="True">
                                </span> 
                            </div>
                    </div>

                     <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Fecha de Nacimiento:</p></div>
                            <input type="date" name="BORN">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Lugar de Nacimiento:</p></div>
                            <input type="text" name="NACIM" maxlength="15" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nacionalidad:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="NACIONAL" class="inderecha">
                                <option value="MAXICANA">MEXICANA</option>
                                <option value="ESTADOUNIDENSE">ESTADOUNIDENSE</option>
                                <option value="EXTRANJERA">EXTRANJERA</option>
                                
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>No. de Dependientes:</p></div>
                            <input type="NUMBER" name="DEPENDIENT" max="99">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Transporte:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="MEDIO" class="inderecha">
                                <option value="0">Camión Empresa</option>
                                <option value="1">Camión Urbano</option>
                                <option value="2">Trae Tamsporte Personal</option>
                                <option value="3">Otro Transporte sin Costo</option>                                
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Fuentes de Empleo:</p></div>
                            <input type="number" name="FUENTE" max="10">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>E-Mail:</p></div>
                            <input type="email" name="Email">
                        </div> 
                    </div>
                </div>
            </div>

              <div id="datosa" class="tab-pane fade">
                <div class="row">
                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nombre: </p></div>
                            <input type="text" id="nombre3"  class="bloqueado" readonly="readonly">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>CURP: </p></div>
                            <input type="text" name="CURP" maxlength="25" onkeyup="Curp(event, this)">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>No. Nuevo del IMSS: </p></div>
                            <input type="number" name="IMSS2" max="999999999999999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nombre del Padre: </p></div>
                            <input type="text" name="PADRE" maxlength="30" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nombre de la Madre: </p></div>
                            <input type="text" name="MADRE" maxlength="30" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                </div>
              </div>
              <button class="mediano separation">Registrar</button> 
            <a href="{{url('catalogos/empleados')}}" class="primario1">Cancelar</a>
            </form>
            </div>
        </div>
      </div>    
    </div>
  </div>
  <div style="height: 15px;"></div>
 @include('includes.footer')
<script language="javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
});     
function fAgrega1()
{
document.getElementById("nombre3").value = document.getElementById("NOMBRES").value + ' ' + document.getElementById("PATERNO").value + ' ' + document.getElementById("MATERNO").value;
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

      <!-- Script para valores de checkbox -->
       <script type="text/javascript">
    $('#checkbox-value').text($('#checkbox1').val());

$("#checkbox1").on('change', function() {
  if ($(this).is(':checked')) {
    $(this).attr('value', 'true');
  } else {
    $(this).attr('value', 'false');
  }
  
  $('#checkbox-value').text($('#checkbox1').val());
});
</script>

    <!-- SCRIPT PARA EL RFC -->
    <script type="text/javascript">
        function Rfc(event, el){//Validar nombre   
    //Obteniendo posicion del cursor 
    var val = el.value;//Valor de la caja de texto
    var pos = val.slice(0, el.selectionStart).length;
    
    var out = '';//Salida
    var filtro = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890';
    var v = 0;//Contador de caracteres validos
    
    //Filtar solo los numeros
    for (var i=0; i<val.length; i++){
       if (filtro.indexOf(val.charAt(i)) != -1){
         v++;
         out += val.charAt(i);         
         //Agregando un espacio cada 4 caracteres
         if((v==4) || (v==10))
             out+='-';
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

    <!-- SCRIPT PARA EL curp -->
    <script type="text/javascript">
        function Curp(event, el){//Validar nombre   
    //Obteniendo posicion del cursor 
    var val = el.value;//Valor de la caja de texto
    var pos = val.slice(0, el.selectionStart).length;
    
    var out = '';//Salida
    var filtro = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890';
    var v = 0;//Contador de caracteres validos
    
    //Filtar solo los numeros
    for (var i=0; i<val.length; i++){
       if (filtro.indexOf(val.charAt(i)) != -1){
         v++;
         out += val.charAt(i);         
         //Agregando un espacio cada 4 caracteres
         if((v==4) || (v==6) || (v==8) || (v==10) || (v==11) || (v==13) || (v==16)  )
             out+='-';
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
    $('#Sueldo').change(function() {
        var token = $('input[name=_token]').val();              
        var minimoDF = $('input[name=minimoDF]').val();              
        var sueldo  =  $('#Sueldo').val();
        var ingreso = $('#Ingreso').val();
        var eym = document.getElementById("Integ");
        var iv = document.getElementById("Intiv");      
        //alert('F.Ingreso: ' + ingreso + ' - Sueldo : ' + sueldo);        
        $.post("getSalarioIntegrado", { fldSueldo: sueldo, fldIngreso: ingreso, _token: token }, function( data ) {
            
            eym.value = data['integrado'];
            iv.value = data['integrado2'];
            //alert('regreso con: ' + data['integrado'] + data['integrado2'] + data['ingreso']);
        });     
    });
</script>
@endsection
