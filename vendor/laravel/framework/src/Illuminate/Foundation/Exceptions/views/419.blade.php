@extends('errors::layout')

@section('title', 'Pagina Expirada')

@section('message')
    La pagina ha expirado por inactividad.
    <br/><br/>
    Puedes esperar 3 segundos para ser redirigido o si tu explorar no lo hace automaticamente puedes presionar <a href="https://www.aron.com.mx">AQUI</a>
    <meta http-equiv="refresh" content="3; URL='https://www.aron.com.mx/login'" />
@stop
