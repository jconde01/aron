@extends('layouts.app')

@section('title','Listado de Usuarios')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <h2 class="titulo">Listado de usuarios</h2>
            <div class="team">
                <div class="row">
                    <a href="{{ url('/admin/usuarios/create')}}" class="btn btn-primary btn-round">Nuevo usuario</a>
                    <br>
                    <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Perfil</th>
                                <th>Cliente</th>
                                <th class="text-center">Activo</th>
                                <th class="text-center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                            <tr>
                                <td class="text-center">{{ $usuario->id }}</td>
                                <td class="text-left">{{ $usuario->name }}</td>
                                <td class="text-left">{{ $usuario->email }}</td>
                                <td class="text-left">{{ ($usuario->profile == NULL)? 'Web Master': $usuario->profile->nombre }}</td>
                                @if ($usuario->client_id == 0)
                                    <td class="text-left">No Asignado</td>
                                @else
                                    <td class="text-left">{{ $usuario->client->Nombre }}</td>
                                @endif                                
                                <td class="text-center">
                                        <span>
                                            <input type="checkbox" aria-label="..." {{ $usuario->Activo? 'checked':'' }} >
                                        </span>
                                </td>
                                <td class="td-actions text-center">
<!--                                     <form method="post" action=" {{ url('/admin/usuarios/'.$usuario->id) }} ">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }} -->
<!--                                         <a href="#" rel="tooltip" title="Ver" class="btn btn-info btn-simple btn-xs">
                                            <i class="fa fa-info"></i>
                                        </a> -->
                                        <a href="{{ url('/admin/usuarios/'.$usuario->id.'/edit')}} " rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs">
                                            <i class="fa fa-edit"></i>
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
                    {{ $usuarios->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
