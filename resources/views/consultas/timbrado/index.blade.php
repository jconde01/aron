@extends('layouts.app')

@section('title','Aron | Menú')
@section('body-class','')

@section('content')
<body>
<h1 align="center" style="color: rgb(0, 190, 239);">Nomina</h1>
<br>
<div style="text-align: center;">
		
	
		<?php
            $directorio = opendir("./timbrado"); //ruta actual
            while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {
                if (is_dir($archivo))//verificamos si es o no un directorio
                {
                    //echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
                }
                else
                {
                    echo '<a href="/timbrado/'.$archivo.'">'.$archivo.'</a>' . "<br />";
                }
            }
         ?>                  
         <br>
		<a href="{{url('/consultas/timbrado/firmar')}}" class="primario1 separation">Confirmar nomina</a>

	</div>

	
<br><br>
</body>
@include('includes.footer');
</html>

@endsection
