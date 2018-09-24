@extends('layouts.app')

@section('title','Listado de empresas prestadoras de servicios')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <h2 class="titulo">Empresas prestadoras de servicios</h2>
            <div class="row">
                <a href="{{ url('/admin/empresas/create')}}" class="btn btn-primary btn-round" role="button">Nueva Empresa</a>
                <br>
                <br>
                <table class="table">
                    <thead>
                        <tr>
<!--                        <th class="text-center">#</th> -->
                            <th style="width: 450px;">Nombre</th>
                            <th>Representante</th>
                            <th>Email</th>
                            <th class="text-center" style="width: 20px;">Activo</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empresas as $empresa)
                        <tr>
<!--                        <td class="text-center">{{ $empresa->id }}</td> -->
                            <td class="text-left" style="width: 450px;">{{ $empresa->Nombre }}</td>
                            <td class="text-left">{{ ($empresa->Representante)? $empresa->Representante:'No definido' }}</td>
                            <td class="text-left">{{ ($empresa->Email)? $empresa->Email:'No definido' }}</td>
                            <td class="text-center" style="width: 20px;">
                                    <span>
                                        <input type="checkbox" aria-label="..." {{ $empresa->Activo? 'checked':'' }} >
                                    </span>
                            </td>
                            <td class="td-actions text-center">
<!--                                     <form method="post" action=" {{ url('/admin/empresas/'.$empresa->id) }} ">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }} -->
<!--                                         <a href="#" rel="tooltip" title="Ver" class="btn btn-info btn-simple btn-xs">
                                        <i class="fa fa-info"></i>
                                    </a> -->
                                    <a href="{{ url('/admin/empresas/'.$empresa->id.'/edit')}} " rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ url('/admin/empresas/'.$empresa->id.'/files')}} " rel="tooltip" title="Archivos" class="btn btn-warning btn-simple btn-xs">
                                        <i class="fa fa-file"></i>
                                    </a>                                    
<!--                                         <button type="submit" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </form> -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $empresas->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
