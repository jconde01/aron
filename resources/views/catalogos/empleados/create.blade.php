<!-- inicia el codigo escrito por Ricardo Cordero -->
@extends('layouts.app') 
@section('body-class', 'profile-page sidebar-collapse')  
@section('content')

  <div class="main main-raised">
    <div>
 
      <div class="section text-center">
        <h2 class="titulo">Registrar Nuevo Empleado</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error}}</li>
                    @endforeach
                </ul>
            </div>
         @endif
        <form method="POST" action=" {{url('/catalogos/empleados')}} " enctype="multipart/form-data"> 
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="minimoDF" value="{{ \Cache::get('minimoDF') }}">

          <div class="" style="">

            <br><br>
            <div class="tab-content">
            

              
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
                            <input type="text" name="TIPONO" value="{{ $emp->tipoNo->NOMBRE }}" readonly="readonly" class="bloqueado">
                        </div> 
                    </div>

                    <div class="col-md-5  no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Empleado</p></div>
                            <input type="number" name="EMP" id="EMP" onkeyup="fAgrega2();" max="9999999" value="{{ $ultimo3}}" required>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nombre: </p></div>
                            <input type="text" name="NOMBRES" id="NOMBRES" value="{{ old('NOMBRES') }}"  onkeyup="fAgrega1(); javascript:this.value=this.value.toUpperCase();" maxlength="27" required>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Apellido Paterno: </p></div>
                            <input type="text" name="PATERNO" id="PATERNO" value="{{ old('PATERNO') }}" onkeyup="fAgrega1(); javascript:this.value=this.value.toUpperCase();" maxlength="27">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Apellido Materno: </p></div>
                            <input type="text" name="MATERNO" id="MATERNO" value="{{ old('MATERNO') }}"onkeyup="fAgrega1(); javascript:this.value=this.value.toUpperCase();" maxlength="27">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Puesto</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right !important; padding-right: 20px; font-size: 12px;" name="PUESTO" class="inderecha">
                                @foreach ($jobs as $job)
                                <option value="{{$job->PUESTO}}" {{ (old("PUESTO") == $job->PUESTO ? "selected":"") }}>{{$job->NOMBRE}}</option>
                   
                                @endforeach
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="border-left: 2px #F0F0F0 solid;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Cuenta Contable</p></div>
                            <input type="text" maxlength="9" name="cuenta" value="{{ old('cuenta') }}" onkeyup="Cue(event, this)">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Departamento</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 0px; margin-left: 75px; font-size: 13px;" name="DEPTO"  required class="inderecha deptip">
                                @foreach ($deps as $dep)
                                <option value="{{$dep->DEPTO}}" {{ (old("DEPTO") == $dep->DEPTO ? "selected":"") }} >{{$dep->DESCRIP}}</option>
                                @endforeach
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Trabajador</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="TIPOTRA" class="inderecha">
                                <option value="1" {{ (old("TIPOTRA") == 1 ? "selected":"") }}>1-Planta Confianza</option>
                                <option value="2" {{ (old("TIPOTRA") == 2 ? "selected":"") }}>2-Eventual Confianza</option>
                                <option value="3" {{ (old("TIPOTRA") == 3 ? "selected":"") }}>3-Obrero Planta</option>
                                <option value="4" {{ (old("TIPOTRA") == 4 ? "selected":"") }}>4-Obrero Eventual</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Estado</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="c_Estado" required class="inderecha">
                                @foreach ($ests as $est)
                                <option value="{{$est->c_Estado}}" {{ (old("c_Estado") == $est->c_Estado ? "selected":"") }}>{{$est->c_NombreEdo}}</option>
                                @endforeach
                            </select>
                        </div> 
                    </div>

                     <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Clave Contable</p></div>
                            
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="DIRIND" class="inderecha">
                                <option value="0" {{ (old("DIRIND") == 0 ? "selected":"") }}>Directa</option>
                                <option value="1" {{ (old("DIRIND") == 1 ? "selected":"") }}>Indirecta</option>
                                
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Jornada</p></div>
                              <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="TIPOJORNADA" class="inderecha">
                                <option value="1" {{ (old("TIPOJORNADA") == 1 ? "selected":"") }}>1-Diurna</option>
                                <option value="2" {{ (old("TIPOJORNADA") == 2 ? "selected":"") }}>2-Nocturna</option>
                                <option value="3" {{ (old("TIPOJORNADA") == 3 ? "selected":"") }}>3-Mixta</option>
                                <option value="4" {{ (old("TIPOJORNADA") == 4 ? "selected":"") }}>4-Por hora</option>
                                <option value="5" {{ (old("TIPOJORNADA") == 5 ? "selected":"") }}>5-Reducida</option>
                                <option value="6" {{ (old("TIPOJORNADA") == 6 ? "selected":"") }}>6-Continuada</option>
                                <option value="7" {{ (old("TIPOJORNADA") == 7 ? "selected":"") }}>7-Partida</option>
                                <option value="8" {{ (old("TIPOJORNADA") == 8 ? "selected":"") }}>8-Por Turno</option>
                                <option value="99" {{ (old("TIPOJORNADA") == 99 ? "selected":"") }}>99-Otra Jornada</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Regimen</p></div>
                             <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="TIPOREGIMEN" class="inderecha"> 
                                <option value="2" {{ (old("TIPOREGIMEN") == 2 ? "selected":"") }}>2-Sueldos</option>
                                <option value="3" {{ (old("TIPOREGIMEN") == 3 ? "selected":"") }}>3-Jubilados</option>
                                <option value="4" {{ (old("TIPOREGIMEN") == 4 ? "selected":"") }}>4-Pensionados</option>
                                <option value="5" {{ (old("TIPOREGIMEN") == 5 ? "selected":"") }}>5-Asimilados Miembros de Sociedades Cooperarivas y Produccion</option>
                                <option value="6" {{ (old("TIPOREGIMEN") == 6 ? "selected":"") }}>6-Asimilados Integrantes Sociedades Asociaciones Civiles</option>
                                <option value="7" {{ (old("TIPOREGIMEN") == 7 ? "selected":"") }}>7-Asimilados Miembros Consejo</option>
                                <option value="8" {{ (old("TIPOREGIMEN") == 8 ? "selected":"") }}>8-Asimilados Comisionistas</option>
                                <option value="9" {{ (old("TIPOREGIMEN") == 9 ? "selected":"") }}>9-Asimilados Honorarios</option>
                                <option value="10" {{ (old("TIPOREGIMEN") == 10 ? "selected":"") }}>10-Asimilados Acciones</option>
                                <option value="11" {{ (old("TIPOREGIMEN") == 11 ? "selected":"") }}>11-Asimilados Otros</option>
                                <option value="99" {{ (old("TIPOREGIMEN") == 99 ? "selected":"") }}>99-Otro Regimen</option>
                            </select>
                        </div> 
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                    <div class="col-md-4 no-pad" style="">
                            <div class="input-group" style="margin-left: 45px;">
                                <h5>Checa Tarjeta: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                        <input type="hidden"  name="CHECA"  value="False">
                                        <input type="checkbox"  name="CHECA" value="True" {{ (old("CHECA") == "True" ? "checked":"") }}>
                                    </span>     
                            </div>

                            <div class="input-group" style="margin-left: 45px;">
                                <h5>¿Es sindicalizado?: </h5> &nbsp;
                                    <span class="">
                                        <input type="hidden" aria-label="..." name="SINDIC"  value="False">
                                        <input type="checkbox" aria-label="..." name="SINDIC"  value="True" {{ (old("SINDIC") == "True" ? "checked":"") }}>
                                    </span> 
                            </div>
                            <br><br><br>
                    </div>

                     <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Turno</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="TURNO" class="inderecha">
                                <option value="1" {{ (old("TURNO") == 1 ? "selected":"") }}>1-Diurno</option>
                                <option value="2" {{ (old("TURNO") == 2 ? "selected":"") }}>2-Nocturno</option>
                                <option value="3" {{ (old("TURNO") == 3 ? "selected":"") }}>3-Mixto</option>                               
                            </select>
                        </div> 
                    </div>

                     <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Zona Economica</p></div>
                            <input type="number" name="ZONAECO" value="{{ old('ZONAECO') }}">
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
                            <input type="number" name="CLIMSS" value="{{ old('CLIMSS') }}">
                        </div> 
                    </div>

                     <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Pago</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="TIPOPAGO" required class="inderecha">
                                <option value="01 Efectivo" {{ (old("TIPOPAGO") == '01 Efectivo' ? "selected":"") }}>01 Efectivo</option>
                                <option value="02 Cheque nominativo" {{ (old("TIPOPAGO") == '02 Cheque nominativo' ? "selected":"") }}>02 Cheque nominativo</option>
                                <option value="03 Transferencia Electronica" {{ (old("TIPOPAGO") == '03 Transferencia Electronica' ? "selected":"") }}>03 Transferencia Electrónica</option>
                                <option value="04 Tarjeta de Credito" {{ (old("TIPOPAGO") == '04 Tarjeta de Credito' ? "selected":"") }}>04 Tarjeta de Crédito</option>
                                <option value="05 Monedero Electronico" {{ (old("TIPOPAGO") == '05 Monedero Electronico' ? "selected":"") }}>05 Monedero Electrónico</option>
                                <option value="06 Dinero Electronico" {{ (old("TIPOPAGO") == '06 Dinero Electronico' ? "selected":"") }}>06 Dinero Electrónico</option>
                                <option value="08 Vales de Despensa" {{ (old("TIPOPAGO") == '08 Vales de Despensa' ? "selected":"") }}>08 Vales de Despensa</option>
                                <option value="28 Tarjeta de Debito" {{ (old("TIPOPAGO") == '28 Tarjeta de Debito' ? "selected":"") }}>28 Tarjeta de Débito</option>
                                <option value="29 Tarjeta de Servicio" {{ (old("TIPOPAGO") == '29 Tarjeta de Servicio' ? "selected":"") }}>29 Tarjeta de Servicio</option>
                                <option value="99 Otros" {{ (old("TIPOPAGO") == '99 Otros' ? "selected":"") }}>99 Otros</option>
                            </select>
                        </div> 
                    </div>

                     <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Contrato</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right:0px; font-size: 11px; margin-left: 75px;" name="c_TipoContrato" required class="inderecha deptip">
                                <option value="01 Contrato de trabajo por tiempo indeterminado" {{ (old("c_TipoContrato") == '01 Contrato de trabajo por tiempo indeterminado' ? "selected":"") }}>01 Contrato de trabajo por tiempo indeterminado</option>
                                <option value="02 Contrato de trabajo para obra determinada" {{ (old("c_TipoContrato") == '02 Contrato de trabajo para obra determinada' ? "selected":"") }}>02 Contrato de trabajo para obra determinada</option>
                                <option value="03 Contrato de trabajo por tiempo determinado" {{ (old("c_TipoContrato") == '03 Contrato de trabajo por tiempo determinado' ? "selected":"") }}>03 Contrato de trabajo por tiempo determinado</option>
                                <option value="04 Contrato de trabajo por temporada" {{ (old("c_TipoContrato") == '04 Contrato de trabajo por temporada' ? "selected":"") }}>04 Contrato de trabajo por temporada</option>
                                <option value="05 Contrato de trabajo sujeto a prueba" {{ (old("c_TipoContrato") == '05 Contrato de trabajo sujeto a prueba' ? "selected":"") }}>05 Contrato de trabajo sujeto a prueba</option>
                                <option value="06 Contrato de trabajo con capacitación inicial" {{ (old("c_TipoContrato") == '06 Contrato de trabajo con capacitación inicial' ? "selected":"") }}>06 Contrato de trabajo con capacitación inicial</option>
                                <option value="07 Modalidad de contratación por pago de hora laborada" {{ (old("c_TipoContrato") == '07 Modalidad de contratación por pago de hora laborada' ? "selected":"") }}>07 Modalidad de contratación por pago de hora laborada</option>
                                <option value="08 Modalidad de trabajo por comisión laboral" {{ (old("c_TipoContrato") == '08 Modalidad de trabajo por comisión laboral' ? "selected":"") }}>08 Modalidad de trabajo por comisión laboral</option>
                                <option value="09 Modalidades de contratación donde no existe relación de trabajo" {{ (old("c_TipoContrato") == '09 Modalidades de contratación donde no existe relación de trabajo' ? "selected":"") }}>09 Modalidades de contratación donde no existe relación de trabajo</option>
                                <option value="10 Jubilación, pensión, retiro." {{ (old("c_TipoContrato") == '10 Jubilación, pensión, retiro.' ? "selected":"") }}>10 Jubilación, pensión, retiro.</option>
                                <option value="99 Otro contrato" {{ (old("c_TipoContrato") == '99 Otro contrato' ? "selected":"") }}>99 Otro contrato</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Ingreso</p></div>
                            <input type="date" id="Ingreso" name="INGRESO" value="{{ old('INGRESO') }}" required>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Vacaciones</p></div>
                            <input type="date" name="VACACION" value="{{ old('VACACION') }}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Planta</p></div>
                            <input type="date" name="PLANTA" value="{{ old('PLANTA') }}">
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
                            <input type="date" name="VENCIM" value="{{ old('VENCIM') }}">
                        </div> 
                    </div>
                    
                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Baja</p></div>
                            <input type="date" name="BAJA" disabled="disabled" class="bloqueado">
                        </div> 
                    </div>

                </div>
              

              
                    <div class="row">
                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p># IMSS Patrón:</p></div>
                            <input type="text" name="REGPAT" maxlength="11" value="{{ old('REGPAT') }}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Reg. Fed. de C.:</p></div>
                            <input type="text" name="RFC" value="{{ old('RFC') }}" required="" maxlength="15" onkeyup="javascript:this.value=this.value.toUpperCase(); Rfc(event, this);">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>IMSS Empleado:</p></div>
                            <input type="number" name="IMSS" value="{{ old('IMSS') }}"max="999999999999999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" >
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Grupo IMSS:</p></div>                          
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="GRUIMS" class="inderecha">
                                <option value="0" {{ (old("GRUIMS") == 0 ? "selected":"") }}>Fijo</option>
                                <option value="1" {{ (old("GRUIMS") == 1 ? "selected":"") }}>Variable</option>
                                <option value="2" {{ (old("GRUIMS") == 2 ? "selected":"") }}>Mixto</option>
                                <option value="3" {{ (old("GRUIMS") == 3 ? "selected":"") }}>Sin Descuento</option>                               
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" >
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Crédito FONACOT:</p></div>
                            <input type="number" name="FONACOT" value="{{ old('FONACOT') }}" max="999999999999999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" >
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Crédito INFONAVIT:</p></div>
                            <input type="number" name="INFONAVIT" value="{{ old('INFONAVIT') }}" max="999999999999999">
                        </div> 
                    </div>
                    <div class="col-md-4 no-pad" style="border-bottom: 2px #F0F0F0 solid; height: 70px;">
                        
                    </div>
                    <div class="col-md-4 no-pad" style="border-bottom: 2px #F0F0F0 solid;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>CURP: </p></div>
                            <input type="text" name="CURP" value="{{ old('CURP') }}" maxlength="25" onkeyup="Curp(event, this)">
                        </div> 
                    </div>
                    <div class="col-md-4 no-pad" style="border-bottom: 2px #F0F0F0 solid;  height: 70px;">
                        
                    </div>

                    <div class="col-md-12" style=" text-align: left;">
                      <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Acumulado Otras Empresas.</h3>
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Perce:</p></div>
                            <input type="number" name="OTRACIA" max="999999999" value="{{ old('OTRACIA', 0) }}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>ISPT:</p></div>
                            <input type="number" name="TAXOTRA" max="999999999" value="{{ old('TAXOTRA', 0) }}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>SPE:</p></div>
                            <input type="number" name="CASOTRA" max="999999999" value="{{ old('CASOTRA',0) }}" required>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>SAR:</p></div>
                            <input type="number" name="SAROTR" max="999999999" value="{{ old('SAROTR') }}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>INFONAVIT:</p></div>
                            <input type="number" name="DESINFO" max="999999999" value="{{ old('DESINFO',0) }}">
                        </div> 
                    </div>

                    <div class="col-md-12" style=" text-align: left; border-top: 2px #F0F0F0 solid;">
                      <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sueldos.</h3>
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Sueldo Diario:</p></div>
                            <input type="number" id="Sueldo" step="0.01" name="SUELDO" min="{{$minimodia}}" max="999999999" value="{{ old('SUELDO') }}">
                        </div> 
                    </div>

                    
                     <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Sueldo Integro Mensual:</p></div>
                            <input type="number" id="SueldoIn" step="0.01" name="NetoMensual" max="999999999" value="{{ old('NetoMensual') }}">
                        </div> 
                    </div>
                   

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Var IMSS:</p></div>
                            <input type="text" name="VARIMSS" step="0.01" max="999999999" value="{{ old('VARIMSS',0) }}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>EYM SAR:</p></div>
                            <input type="number" step="0.01" id="Integ" name="INTEG" max="999999999" value="{{ old('INTEG',0) }}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>IV-CV-INF:</p></div>
                            <input type="number" step="0.01" id="Intiv" name="INTIV" max="999999999" value="{{ old('INTIV',0) }}">
                        </div> 
                    </div>

                    <div class="col-md-12 no-pad" style="border-top: 2px #F0F0F0 solid;">
                            <div class="input-group" style="margin-left: 45px;">
                                <h5>¿Presenta Declaración Anual? </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="hidden" aria-label="..." name="PRESDEC" value="False">
                                    <input type="checkbox" aria-label="..." name="PRESDEC" value="True" {{ (old("PRESDEC") == "True" ? "checked":"") }}>
                                </span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <h5>¿Tiene SPE en otra Compañia?: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="hidden" aria-label="..." name="NOCRED" value="False">
                                    <input type="checkbox" aria-label="..." name="NOCRED" value="True" {{ (old("NOCRED") == "True" ? "checked":"") }}>
                                </span>                               
                            </div>                           
                    </div>
                    </div>
                



            
                <div class="row">
                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Clave</p></div>
                            <input type="number" name="EMP2" id="EMP2" readonly="readonly" value="{{old('EMP2',$ultimo3)}}" class="bloqueado">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nivel:</p></div>
                            <input type="text" name="NIVEL" max="9999" value="{{ old('NIVEL') }}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Reporta al:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 0px; margin-left: 75px;" name="REPORTA" class="inderecha deptip">
                                
                                @foreach ($jobs as $job)
                                <option value="{{$job->PUESTO}}" {{ (old("REPORTA") == $job->PUESTO ? "selected":"") }}>{{$job->NOMBRE}}</option>                  
                                @endforeach
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Calle:</p></div>
                            <input type="text" name="DIRECCION" value="{{ old('DIRECCION') }}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Referencia:</p></div>
                            <input type="text" name="Referencia" value="{{ old('Referencia') }}" maxlength="50" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>No. Exterior:</p></div>
                            <input type="number" name="noExterior" value="{{ old('noExterior') }}" max="9999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>No. Interior:</p></div>
                            <input type="number" name="noInterior" value="{{ old('noInterior') }}" max="9999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Municipio:</p></div>
                            <input type="text" name="Municipio" value="{{ old('Municipio') }}" maxlength="150" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Colonia:</p></div>
                            <input type="text" name="COLONIA" value="{{ old('COLONIA') }}" maxlength="40" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Localidad:</p></div>
                            <input type="text" name="CIUDAD" maxlength="30" value="{{ old('CIUDAD') }}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Estado:</p></div>
                            <input type="text" name="ESTADO" maxlength="20" value="{{ old('ESTADO') }}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Telefono:</p></div>
                            <input type="number" name="TELEFONO" value="{{ old('TELEFONO') }}" max="9999999999999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Codigo Postal:</p></div>
                            <input type="number" name="ZIP" value="{{ old('ZIP') }}" max="99999999999">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Celular:</p></div>
                            <input type="NUMBER" name="CELULAR" value="{{ old('CELULAR') }}" max="999999999999999">
                        </div> 
                    </div>

                    <div class="col-md-5">
                      <h5>Otra Experiencia:</h5>
                        <div class="">
                          <textarea class="campo-texto-etiqueta" placeholder="" name="EXPERI" id="" cols="30" rows="5">{{ old('EXPERI') }}</textarea>
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
                        <output id="list" style="width: 100px; height: 100px;"><img src="<?php echo "/admon/empleados/Ideatisa.ico"; ?>" style="width: 100px; height: 100px;"></output>
                        
                    </div>

                    <div class="col-md-12 no-pad" style="border-top: 2px #F0F0F0 solid; margin-bottom: 15px;margin-top: 13px;">                     
                    </div>

                    <div class="col-md-4 no-pad" style="">
                            <div class="input-group" style="margin-left: 45px;">
                                <h5>Sexo: </h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <h5>Femenino: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="radio" name="SEXO" aria-label="..." value="F" {{ (old("SEXO") == "F" ? "checked":"") }} required="">
                                </span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <h5>Masculino: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="radio" name="SEXO" aria-label="..." value="M" {{ (old("SEXO") == "M" ? "checked":"") }} required="">
                                </span> 
                            </div>    
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Estado Civil:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="CIVIL" class="inderecha">
                                <option value="S" {{ (old("CIVIL") == 'S' ? "selected":"") }}>Soltero</option>
                                <option value="C" {{ (old("CIVIL") == 'C' ? "selected":"") }}>Casado</option>
                                <option value="D" {{ (old("CIVIL") == 'D' ? "selected":"") }}>Divorciado</option>
                                <option value="U" {{ (old("CIVIL") == 'U' ? "selected":"") }}>Unión Libre</option>
                                <option value="V" {{ (old("CIVIL") == 'V' ? "selected":"") }}>Viudo</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Fecha de Boda:</p></div>
                            <input type="date" name="BODA" value="{{ old('BODA') }}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Licencia:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="LICENCIA" class="inderecha">
                                <option value="A" {{ (old("LICENCIA") == 'A' ? "selected":"") }}>Automovilista</option>
                                <option value="C" {{ (old("LICENCIA") == 'C' ? "selected":"") }}>Chofer</option>
                                <option value="M" {{ (old("LICENCIA") == 'M' ? "selected":"") }}>Motociclista</option>
                                <option value="N" {{ (old("LICENCIA") == 'N' ? "selected":"") }}>Ninguno</option>
                                
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Tipo de Sangre:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="SANGRE" class="inderecha">
                                <option value="A+" {{ (old("SANGRE") == 'A+' ? "selected":"") }}>A+</option>
                                <option value="A-" {{ (old("SANGRE") == 'A-' ? "selected":"") }}>A-</option>
                                <option value="B+" {{ (old("SANGRE") == 'B+' ? "selected":"") }}>B+</option>
                                <option value="B-" {{ (old("SANGRE") == 'B-' ? "selected":"") }}>B-</option>
                                <option value="AB+" {{ (old("SANGRE") == 'AB+' ? "selected":"") }}>AB+</option>
                                <option value="AB-" {{ (old("SANGRE") == 'AB-' ? "selected":"") }}>AB-</option>
                                <option value="O+" {{ (old("SANGRE") == 'O+' ? "selected":"") }}>O+</option>
                                <option value="O-" {{ (old("SANGRE") == 'O-' ? "selected":"") }}>O-</option>
                                <option value="I" {{ (old("SANGRE") == 'I' ? "selected":"") }}>I</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Escolaridad:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="ESCOLAR" class="inderecha">
                                <option value="0" {{ (old("ESCOLAR") == '0' ? "selected":"") }}>Nada</option>
                                <option value="1" {{ (old("ESCOLAR") == '1' ? "selected":"") }}>Primaria</option>
                                <option value="2" {{ (old("ESCOLAR") == '2' ? "selected":"") }}>Secundaria</option>
                                <option value="3" {{ (old("ESCOLAR") == '3' ? "selected":"") }}>Bachillerato</option>
                                <option value="4" {{ (old("ESCOLAR") == '4' ? "selected":"") }}>Profesional</option>
                                <option value="5" {{ (old("ESCOLAR") == '5' ? "selected":"") }}>Posgrado</option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="border-left: 2px #F0F0F0 solid;">
                            <div class="input-group" style="margin-left: 45px;">

                                <h5>Cambio de Residencia: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="hidden" aria-label="..." name="CAMB_RESID" value="False">
                                    <input type="checkbox" aria-label="..." name="CAMB_RESID" value="True" {{ (old("CAMB_RESID") == 'True' ? "checked":"") }}>
                                </span>
                                
                            </div>
                            <div class="input-group" style="margin-left: 45px;">
                                <h5>Disposición de Viajar: </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="">
                                    <input type="hidden" aria-label="..." name="DISP_VIAJE" value="False">
                                    <input type="checkbox" aria-label="..." name="DISP_VIAJE" value="True" {{ (old("DISP_VIAJE") == 'True' ? "checked":"") }}>
                                </span> 
                            </div>
                    </div>

                     <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Fecha de Nacimiento:</p></div>
                            <input type="date" name="BORN" value="{{ old('BORN') }}">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Lugar de Nacimiento:</p></div>
                            <input type="text" name="NACIM" value="{{ old('NACIM') }}" maxlength="15" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Nacionalidad:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="NACIONAL" class="inderecha">
                                <option value="MAXICANA" {{ (old("NACIONAL") == 'MEXICANA' ? "selected":"") }}>MEXICANA</option>
                                <option value="ESTADOUNIDENSE" {{ (old("NACIONAL") == 'ESTADOUNIDENSE' ? "selected":"") }}>ESTADOUNIDENSE</option>
                                <option value="EXTRANJERA" {{ (old("NACIONAL") == 'EXTRANJERA' ? "selected":"") }}>EXTRANJERA</option>
                                
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>No. de Dependientes:</p></div>
                            <input type="NUMBER" name="DEPENDIENT" value="{{ old('DEPENDIENT') }}" max="99">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Transporte:</p></div>
                            <select style="width: 340px; height: 40px; border-radius: 10px; text-align: right; padding-right: 20px;" name="MEDIO" class="inderecha">
                                <option value="0" {{ (old("MEDIO") == '0' ? "selected":"") }}>Camión Empresa</option>
                                <option value="1" {{ (old("MEDIO") == '1' ? "selected":"") }}>Camión Urbano</option>
                                <option value="2" {{ (old("MEDIO") == '2' ? "selected":"") }}>Trae Tamsporte Personal</option>
                                <option value="3" {{ (old("MEDIO") == '3' ? "selected":"") }}>Otro Transporte sin Costo</option>                                
                            </select>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Fuentes de Empleo:</p></div>
                            <input type="number" name="FUENTE" value="{{ old('FUENTE') }}" max="10">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>E-Mail:</p></div>
                            <input type="email" name="Email" value="{{ old('Email') }}">
                        </div> 
                    </div>
                </div>
            

             
                <div class="row">
                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            
                            <input type="hidden" id="nombre3" name="na" value="{{ old('na') }}" class="bloqueado" readonly="readonly">
                        </div> 
                    </div>


                    <div class="col-md-4 no-pad">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>No. Nuevo del IMSS: </p></div>
                            <input type="number" name="IMSS2" value="{{ old('IMSS2') }}" max="999999999999999">
                        </div> 
                    </div>


                </div>
             


    
            <div class="row">
                        <style type="text/css">
                          .files input {
                            outline: 2px dashed #92b0b3;
                            outline-offset: -10px;
                            -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
                            transition: outline-offset .15s ease-in-out, background-color .15s linear;
                            padding: 120px 0px 85px 35%;
                            text-align: center !important;
                            margin: 0;
                            width: 100% !important;
                          }
                            .files input:focus{     outline: 2px dashed #92b0b3;  outline-offset: -10px;
                                -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
                                transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
                          }

                            .files{ position:relative}
                            .files:after {  pointer-events: none;
                                position: absolute;
                                top: 60px;
                                left: 0;
                                width: 50px;
                                right: 0;
                                height: 56px;
                                content: "";
                                background-image: url(https://image.flaticon.com/icons/png/128/109/109612.png);
                                display: block;
                                margin: 0 auto;
                                background-size: 100%;
                                background-repeat: no-repeat;
                          }
                            .color input{ background-color:#f1f1f1;}
                            .files:before {
                                position: absolute;
                                bottom: 0px;
                                left: 0;  pointer-events: none;
                                width: 100%;
                                right: 0;
                                height: 57px;
                                content: " O arrastralo aqui. ";
                                display: block;
                                margin: 0 auto;
                                color: #2ea591;
                                font-weight: 600;
                                text-transform: capitalize;
                                text-align: center;
                          }
                          .cargador:hover{
                            background-color: rgb(179, 215, 243);
                            transition: 1s;
                          }
                        </style>

                        <div style="   width: 100%">
                @if($docsReque->REQUERIDO1==1)
                  <div class="col-md-4" style="margin-bottom: 0px;  height: 310px;">
                            <div style="width: 100%; float: left;">
                            <div class="form-group files">
                              <label>Sube el documento de acta de nacimiento</label>
                              <input type="file" class="form-control cargador" name="nacimiento" multiple="" @if($docsReque->REQUERIDO1==1) {{'required'}}@endif>
                            </div>
                            @if ($docsReque->FECHAREQUE1==1)        
                            <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechanaci" required>
                            @endif
                          </div>     
                           
                  </div>
                @endif 
                @if($docsReque->REQUERIDO2==1)
                   <div class="col-md-4" style="margin-bottom: 0px;  height: 310px;">
                      
                             <div style="width: 100%; float: left;">
                            <div class="form-group files">
                              <label>Sube el documento de RFC</label>
                              <input type="file" class="form-control cargador" name="rfc" multiple="" @if($docsReque->REQUERIDO2==1) {{'required'}}@endif>
                            </div>
                              @if ($docsReque->FECHAREQUE2==1)   
                            <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fecharfc" required>
                           @endif
                          </div>
                        
                  </div>
                @endif 
                @if($docsReque->REQUERIDO3==1)
                   <div class="col-md-4" style="margin-bottom: 0px;  height: 310px;">
                      
                             <div style="width: 100%; float: left;">
                            <div class="form-group files">
                              <label>Sube el documento de CURP</label>
                              <input type="file" class="form-control cargador" name="curp" multiple="" @if($docsReque->REQUERIDO3==1) {{'required'}}@endif>
                            </div>
                            @if ($docsReque->FECHAREQUE3==1)        
                            <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechacurp" required>
                            @endif
                          </div>
                                 
                  </div> 
                @endif
                @if($docsReque->REQUERIDO4==1)
                    <div class="col-md-4" style="margin-bottom: 0px;  height: 310px;">  
                      <div style="width: 100%; float: left;">
                        <div class="form-group files">
                          <label>Sube el documento de Comprobante Domiciliario</label>
                          <input type="file" class="form-control cargador" name="comprobante" multiple=""@if($docsReque->REQUERIDO4==1) {{'required'}}@endif>
                        </div>
                        @if ($docsReque->FECHAREQUE4==1)        
                          <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechacompro" required>
                        @endif
                      </div>     
                     
                    </div>
                @endif

                @if($docsReque->REQUERIDO5==1)
                    <div class="col-md-4" style="margin-bottom: 0px;  height: 310px;">  
                      <div style="width: 100%; float: left;">
                        <div class="form-group files">
                          <label>Sube el documento de Solicitud de Empleo</label>
                          <input type="file" class="form-control cargador" name="empleo" multiple=""@if($docsReque->REQUERIDO5==1) {{'required'}}@endif>
                        </div>
                        @if ($docsReque->FECHAREQUE5==1)        
                          <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechaempleo" required>
                        @endif
                      </div>
                        
                    </div>
                @endif
                @if($docsReque->REQUERIDO6==1)
                    <div class="col-md-4" style="margin-bottom: 0px;  height: 310px;">  
                      <div style="width: 100%; float: left;">
                        <div class="form-group files">
                          <label>Sube el documento de IFE o INE</label>
                          <input type="file" class="form-control cargador" name="ine" multiple=""@if($docsReque->REQUERIDO6==1) {{'required'}}@endif>
                        </div>
                        @if ($docsReque->FECHAREQUE6==1)        
                          <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechaine" required>
                        @endif
                      </div>
                      
                    </div>
                @endif
                @if($docsReque->REQUERIDO7==1)
                    <div class="col-md-4" style="margin-bottom: 0px;  height: 310px;">  
                      <div style="width: 100%; float: left;">
                        <div class="form-group files">
                          <label>Sube el documento de Acta de Boda</label>
                          <input type="file" class="form-control cargador" name="boda" multiple=""@if($docsReque->REQUERIDO7==1) {{'required'}}@endif>
                        </div>
                        @if ($docsReque->FECHAREQUE7==1)        
                          <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechabodaa" required>
                        @endif
                      </div>
                     
                    </div>
                @endif
                @if($docsReque->REQUERIDO8==1)
                    <div class="col-md-4" style="margin-bottom: 0px;  height: 310px;">  
                      <div style="width: 100%; float: left;">
                        <div class="form-group files">
                          <label>Sube el documento de Titulo</label>
                          <input type="file" class="form-control cargador" name="titulo" multiple=""@if($docsReque->REQUERIDO8==1) {{'required'}}@endif>
                        </div>
                        @if ($docsReque->FECHAREQUE8==1)        
                          <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechatitulo" required>
                        @endif
                      </div>
                     
                    </div>
                @endif
                @if($docsReque->REQUERIDO9==1)
                    <div class="col-md-4" style="margin-bottom: 0px;  height: 310px;">  
                      <div style="width: 100%; float: left;">
                        <div class="form-group files">
                          <label>Sube el documento de Carta de Atecedentes no Penales</label>
                          <input type="file" class="form-control cargador" name="antecedentes" multiple=""@if($docsReque->REQUERIDO9==1) {{'required'}}@endif>
                        </div>
                        @if ($docsReque->FECHAREQUE9==1)        
                          <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechaante" required>
                        @endif
                      </div>
                     
                    </div>
                @endif
                @if($docsReque->REQUERIDO10==1)
                    <div class="col-md-4" style="margin-bottom: 0px;  height: 310px;">  
                      <div style="width: 100%; float: left;">
                        <div class="form-group files">
                          <label>Sube el documento de Contrato</label>
                          <input type="file" class="form-control cargador" name="contrato" multiple=""@if($docsReque->REQUERIDO10==1) {{'required'}}@endif>
                        </div>
                        @if ($docsReque->FECHAREQUE10==1)        
                          <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechacontrato" required>
                        @endif
                      </div>
                     
                    </div>
                @endif
                @if($docsReque->REQUERIDO11==1)
                    <div class="col-md-4" style="margin-bottom: 0px;  height: 310px;">  
                      <div style="width: 100%; float: left;">
                        <div class="form-group files">
                          <label>Sube el documento de Curriculum</label>
                          <input type="file" class="form-control cargador" name="curriculum" multiple=""@if($docsReque->REQUERIDO11==1) {{'required'}}@endif>
                        </div>
                        @if ($docsReque->FECHAREQUE11==1)        
                          <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechacurri" required>
                        @endif
                      </div>
                     
                    </div>
                @endif
                @if($docsReque->REQUERIDO12==1)
                    <div class="col-md-4" style="margin-bottom: 0px;  height: 310px;">  
                      <div style="width: 100%; float: left;">
                        <div class="form-group files">
                          <label>Sube el documento de Cedula Profesional</label>
                          <input type="file" class="form-control cargador" name="cedula" multiple=""@if($docsReque->REQUERIDO12==1) {{'required'}}@endif>
                        </div>
                        @if ($docsReque->FECHAREQUE12==1)        
                          <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechacedula" required>
                        @endif
                      </div>
                     
                    </div>
                @endif
                @if($docsReque->REQUERIDO13==1)
                    <div class="col-md-4" style="margin-bottom: 0px;  height: 310px;">  
                      <div style="width: 100%; float: left;">
                        <div class="form-group files">
                          <label>Sube el documento de Diplomas, Seminarios u Otros</label>
                          <input type="file" class="form-control cargador" name="diplomas" multiple=""@if($docsReque->REQUERIDO13==1) {{'required'}}@endif>
                        </div>
                        @if ($docsReque->FECHAREQUE13==1)        
                          <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechadiplo" required>
                        @endif
                      </div>
                     
                    </div>
                @endif
                @if($docsReque->REQUERIDO14==1)
                    <div class="col-md-4" style="margin-bottom: 0px;  height: 310px;">  
                      <div style="width: 100%; float: left;">
                        <div class="form-group files">
                          <label>Sube el documento de Certificaciones</label>
                          <input type="file" class="form-control cargador" name="certificaciones" multiple=""@if($docsReque->REQUERIDO14==1) {{'required'}}@endif>
                        </div>
                        @if ($docsReque->FECHAREQUE14==1)        
                          <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechacerti" required>
                        @endif
                      </div>
                     
                    </div>
                @endif
                @if($docsReque->REQUERIDO15==1)
                    <div class="col-md-4" style="margin-bottom: 0px;  height: 310px;">  
                      <div style="width: 100%; float: left;">
                        <div class="form-group files">
                          <label>Sube el documento de Licencia</label>
                          <input type="file" class="form-control cargador" name="licencia" multiple=""@if($docsReque->REQUERIDO15==1) {{'required'}}@endif>
                        </div>
                        @if ($docsReque->FECHAREQUE15==1)        
                          <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechalicencia" required>
                        @endif
                      </div>
                     
                    </div>
                @endif
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

<!-- ----- cambio de color pestañas---------------- -->
<script type="text/javascript">
    function cambiar_color_over(pestana){ 
    var x= document.getElementsByClassName("pestanas");
    var i;
    for (i = 0; i < x.length; i++) {
        x[i].style.backgroundColor = "white";
        }
    pestana.style.backgroundColor="rgb(179, 215, 243)";
    } 
</script>
<!-- ----------- fin de cambio de color pestañas------------------ -->
@endsection
<!-- termina el codigo escrito por Ricardo Cordero 2018