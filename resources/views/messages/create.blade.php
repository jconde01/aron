@extends('layouts.app')

@section('title','nueva notificación')
@section('body-class','')

@section('content')
<div class="container">
	<div class="row">
	    <div class="col-md-8 col-md-offset-2">
	    	<div class="panel panel-default">
	    		<div class="panel-heading">Enviar mensaje</div>
<!-- 	            @if ($errors->any())
	                <div class="alert alert-danger">
	                    <ul>
	                        @foreach($errors->all() as $error)
	                            <li>{{ $error }}</li>
	                        @endforeach
	                    </ul>                    
	                </div>
	            @endif -->	    		
	    		<form method="POST" action="{{ route('messages.store') }}">
	    			{{ csrf_field() }}
		    		<div class="panel-body">
		    			<div class="form-group {{ $errors->has('recipient_id')? 'has-error':'' }} " >
		    				<select name="recipient_id" class="form-control">
		    					<option value="">Selecciona el usuario</option>
		    					@foreach($users as $user)
		    						<option value="{{ $user->id }}">{{ $user->name . ' - ' . $user->client->Nombre }}</option>
		    					@endforeach
		    				</select>
			    			{!! $errors->first('recipient_id',"<span class=help-block>:message</span>"); !!} 
		    			</div>
		    			<div class="form-group {{ $errors->has('body')? 'has-error':'' }} " >
			    			<textarea name="body" class="form-control" placeholder="escribe aqui tu mensaje"></textarea>
			    			{!! $errors->first('body',"<span class=help-block>:message</span>"); !!} 
			    		</div>
		    			<div class="form-group">		    			
			    			<button class="btn btn-primary btn-block">Enviar</button>
		    			</div>
		    		</div>
		    	</div>
	    	</form>
	    </div>
	</div>
</div>
@endsection