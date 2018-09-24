@extends('layouts.app')

@section('title','Listado de Giros')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <h2 class="titulo">Listado de giros</h2>
            <div class="row">
                <!-- <a href=" {{ url('/admin/empresas/create')}} "class="btn btn-primary btn-round">Nueva Empresa</a> -->
                <a href="{{ url('/admin/giros/create')}}" class="primario1 separation" style="width: 160px;"><i class="fas fas fa-plus-square icon-left"></i> &nbsp;Agregar giro</a>
                <br>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nombre</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($giros as $giro)
                        <tr>
                            <td class="text-center">{{ $giro->id }}</td>
                            <td class="text-left">{{ $giro->nombre }}</td>
                            <td class="td-actions text-center">
                                <a href="{{ url('/admin/giros/'.$giro->id.'/edit')}} " rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $giros->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
