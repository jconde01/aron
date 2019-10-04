@extends('layouts.app')

@section('title','Notificaciones')
@section('body-class','')

@section('content')
	<div class="container">
		<h1>Notificaciones</h1>
		<a type="button" class="btn btn-success" href="{{ url('/messages/create/0') }}"><i class="fa fa-plus"></i> Crear nueva </a>
		<div class="row">
			<div class="col-sm-6">
				<h2 >No leídas</h2>
 				<ul class="list-group">
					@foreach($unreadNotifications as $unreadNotification)
					
						 <li class="list-group-item">
						 	<a href="{{ $unreadNotification->data['link'] }}/{{ $unreadNotification->id }}">
						 		{{ $unreadNotification->data['text'] }}
						 	</a>
						 	<form method="POST" action="{{ url('notificaciones/leida/' . $unreadNotification->id ) }}"  class="pull-right">
						 		{{ method_field('PATCH') }}
                				{{ csrf_field() }}
						 		<button class="btn-danger">X</button>
						 	</form>
						 </li>
					@endforeach
				</ul>
			</div>
			<div class="col-sm-6">
				<h2>Leídas</h2>
 				<ul class="list-group">
					@foreach($readNotifications as $readNotification)
						 <li class="list-group-item">
						 	<a href="{{ $readNotification->data['link'] }}">
						 		{{ $readNotification->data['text'] }}
						 	</a>
						 </li>
					@endforeach
				</ul>				
			</div>
		</div>	
	</div>
@endsection