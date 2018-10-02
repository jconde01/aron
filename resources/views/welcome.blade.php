@extends('layouts.app')

@section('title','Bienvenido a Aron')
@section('body-class','')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="jumbotron" id="jumbotron2">
            <h1 class="titulo">Bienvenido a Aron.</h1>
            <p style="color:white;" id="hola">Una herramienta efectiva para el control de las nóminas de tu empresa.</p>
            <br />
            <a class="primario1 oculto" href="#" role="button"><i class="fas fa-bolt icon-left"></i>¿Como funciona?</a>
        </div>
    </div>
    @include('includes.footer');
</div>
@endsection

