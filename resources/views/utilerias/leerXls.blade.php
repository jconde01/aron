@extends('layouts.app')

@section('title','Leer archivo de excel')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <h2 class="title">Leer archivo de excel</h2>
            <form method="post" action="{{ url('/utilerias/leerxls') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-2 col-sm-offset-5 text-center">
                        <input type="file" name="archivo" required>
                    </div>                    
                </div>
                <button type="submit" class="btn btn-primary btn-round">Leer archivo seleccionado</button>
                <a href=" {{ url('/home') }}" class="btn btn-default btn-round">Cancelar</a>
            </form>
            <hr>            
        </div>
    </div>
</div>
@include('includes.footer')
@endsection
