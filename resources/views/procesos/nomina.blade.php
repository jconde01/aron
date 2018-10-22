@extends('layouts.app')

@section('title','Solicitud de Proceso')
@section('body-class','')

@section('content')
{!! Session::get("message", '') !!}
<div class="container">
    <form class="form" method="POST" action="{{ url('procesos/nomina') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row form-group">
            <div class="col-md-4 col-md-offset-4">
                <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                    <label class="label-left" style="font-size: 14px;">Período</label>
                    <input type="text" name="periodo" value="{{ $periodo->PERIODO }}">
                </div>
            </div>
        </div>
        <div class="row text-center">
            <button type="submit" class="btn btn-primary">Solicitar proceso</button>
        </div>
    </form>
</div>
@include('includes.footer')
@endsection
