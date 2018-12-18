@extends('layouts.app')

@section('title','Listado de Clientes')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <h2 class="titulo">Lista de Clientes</h2>
            <div class="row">
                <a href="{{ url('/admin/clientes/create')}}" class="btn btn-primary btn-round" role="button"><i class="fa fa-plus"></i> Agregar cliente</a>
                <br>
                <br>
                <table class="table" id="lista">
                    <thead>
                        <tr>
                            <th style="display:none;">#</th>
                            <th style="width: 450px;">Nombre</th>
                            <th>Esquema</th>
                            <th class="text-center">Fiscal</th>
                            <th class="text-center">Asimilados</th>                            
                            <th>Representante</th>
                            <th>Email</th>
                            <th class="text-center">Activo</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                        <tr>
                            <td class="cte" style="display:none;">{{ $cliente->id }}</td>
                            <td class="text-left" style="width: 450px;">{{ $cliente->Nombre }}</td>
                            <td class="text-left">{{ ($cliente->Esquema == 1)? 'Maquila Vally':'Maquila Empresa' }}</td>
                            <td class="text text-center">
                                <span>
                                    <input type="checkbox" aria-label="..." {{ $cliente->fiscal? 'checked':'' }} >
                                </span>
                            </td>
                            <td class="text text-center">
                                <span>
                                    <input type="checkbox" aria-label="..." {{ $cliente->asimilado? 'checked':'' }} >
                                </span>
                            </td>                            
                            <td class="text-left">{{ ($cliente->Representante)? $cliente->Representante:'No definido' }}</td>
                            <td class="text-left">{{ ($cliente->Email)? $cliente->Email:'No definido' }}</td>
                            <td class="text-center">
                                    <span>
                                        <input type="checkbox" aria-label="..." {{ $cliente->Activo? 'checked':'' }} >
                                    </span>
                            </td>
                            <td class="td-actions text-center">
                                <a href="{{ url('/admin/clientes/'.$cliente->id.'/edit')}} " rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a>
                                <a href="{{ url('/admin/clientes/'.$cliente->id.'/files')}} " rel="tooltip" title="Archivos" class="btn btn-warning btn-simple btn-xs"><i class="fa fa-file"></i></a>
                                <a href="#" rel="tooltip" title="Generar certificado" class="btn btn-default btn-simple btn-xs"><i class="fa fa-sign"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $clientes->links() }}
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="genera" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">

        <!-- url('/consultas/timbrado/firmar/') -->
        <form method="POST" action="{{ url('/admin/clientes/genera-firma') }}" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">';
            <input type="hidden" name="Id" id="Cte">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ingrese contraseña de clave privada</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                        <label class="label-left" style="font-size: 14px;">Cliente</label>
                        <input type="text" id="Nombre" name="Nombre" readonly value="">
                    </div>
                    <span> 
                        Los certificados emitidos por Aron tienen una vigencia de 3 años. Utilice esta opción para generar un nuevo certificado para firmar o autorizar.  
                    </span>
                    <div class="input-data">
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left" style="font-size: 14px;">Contraseña anterior:</label>
                            <input type="password" id="pkey_pwd" name="pkey_pwd" value="">
                        </div>
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left" style="font-size: 14px;">Contraseña nueva:</label>
                            <input type="password" id="new_pwd" name="new_pwd" value="">
                        </div>
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left" style="font-size: 14px;">Confirmar nueva:</label>
                            <input type="password" id="conf_pwd" name="conf_pwd" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">Generar nuevo certificado</button>
                </div>
            </div>
        </form>            
    </div>
</div>
@endsection
@section('jscript')
<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        token = $('input[name=_token]').val();
    });


    // EDITA el renglón
    $('#lista').on('click', '.btn-default', function () {
        rowElem = $(this).closest("tr");

        // asigna valores a los campos del modal de edicion
        document.getElementById("Cte").value = rowElem.find('td:eq(0)').text();
        document.getElementById("Nombre").value = rowElem.find('td:eq(1)').text();
        $("#genera").modal();
    });

</script>
@endsection
