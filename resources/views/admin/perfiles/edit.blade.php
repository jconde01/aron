@extends('layouts.app')

@section('title','Editando perfil')
@section('body-class','')

@section('content')
<div class="header header-filter" style="background-image: url('{{ asset('img/Listados.jpg') }}');">
</div>

<div class="main main-raised">
    <div class="container">
        <div class="section">
            <h2 class="titulo text-center">Editar Perfil seleccionado</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>                    
                </div>
            @endif            
            <form method="post" action="{{ url('/admin/perfiles/'.$perfil->id.'/edit') }}">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-sm-6 col-sm-offset-2">
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left" style="font-size: 14px;">Nombre</label>
                            <input type="text" class="form-control" name="Nombre" value="{{ old('Nombre', $perfil->nombre) }}">
                        </div>
                    </div>                        
                    <div class="col-sm-2">
                        <div class="checkbox text-center">
                            <label>
                                <input type="checkbox" name="Activo" aria-label="..." {{ ($perfil->activo == 1 )? 'checked':'' }}>
                                &nbspActivo
                            </label>
                        </div>
                    </div>                        
                </div>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <?php echo $opcionesHTML ?>                    
                    </div>
                </div>
                <div class="row text-center">
                    <button class="btn btn-primary">Guardar cambios</button>
                    <a href="{{ url('/admin/perfiles') }}" class="btn btn-default">Cancelar cambios</a>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- @include('includes.footer') -->
@endsection