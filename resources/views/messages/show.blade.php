@extends('layouts.app')

@section('title','Mensajes')
@section('body-class','')

@section('content')
	<div class="container">
		<h1>Mensaje</h1>
		<p>{{ $message->body }} </p>
		<small>Enviado por {{ $message->sender->name }}</small>
	</div>
@endsection