@extends('layouts.app')

@section('title','Registrar nuevo usuario')
@section('body-class','')

@section('content')
<!-- <div class="header header-filter" style="background-image: url('{{ asset('img/cdmx.jpg') }}');">
</div> -->

<div class="main main-raised">
    <div class="container">
        <div class="section">
            <h2 class="titulo text-center">Registrar nuevo usuario</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>                    
                </div>
            @endif
            <form method="post" action="{{ url('/admin/usuarios') }}">
                {{ csrf_field() }}

                <div class="row">
                    <!-- div class="col-sm-6"> -->
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left" style="font-size: 14px;">Nombre</label>
                            <input type="text" name="name" value="{{ old('name') }}">
                        </div>
                    <!-- /div> -->
                </div>
                <div class="row">
                    <div class="col-sm-6">                        
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left" style="font-size: 14px;">Contraseña</label>
                            <input type="password" name="password" value="{{ old('password') }}">
                        </div>                     
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left" style="font-size: 14px;">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">                    
                        <div class="form-group label-floating">
                            <label class="etiqueta">Perfil</label>
                            <select class="form-control" name="profile_id">
                                <option value="0">No asignado</option> 
                                @foreach ($perfiles as $perfil)
                                    <option value="{{ $perfil->id }}">{{ $perfil->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">                    
                        <div class="form-group label-floating">
                            <label class="etiqueta">Cliente</label>
                            <select class="form-control" name="client_id">
                                <OPTION value="0">No asignado</OPTION>
                                @foreach ($clientes as $cli)
                                    <option value="{{ $cli->id }}">{{ $cli->Nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-sm-4 col-sm-offset-4">
                        <div class="checkbox text-center">
                            <label>
                                <input type="checkbox" name="Activo" checked disabled>
                                Activo
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <button class="primario separation">Guardar</button>
                    <a href="{{ url('/admin/usuarios') }}" class="primario1">Cancelar</a>
                </div>
            </form>

        </div>
    </div>
</div>

@include('includes.footer')
@endsection