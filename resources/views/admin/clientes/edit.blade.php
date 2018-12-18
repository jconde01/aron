@extends('layouts.app')

@section('title','Editar cliente seleccionado')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section">
            <h2 class="title text-center">Editar cliente seleccionado</h2>
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
                    <div class="col-sm-10">
                        <div class="form-group content-descripcion-left-input">
                            <label class="label-left" style="font-size: 14px;">Nombre del cliente</label>
                            <input type="text" class="form-control" name="Nombre" value="{{ old('Nombre', $cliente->Nombre) }}">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="Activo" {{ ($cliente->Activo == 1 )? 'checked':'' }}>
                                Activo
                            </label>
                        </div>
                    </div>                    
                </div>

                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-sm-6">
                        <div class="form-group content-descripcion-left-input">
                            <label class="label-left">Representante</label>
                            <input type="text" class="form-control" name="Representante" value="{{ old('Representante', $cliente->Representante) }}">
                        </div>
                    </div>
                    <div class="col-sm-6">                
                        <div class="form-group content-descripcion-left-input">
                            <label class="label-left">Correo electrónico</label>
                            <input type="email" class="form-control" name="Email" value="{{ old('Email', $cliente->Email) }}">
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 0px;">
                    <div class="col-md-4 col-md-offset-1">
                        <div class="form-group">
                            <label class="control-label" style="float: left; padding-top: 5px;">Giro</label>                        
                            <select class="form-control giros_list" name="Giro" readonly style="float: right; width: 300px;">
                                @foreach ($giros as $giro)
                                    <option value="{{ $giro->id }}" {{ ($cliente->giro_id == $giro->id)? 'selected':'' }}>{{ $giro->nombre }}</option>
                                @endforeach
                            </select>
                        </div>                        
                    </div>

                    <div class="col-md-4 col-md-offset-1">
                        <div class="form-group">
                            <label class="control-label" style="float: left; padding-top: 5px;">Celula</label>                        
                            <select class="form-control giros_list" name="celula" readonly style="float: right; width: 300px;">
                                @foreach ($celulas as $celula)
                                    <option value="{{ $celula->id }}" {{ ($cliente->cell_id == $celula->id)? 'selected':'' }}>{{ $celula->nombre }}</option>
                                @endforeach
                            </select>
                        </div>                        
                    </div>
                </div>


                <label class="label-left">Servicios contratados</label>
                <div style="border:1px red solid;margin-bottom: 10px;">
                    <div class="row" style="margin-bottom: 2px;">
                        <div class="col-sm-2 text-center">
                            <div class="checkbox" style="padding-top: 15px;">
                                <label  style="padding-top: 15px;">
                                    <input type="checkbox" name="Fiscal" {{ ($cliente->fiscal == 1)? 'checked':'' }}>
                                    Fiscal
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-5 label-floating">
                            <label class="etiqueta">Prestadora de servicios</label>
                            <select class="form-control" name="Fiscal_Company_id" id="selFiscal">
                                <OPTION value="0">No asignado</OPTION>
                                @foreach ($empresas as $cia)
                                    <option value="{{ $cia->id }}" {{ ($cliente->fiscal_company_id == $cia->id)? 'selected':'' }}>{{ $cia->Nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-5">
                            <label class="etiqueta">BD Asociada</label>
                            <select class="form-control" readonly name="Fiscal_BDA">
                                <OPTION value="0">No asignado</OPTION>
                                @foreach ($tisanom_cias as $cia)
                                    <option value="{{ $cia->CIA }}" {{ ($cliente->fiscal_bda == $cia->CIA)? 'selected':'' }}>{{ $cia->NOMCIA }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 2px;">
                        <div class="col-sm-2 text-center">
                            <div class="checkbox">
                                <label>
                                    <input style="margin-top: 0px;" type="checkbox" name="Asimilado" {{ ($cliente->asimilado == 1)? 'checked':'' }}>
                                    Asimilado
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-5">                    
                            <div class="form-group label-floating">
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
                                <select class="form-control" readonly name="Asimilado_BDA">
                                    <OPTION value="0">No asignado</OPTION>
                                    @foreach ($tisanom_cias as $cia)
                                        <option value="{{ $cia->CIA }}" {{ ($cliente->asimilado_bda == $cia->CIA)? 'selected':'' }}>{{ $cia->NOMCIA }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>                
                </div>

                <label class="label-left">Usuarios y perfiles</label>
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-sm-4" style="">
                        <div class="form-group content-descripcion-left-input">
                            <label class="label-left">Nominista</label>
                            <input type="text" name="Nominista" readonly class="bloqueado" value="{{ $usuarios->where('profile_id',3)->first()->email }}">
                        </div>
                    </div>
                    <div class="col-sm-4" style="">
                        <div class="form-group content-descripcion-left-input">
                            <label class="label-left">Fiscalista</label>
                            <input type="text" name="Fiscalista" readonly class="bloqueado" value="{{ $usuarios->where('profile_id',2)->first()->email }}">
                        </div>
                    </div>
                    <div class="col-sm-4" style="">
                        <div class="form-group content-descripcion-left-input">
                            <label class="label-left">Administrador</label>
                            <input type="text" name="Administrador" readonly class="bloqueado" value="{{ $usuarios->where('profile_id',1)->first()->email }}">
                        </div>
                    </div>
                </div>

                <div class="row text-center">
                    <button class="btn primario1 separation">Guardar cambios</button>
                    <a href="{{ url('/admin/clientes') }}" class="btn primario1">Cancelar cambios</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection