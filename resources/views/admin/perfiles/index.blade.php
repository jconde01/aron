@extends('layouts.app')

@section('title','Listado de Perfiles')
@section('body-class','')

@section('content')
<div class="header header-filter" style="background-image: url('{{ asset('img/Listados.jpg') }}');">
</div>

<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <h2 class="titulo">Listado de perfiles de usuario</h2>
            <div class="row">
                <a href="{{ url('/admin/perfiles/create')}}" class="btn btn-primary btn-round">
                    <i class="fas fas fa-plus-square icon-left"></i>
                    &nbsp;Nuevo Perfil
                </a>
                <br>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nombre</th>
                            <th class="text-center">Activo</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perfiles as $perfil)
                        <tr>
                            <td class="text-center">{{ $perfil->id }}</td>
                            <td class="text-left">{{ $perfil->nombre }}</td>
                            <td class="text-center">
                                    <span>
                                        <input type="checkbox" aria-label="..." {{ $perfil->activo? 'checked':'' }} >
                                    </span>
                            </td>                            
                            <td class="td-actions text-center">
<!--                                     <form method="post" action=" {{ url('/admin/perfiles/'.$perfil->id) }} ">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }} -->

                                    <a href="{{ url('/admin/perfiles/'.$perfil->id.'/edit')}} " rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs">
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
                {{ $perfiles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
