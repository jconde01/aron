@extends('layouts.app')

@section('title','Registrar nueva opcion')
@section('body-class','')

@section('content')
<div class="header header-filter" style="background-image: url('{{ asset('img/cdmx.jpg') }}');">
</div>

<div class="main main-raised" style="margin: -60px 200px 0px;">
    <div class="container">
        <div class="section">
            @if ($option)
                <h2 class="title text-center">Nueva subopción [{{ $option->nombre }}]</h2>
            @else
                <h2 class="title text-center">Registrar nueva opción></h2>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>                    
                </div>
            @endif
            <form method="post" action="{{ url('/admin/opciones/'. $parent) }}">
                {{ csrf_field() }}

                <div class="row text-center">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="checkbox text-center">
                            <label>
                                <input type="checkbox" name="Padre">
                                <!-- {{ $option->padre ? 'checked':'' }} -->
                                Opción Padre
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left" style="font-size: 14px;">Nombre de opción</label>
                            <input type="text" name="Nombre" value="{{ old('Nombre') }}">
                        </div>
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="checkbox text-center">
                            <label>
                                <input type="checkbox" name="Activo" checked>
                                Activo
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row text-center">
                    <button class="primario">Guardar</button>
                    <a href="{{ url('/admin/opciones/'.$parent) }}" class="primario1">Cancelar</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection