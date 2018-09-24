@extends('layouts.app')
@section('title','Registrar nueva empresa')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section">
            <h2 class="title text-center">Registrar nueva empresa</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>                    
                </div>
            @endif
            <form method="post" action="{{ url('/admin/empresas') }}">
                {{ csrf_field() }}

                <div class="row" style="margin-bottom: 0px;">
                    <!-- div class="col-sm-6"> -->
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left" style="font-size: 14px;">Nombre de la empresa</label>
                            <input type="text" name="Nombre" value="{{ old('Nombre') }}">
                        </div>
                    <!-- /div> -->
                </div>
                <div class="row" style="margin-bottom: 0px;">
                    <div class="col-sm-6">
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left">Representante</label>
                            <input type="text" name="Representante" value="{{ old('Representante') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">                
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left">Correo electrónico</label>
                            <input type="email" name="Email" value="{{ old('Email') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dynamic_field">
                            <tr>
                                <!-- <td><input type="text" name="giro[]" placeholder="Enter your Name" class="form-control name_list" /></td> -->
                                <td><select class="form-control giros_list" name="giro[]">
                                    @foreach ($giros as $giro)
                                        <option value="{{ $giro->id }}">{{ $giro->nombre }}</option>
                                    @endforeach
                                </select></td>                                
                                <td style="text-align: left;"><button type="button" name="add" id="add" class="btn btn-success"><i class="fas fas fa-plus-square icon-left"></i> &nbsp;Agregar giro</button></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="checkbox text-center">
                        <label>
                            <input type="checkbox" name="Activo" checked>
                            Activo
                        </label>
                    </div>
                </div>
                <div class="row text-center">
                    <button class="primario separation">Guardar</button>
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
    var i=1;
    $('#add').click(function(){
        i++;
        //$('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        $('#dynamic_field').append('<tr id="row'+i+'"><td><select class="form-control giros_list" name="giro[]">                                    @foreach ($giros as $giro)<option value="{{ $giro->id }}">{{ $giro->nombre }}</option>@endforeach                                </select></td><td style="text-align: left;"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
    });
    
    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id"); 
        $('#row'+button_id+'').remove();
    });
    
    // $('#submit').click(function(){      
    //     $.ajax({
    //         url:"name.php",
    //         method:"POST",
    //         data:$('#add_name').serialize(),
    //         success:function(data)
    //         {
    //             alert(data);
    //             $('#add_name')[0].reset();
    //         }
    //     });
    // });
    
});
</script> 
@endsection