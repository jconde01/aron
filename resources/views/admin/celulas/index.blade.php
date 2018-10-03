@extends('layouts.app')

@section('title','Listado de Células')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <h2 class="titulo">Listado de Células</h2>
            <div class="row">
                <a href="{{ url('/admin/celulas/create')}}" class="btn btn-primary btn-round" role="button">Nueva Célula</a>
                <br>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th style="width: 450px;">Nombre</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($celulas as $celula)
                        <tr>

                            <td class="text-left">{{$celula->id}}</td>
                            <td class="text-left"style="width: 450px;">{{$celula->nombre}}</td>
                           
                        </tr>
                         @endforeach
                    </tbody>
                </table>
            
            </div>
        </div>
    </div>
</div>
@endsection