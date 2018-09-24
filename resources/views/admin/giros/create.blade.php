@extends('layouts.app')

@section('title','Registrar nuevo giro')
@section('body-class','')

@section('content')
<div class="main main-raised" style="margin: -60px 200px 0px;">
    <div class="container">
        <div class="section">
            <h2 class="title text-center">Registrar nuevo giro</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>                    
                </div>
            @endif
            <form method="post" action="{{ url('/admin/giros') }}">
                {{ csrf_field() }}

                <div class="row" style="margin-bottom: 2px;">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left" style="font-size: 14px;">Nombre</label>
                            <input type="text" name="Nombre" value="{{ old('Nombre') }}">
                        </div>
                    </div>
                </div>                    
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <label for="Descripcion" class="label-left" style="font-size: 14px;">Descripción</label>
                        <textarea class="campo-texto-etiqueta" placeholder="" name="Descripcion" cols="30" rows="5" style="border-color:#F000F0">{{ old('Descripcion') }}</textarea>
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
@endsection