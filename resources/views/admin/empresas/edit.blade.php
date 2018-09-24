@extends('layouts.app')
@section('title','Editar empresa seleccionada')
@section('body-class','')
@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section">
            <h2 class="titulo text-center">Editar empresa seleccionada</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>                    
                </div>
            @endif            
            <form method="post" action="{{ url('/admin/empresas/'.$empresa->id.'/edit') }}">
                {{ csrf_field() }}

                <div class="row" style="margin-bottom: 0px;">
                    <!-- div class="col-sm-6"> -->
                        <div class="form-group label-floating">
                            <label class="etiqueta">Nombre de la empresa</label>
                            <input type="text" class="form-control" name="Nombre" value="{{ old('Nombre', $empresa->Nombre) }}">
                        </div>
                    <!-- /div> -->
                </div>
                <div class="row" style="margin-bottom: 0px;">
                    <div class="col-sm-6">
                        <div class="form-group label-floating">
                            <label class="etiqueta">Representante</label>
                            <input type="text" class="form-control" name="Representante" value="{{ old('Representante', $empresa->Representante) }}">
                        </div>
                    </div>
                    <div class="col-sm-6">                
                        <div class="form-group label-floating">
                            <label class="etiqueta">correo electrónico</label>
                            <input type="email" class="form-control" name="Email" value="{{ old('Email', $empresa->Email) }}">
                        </div>
                    </div>
                </div>
                <label class="etiqueta">Giros disponibles</label>                
                <div class="form-group" style="border:1px red solid;">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dynamic_field">
                            @foreach ($companyGiros as $key => $cg)
                            @if ($key == 0)
                                <tr>
                            @else
                                <tr id="row{{ ++$key }}">
                            @endif
                                <!-- <td><input type="text" name="giro[]" placeholder="Enter your Name" class="form-control name_list" /></td> -->
                                <td><select class="form-control giros_list" name="giro[]">
                                    @foreach ($giros as $giro)
                                        <option value="{{ $giro->id }}" {{ $giro->id == $cg->giro_id? 'selected':'' }} >{{ $giro->nombre }}</option>
                                    @endforeach
                                </select></td>
                                @if ($key == 0) 
                                    <td style="text-align: left;"><button type="button" name="add" id="add" class="btn btn-success"><i class="fas fas fa-plus-square icon-left"></i> &nbsp;Agregar giro</button></td>
                                @else
                                    <td style="text-align: left;">
                                        <button type="button" name="remove" id="{{ $key }}" class="btn btn-danger btn_remove">X</button>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="checkbox text-center">
                        <label>
                            <input type="checkbox" name="Activo" <?php if ($empresa->Activo == 1 ) echo 'checked'; ?>>
                            Activo
                        </label>
                    </div>
                </div>
                <div class="row text-center">
                    <button class="primario">Guardar</button>
                    <a href="{{ url('/admin/empresas') }}" class="primario1">Cancelar</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@section('jscript')
<script type="text/javascript">
$(document).ready(function(){
    var i = document.getElementById("dynamic_field").rows.length;
    $('#add').click(function(){
        i++;
        $('#dynamic_field').append('<tr id="row'+i+'"><td><select class="form-control giros_list" name="giro[]">                                    @foreach ($giros as $giro)<option value="{{ $giro->id }}">{{ $giro->nombre }}</option>@endforeach                                </select></td><td style="text-align: left;"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
    });
    
    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id"); 
        $('#row'+button_id+'').remove();
    });
});
</script> 
@endsection