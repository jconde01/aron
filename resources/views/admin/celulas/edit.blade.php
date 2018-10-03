@extends('layouts.app')

@section('title','Editar cliente seleccionado')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section">
            <h2 class="titulo text-center">Editar cliente seleccionado</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>                    
                </div>
            @endif            
            <form method="post" action="{{ url('/admin/clientes/'.$cliente->id.'/edit') }}">
                {{ csrf_field() }}

                <div class="row" style="margin-bottom: 5px;">
                    <div class="form-group content-descripcion-left-input">
                        <label class="label-left" style="font-size: 14px;">Nombre del cliente</label>
                        <input type="text" class="form-control" name="Nombre" value="{{ old('Nombre', $cliente->Nombre) }}">
                    </div>
                </div>

                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-sm-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Representante</label>
                            <input type="text" class="form-control" name="Representante" value="{{ old('Representante', $cliente->Representante) }}">
                        </div>
                    </div>
                    <div class="col-sm-6">                
                        <div class="form-group label-floating">
                            <label class="control-label">Correo electrónico</label>
                            <input type="email" class="form-control" name="Email" value="{{ old('Email', $cliente->Email) }}">
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-4 col-md-offset-4">
<!--                         <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                            <div class="label-left"><p>Giro</p></div>                        
                            <select class="giros_list" style="width: 440px; height: 40px; border-radius: 10px; text-align-last: right; padding-right: 10px;" name="Giro" disabled>
                                @foreach ($giros as $giro)
                                    <option value="{{ $giro->id }}" {{ ($cliente->giro_id == $giro->id)? 'selected':'' }}>{{ $giro->nombre }}</option>
                                @endforeach
                            </select>
                        </div> -->
                        <div class="form-group"  style=" width: 350px;">
                            <label class="control-label" style="float: left; padding-top: 5px;">Giro</label>                        
                            <select class="form-control giros_list" name="Giro" style="float: right; width: 300px;">
                                @foreach ($giros as $giro)
                                    <option value="{{ $giro->id }}" {{ ($cliente->giro_id == $giro->id)? 'selected':'' }}>{{ $giro->nombre }}</option>
                                @endforeach
                            </select>
                        </div>                        
                    </div>
                </div>
    
                <label class="etiqueta">Servicios contratados</label>
                <div style="border:1px red solid;">
                    <div class="row" style="margin-bottom: 2px;">
                        <div class="col-sm-2 text-center">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="Fiscal" {{ ($cliente->fiscal == 1)? 'checked':'' }}>
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
                                        <option value="{{ $cia->id }}" {{ ($cliente->fiscal_company_id == $cia->id)? 'selected':'' }}>{{ $cia->Nombre }}</option>
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
                                        <option value="{{ $cia->CIA }}" {{ ($cliente->fiscal_bda == $cia->CIA)? 'selected':'' }}>{{ $cia->NOMCIA }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 2px;">
                        <div class="col-sm-2 text-center">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="Asimilado" {{ ($cliente->asimilado == 1)? 'checked':'' }}>
                                    Asimilado
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-5">                    
                            <div class="form-group label-floating">
                                <!-- <label class="etiqueta">Prestadora de servicios</label> -->
                                <select class="form-control" name="Asimilado_Company_id" id="selAsimilados">
                                    <OPTION value="0">No asignado</OPTION>
                                    @foreach ($empresas as $cia)
                                        <option value="{{ $cia->id }}" {{ ($cliente->asimilado_company_id == $cia->id)? 'selected':'' }}>{{ $cia->Nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                    
                        <div class="col-sm-5">
                            <div class="form-group label-floating">
                                <!-- <label class="etiqueta">BD Asociada</label> -->
                                <select class="form-control" name="Asimilado_BDA">
                                    <OPTION value="0">No asignado</OPTION>
                                    @foreach ($tisanom_cias as $cia)
                                        <option value="{{ $cia->CIA }}" {{ ($cliente->asimilado_bda == $cia->CIA)? 'selected':'' }}>{{ $cia->NOMCIA }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>                
                </div>

                <div class="row text-center">
                    <div class="col-sm-4 col-sm-offset-4">
                        <div class="checkbox text-center">
                            <label>
                                <input type="checkbox" name="Activo" {{ ($cliente->Activo == 1 )? 'checked':'' }}>
                                Activo
                            </label>
                        </div>
                    </div>                    
                </div>

                <div class="row text-center">
                    <button class="primario1 separation">Guardar cambios</button>
                    <a href="{{ url('/admin/clientes') }}" class="primario1">Cancelar cambios</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection