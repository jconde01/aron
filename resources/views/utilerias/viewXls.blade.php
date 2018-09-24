@extends('layouts.app')
 
@section('title','Leer archivo de excel')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <h2 class="title">contenido del archivo de excel</h2>
            <table class="table" id="table_id" class="display">
            	@foreach ($sheetData as $key => $row)
            		@if ($key == 1) 
		                <thead>
		                    <tr>
		                    @foreach ($row as $key => $value)
		                    	<th>{{ $value }}</th>
		                    @endforeach
		                    </tr>
		                </thead>
		            @else
		            	@if ($key == 2)
		                	<tbody>
		                @endif	
	                    <tr>
	                	@foreach ($row as $key => $value)
	                        <td class="text-left">{{ $value }}</td>
	                	@endforeach
	                    </tr>
		                @if ($key == count($sheetData))
		                	</tbody>
		                @endif
		            @endif
	            @endforeach           	
            </table>
            <div class="row">
                <div class="col-sm-2 col-sm-offset-5 text-center">
            		<a href=" {{ url('/home') }}" class="btn btn-default btn-round">Regresar</a>
                </div>                    
            </div>            
            <hr>            
        </div>
    </div>
</div>
@include('includes.footer')
@endsection
