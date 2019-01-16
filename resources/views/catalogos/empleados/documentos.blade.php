@extends('layouts.app')

@section('title','Aron | Menú')
@section('body-class','')

@section('content')
<div class="main main-raised"> 
    <div class="">   
      <div class="section text-center">
        <h2 class="titulo">Documentos de {{$nombre_emp}}</h2>
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
        <form method="POST" action="{{url('/catalogos/documentos/empleados/actualizar')}}" id="#" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div style=" width: 20%; float: left; height: 2500px; text-align: left; padding-left: 20px;">
            <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lista de Documentos</h3><br>
            <input type="checkbox" disabled name="" @if ($listdoc->CHECK1 == 1) {{'checked'}}@endif> <label>&nbsp;Acta de nacimiento</label><br>
            <input type="checkbox" disabled name="" @if ($listdoc->CHECK2 == 1) {{'checked'}}@endif> <label>&nbsp;RFC</label><br>
            <input type="checkbox" disabled name="" @if ($listdoc->CHECK3 == 1) {{'checked'}}@endif> <label>&nbsp;CURP</label><br>
            <input type="checkbox" disabled name="" @if ($listdoc->CHECK4 == 1) {{'checked'}}@endif> <label>&nbsp;Comprobante domiciliario</label><br>
            <input type="checkbox" disabled name="" @if ($listdoc->CHECK5 == 1) {{'checked'}}@endif> <label>&nbsp;Solicitud de Empleo</label><br>
            <input type="checkbox" disabled name="" @if ($listdoc->CHECK6 == 1) {{'checked'}}@endif> <label>&nbsp;IFE o INE</label><br>
            <input type="checkbox" disabled name="" @if ($listdoc->CHECK7 == 1) {{'checked'}}@endif> <label>&nbsp;Acta de boda</label><br>
            <input type="checkbox" disabled name="" @if ($listdoc->CHECK8 == 1) {{'checked'}}@endif> <label>&nbsp;Titulo</label><br>
            <input type="checkbox" disabled name="" @if ($listdoc->CHECK9 == 1) {{'checked'}}@endif> <label>&nbsp;Atecedentes no Penales</label><br>
            <input type="checkbox" disabled name="" @if ($listdoc->CHECK10 == 1) {{'checked'}}@endif> <label>&nbsp;Contrato</label><br>
            <input type="checkbox" disabled name="" @if ($listdoc->CHECK11 == 1) {{'checked'}}@endif> <label>&nbsp;Curriculum</label><br>
            <input type="checkbox" disabled name="" @if ($listdoc->CHECK12 == 1) {{'checked'}}@endif> <label>&nbsp;Cedula Profesional</label><br>
            <input type="checkbox" disabled name="" @if ($listdoc->CHECK13 == 1) {{'checked'}}@endif> <label>&nbsp;Diplomas Seminarios y OtrOs</label><br>
            <input type="checkbox" disabled name="" @if ($listdoc->CHECK14 == 1) {{'checked'}}@endif> <label>&nbsp;Certificaciones</label><br>
            <input type="checkbox" disabled name="" @if ($listdoc->CHECK15 == 1) {{'checked'}}@endif> <label>&nbsp;Licencia</label><br>
            
          </div>


        <div style=" border-radius: 5px; border:rgb(179, 215, 243) solid; height: 2450px; float: right; width: 80%">
            
          <div class="col-md-6" style="margin-bottom: 0px; height: 310px;">
                    <div style="width: 51%; float: left;">
                    <div class="form-group files">
                      <label>Sube el documento de acta de nacimiento</label>
                      <input type="file" class="form-control cargador" name="nacimiento" multiple="" >
                    </div>
                    @if ($docsReque->FECHAREQUE1==1)        
                    <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechanaci" required>
                    @endif
                  </div>
                  @if($listdoc->CHECK1==1)
                   <div style="width: 49%; float: right;"><img src="{{asset('/img/acta.jpg')}}" width="200" height="250"><br><br><a href="/catalogos/documentos/empleados/{{$listdoc->NOMBRE1}}">Visualizar</a>
                    </div> 
                  @endif
          </div>

           <div class="col-md-6" style="margin-bottom: 0px; height: 310px;">
              
                     <div style="width: 51%; float: left;">
                    <div class="form-group files">
                      <label>Sube el documento de RFC</label>
                      <input type="file" class="form-control cargador" name="rfc" multiple="" >
                    </div>
                      @if ($docsReque->FECHAREQUE2==1)   
                    <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fecharfc" required>
                   @endif
                  </div>
                  @if($listdoc->CHECK2==1)
                   <div style="width: 49%; float: right;"><br><br><img src="{{asset('/img/rfc.jpg')}}" width="250" height="190"><br><br><br><a href="/catalogos/documentos/empleados/{{$listdoc->NOMBRE2}}">Visualizar</a>
                    </div> 
                    @endif
          </div> 

           <div class="col-md-6" style="margin-bottom: 0px; height: 310px;">
              
                     <div style="width: 51%; float: left;">
                    <div class="form-group files">
                      <label>Sube el documento de CURP</label>
                      <input type="file" class="form-control cargador" name="curp" multiple="" >
                    </div>
                    @if ($docsReque->FECHAREQUE3==1)        
                    <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechacurp" required>
                    @endif
                  </div>
                  @if($listdoc->CHECK3==1)
                   <div style="width: 49%; float: right;"><br><br><img src="{{asset('/img/curp.jpg')}}" width="250" height="150"><br><br><a href="/catalogos/documentos/empleados/{{$listdoc->NOMBRE3}}">Visualizar</a>
                    </div> 
                  @endif
          </div> 

            <div class="col-md-6" style="margin-bottom: 0px; height: 310px;">  
              <div style="width: 51%; float: left;">
                <div class="form-group files">
                  <label>Sube el documento de Comprobante Domiciliario</label>
                  <input type="file" class="form-control cargador" name="comprobante" multiple="">
                </div>
                @if ($docsReque->FECHAREQUE4==1)        
                  <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechacompro" required>
                @endif
              </div>
              @if($listdoc->CHECK4==1)
                <div style="width: 49%; float: right;"><img src="{{asset('/img/cfe.jpg')}}" width="200" height="250">
                  <br><br>
                  <a href="/catalogos/documentos/empleados/{{$listdoc->NOMBRE4}}">Visualizar</a>
                </div> 
              @endif
            </div>


            <div class="col-md-6" style="margin-bottom: 0px; height: 310px;">  
              <div style="width: 51%; float: left;">
                <div class="form-group files">
                  <label>Sube el documento de Solicitud de Empleo</label>
                  <input type="file" class="form-control cargador" name="empleo" multiple="">
                </div>
                @if ($docsReque->FECHAREQUE5==1)        
                  <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechaempleo" required>
                @endif
              </div>
              @if($listdoc->CHECK5==1)
                <div style="width: 49%; float: right;"><img src="{{asset('/img/solicitud.jpg')}}" width="200" height="250">
                  <br><br>
                  <a href="/catalogos/documentos/empleados/{{$listdoc->NOMBRE5}}">Visualizar</a>
                </div> 
              @endif
            </div>

            <div class="col-md-6" style="margin-bottom: 0px; height: 310px;">  
              <div style="width: 51%; float: left;">
                <div class="form-group files">
                  <label>Sube el documento de IFE o INE</label>
                  <input type="file" class="form-control cargador" name="ine" multiple="">
                </div>
                @if ($docsReque->FECHAREQUE6==1)        
                  <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechaine" required>
                @endif
              </div>
              @if($listdoc->CHECK6==1)
                <div style="width: 49%; float: right;"><img src="{{asset('/img/ine.jpg')}}" width="200" height="250">
                  <br><br>
                  <a href="/catalogos/documentos/empleados/{{$listdoc->NOMBRE6}}">Visualizar</a>
                </div> 
              @endif
            </div>

            <div class="col-md-6" style="margin-bottom: 0px; height: 310px;">  
              <div style="width: 51%; float: left;">
                <div class="form-group files">
                  <label>Sube el documento de Acta de Boda</label>
                  <input type="file" class="form-control cargador" name="boda" multiple="">
                </div>
                @if ($docsReque->FECHAREQUE7==1)        
                  <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechabodaa" required>
                @endif
              </div>
              @if($listdoc->CHECK7==1)
                <div style="width: 49%; float: right;"><img src="{{asset('/img/actaboda.jpg')}}" width="200" height="250">
                  <br><br>
                  <a href="/catalogos/documentos/empleados/{{$listdoc->NOMBRE7}}">Visualizar</a>
                </div> 
              @endif
            </div>

            <div class="col-md-6" style="margin-bottom: 0px; height: 310px;">  
              <div style="width: 51%; float: left;">
                <div class="form-group files">
                  <label>Sube el documento de Titulo</label>
                  <input type="file" class="form-control cargador" name="titulo" multiple="">
                </div>
                @if ($docsReque->FECHAREQUE8==1)        
                  <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechatitulo" required>
                @endif
              </div>
              @if($listdoc->CHECK8==1)
                <div style="width: 49%; float: right;"><img src="{{asset('/img/titulo.jpg')}}" width="200" height="250">
                  <br><br>
                  <a href="/catalogos/documentos/empleados/{{$listdoc->NOMBRE8}}">Visualizar</a>
                </div> 
              @endif
            </div>

            <div class="col-md-6" style="margin-bottom: 0px; height: 310px;">  
              <div style="width: 51%; float: left;">
                <div class="form-group files">
                  <label>Sube el documento de Carta de Atecedentes no Penales</label>
                  <input type="file" class="form-control cargador" name="antecedentes" multiple="">
                </div>
                @if ($docsReque->FECHAREQUE9==1)        
                  <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechaante" required>
                @endif
              </div>
              @if($listdoc->CHECK9==1)
                <div style="width: 49%; float: right;"><img src="{{asset('/img/antecedentes.jpg')}}" width="200" height="250">
                  <br><br>
                  <a href="/catalogos/documentos/empleados/{{$listdoc->NOMBRE9}}">Visualizar</a>
                </div> 
              @endif
            </div>

            <div class="col-md-6" style="margin-bottom: 0px; height: 310px;">  
              <div style="width: 51%; float: left;">
                <div class="form-group files">
                  <label>Sube el documento de Contrato</label>
                  <input type="file" class="form-control cargador" name="contrato" multiple="">
                </div>
                @if ($docsReque->FECHAREQUE10==1)        
                  <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechacontrato" required>
                @endif
              </div>
              @if($listdoc->CHECK10==1)
                <div style="width: 49%; float: right;"><img src="{{asset('/img/contrato.jpg')}}" width="200" height="250">
                  <br><br>
                  <a href="/catalogos/documentos/empleados/{{$listdoc->NOMBRE10}}">Visualizar</a>
                </div> 
              @endif
            </div>

            <div class="col-md-6" style="margin-bottom: 0px; height: 310px;">  
              <div style="width: 51%; float: left;">
                <div class="form-group files">
                  <label>Sube el documento de Curriculum</label>
                  <input type="file" class="form-control cargador" name="curriculum" multiple="">
                </div>
                @if ($docsReque->FECHAREQUE11==1)        
                  <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechacurri" required>
                @endif
              </div>
              @if($listdoc->CHECK11==1)
                <div style="width: 49%; float: right;"><img src="{{asset('/img/curriculum.jpg')}}" width="200" height="250">
                  <br><br>
                  <a href="/catalogos/documentos/empleados/{{$listdoc->NOMBRE11}}">Visualizar</a>
                </div> 
              @endif
            </div>

            <div class="col-md-6" style="margin-bottom: 0px; height: 310px;">  
              <div style="width: 51%; float: left;">
                <div class="form-group files">
                  <label>Sube el documento de Cedula Profesional</label>
                  <input type="file" class="form-control cargador" name="cedula" multiple="">
                </div>
                @if ($docsReque->FECHAREQUE12==1)        
                  <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechacedula" required>
                @endif
              </div>
              @if($listdoc->CHECK12==1)
                <div style="width: 49%; float: right;"><img src="{{asset('/img/cedula.jpg')}}" width="200" height="250">
                  <br><br>
                  <a href="/catalogos/documentos/empleados/{{$listdoc->NOMBRE12}}">Visualizar</a>
                </div> 
              @endif
            </div>

            <div class="col-md-6" style="margin-bottom: 0px; height: 310px;">  
              <div style="width: 51%; float: left;">
                <div class="form-group files">
                  <label>Sube el documento de Diplomas, Seminarios u Otros</label>
                  <input type="file" class="form-control cargador" name="diplomas" multiple="">
                </div>
                @if ($docsReque->FECHAREQUE13==1)        
                  <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechadiplo" required>
                @endif
              </div>
              @if($listdoc->CHECK13==1)
                <div style="width: 49%; float: right;"><img src="{{asset('/img/diploma.jpg')}}" width="200" height="250">
                  <br><br>
                  <a href="/catalogos/documentos/empleados/{{$listdoc->NOMBRE13}}">Visualizar</a>
                </div> 
              @endif
            </div>

            <div class="col-md-6" style="margin-bottom: 0px; height: 310px;">  
              <div style="width: 51%; float: left;">
                <div class="form-group files">
                  <label>Sube el documento de Certificaciones</label>
                  <input type="file" class="form-control cargador" name="certificaciones" multiple="">
                </div>
                @if ($docsReque->FECHAREQUE14==1)        
                  <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechacerti" required>
                @endif
              </div>
              @if($listdoc->CHECK14==1)
                <div style="width: 49%; float: right;"><img src="{{asset('/img/certificado.jpg')}}" width="200" height="250">
                  <br><br>
                  <a href="/catalogos/documentos/empleados/{{$listdoc->NOMBRE14}}">Visualizar</a>
                </div> 
              @endif
            </div>

            <div class="col-md-6" style="margin-bottom: 0px; height: 310px;">  
              <div style="width: 51%; float: left;">
                <div class="form-group files">
                  <label>Sube el documento de Licencia</label>
                  <input type="file" class="form-control cargador" name="licencia" multiple=""@if($docsReque->REQUERIDO15==1) {{'required'}}@endif>
                </div>
                @if ($docsReque->FECHAREQUE15==1)        
                  <label>Introduce la fecha de vencimiento:&nbsp;&nbsp;</label> <input type="date" name="fechalicencia" required>
                @endif
              </div>
              @if($listdoc->CHECK15==1)
                <div style="width: 49%; float: right;"><img src="{{asset('/img/licencia.jpg')}}" width="270" height="200" style="margin-top: 15px;">
                  <br><br>
                  <a href="/catalogos/documentos/empleados/{{$listdoc->NOMBRE15}}">Visualizar</a>
                </div> 
              @endif
            </div>
        </div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


           <div class="row text-center">
                    
                    <button class="primario separation">Guardar</button>
                    <a href="{{ url('/catalogos/empleados') }}" class="primario1">Cancelar</a>
                </div>    
        </form>
      </div>
    </div>
  </div>
<br><br><br style="height: ">




@include('includes.footer');


@endsection
