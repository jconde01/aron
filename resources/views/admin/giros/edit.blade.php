@extends('layouts.app')

@section('title','Editando giro')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section">
            <h2 class="titulo text-center">Editando giro seleccionado</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>                    
                </div>
            @endif            
            <form method="post" action="{{ url('/admin/giros/'.$giro->id.'/edit') }}">
                {{ csrf_field() }}

                <div class="row" style="margin-bottom: 2px;">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left" style="font-size: 14px;">Nombre</label>
                            <input type="text" class="form-control" name="Nombre" value="{{ old('Nombre', $giro->nombre) }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <label for="Descripcion" class="label-left" style="font-size: 14px;">Descripción</label>
                        <textarea class="campo-texto-etiqueta" placeholder="" name="Descripcion" cols="30" rows="5" style="border-color:#F000F0">{{ old('Descripcion', $giro->descripcion) }}</textarea>
                    </div>
                </div>
                <div class="row text-center">
                    <button class="primario">Guardar</button>
                    <a href="{{ url('/admin/giros') }}" class="primario1">Cancelar</a>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- @include('includes.footer') -->
@endsection