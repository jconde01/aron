@extends('layouts.app')

@section('title','Registrar nuevo Cliente')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section">
            <h2 class="title text-center">Registrar nuevo cliente</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>                    
                </div>
            @endif
            <form method="post" action="{{ url('/admin/clientes') }}">
                {{ csrf_field() }}

                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-sm-10">
                        <div class="form-group content-descripcion-left-input">
                            <label class="label-left" style="font-size: 14px;">Nombre del cliente</label>
                            <input type="text" class="form-control" name="Nombre" value="{{ old('Nombre') }}">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="Activo" checked>
                                Activo
                            </label>
                        </div>
                    </div>                    
                </div>

                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-sm-6">
                        <div class="form-group content-descripcion-left-input">
                            <label class="label-left">Representante</label>
                            <input type="text" name="Representante" value="{{ old('Representante') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">                
                        <div class="form-group content-descripcion-left-input">
                            <label class="label-left">Correo electrónico</label>
                            <input type="email" name="Email" value="{{ old('Email') }}">
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-sm-6" style="">
                        <div class="form-group content-descripcion-left-input">
                            <label class="label-left">Dominio</label>
                            <input type="text" name="dominio" id="DOMINIO" placeholder="@ejemplo.com" value="{{ old('dominio') }}" onkeyup="fAgrega1();" required>
                        </div>
                    </div>

                    <div class="col-sm-3" style="">
                        <div class="col-sm-12 col-sm-offset-" style="">
                            <label class="label-left" style="float: left; margin-top: 7px;">Giro &nbsp;&nbsp;</label>
                            <select class="form-control giros_list" style="width: 80%;" name="Giro" style="float: right!important;">
                                @foreach ($giros as $giro)
                                    <option value="{{ $giro->id }}">{{ $giro->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-3" style="">
                        <div class="col-sm-12" style="">
                            <label class="label-left" style="float: left; margin-top: 7px;">Celula &nbsp;&nbsp;</label>
                            <select class="form-control giros_list" style="width: 70%;" name="celula" style="float: right!important;">
                                @foreach ($celulas as $celula)
                                    <option value="{{ $celula->id }}">{{ $celula->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 0px;">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="form-group content-descripcion-left-input">
                            <label class="label-left" style="width:220px;">Contraseña de clave privada</label>
                            <input style="padding-left: 230px;" type="password" placeholder="Ingrese al menos 6 caracteres..." name="key_pwd" maxlength="12" required value="{{ old('key_pwd') }}">
                        </div>
                    </div>
                </div>

                <label class="label-left">Servicios contratados</label>
                <div style="border:1px red solid;margin-bottom: 10px;">
                    <div class="row" style="margin-bottom: 2px;">
                        <div class="col-sm-2 text-center">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="Fiscal">
                                    Fiscal
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-5">                    
                            <div class="form-group label-floating">
                                <label class="etiqueta">Prestadora de servicios</label>
                                <select class="form-control" name="Fiscal_Company_id" id="selFiscal">
                                    <OPTION value="0">No asignado</OPTION>
                                    @foreach ($empresas as $cia)
                                        <option value="{{ $cia->id }}">{{ $cia->Nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                    
                        <div class="col-sm-5">
                            <div class="form-group label-floating">
                                <label class="etiqueta">BD Asociada</label>
                                <select class="form-control" name="Fiscal_BDA">
                                    <OPTION value="0">No asignado</OPTION>
                                    @foreach ($tisanom_cias as $cia)
                                        <option value="{{ $cia->CIA }}">{{ $cia->NOMCIA . ' - ' . $cia->DBNAME }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 2px;">
                        <div class="col-sm-2 text-center">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="Asimilado">
                                    Asimilado
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-5">                    
                            <div class="form-group label-floating">
                                <select class="form-control" name="Asimilado_Company_id" id="selAsimilados">
                                    <OPTION value="0">No asignado</OPTION>
                                    @foreach ($empresas as $cia)
                                        <option value="{{ $cia->id }}">{{ $cia->Nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                    
                        <div class="col-sm-5">
                            <div class="form-group label-floating">
                                <select class="form-control" name="Asimilado_BDA">
                                    <OPTION value="0">No asignado</OPTION>
                                    @foreach ($tisanom_cias as $cia)
                                        <option value="{{ $cia->CIA }}">{{ $cia->NOMCIA . ' - ' . $cia->DBNAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>                
                </div>

                <div style="margin-bottom: 2px;">
                    <label class="label-left">Usuarios y perfiles</label>
                    <div class="row" style="margin-bottom: 0px;">
                        <div class="col-sm-4" style="">
                            <div class="form-group content-descripcion-left-input">
                                <label class="label-left">Nominista</label>
                                <input type="text" name="Nominista" id="CORREO" placeholder="@ejemplo.com" readonly="readonly" class="bloqueado">
                            </div>
                        </div>
                        <div class="col-sm-4" style="">
                            <div class="form-group content-descripcion-left-input">
                                <label class="label-left">Fiscalista</label>
                                <input type="text" name="Fiscalista" id="CORREO1" placeholder="@ejemplo.com" readonly="readonly" class="bloqueado">
                            </div>
                        </div>
                        <div class="col-sm-4" style="">
                            <div class="form-group content-descripcion-left-input">
                                <label class="label-left">Administrador</label>
                                <input type="text" name="Administrador" id="CORREO2" placeholder="@ejemplo.com" readonly="readonly" class="bloqueado">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <button class="btn primario separation">Guardar</button>
                    <a href="{{ url('/admin/clientes') }}" class="btn primario1">Cancelar</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@section('jscript')
<script type="text/javascript">
$(document).ready(function() {
    var selFiscal = document.getElementById("selFiscal");
    var selAsimilados = document.getElementById("selAsimilados");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
    }); 

    var token = $('input[name=_token]').val();      
    //console.log('here we are. The token is: ' + token);

    $('.giros_list').change(function() {
        var giro  =  $('.giros_list').val();
        $.post("get-empresas-by-giro", { giro: giro, _token: token }, function( data ) {
            var empresas = Object.values(data);
            //alert(empresas[0].Nombre);
            while (selFiscal.options.length) {
                selFiscal.remove(0);
            }
            while (selAsimilados.options.length) {
                selAsimilados.remove(0);
            }
            for (var i = 0; i < empresas.length; i++) {
                var opt = new Option(empresas[i]["Nombre"], empresas[i]["id"]);
                selFiscal.options.add(opt);
            }
            for (var i = 0; i < empresas.length; i++) {
                var opt = new Option(empresas[i]["Nombre"], empresas[i]["id"]);
                selAsimilados.options.add(opt);
            }               
        });     
    });
});

function fAgrega1() {
    document.getElementById("CORREO").value = document.getElementById("DOMINIO").value;
    document.getElementById("CORREO1").value = document.getElementById("DOMINIO").value;
    document.getElementById("CORREO2").value = document.getElementById("DOMINIO").value;
}
</script>           
@endsection