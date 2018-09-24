@extends('layouts.app')

@section('title','Archivos de la Empresa')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <h2 class="title">Archivos de: {{ $empresa->Nombre }}</h2>
            <form method="post" action="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-2 col-sm-offset-5 text-center">
                        <input type="file" name="archivo" required>
                    </div>                    
                </div>
                <button type="submit" class="btn btn-primary btn-round">Subir nuevo archivo</button>
                <a href=" {{ url('/admin/empresas') }}" class="btn btn-default btn-round">Volver a listado de empresas</a>
            </form>
            <hr>
            <div class="row">
                @foreach($files as $file)
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <a href="{{ $file->url }}">{{ $file->file }}</a>
                            <form method="post" action="">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <input type="hidden" name="file_id" value="{{ $file->id }}">
                                <button type="submit" class="btn btn-danger btn-round">Eliminar</button>
                                <!-- Mail::to('jconde1@hotmail.com')->send(new HelloFromHere());   -->
                            </form>
                            
                        </div>
                    </div>                
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
