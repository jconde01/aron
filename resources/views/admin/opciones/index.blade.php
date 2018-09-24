@extends('layouts.app')

@section('title','Listado de Opciones de Menú')
@section('body-class','')

@section('content')
<div class="header header-filter" style="background-image: url('{{ asset('img/Listados.jpg') }}');">
</div>

<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <h2 class="titulo">Listado de Opciones de Menú</h2>
            <div class="row">
                <a href="{{ url('/admin/opciones/create/0')}}" class="primario1" role="button">Nueva Opción Principal</a>
                <br>
                <br>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <?php echo $opcionesHTML ?>                    
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection
