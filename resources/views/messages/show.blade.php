@extends('layouts.app')

@section('title','Mensajes')
@section('body-class','')

@section('content')
	<div class="container">
		<?php //dd($message,auth()); ?>
		<h1>Mensaje</h1>
		<p><?php echo $message->body; ?> </p>
		<br>
		
		@if (auth()->user()->cell_id!=0)
		<p><a class="primario1" href="{{url('/messages/create/'.$message->sender_id.'')}}">Responder</a></p>
		<br>
		@endif
		<small>Enviado por {{ $message->sender->name }}</small>
	</div>
@endsection