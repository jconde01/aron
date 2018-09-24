@extends('layouts.app')

@section('title','Listado de Clientes')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <h2 class="titulo">Listado de Clientes</h2>
            <div class="row">
                <a href="{{ url('/admin/clientes/create')}}" class="btn btn-primary btn-round" role="button">Nuevo Cliente</a>
                <br>
                <br>
                <table class="table">
                    <thead>
                        <tr>
<!--                        <th class="text-center">#</th> -->
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
<!--                        <td class="text-center">{{ $cliente->id }}</td> -->
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
<!--                                     <form method="post" action=" {{ url('/admin/empresas/'.$cliente->id) }} ">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }} -->
<!--                                         <a href="#" rel="tooltip" title="Ver" class="btn btn-info btn-simple btn-xs">
                                        <i class="fa fa-info"></i>
                                    </a> -->
                                    <a href="{{ url('/admin/clientes/'.$cliente->id.'/edit')}} " rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ url('/admin/clientes/'.$cliente->id.'/files')}} " rel="tooltip" title="Archivos" class="btn btn-warning btn-simple btn-xs">
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
                {{ $clientes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
